<?php
// ===== Вспомогательные функции =====

// Строка интерфейса из файла переводов lang/<LANG>.php
function t($key) {
	global $T;
	return isset($T[$key]) ? $T[$key] : $key;
}

function e($s) {
	return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// Поле JSON с переводами {"GEO": "...", "ENG": "...", "RUS": "..."} -> текст на текущем языке
function tr($field) {
	if (!is_array($field)) return $field;
	return isset($field[LANG]) ? $field[LANG] : $field[DEFAULT_LANG];
}

// Ссылка на общий файл: url('css/style.css') -> /css/style.css
function url($path = '') {
	return BASE . $path;
}

// Ссылка внутри языковой папки: lurl('news.php') -> /GEO/news.php
function lurl($path = '', $lang = LANG) {
	return BASE . $lang . '/' . $path;
}

// Та же страница на другом языке; если её там нет — главная этого языка
function lang_url($lang) {
	if (!file_exists(ROOT . '/' . $lang . '/' . PAGE)) return lurl('', $lang);
	$path = PAGE === 'index.php' ? '' : (substr(PAGE, -10) === '/index.php' ? substr(PAGE, 0, -9) : PAGE);
	$query = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? '?' . $_SERVER['QUERY_STRING'] : '';
	return lurl($path, $lang) . $query;
}

// "2026-10-12" -> "12 ოქტომბერი 2026" / "12 October 2026" / "12 октября 2026"
function date_text($ymd) {
	$d = explode('-', $ymd);
	return (int)$d[2] . ' ' . t('months_of')[(int)$d[1] - 1] . ' ' . $d[0];
}

// "2026-10" -> "ოქტომბერი 2026" / "October 2026" / "Октябрь 2026"
function month_text($ym) {
	$d = explode('-', $ym);
	return t('months')[(int)$d[1] - 1] . ' ' . $d[0];
}

function today_text() {
	return t('days')[(int)date('w')] . ', ' . date_text(date('Y-m-d'));
}

// Число со словом: plural(3, t('news_count')) -> "3 новости"
function plural($n, $forms) {
	if (LANG === 'RUS') {
		$i = ($n % 10 == 1 && $n % 100 != 11) ? 0 : (($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20)) ? 1 : 2);
	} else {
		$i = $n == 1 ? 0 : 1;
	}
	return $n . ' ' . $forms[min($i, count($forms) - 1)];
}

function cat_name($cat) {
	$cats = t('cats');
	return isset($cats[$cat]) ? $cats[$cat] : $cat;
}

function load_json($name) {
	static $cache = [];
	if (!isset($cache[$name])) {
		$file = ROOT . '/data/' . $name . '.json';
		$data = file_exists($file) ? json_decode(file_get_contents($file), true) : null;
		$cache[$name] = is_array($data) ? $data : [];
	}
	return $cache[$name];
}

// Статьи (data/articles.json) по id, в порядке карточек на главной
function articles() {
	$list = [];
	foreach (load_json('articles') as $a) $list[$a['id']] = $a;
	return $list;
}

function article($id) {
	$list = articles();
	return isset($list[$id]) ? $list[$id] : null;
}

// Новости (data/news.json), новые сверху
function news_items() {
	$list = load_json('news');
	usort($list, function ($a, $b) { return strcmp($b['date'], $a['date']); });
	return $list;
}

function news_item($id) {
	foreach (load_json('news') as $n) {
		if ($n['id'] === $id) return $n;
	}
	return null;
}

// Ссылка на новость: своя страница или якорь в ленте
function news_link($n) {
	return !empty($n['path']) ? lurl($n['path']) : lurl('news.php') . '#news-' . $n['id'];
}

// Месяцы, в которых есть новости со своей страницей: ["2026-10" => 3, ...], новые сверху
function news_months() {
	$months = [];
	foreach (news_items() as $n) {
		if (empty($n['path'])) continue;
		$m = substr($n['date'], 0, 7);
		$months[$m] = isset($months[$m]) ? $months[$m] + 1 : 1;
	}
	return $months;
}
