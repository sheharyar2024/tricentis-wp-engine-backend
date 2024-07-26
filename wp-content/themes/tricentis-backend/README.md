Narwhal Boilerplate
===

This is a boilerplate starter theme for Narwhal Digital Wordpress projects.  It is not meant to be used as is, but as a starting point for custom themes
for each client.  There are several pre defined modules available after installation and an ACF sync.  This theme was originally based off of [underscores](https://underscores.me).

* Module starting point and examples - ACF fields, html template, SASS, and animations.
* Commonly needed third party scripts - [AnimeJS](https://animesjs.com/), [Waypoints](http://imakewebthings.com/waypoints/), [Magnific Modal](https://dimsemenov.com/plugins/magnific-popup/)
* Organized SASS files to quickly get started with custom designs


Getting Started
---------------

Download master zip file from BitBucket. Copy the theme or upload it through WP in your local environment and then rename the folder to the project name.
Then it is recommended to find/replace particular strings within the theme to make it client specific.  It is important to make sure you are matching on case.

1. Search for: `tricentis-backend` and replace with: `custom-theme-name`.  This should catch text domain and filter/actions
2. Search for: `tricentis_backend_` and replace with: `custom_theme_name_`.  This should catch all function declarations
3. Search for: `TricentisBackend` and replace with: `CustomThemeName`.  This should catch all class declarations.
4. Search for: `TRICENTIS_BACKEND` and replace with: `CUSTOM_THEME_NAME`.  This should catch all constants.
5. Search for: `Narwhal Boilerplate` and replace with: `Custom Theme Name`.  This should catch all strings and titles.
6. Rename any files that have Tricentis Backendin the name.  Languages/tricentis-backend.pot.

After the optional renaming, these steps will get the theme ready for you to start developing.

1. Go into the theme directory and run `npm install`.
2. Startup gulp with `npm run watch` or `gulp && gulp watch`.
3. Install Advanced Custom Fields, Gravity Forms, Yoast SEO, and Classic Editor.
4. Activate your theme.
5. Go into Custom Fields and sync all fields.

Guidelines
===

The main point of this theme is to provide organizing principles to a custom theme and allow all developers to build sites in a more consistent manner.  The
base theme should demonstrate the preferred manner to build modules in terms of admin interface, performance, and end result.  It should also contain solutions to common problems that represent the best agreed upon solution at the time.  We recognize that development is an area that is always changing, so don't feel that these are hard constraints, but make sure that is something is changed, it is documented why and perhaps put back in the base theme as the new agreed upon solution.

Templates
---------------
