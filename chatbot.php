<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['user_message'])) {
    $message = addslashes($_POST['user_message']);

    $apiKey = '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'; 
    $apiUrl = 'https://api.openai.com/v1/chat/completions';

    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ];

    $postData = [
        'model' => 'gpt-4o-mini', 
        'messages' => [
            [
                'role' => 'system',
                'content' => 'You are a chatbot assisting users on an educational website about dance traditions worldwide.'
            ],
            [
                'role' => 'user',
                'content' => $message
            ]
        ],
        'temperature' => 0.7
    ];

    $ch = curl_init($apiUrl);

    curl_setopt_array($ch, [
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($postData)
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get the HTTP status code

    if ($response === false) {
        echo json_encode(['error' => 'cURL error: ' . curl_error($ch)]);
    } else {
        $decoded_response = json_decode($response, true);

        if ($httpCode !== 200) {
            // Log the raw response if the API returns an error (debug)
            echo json_encode([
                'error' => 'API error: ' . ($decoded_response['error']['message'] ?? 'Unknown error'),
                'status' => $httpCode,
                'response' => $response
            ]);
        } else {
            $bot_message = $decoded_response['choices'][0]['message']['content'] ?? 'Sorry, I couldn\'t process your request right now.';
            echo nl2br(json_encode(['response' => $bot_message])); //  line breaks 
        }
    }

    curl_close($ch);
    exit();
}
?>
