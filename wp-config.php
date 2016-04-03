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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'eventhosthub');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** The WordPress Trash Empty Settings - MJDevelopZ */
define ('EMPTY_TRASH_DAYS', 7);

/** Limit the number of drafts and autosaves of posts - MJDevelopZ */
define( 'WP_POST_REVISIONS', 3 );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'In)?bd1%QgL4jkAV<^&o9/6_vGT6;mD4DIl-KT]MESIbBc?;J#rK7${07*AKbH!w');
define('SECURE_AUTH_KEY',  '6tn7=h|14VvY(XJ+v=C+b4>n4&?#{H05C9$qZ-v:$H}/=GkCHk:!bR}>o?t--3V|');
define('LOGGED_IN_KEY',    'E4AU|#->&Rja0&(1@c5WLk$qNi,N47TV,4|RC7& 5.Lrpq8SiMsNK6AyY{o3IOzY');
define('NONCE_KEY',        '<2w-8zk$Orfm)JD}C2D+rTx8{>ek4KG~4^n -Iuf6Wr;+j /bU>jXAu[^WF/oDPI');
define('AUTH_SALT',        'MX,}t.F(V`6EN8El~OS4g|L+.lBO35_k6Zp?#ItJ&a!anA+/[2zXv4sv>(+]l!1o');
define('SECURE_AUTH_SALT', 'l#dh/P=F0@Ve(FsrllE/WolVey-6k(V_|:t&)*BIr/{a%JKg-[Cu)fC*Y(MFYSy^');
define('LOGGED_IN_SALT',   'NmDx{fhJ~RS+VZJK }37oyE^zK.>^W+PoYDZj$Q-V)gkZl8ZHD%er._kQPQJQiv(');
define('NONCE_SALT',       'v)j}>aNN~*f:&v|9R4# ]%)[4duI|7$PJSY[6nq`K^&f.0o;2j*67PUZfnNbAegL');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_0msgvgz09k_';

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
