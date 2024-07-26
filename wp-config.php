<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

/**
 * This config file is yours to hack on. It will work out of the box on Pantheon
 * but you may find there are a lot of neat tricks to be used here.
 *
 * See our documentation for more details:
 *
 * https://pantheon.io/docs
 */

/**
 * Pantheon platform settings. Everything you need should already be set.
 */
if (file_exists(dirname(__FILE__) . '/wp-config-pantheon.php') && isset($_ENV['PANTHEON_ENVIRONMENT'])) {
	require_once(dirname(__FILE__) . '/wp-config-pantheon.php');

/**
 * Local configuration information.
 *
 * If you are working in a local/desktop development environment and want to
 * keep your config separate, we recommend using a 'wp-config-local.php' file,
 * which you should also make sure you .gitignore.
 */
} elseif (file_exists(dirname(__FILE__) . '/wp-config-local.php') && !isset($_ENV['PANTHEON_ENVIRONMENT'])){
	# IMPORTANT: ensure your local config does not include wp-settings.php
	require_once(dirname(__FILE__) . '/wp-config-local.php');

/**
 * This block will be executed if you are NOT running on Pantheon and have NO
 * wp-config-local.php. Insert alternate config here if necessary.
 *
 * If you are only running on Pantheon, you can ignore this block.
 */
} else {
	// ** MySQL settings - You can get this info from your web host ** //
	/** The name of the database for WordPress */
	define( 'DB_NAME', 'local' );

	/** MySQL database username */
	define( 'DB_USER', 'root' );

	/** MySQL database password */
	define( 'DB_PASSWORD', 'root' );

	/** MySQL hostname */
	define( 'DB_HOST', 'localhost' );

	/** Database Charset to use in creating database tables. */
	define( 'DB_CHARSET', 'utf8' );

	/** The Database Collate type. Don't change this if in doubt. */
	define( 'DB_COLLATE', '' );

	define('AUTH_KEY',         '/e+DbULcuxWSV0oMvX0afizDIAjrpYF/tIQme9I6Nc2B1VDzgPcncRJJ1Gx+P4Xiz4eYbtZSsJXD2F3uesXF/A==');
	define('SECURE_AUTH_KEY',  '9ZnfDyKtYYOEnzXmnIysO3Fb+9WD3OBUT9xB3PuX6hDdsGrEtSoPcHdo4vKBgv0bzoEBZYsLqu+93hEQYCno+w==');
	define('LOGGED_IN_KEY',    's8UPW17ITbdG1Ulpb+MdtOtxhOWgGzK/NAeQsKRopObjFr9b7VNCFGIklfa10mPHOhU+NA1FrdWSzg7oyQTlPA==');
	define('NONCE_KEY',        'Gm3EYi38pzWW65QgEKCgzVw48uM8aZTZxDV0LFlxkvLIBhx5Y9HCTHZX9Rc4mPKccr5V0i6xdty+XKUzrBUxXw==');
	define('AUTH_SALT',        '7HMPQfaQ+IngrMOJsOiNNJ43zIp16wBViYU6MRMuOKWAnl/hFn7kOiaZcBRh5PbF0wUQU2h7ib3u1iSEv2Dyuw==');
	define('SECURE_AUTH_SALT', '/MRqBF+UQaLpeWF5StrwLKzmZJvlfvXu+k5IAKIe8/53tTWDtb2LVk49cyhdErSay4YKtezq5cDlYRxyOATPzQ==');
	define('LOGGED_IN_SALT',   'BYLi99hSs93uRrlBItlWka12KcBYoR6CWwp1YhP2ldhNyLr35k749YBlSi+bTzy6/IcETvHn7uH45c2eOIVhSA==');
	define('NONCE_SALT',       'KXESODThumUH4JPTNhCct+W2Qwlemi9PAcANudP5Yc0Ws8+K3iIqwTlGevd/vkzEZW01GhWpFRUELFZxw4K8Yw==');
	// HTTP is still the default scheme for now.
	$scheme = 'http';
	// If we have detected that the end use is HTTPS, make sure we pass that
	// through here, so <img> tags and the like don't generate mixed-mode
	// content warnings.
	if (isset($_SERVER['HTTP_USER_AGENT_HTTPS']) && $_SERVER['HTTP_USER_AGENT_HTTPS'] == 'ON') {
		$scheme = 'https';
		$_SERVER['HTTPS'] = 'on';
	}
		define('WP_HOME', $scheme . '://' . $_SERVER['HTTP_HOST']);
		define('WP_SITEURL', $scheme . '://' . $_SERVER['HTTP_HOST']);
}


/** Standard wp-config.php stuff from here on down. **///

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
set_time_limit(240);
/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * You may want to examine $_ENV['PANTHEON_ENVIRONMENT'] to set this to be
 * "true" in dev, but false in test and live.
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define('WP_DEBUG', false);
}

define( 'WP_POST_REVISIONS', 10 );

define( 'HEADLESS_MODE_CLIENT_URL', 'https://www.tricentis.com' );

define( 'GRAPHQL_JWT_AUTH_SECRET_KEY', 'FBf{4Pig%7m-a2|niSuK"=`KQ]/y0E' );

define('WP_FE_URL', 'https://www.tricentis.com');

define( 'ACFML_SCAN_LOCAL_FIELDS', false );

/* That's all, stop editing! Happy Pressing. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
