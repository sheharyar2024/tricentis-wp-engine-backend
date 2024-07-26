<?php

/**
 * This endpoint allow a few parameters:
 * post_type -> array of str (name of a post type)
 * posts_per_page -> int (posts to show in a page)
 * page -> int (page to show)
 * search -> stg (search query)
 * taxonomies -> json (Allow a json of taxonomies terms to filter, one object per taxonomy) 
 *      JS EXAMPLE:
 *      const taxonomies = JSON.stringify([
 *           {
 *               taxonomy: 'company',
 *               term: 'filter-term'
 *           },
 *           {
 *               taxonomy: 'industries',
 *               term: 'test'
 *           }
 *       ]);
 * fields -> json (Allow a json of fields to return)
 *      JS EXAMPLE:
 *      const fields = JSON.stringify({
 *          acf: ['blurb', 'company_logo'],
 *          core: ['title', 'permalink']
 *      })
 * 
 * FULL JS FETCH EXAMPLE BELLOW:*/
/*      
    //Hardcoded params
    const post_type = 'case_study';
    const posts_per_page = 2;
    const page = 1;
    const taxonomies = JSON.stringify([
        {
            taxonomy: 'company',
            term: 'locals'
        },
        {
            taxonomy: 'industries',
            term: 'test'
        }
    ]);
    const fields = JSON.stringify({
        acf: ['blurb', 'company_logo'],
        core: ['title', 'permalink']
    })
    const search = ''

    //Prepare params
    const params = new URLSearchParams({
        post_type,
        posts_per_page,
        page,
        taxonomies,
        search,
        fields
    });

    //Setup URL, YOU SHOULD CHANGE "http://tricentis-backend.local" FOR YOUR BACKEND URL
    const url = `http://tricentis-backend.local/wp-json/tricentis/v1/filter-posts?${params}`;

    //Fetch to "tricentis/v1/filter-posts" custom endpoint
    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(res => res.json())
        .catch(error => console.error('Error:', error))
        .then(response => console.log('Success:', response));
*/

new PaginatedPostsFilter;

class PaginatedPostsFilter extends WP_REST_Controller
{
    public function __construct()
    {
        $this->namespace = 'tricentis/v1';
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    public function register_routes()
    {
        register_rest_route($this->namespace, 'filter-posts', array(
            'methods' => WP_REST_SERVER::READABLE,
            'callback' => array($this, 'filterPosts'),
            'permission_callback' => '__return_true',
            'args' => array(
                'post_type' => array(
                    'required' => true,
                ),
                'posts_per_page' => array(
                    'validate_callback' => function ($param, $request, $key) {
                        return is_numeric($param);
                    },
                    'required' => true
                ),
                'page' => array(
                    'validate_callback' => function ($param, $request, $key) {
                        return is_numeric($param);
                    },
                    'required' => true
                ),
                'search' => array(
                    'validate_callback' => function ($param, $request, $key) {
                        return is_string($param);
                    },
                    'required' => false
                ),
                'taxonomies' => array(
                    'required' => false
                ),
                'fields' => array(
                    'required' => false
                ),
            ),
            'summary' => __('Filter your post with tasonomies and search string.', 'tricentis-backend'),
            'description' => __('Filter your post with tasonomies and search string.', 'tricentis-backend'),
            'schema' => 'prefix_get_comment_schema'
        ));
    }

    /**
     * Returns filter posts.
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
    public function filterPosts(WP_REST_Request $request)
    {
        //Pagination Settings (mandatory)
        $postType = json_decode($request->get_param('post_type'), true);
        $postsPerPage = $request->get_param('posts_per_page');
        $page = intval($request->get_param('page'));

        //Search Query
        $search = $request->get_param('search');
        $filtersSettings = json_decode($request->get_param('taxonomies'), true);
        $fieldsToReturn = json_decode($request->get_param('fields'), true);

        //Filters (taxonomies)
        if ($filtersSettings) {
            $filters = array('relation' => 'AND');
            foreach ($filtersSettings as $filter) {
                if ($filter['term'] != 'all') {
                    $taxonomy = array(
                        'taxonomy' => $filter['taxonomy'],
                        'field' => 'slug',
                        'terms' => array($filter['term'])
                    );
                    array_push($filters, $taxonomy);
                }
            }
        } else {
            $filters = null;
        }



        $posts = new WP_Query(
            [
                'post_type' => $postType,
                'posts_per_page' => $postsPerPage,
                's' => $search,
                'order' => 'DESC',
                'tax_query' => $filters,
                'paged' => $page
            ]
        );

        if ($posts->have_posts()) {

            $filteredData = [];
            while ($posts->have_posts()) {
                $posts->the_post();
                $postData = [];

                //Add acf fields
                $acfData = [];
                foreach ($fieldsToReturn['acf'] as $field) {
                    $acfData[$field] = get_field($field) ?: null;
                }

                //Add core fields
                $coreData = [];
                foreach ($fieldsToReturn['core'] as $field) {
                    $coreData[$field] = call_user_func("get_the_$field") ?: null;
                }

                //Get taxonomies related to current post type
                $taxonomies = get_object_taxonomies(get_post_type());

                //Add taxonomy terms
                $taxonomiesApplied = [];
                foreach ($taxonomies as $tax) {
                    $taxonomiesApplied[$tax] = get_the_terms(get_the_ID(), $tax);
                }

                $postData = [
                    'post_type' => get_post_type(),
                    'acf' => $acfData,
                    'core' => $coreData,
                    'taxonomies' => $taxonomiesApplied
                ];

                array_push($filteredData, $postData);
            }

            $res = [
                'posts' => $filteredData,
                'page' => $page,
                'max_pages' => $posts->max_num_pages,
                'total_posts_found' => $posts->found_posts
            ];

            // Create the response object
            $response = new WP_REST_Response($res);

            // Add a custom status code
            $response->set_status(200);

            return $response;
        }

        return new WP_Error('posts_error', __("Nothing found for '$postType'", 'tricentis-backend'), array('status' => 404));
    }
}
