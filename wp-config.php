<?php
/**
 * Grundeinstellungen für WordPress
 *
 * Zu diesen Einstellungen gehören:
 *
 * * MySQL-Zugangsdaten,
 * * Tabellenpräfix,
 * * Sicherheitsschlüssel
 * * und ABSPATH.
 *
 * Mehr Informationen zur wp-config.php gibt es auf der
 * {@link https://codex.wordpress.org/Editing_wp-config.php wp-config.php editieren}
 * Seite im Codex. Die Zugangsdaten für die MySQL-Datenbank
 * bekommst du von deinem Webhoster.
 *
 * Diese Datei wird zur Erstellung der wp-config.php verwendet.
 * Du musst aber dafür nicht das Installationsskript verwenden.
 * Stattdessen kannst du auch diese Datei als wp-config.php mit
 * deinen Zugangsdaten für die Datenbank abspeichern.
 *
 * @package WordPress
 */

// ** MySQL-Einstellungen ** //
/**   Diese Zugangsdaten bekommst du von deinem Webhoster. **/




switch ($_SERVER['HTTP_HOST']) {
    case 'localhost':
        switch (php_uname('n')) {
            case 'BEN-PC':
                define('DB_NAME', 'displayoutletberlin');
                define('DB_USER', 'root');
                define('DB_PASSWORD', '');
                define('DB_HOST', 'localhost');
                define('DB_CHARSET', 'utf8');
                break;
            case 'BEN-LAPTOP':
                define('DB_NAME', 'displayoutletberlin');
                define('DB_USER', 'root');
                define('DB_PASSWORD', '');
                define('DB_HOST', 'localhost');
                define('DB_CHARSET', 'utf8');
                break;
            case 'RKNAPPE':
                define('DB_NAME', 'displayoutletberlin');
                define('DB_USER', 'root');
                define('DB_PASSWORD', '1234');
                define('DB_HOST', 'localhost');
                define('DB_CHARSET', 'utf8');
                break;
            default:
                exit('Set your local environment variables in wp-config.php for your PC called: '.php_uname('n'));
                break;
        }
        break;
    case 'www.display-outlet-berlin.de':
        define('DB_NAME', 'd026e141');
        define('DB_USER', 'd026e141');
        define('DB_PASSWORD', 'suHmHG5FDbwqFB38');
        define('DB_HOST', 'localhost');
        define('DB_CHARSET', 'utf8mb4');
        define('DB_COLLATE', '');
        break;
    default:
        exit("Environment variables in wp-config.php have not been set for this (sub)domain. Uname: ".php_uname('n'). " HTTP Host: " . $_SERVER['HTTP_HOST']);
}

/**#@+
 * Sicherheitsschlüssel
 *
 * Ändere jeden untenstehenden Platzhaltertext in eine beliebige,
 * möglichst einmalig genutzte Zeichenkette.
 * Auf der Seite {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * kannst du dir alle Schlüssel generieren lassen.
 * Du kannst die Schlüssel jederzeit wieder ändern, alle angemeldeten
 * Benutzer müssen sich danach erneut anmelden.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '?>FJ>e?-(I(adVelL~<62?6m5M/b00%}dTW[/=6vEN:>Rz{_,L/7h+pm|^Df&IDC');
define('SECURE_AUTH_KEY',  '~.o3c{PP31g3Dmy_A &^(M;m;HsG6cF2g<TI,__Wv*T W]1+|0sX5/7/5I~QoZy$');
define('LOGGED_IN_KEY',    'Pq7;NiR.FuQv#<U6e4A~nta?xBi0+i*K@yY&YXDXM)hsTnT2Ss`K#O3]QU*Y>`Ot');
define('NONCE_KEY',        '+0Yko,({|j<D5,yM5|pyW~?o%H(i> ]/~rO`Fp0G%&JO|lb &;g&:3!Ze5oh2>H8');
define('AUTH_SALT',        '@YBCV:qonk<cY_K@+<ACJvYU<r}kuqMfR#O]9pBV%o~P~uSb9T&qE)U Pf%?Eo&^');
define('SECURE_AUTH_SALT', '6-?NHOO%rxu0*F$;eWatGczM!HjlnjMmCVKnT^Hv=Uj^2C(6[6?.:56+a).0Uoo4');
define('LOGGED_IN_SALT',   '[pR]dUSj::8{>w5OG35QiO|IkdGGaG%Z&+<KNXk>:p `@}%?DgWMRY{>+5X8DMmN');
define('NONCE_SALT',       'f6+Ai*pz^31/_k~i2uSMbY L/v/2CvyQ_`VN%o>N[sHkF|<)[vLTt7:>=Sx U&))');

/**#@-*/

/**
 * WordPress Datenbanktabellen-Präfix
 *
 * Wenn du verschiedene Präfixe benutzt, kannst du innerhalb einer Datenbank
 * verschiedene WordPress-Installationen betreiben.
 * Bitte verwende nur Zahlen, Buchstaben und Unterstriche!
 */
$table_prefix  = 'dob_';

/**
 * Für Entwickler: Der WordPress-Debug-Modus.
 *
 * Setze den Wert auf „true“, um bei der Entwicklung Warnungen und Fehler-Meldungen angezeigt zu bekommen.
 * Plugin- und Theme-Entwicklern wird nachdrücklich empfohlen, WP_DEBUG
 * in ihrer Entwicklungsumgebung zu verwenden.
 *
 * Besuche den Codex, um mehr Informationen über andere Konstanten zu finden,
 * die zum Debuggen genutzt werden können.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Das war’s, Schluss mit dem Bearbeiten! Viel Spaß beim Bloggen. */
/* That's all, stop editing! Happy blogging. */

/** Der absolute Pfad zum WordPress-Verzeichnis. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Definiert WordPress-Variablen und fügt Dateien ein.  */
require_once(ABSPATH . 'wp-settings.php');
