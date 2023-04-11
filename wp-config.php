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
define( 'DB_NAME', 'myplugin' );

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
define( 'AUTH_KEY',         ':_xDT$#_fhy:<(t4#qPY9{zvk(^1$B#gbb*ou#S@39XN9yLo?r)Q{_~pI%u(bDU)' );
define( 'SECURE_AUTH_KEY',  'xV@-m.q}e;H:zPpPJ#5A4gqi3q<C+-HJ4d*2rD=f`%+9B}m;@K-<->g.c`k[?I2r' );
define( 'LOGGED_IN_KEY',    'ZVytj?foR6+F>.&IQ_X_}&6U,~:f7kivLrUWOiODB/WqoU~%CAi%0WbjUMV=Y>1L' );
define( 'NONCE_KEY',        '?)I)T~g}J#sj} y6MLSyRiQ_&jbq8!3uc()*$86vBs)/&SqiHs5wLU*La<,)/h/1' );
define( 'AUTH_SALT',        '+MQ&ByEY0A7Z_a EI^8DHMiN[yiZL&]C3@VkgYPXP9U;aJV5#&`-z0}L;wHfCw&v' );
define( 'SECURE_AUTH_SALT', 'zLx0)0s1S^9U;339yPCs,-qqKsm/XJ.jZ~GoGWZFOx>U1:($meF{Y6J%DJkrq%v:' );
define( 'LOGGED_IN_SALT',   'Rq%vaUYy55{VA)U0?Z7_u+*[cFJ*&yrGwFi:Yi=ApFl`+>VVk6$g^|,?h~6QKP.8' );
define( 'NONCE_SALT',       'pUTf)TVl]70$[pV+w&N<<V@GWw.Ni#A*5SkacTsv(a+G.p67:DMrH&T_z4iK-lek' );

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
