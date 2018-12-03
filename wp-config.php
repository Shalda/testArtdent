<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'my_stomat');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Pb{FL<:,TJu(9r},+:v;+LUZz{F/(I (U9a>>3P:?8C!!5Zo79,I$0>#!4Qg#3$/');
define('SECURE_AUTH_KEY',  'vM]5dMZZ&v.Sb4bBDV#dy9|D+;`[7Yd<0{J7yn}|k@;U^y@aY|cxyS6mj->BJ!EZ');
define('LOGGED_IN_KEY',    '&uyr:(Fn~D@BANuB!H[~Y$+[.QP%-7mO;8-H}32~R))n&EEQ[JT)B:02V@CJo=Av');
define('NONCE_KEY',        'WN:Hu#:&4M|lTLBnf-{ ,g>=H~LIE;%4}hePMyl(yYuLUtB|B02uBa/HLL;bp?>-');
define('AUTH_SALT',        'tJ]9xWwav<}98GzUI)mdApY{g6bc$4CU}MJFnW=H)+|!6nX%jz?|,3mYVB8|iB-y');
define('SECURE_AUTH_SALT', 'Z<s~G:b-kb.[M*JTu>3z?KUq+3!d-rCDERKmwjT5+x}D|]?ZH=%%0{]KD1hAdIZm');
define('LOGGED_IN_SALT',   'pI[#tyKinFR!<Z0(3d6qE8opz?9.;VQhcl<+$ y/{/znz i_4tS64-Kk}MqWa~3-');
define('NONCE_SALT',       '?MGz4jm-[<2@8}<l:f&ej>H!)3X+Ue}*B{7G)6|fjUX{sKjhgF9)tf|`u&f^W}_+');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
