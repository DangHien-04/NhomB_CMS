<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_602_core' );

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
define( 'AUTH_KEY',         '9 3fCHBE3e{An:$cHKXZ,)}nGu$LxV};*AU9$(m#k]~@>#&.>.gepIl3MaxAKKD~' );
define( 'SECURE_AUTH_KEY',  'C( j&EyZdfON|~G2oBDXc7O}/hr;[Ex- es,/4zw@W2fj(&(!TVGUZ8GFdS%&QWN' );
define( 'LOGGED_IN_KEY',    '` Cbke@|_1ow-l[8H5ES)UFBDh~O`%6dF;`|+E.zN~<lX4Q}Oo4bmDSrF;(D_tmK' );
define( 'NONCE_KEY',        'XzP/9?E`zd2tT)uG+OX#+wk,R?jq:DAgL]27IYEyVv)}@ts*1w*Z9uGx&4YE6BL[' );
define( 'AUTH_SALT',        '{;AG-j8cu#1o:V40=iWN]FC$:&9goGgs^iH`HDg*!oalqRle4:Ei>#^Gq>Q}tg&j' );
define( 'SECURE_AUTH_SALT', '(q8w7cTF-<2}ZY}v}p3G0?e&,$$N6&iq+;)SR4}Gd ](,?Nn*=*9@OhZee#vu^6C' );
define( 'LOGGED_IN_SALT',   'KPtgg)3@&>/f|vpu wGO$y[r)_)~j3ty(%m^j_MCE~%D;m1tA[gvyl<Xo5f){^>b' );
define( 'NONCE_SALT',       'CQWjbdmURlNs>boc#w8AdZW.kWf0f:x:Xm}]N@q/EWSPZ|OYENaXG(=fc B.%tg<' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
