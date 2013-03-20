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
define('DB_NAME', 'inter');

/** MySQL database username */
define('DB_USER', 'inter');

/** MySQL database password */
define('DB_PASSWORD', 'inter');

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
define('AUTH_KEY',         'aSyFQSIGO168`Jp!WW[b|V7qD2$N~2;{0YKv<lt&N$e&zO3RQrZ@P#.#rx`i;[;n');
define('SECURE_AUTH_KEY',  '579(y#ljm<-I;(89:UR6s u~s>H.Hm+kV~h?iV+@2}5<l+lE,k[20)s.`+&+U[&S');
define('LOGGED_IN_KEY',    '2ymvbfyzgM},h)8`:Lly,lPbRc:`IDzkfy=Lnvcj]4k03en1q.f.n?a  <y_KLhX');
define('NONCE_KEY',        'wMIP?L7kL}9n`*ism*nJAhXpPypr}Bk <@#BNMRxR[cVU0R58F!0rzy4QAB)/.Z7');
define('AUTH_SALT',        '{;JsJeAj@Mj)M{~{O<g%O%7{G(pBVMTjh <w2kIjl0/+<uTC]di4Hu=G%LT<{g8d');
define('SECURE_AUTH_SALT', '/_/Ms`uWH`iuHYuf=|y!<MJ}klP_Ps{aPJu`<>^pt7e3L&$mjD9?+$v0U*}~OL(2');
define('LOGGED_IN_SALT',   'H<etUjsm6qz lv$8@KklPLMOVnG@!~w8Ai U(b,weIZTB8^iE`pLk%=H-z|Za=F$');
define('NONCE_SALT',       'pV/w7_:>jN~Cr$.?CJ&fdD&SH@6#z?mk:a<VMqMKV{=yO&cBODyALt2K1#Yb0M-^');

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

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
