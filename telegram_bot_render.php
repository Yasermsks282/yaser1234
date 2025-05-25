<?php
// Telegram Bot Token
$token = "7686704866:AAES2w-g3-Gommd_qHMCMHIJThYY02oPiqQ";
$admin_id = 7690150728;

// استقبال التحديث من Telegram
$update = json_decode(file_get_contents("php://input"), true);

if (!$update || !isset($update["message"])) exit;

$message = $update["message"];
$text = $message["text"] ?? '';
$chat_id = $message["chat"]["id"];
$name = $message["from"]["first_name"] ?? '';
$username = $message["from"]["username"] ?? '';

// إرسال رسالة
function sendMessage($chat_id, $text) {
    global $token;
    $url = "https://api.telegram.org/bot$token/sendMessage";

    $data = [
        'chat_id' => $chat_id,
        'text' => $text
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context  = stream_context_create($options);
    file_get_contents($url, false, $context);
}

// استجابة للأوامر
if ($text == "/start") {
    sendMessage($chat_id, "مرحباً $name! أرسل أي رسالة وسنقوم بالرد عليك.");
} else {
    // يرسل نسخة للمدير
    $forward = "رسالة من @$username ($name):\n\n$text";
    sendMessage($admin_id, $forward);
    sendMessage($chat_id, "تم استلام رسالتك وسنقوم بالرد عليك قريباً.");
}
?>