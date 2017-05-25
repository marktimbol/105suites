<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') $_SERVER['HTTPS']='on';

define( 'WP_MEMORY_LIMIT', '256M' );

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', '105suites');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '{>G99xp$LW*H|{*N*]{$?!I95l$|H}j)kVZ(kAglBqhr~Mk0-=UWR*h=WCAk~LY4');
define('SECURE_AUTH_KEY',  '^`#SRkWmK1fMfYB&~@RV{YRMZkEW%hI?36Axf,WlK{~DpG&>;tvK7WS1{F]jT#@h');
define('LOGGED_IN_KEY',    'HsE*v[iMlRv5yeCbp;K07G# ),-7Mn1o|FbVDJK4qXn`d.]+`#M-{:j*4S/)HEnk');
define('NONCE_KEY',        '?shdyKsRU+b8@iH]N3CxPLTkDZee&TwF%PEk[O AzQ$Q-?{$MP)aP:=^i=I_DtvV');
define('AUTH_SALT',        '#DkwmM&e6Jb=}+gzY4RKr0cd=Cb/[`*p<}{7>5ZN%kAS#08d.<+9KQSxV.s%L[qa');
define('SECURE_AUTH_SALT', 'q;g[[W-9eYWw>z$j%t5$j?]E sC%c@G,M1Ag0X;J#NIb^yQYH9G:tDk-hN^UmacV');
define('LOGGED_IN_SALT',   'pQRQ#l~9 cTH~BwVf[YAm$.=<u}sRi3@y$tK8x@IBf)(?+S9P:3B^ey88u99A6?y');
define('NONCE_SALT',       '0]CC]trb>V1JDYGw}ZyUPj@yGd{S/KNZ+0*vAoP@zHR{i+!eZU+RhAu[A^%;%H4e');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
