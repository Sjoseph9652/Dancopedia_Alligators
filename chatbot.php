<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/f40040d297.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/chatbot.css">
</head>
<body>

<?php 
if (isset($_POST['input'])) {
    $message = '{"role": "user", "content": "' . addslashes($_POST['input']) . '"}';
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer APIKEYHERE'
    ];
    
    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    $json_data = '{"model":"gpt-3.5-turbo",
        "messages": [{"role": "system", "content": "You are a chatbot assisting users on an educational website about Indian history and traditional outfits."}, ' . $message . ']}';

    curl_setopt_array($ch, [
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $json_data
    ]);
    
    $response = curl_exec($ch);
    if ($response === false) {
        echo "Request error: " . curl_error($ch);
    } else {
        $decoded_response = json_decode($response, true);
        echo isset($decoded_response['choices'][0]['message']['content']) ? $decoded_response['choices'][0]['message']['content'] : 'Error processing response';
    }
    curl_close($ch);
    exit();
}
?>

<div class="chat-box-container">
    <button class="open-button">Chat <i class="fa-regular fa-comment"></i></button>
    <div class="chat-popup" id="myForm">
        <form id="chat-form" class="form-container">
            <div class="chat-header">Chat</div>
            <div class="chat-messages" id="chat-messages"></div>
            <textarea placeholder="Type your message..." name="input" required></textarea>
            <button id="chat-submit" type="submit" class="btn">Send <i class="fa-regular fa-paper-plane"></i></button>
            <button type="button" class="btn cancel">Close</button>
        </form>
    </div> 
</div>

</body>
</html>
