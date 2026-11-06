<?php
// ===== უკუკავშირის ფორმის დამუშავება (/<LANG>/contact.php) =====

// TODO: ჩაანაცვლეთ რეალური მისამართით
$to = 'info@example.com';
$log = __DIR__ . '/data/messages.php';

// ფორმა აგზავნის ენას ფარული ველით lang (GEO, ENG, RUS)
$lang = isset($_POST['lang']) && in_array($_POST['lang'], array('GEO', 'ENG', 'RUS'), true) ? $_POST['lang'] : 'GEO';

function back($status) {
	global $lang;
	header('Location: /' . $lang . '/contact.php?status=' . $status . '#form');
	exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	back('error');
}

// სპამ-ბოტი შეავსებს უხილავ ველს - ვაჩვენებთ წარმატებას, მაგრამ არაფერს ვაგზავნით
if (!empty($_POST['website'])) {
	back('sent');
}

$name    = trim(isset($_POST['name']) ? $_POST['name'] : '');
$email   = trim(isset($_POST['email']) ? $_POST['email'] : '');
$subject = trim(isset($_POST['subject']) ? $_POST['subject'] : '');
$message = trim(isset($_POST['message']) ? $_POST['message'] : '');

// სათაურებში ახალი ხაზი არ უნდა მოხვდეს
$name    = str_replace(array("\r", "\n"), ' ', $name);
$subject = str_replace(array("\r", "\n"), ' ', $subject);

if ($name === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)
	|| mb_strlen($name) > 100 || mb_strlen($email) > 150
	|| mb_strlen($subject) > 150 || mb_strlen($message) > 5000) {
	back('error');
}

// შეტყობინებას ვინახავთ ფაილში (PHP-ის თავსართი ბრაუზერიდან წაკითხვას კრძალავს)
if (!is_dir(dirname($log))) {
	mkdir(dirname($log), 0755, true);
}
if (!file_exists($log)) {
	file_put_contents($log, "<?php exit; ?>\n");
}
$entry = array(
	'date'    => date('Y-m-d H:i:s'),
	'name'    => $name,
	'email'   => $email,
	'subject' => $subject,
	'message' => $message,
);
$saved = file_put_contents($log, json_encode($entry, JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND | LOCK_EX) !== false;

// წერილის გაგზავნა
$mailSubject = '=?UTF-8?B?' . base64_encode('CyberNetwork: ' . ($subject !== '' ? $subject : 'ახალი შეტყობინება')) . '?=';
$body = "სახელი: $name\nელფოსტა: $email\nთემა: $subject\n\n$message\n";
$headers = "From: CyberNetwork <noreply@cybernetwork.local>\r\n"
	. "Reply-To: $email\r\n"
	. "MIME-Version: 1.0\r\n"
	. "Content-Type: text/plain; charset=UTF-8\r\n"
	. "Content-Transfer-Encoding: base64";
$mailed = @mail($to, $mailSubject, chunk_split(base64_encode($body)), $headers);

back($saved || $mailed ? 'sent' : 'error');
