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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'Ao]U`_{h2&0Q}h2q2@Lz;ow)G?% K7>,/Z%^3XAlpcfE0;O2}^v>V?Ey6-x@GX?R' );
define( 'SECURE_AUTH_KEY',  'V^w1t5!&xwEcv$&[(=^0uyn5l<R8PUh;4(?AEBo~%S|cF}@Ak{q4=u7j=^6aFc88' );
define( 'LOGGED_IN_KEY',    ']o]db#J%bOCe]A?; ^DM05=j2X%w`R4zLL;l#BGm+v TV9nPK[I!^Yz#wNmCBnSY' );
define( 'NONCE_KEY',        '^Uao3lVCh=it/dOuXn)pz ZOGbF]O6t}4f@!+pZThE+%s,ryZ-kDi15[HZY#^1=:' );
define( 'AUTH_SALT',        '%nuYE4.Hp1kq5JwGP2p@l3V0pm)9rn+?)Mf`4ZHoL0fS6 inn1uH}$E[7=yQ&lKO' );
define( 'SECURE_AUTH_SALT', '^dGJ7opQrnt~_cak;s?@ZG#[r!E`u.K:[;pKV|y+?6DGu<e(hVEyL;@)#eQu$OT4' );
define( 'LOGGED_IN_SALT',   'nt}fsso p>L<Qo~E~PLlMoS-FriM{i9/*b376ny,C<)~eBn<;I10LiSRgeNA|k[#' );
define( 'NONCE_SALT',       '9*>5aHI&4(CCi(Y)V&)u=(4U(Kbeo#btuT9m4+YQB5zZ_`Y%M`fz[BORDCpdsx?!' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
