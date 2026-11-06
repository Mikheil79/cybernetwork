<?php
// ===== CyberNetwork: общая инициализация =====
// Каждая страница в /GEO/, /ENG/, /RUS/ начинается строкой:
//   require $_SERVER['DOCUMENT_ROOT'] . '/inc/init.php';
// Язык определяется по папке, в которой лежит страница.

define('ROOT', dirname(__DIR__));
define('BASE', '/');                 // путь к сайту от корня домена
define('SITE', 'CyberNetwork');
define('LANGS', ['GEO' => 'ka', 'ENG' => 'en', 'RUS' => 'ru']); // папка => код языка для <html lang>
define('DEFAULT_LANG', 'GEO');
define('TOPICS', ['windows', 'linux', 'android', 'hardware', 'ai']); // меню тем и рубрики агента cyber-news

// "GEO/news/2026/october/ai/x.php" -> язык GEO, страница "news/2026/october/ai/x.php"
$parts = explode('/', trim(substr($_SERVER['SCRIPT_NAME'], strlen(BASE)), '/'), 2);
define('LANG', isset(LANGS[$parts[0]]) ? $parts[0] : DEFAULT_LANG);
define('PAGE', isset(LANGS[$parts[0]]) && isset($parts[1]) ? $parts[1] : 'index.php');
unset($parts);

$T = require ROOT . '/lang/' . LANG . '.php';

require __DIR__ . '/functions.php';
require __DIR__ . '/icons.php';
