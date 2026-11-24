<?php
/**
 * Land Istanbul — contact / lead form handler (v2).
 * - Sends every inquiry to info@landistanbul.com as before (now UTF-8 safe for Arabic/Russian names).
 * - Also saves each inquiry to /_private/leads.jsonl (web access denied) so leads are never lost.
 * - Accepts email OR phone, records the page and language the lead came from, drops spam bots (honeypot).
 * Original file is backed up in /_private/backups/mail.php.orig.
 */
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

function li_field($key, $max = 1000) {
    if (!isset($_POST[$key])) return '';
    $v = trim(strip_tags((string)$_POST[$key]));
    $v = str_replace(["\r\n", "\r"], "\n", $v);
    return function_exists('mb_substr') ? mb_substr($v, 0, $max) : substr($v, 0, $max);
}
function li_oneline($v) {
    return trim(preg_replace('/[\r\n\t]+/', ' ', $v));
}

// Honeypot: real visitors never fill this hidden field.
if (li_field('website') !== '') {
    echo json_encode(['success' => true, 'message' => 'Your message has been sent successfully!']);
    exit;
}

$name     = li_oneline(trim(li_field('name', 120) . ' ' . li_field('lastname', 120)));
$email    = li_oneline(li_field('email', 200));
$phone    = li_oneline(li_field('phone', 60));
$budget   = li_oneline(li_field('budget', 100));
$interest = li_oneline(li_field('interest', 120));
$message  = li_field('message', 4000);
$source   = li_oneline(li_field('source', 300));
$lang     = li_oneline(li_field('lang', 5));
$referer  = isset($_SERVER['HTTP_REFERER']) ? li_oneline(substr(strip_tags($_SERVER['HTTP_REFERER']), 0, 300)) : '';
if ($source === '') $source = $referer;

// Extra details from the valuation form and the tax calculator: every field named p_* (arrays joined).
$details = [];
foreach ($_POST as $key => $val) {
    if (strpos($key, 'p_') !== 0) continue;
    if (is_array($val)) $val = implode(', ', array_map(function ($v) { return trim(strip_tags((string)$v)); }, $val));
    $val = trim(strip_tags((string)$val));
    if ($val === '') continue;
    $label = ucfirst(str_replace('_', ' ', substr($key, 2)));
    $details[$label] = function_exists('mb_substr') ? mb_substr($val, 0, 2000) : substr($val, 0, 2000);
    if (count($details) >= 30) break;
}

$emailValid = $email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL);
$phoneDigits = preg_replace('/\D+/', '', $phone);

if ($name === '' || ($email !== '' && !$emailValid) || (!$emailValid && strlen($phoneDigits) < 6)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}

// 1) Save the lead (never lose an inquiry, even if the mail server fails).
$saved = false;
$privDir = __DIR__ . '/_private';
if (!is_dir($privDir)) @mkdir($privDir, 0755, true);
if (is_dir($privDir)) {
    if (!file_exists($privDir . '/.htaccess')) {
        @file_put_contents($privDir . '/.htaccess', "<IfModule mod_authz_core.c>\n  Require all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\n  Order allow,deny\n  Deny from all\n</IfModule>\n");
    }
    $row = [
        'received_at' => date('c'),
        'name' => $name,
        'email' => $emailValid ? $email : '',
        'phone' => $phone,
        'interest' => $interest,
        'budget' => $budget,
        'message' => $message,
        'source' => $source,
        'lang' => $lang,
        'details' => $details,
    ];
    $saved = @file_put_contents($privDir . '/leads.jsonl', json_encode($row, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n", FILE_APPEND | LOCK_EX) !== false;
}

// 2) Email notification.
$to      = 'info@landistanbul.com';
$subject = 'New Inquiry from Land Istanbul Website' . ($interest !== '' ? ' — ' . $interest : '');

$body  = "You have received a new inquiry from the Land Istanbul website.\n\n";
$body .= "-------------------------------------------\n";
$body .= "Name    : $name\n";
if ($emailValid) $body .= "Email   : $email\n";
if ($phone)    $body .= "Phone   : $phone\n";
if ($budget)   $body .= "Budget  : $budget\n";
if ($interest) $body .= "Interest: $interest\n";
if ($lang)     $body .= "Language: $lang\n";
if ($message)  $body .= "Message : $message\n";
if ($source)   $body .= "Page    : $source\n";
if ($phoneDigits !== '') $body .= "WhatsApp: https://wa.me/$phoneDigits\n";
if ($details) {
    $body .= "\nDetails:\n";
    foreach ($details as $k => $v) $body .= "  $k: $v\n";
}
$body .= "-------------------------------------------\n";
$body .= "Sent from: landistanbul.com\n";

$encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
$headers  = "From: Land Istanbul <noreply@landistanbul.com>\r\n";
if ($emailValid) $headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

$sent = @mail($to, $encodedSubject, $body, $headers);

if ($sent || $saved) {
    echo json_encode(['success' => true, 'message' => 'Your message has been sent successfully!']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to send message. Please try again.']);
}
