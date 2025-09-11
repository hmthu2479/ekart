<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ecweb' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '# jRJTliA~ml{]bmwHolH:dp!4)=68JN n$RKO5,H1?Kru`;_-Vxzx_FJu7%{Z:{' );
define( 'SECURE_AUTH_KEY',  '~|c.<+rlyls_/lxR!fBvVFCM)K&}ATqLs?}0>h)2ov%9oe_:ff}DfX{hPR^>Usyo' );
define( 'LOGGED_IN_KEY',    '$7Rw_<2vLyel^Dw>z*abAGzg33IRG*B.T1(?6&.Q=z?hMmhaK%L1Ps87Xl@*8/e8' );
define( 'NONCE_KEY',        'z=Fz>Emj[3~@BH@<8TwSa3CScD3B>[n{/b5)j7C|{-gv> WK(:}_=pI,QStGSj-u' );
define( 'AUTH_SALT',        'tNTC.`JKWLujB)!xXrWcJuB[rKDZ1&HB1^ab#d P;6^;{5OGw{Pb_j/C%Jl8&?<A' );
define( 'SECURE_AUTH_SALT', 'Jw$C6S;2Jr5`!PP5YL&Nk(|Jm@]*!x^h8:aUeKzCS.?GzDi/@N7Ln8#dzL#~OuIC' );
define( 'LOGGED_IN_SALT',   '24KtySnTzomB_M+B1ZxAV.>2@b#@6g YUt(yu 8R/n#Milmy%pt1b?OZR4gcB#qg' );
define( 'NONCE_SALT',       'bf?sV#$X.Y;uh;_,W3u5f>j#p>K*4UMttT4023}l24|N`/Zo 7!v-|Hc1Z,rLWHW' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */


define('WP_HOME', 'http://localhost/ekart');
define('WP_SITEURL', 'http://localhost/ekart');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
