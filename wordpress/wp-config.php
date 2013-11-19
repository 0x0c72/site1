<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME','wordpressblog');

/** MySQL database username */
define('DB_USER','wordpress');

/** MySQL database password */
define('DB_PASSWORD','');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY','6q3sZzGH1/UiSqrFDCoHI16XT5DhgMCTV7vSJyRlrxkml/H7JaOFaF73v0+SodFT');
define('SECURE_AUTH_KEY','FfkYbCyH+ONAj19OBdQT2hnN0qKEqWM5gCEQR7umzLSTJq0jk6sMu9ryo4Qk9WRr');
define('LOGGED_IN_KEY','FKLnDd08nUZFCxOvi/ukA9NmBotxZZJhkMohB3i8ew6Ki6CECET8UZKBlM0a3Dzu');
define('NONCE_KEY','Zwfe5jGQnWP+ogqmc19C19rZPBTv9hFEpOMYEEPghwxGasZAhXnEbGHmqdbVotOG');
define('AUTH_SALT','AMyQXy5ybqAT+7NMMAuqMMvA4C1Y+IxUH+0vfqpcGIyoi37NZClWlt5anW/J+wtr');
define('SECURE_AUTH_SALT','fy66kNJCBf5MFGsB2ABvsnxxXZSZwj8Uy4H05IZuQOmB17dx8NKYFofIdw0l2B4H');
define('LOGGED_IN_SALT','hYzzqrL8i4PlI4oLXW0l2oM6EtE+l7BY8jNsW2WfwCqANg4F/E+KIkiLXe72OGXS');
define('NONCE_SALT','OZdR8bZnMsjKauSIRnWOggJqWPQxV7UGu1VfAMcNsqShkprSJGTuJTWbVbg1fRo6');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');
define('WP_LANG_DIR', dirname(__FILE__) . '/wp-content/plugins/language-selector/languages');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */
$pageURL = 'http';
if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
$pageURL .= "://";
if ($_SERVER["SERVER_PORT"] != "80") {
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
} else {
	$pageURL .= $_SERVER["SERVER_NAME"];
}
define('WP_SITEURL', $pageURL . '/wordpress');
if (!defined('SYNOWORDPRESS'))
   define('SYNOWORDPRESS', 'Synology Inc.');

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
require_once(ABSPATH . 'syno-misc.php');
