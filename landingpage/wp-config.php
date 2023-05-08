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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'omgeest9_wpdb' );
/** MySQL database username */
define( 'DB_USER', 'omgeest9_wpuserp' );
/** MySQL database password */
define( 'DB_PASSWORD', 'y0S|n}:j' );
/** MySQL hostname */
define( 'DB_HOST', 'localhost' );
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );
/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'cw9fojvcu1r3thxh718jwrqi8s1hpyz5sfqpywqeey4gk4yjh0gbinzyerhlupm6' );
define( 'SECURE_AUTH_KEY',  'sjxpm2x70ild5qqbhsntmeqxkjlxt6ziugootyt0crytd5munkvch9a5bus1qzxp' );
define( 'LOGGED_IN_KEY',    '3yeopbbxwmczcypvwfiuuo5qiv3ox5egiegxnzjb9r37msblevuapa60slpbdfmh' );
define( 'NONCE_KEY',        'mcc5goxamqobfutl7rclnjnh8jkqq3v2lew4t0z9oabxstvp2kzt8zr9yztxkcjo' );
define( 'AUTH_SALT',        'wejaef1evymk8ut6o9rcusirigfefleflzihukn0vrgjcukqxaw98ojxu0shbfqt' );
define( 'SECURE_AUTH_SALT', 'pdxj0wiomjtnaufipfsmktudpjookgblpd6xrsdmwrciow0zdbvaei0gikpcjuvz' );
define( 'LOGGED_IN_SALT',   'ehlqpaedfcwgxbiuk3y8bb61qp3nzmm8otsrpwnuza4rbfke5dwc3dzh4wfam3qg' );
define( 'NONCE_SALT',       'vnpufrrah4mgw6nevomafvdw4s0jr91vezxzqyrkegx4rtrws2my8vzee4cbuv4o' );
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'omg_';
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
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPFress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
