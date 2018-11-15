<?php
/**
 * The base configuration for WordPress.
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
 * @see https://codex.wordpress.org/Editing_wp-config.php
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'db-name');

/* MySQL database username */
define('DB_USER', 'db-user');

/* MySQL database password */
define('DB_PASSWORD', 'db-password');

/* MySQL hostname */
define('DB_HOST', 'localhost');

/* Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/* The Database Collate type. Don't change this if in doubt. */
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
define('AUTH_KEY', 'Qba9ca^oU`Y-sL-j`=:-5vQ?C@?@MW[]H[X /3>p,SzD,I$DU<Jr#1 K`G4OkO7a');
define('SECURE_AUTH_KEY', 'u=CGAb0Y9Y_<M_>2I}w98[P,Q5`v<1@R{px/*kt}9&n=+|rRA`2&YX~MiHG87buN');
define('LOGGED_IN_KEY', '6y}i2~Il<a&4$!Zir-[0p`X7.OEF#kl3eK@;R7hiZ3j8Om~O{*]<p19:&+ YWmDv');
define('NONCE_KEY', 'p&4911]ucQes?CU7:Ef77In$`HT59RbXDFB=iqEPfCU6%]HO%!qo`Y|ATlXF+U8v');
define('AUTH_SALT', '9`*rf:nUR<_LvrpGI@wz>^?yVWZk#?~,Ay.QH6!{uI2nG7$j{}m1.(4 -bJ-EFVh');
define('SECURE_AUTH_SALT', 'f$M,=+b|JM96_|gi`Ed0~+&$D^-91wt1}0y2`3(CB4zrl?:oqN:@A!RYiruwm6~I');
define('LOGGED_IN_SALT', 'YnNaPQqae4Ji[OQv|Vb(Y`nLb{O;LS8WiCsUXMgKSwUcg>(m-o&Bt(h.A]&CcwS}');
define('NONCE_SALT', 'uhdc^];P?L0k+r~YnZ;,[PPO|{YyHm*jJMuhrHbTLy(~;6n&vQ{ YHioRX*a@5B9');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/*
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

/* Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__).'/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH.'wp-settings.php';
