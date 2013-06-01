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
define('DB_NAME', 'mls');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '{:J*Ke5O+Y|jkMl-0>+8vOd|;V&/Rx+qPf2sz:-?k;1T%%o,CPOX0Z9D^MENO@nf');
define('SECURE_AUTH_KEY',  ' u+(o2@Z>|#yKrwubiaee-pP!R99a%4]yqw|Bj>=]r{}8RtWJLh9yx|zs$VJ:d9|');
define('LOGGED_IN_KEY',    ');-DbL6myH+;UK31CUK*.1rx1QL}(63hk>_A-UK|#i0|O[#u;JhdU (UUg-;I<aX');
define('NONCE_KEY',        'DSsf|q%<LIK3HtRHf8PufE`L{]@|;2yy`z^%)-Su^BV7?o.q 1[r-Hlr+@G>ydfb');
define('AUTH_SALT',        '/3vHTfSc2|u+WCa5RCG+. h1p*G-z-I%Je/6Hzc+>{Q^a_5$SSE~TZ15bH+(-P&y');
define('SECURE_AUTH_SALT', '-3uP-Zf$^~[-he%PDLg|p;-BXw&}!VIPp4Wl+4fL/4DA6*_gpe},/p^ E%r!?Lj6');
define('LOGGED_IN_SALT',   'wWZaFGcpl 8~S0W)Sui$0Op9r02$POFcj+iX ro$[+>zC<apgV=xt`ML e@.0v=+');
define('NONCE_SALT',       'dJ4hjqf3k^C[jmh)p(v#&+VBz1bImR}j1Az1>EqRa=Y7obSWk{Ry$%t8OrF=o&Nb');

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
