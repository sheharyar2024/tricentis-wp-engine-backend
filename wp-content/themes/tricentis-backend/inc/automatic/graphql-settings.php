<?php
if (!defined('WPINC')) die;

new acfOptionsPageExport();

class acfOptionsPageExport
{

  public function __construct()
  {
    add_action('acf/save_post', array($this, 'acf_save_post'), 20);
  }

  public function acf_save_post($post)
  {

    $output_EN = get_fields('options');
    $output_DE = get_fields('options_DE');
    $output_FR = get_fields('options_FR');

    $output = array(
      'ThemeGeneralSettings'        =>  $output_EN,
      'ThemeGeneralSettingsGerman'  =>  $output_DE,
      'ThemeGeneralSettingsFrench'  =>  $output_FR,
    );

    //header('Content-Type: application/json');
    $output = $this->update_array_key_recursive($output);

    $upload_dir   = wp_upload_dir();
    $fp = fopen($upload_dir['basedir'] . '/theme_general_settings.json', 'w');
    fwrite($fp, json_encode($output, JSON_PRETTY_PRINT));   // here it will print the array pretty
    fclose($fp);
  }

  public function update_array_key_recursive($arr)
  {
    if (is_array($arr)) {

      $newArr = array();

      foreach ($arr as $key => $value) {
        $key = $this->snakeCaseToCamelCase($key);
        $newArr[$key] = is_array($value) ? $this->update_array_key_recursive($value) : $value;
      }
      return $newArr;
    }
    return $arr;
  }

  public function snakeCaseToCamelCase(string $field_name, $separator = '_')
  {
    $field_name = lcfirst(str_replace($separator, '', ucwords($field_name, $separator)));
    return $field_name;
  }
}

/*
function graphql_settings_output(){
    if(!isset($_GET['create_json_settings_file'])){
        return;
    }
    $graphql = graphql([
        'query' => ' {
            themeGeneralSettings {
                settingsAlerts {
                  globalAlertDisplay
                  alertGroup {
                    globalAlertContentMessage
                    globalAlertContentAlertType
                    globalAlertContentActions {
                      adaText
                      function
                      seoText
                      link {
                        target
                        title
                        url
                        __typename
                      }
                      __typename
                    }
                    __typename
                  }
                  __typename
                }
                settingsSocial {
                  globalSocialChannels {
                    title
                    website
                    __typename
                  }
                  __typename
                }
                settingsFooter {
                  globalFooterCtaDisplay
                  callToActionGroup {
                    titleText
                    backgroundColor
                    backgroundPattern
                    backgroundType
                    backgroundImage {
                      image {
                        altText
                        mediaItemUrl
                        __typename
                      }
                      mobileImage {
                        altText
                        mediaItemUrl
                        __typename
                      }
                      __typename
                    }
                    description
                    paddingBottom
                    paddingTop
                    actions {
                      adaText
                      seoText
                      display
                      function
                      link {
                        target
                        title
                        url
                        __typename
                      }
                      __typename
                    }
                    __typename
                  }
                  footerGroup {
                    adaText
                    seoText
                    footerDescription
                    function
                    link {
                      target
                      title
                      url
                      __typename
                    }
                    __typename
                  }
                  __typename
                }
                settingsHeader {
                  globalHeaderColorLogo {
                    mediaItemUrl
                    altText
                    __typename
                  }
                  globalHeaderLogo {
                    altText
                    mediaItemUrl
                    __typename
                  }
                  flagCta {
                    target
                    title
                    url
                    __typename
                  }
                  __typename
                }
                __typename
              }              
        }'
    ]);
    
    $upload_dir   = wp_upload_dir();
    $fp = fopen($upload_dir['basedir'].'/settings.json', 'w');
    fwrite($fp, json_encode($graphql['data'], JSON_PRETTY_PRINT));   // here it will print the array pretty
    fclose($fp);
}

add_action( 'admin_init', 'graphql_settings_output' );

*/
