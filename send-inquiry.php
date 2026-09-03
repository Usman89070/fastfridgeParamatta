<?php
/**
 * Receives a POST from the site's contact/booking forms (via fetch, no page
 * reload) and emails the submitted details straight to the business inbox -
 * so a query lands in info@fridgerepairparramatta.com.au without the visitor
 * ever having to open their own mail app. Always responds with JSON.
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

const RECIPIENT = 'info@fridgerepairparramatta.com.au';

function respond(bool $success, string $message): void {
    http_response_code($success ? 200 : 400);
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// Honeypot: a hidden field real visitors never see or fill. If it arrives
// non-empty, silently pretend success so the bot moves on without learning
// this rejected it.
if (trim($_POST['website'] ?? '') !== '') {
    respond(true, 'Thanks - we\'ll be in touch shortly.');
}

/**
 * Collapse a submitted field to a single trimmed line, stripping any
 * carriage-return/newline so a crafted field value can't inject extra
 * mail headers (the classic PHP-mail header-injection attack).
 */
function clean_line(string $key, int $maxLength = 200): string {
    $value = $_POST[$key] ?? '';
    $value = str_replace(["\r", "\n"], ' ', (string) $value);
    $value = trim($value);
    return mb_substr($value, 0, $maxLength);
}

function clean_multiline(string $key, int $maxLength = 2000): string {
    $value = trim((string) ($_POST[$key] ?? ''));
    // Normalise stray \r so the body doesn't end up with mixed line endings.
    $value = str_replace("\r\n", "\n", $value);
    $value = str_replace("\r", "\n", $value);
    return mb_substr($value, 0, $maxLength);
}

$formType = clean_line('form_type', 40) ?: 'contact';
$name     = clean_line('name');
$phone    = clean_line('phone');
$email    = clean_line('email');
$suburb   = clean_line('suburb');
$service  = clean_line('service');
$brand    = clean_line('brand');
$date     = clean_line('date');
$timeSlot = clean_line('time_slot');
$message  = clean_multiline('message');

if ($name === '' || $phone === '') {
    respond(false, 'Please fill in your name and phone number.');
}

$validEmail = null;
if ($email !== '') {
    $filtered = filter_var($email, FILTER_VALIDATE_EMAIL);
    if ($filtered !== false) {
        $validEmail = $filtered;
    }
}

$isBooking = $formType === 'booking';
$subject = ($isBooking ? 'New Booking Request' : 'New Website Enquiry') . ' - ' . $name . ($suburb !== '' ? ' (' . $suburb . ')' : '');

$lines = [];
$lines[] = ($isBooking ? 'New online booking request' : 'New enquiry') . ' from fridgerepairparramatta.com.au';
$lines[] = str_repeat('-', 48);
$lines[] = 'Name: ' . $name;
$lines[] = 'Phone: ' . $phone;
if ($validEmail !== null) {
    $lines[] = 'Email: ' . $validEmail;
}
if ($suburb !== '') {
    $lines[] = 'Suburb: ' . $suburb;
}
if ($service !== '') {
    $lines[] = 'Service: ' . $service;
}
if ($brand !== '') {
    $lines[] = 'Appliance brand: ' . $brand;
}
if ($date !== '' || $timeSlot !== '') {
    $lines[] = 'Preferred time: ' . trim($date . ' ' . $timeSlot);
}
if ($message !== '') {
    $lines[] = '';
    $lines[] = 'Message / symptom:';
    $lines[] = $message;
}
$lines[] = '';
$lines[] = str_repeat('-', 48);
$lines[] = 'Submitted: ' . date('j F Y, g:ia');

$body = implode("\n", $lines);

$fromDomain = preg_replace('/^www\./', '', (string) ($_SERVER['HTTP_HOST'] ?? 'fridgerepairparramatta.com.au'));
$fromDomain = preg_replace('/[^a-z0-9.\-]/i', '', $fromDomain) ?: 'fridgerepairparramatta.com.au';

$headers = [];
$headers[] = 'From: Fridge Repair Parramatta Website <no-reply@' . $fromDomain . '>';
if ($validEmail !== null) {
    $headers[] = 'Reply-To: ' . $name . ' <' . $validEmail . '>';
}
$headers[] = 'Content-Type: text/plain; charset=UTF-8';

$sent = @mail(RECIPIENT, $subject, $body, implode("\r\n", $headers));

if (!$sent) {
    respond(false, 'Sorry, something went wrong sending your details. Please email us directly at info@fridgerepairparramatta.com.au.');
}

respond(true, 'Thanks - we\'ll be in touch shortly.');
