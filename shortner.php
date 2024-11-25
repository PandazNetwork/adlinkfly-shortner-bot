<?php

define('API_TOKEN', ''); // Replace with your bot token, For Example: 7865384510:AAHxxxxxZpKagaHbTI-JVGByPZpPzSc9hn4
define('SHORTENER_API_TOKEN', ''); // Your shortener API token, For Example: 5f82d8793husjkb1268e8a4d3e7b4911e217d20a
define('SHORTENER_API_URL', ''); // Shortener API URL, For Example: https://pandaznetwork.com/api

// Get the incoming webhook updates
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update || !isset($update["message"])) {
    exit("Invalid webhook payload");
}

$message = $update["message"];
$chat_id = $message["chat"]["id"];
$text = $message["text"] ?? '';

if (strpos($text, '/start') === 0) {
    // Handle /start command
    $keyboard = [
        [
            ['text' => 'Updates Channel', 'url' => 'https://t.me/your_updates_channel'],
            ['text' => 'Support Group', 'url' => 'https://t.me/your_support_group']
        ],
        [
            ['text' => 'Deploy', 'url' => 'https://github.com/pandaznetwork/Adlinkflyshortnerbot']
        ]
    ];

    $response = [
        'chat_id' => $chat_id,
        'text' => "ðŸ‘‹ Hello!\n\nI'm your link shortener bot. Just send me a link, and I'll shorten it for you!",
        'reply_markup' => json_encode(['inline_keyboard' => $keyboard])
    ];

    sendRequest("sendMessage", $response);
} elseif (preg_match_all('/https?:\/\/\S+/', $text, $matches)) {
    // Handle links in the message
    $links = $matches[0];
    $shortened_links = [];
    foreach ($links as $link) {
        $short_link = getShortLink($link);
        if ($short_link) {
            $shortened_links[] = $short_link;
        } else {
            $shortened_links[] = "Error shortening: $link";
        }
    }

    $response_text = implode("\n", $shortened_links);

    sendRequest("sendMessage", [
        'chat_id' => $chat_id,
        'text' => $response_text
    ]);
}

function sendRequest($method, $data) {
    $url = "https://api.telegram.org/bot" . API_TOKEN . "/" . $method;

    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => json_encode($data)
        ]
    ];
    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}

function getShortLink($url) {
    $long_url = urlencode($url);
    $api_url = SHORTENER_API_URL . "?api=" . SHORTENER_API_TOKEN . "&url=" . $long_url;

    $response = @file_get_contents($api_url);
    if (!$response) {
        return null; // Return null if the request fails
    }

    $result = json_decode($response, true);
    if (isset($result["status"]) && $result["status"] === "success") {
        return $result["shortenedUrl"];
    } elseif (isset($result["message"])) {
        return "Error: " . $result["message"];
    }

    return null; // Return null for unknown errors
}

?>
