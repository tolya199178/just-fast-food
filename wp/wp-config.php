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
define('DB_NAME', 'justfast_wp4');

/** MySQL database username */
define('DB_USER', 'justfast_wp4');

/** MySQL database password */
define('DB_PASSWORD', 'wPa88Sl90i');

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
define('AUTH_KEY',         'oyv9vthpsjgatuaniqif3gpcibw5lpxn7bmnbbslds9umyvnsdytnwrf4r0cqedd');
define('SECURE_AUTH_KEY',  'fz56k0gxvtpvi7dn2mkejjfvhpgkynbav2lkatgbnca9xev1fwiwbc4ppxj0xdhz');
define('LOGGED_IN_KEY',    'zy4vyjvn5lwuohnctmyshujwvfqcancmakh5foysqdk8ahlydcjbzhcx0xn2tyox');
define('NONCE_KEY',        '6qk2urhxz7shyxxakwi2xmgei8jfs4414zwn9as9fpptswdrj38urj0n9gjtruas');
define('AUTH_SALT',        'haz2ncr6gvyabihmdolikn5opgctielu2jf9o0zm78nm2q5iukgtw9vh4i5il565');
define('SECURE_AUTH_SALT', 'hvr8mo5intuwhzrpevguexmvi4rrnrn9xiyhr071i8tynim2kubrumkgzfc5wh5d');
define('LOGGED_IN_SALT',   'l5nqprciwytpchnqepwhnp1v7m8ehiy6qndxdxzbqdo9p4q1eszdxaw3itqzf14y');
define('NONCE_SALT',       '7v16t9otrnmja2vngohrmpt3l3eb05h8cmewfheermhjxk9rb1h2yyubocvnitq2');

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
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define ('WPLANG', '');

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
