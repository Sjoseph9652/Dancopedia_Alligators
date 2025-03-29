<?php
if (!isset($_SESSION)) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "gatorz_db";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['user_message'])) {
    $message = strtolower(trim($_POST['user_message']));

    //  region input
    if (isset($_SESSION['awaiting_region']) && isset($_SESSION['dance_name'])) {
        $_SESSION['dance_region'] = ucfirst($message);
        unset($_SESSION['awaiting_region']);
        $_SESSION['awaiting_style'] = true;
        echo "Got it! Now, what style does '{$_SESSION['dance_name']}' belong to?";
        exit();
    }

    // style input
    if (isset($_SESSION['awaiting_style']) && isset($_SESSION['dance_name'])) {
        $_SESSION['dance_style'] = ucfirst($message);
        unset($_SESSION['awaiting_style']);


        $dance_name = $_SESSION['dance_name'];
        $region = $_SESSION['dance_region'];
        $style = $_SESSION['dance_style'];
        $creator_email = "admin@example.com";
        $status = 0;
        $dance_description = $_SESSION['dance_description'] ?? 'No description available.';

        // Insert into database
		$stmt = $conn->prepare("INSERT INTO dances (name, creator_email, region, style, description, status, image, MimeType, Link)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
      // Set default values for image
		$default_image = "default.jpg"; // Change this to a valid image filename or URL
		$default_mime = "image/jpeg"; // Change this to match your default image type
		$default_link = "https://example.com/default-dance.jpg"; // Example link if needed

		$stmt->bind_param("ssssissss", $dance_name, $creator_email, $region, $style, $dance_description, $status, $default_image, $default_mime, $default_link);

        if ($stmt->execute()) {
            echo "✅ The dance '$dance_name' (Region: $region, Style: $style) has been successfully added to the database!";
        } else {
            echo "❌ Error: " . $stmt->error;
        }

        $stmt->close();

        // Clear session data
        unset($_SESSION['dance_name'], $_SESSION['dance_region'], $_SESSION['dance_style'], $_SESSION['dance_description']);
        exit();
    }

    if (isset($_SESSION['awaiting_dance_confirmation']) && isset($_SESSION['dance_name'])) {
        if ($message === 'yes') {
            $_SESSION['awaiting_region'] = true;
            unset($_SESSION['awaiting_dance_confirmation']);
            echo "Great! What region is '{$_SESSION['dance_name']}' associated with?";
        } else {
            echo "Dance addition canceled.";
            unset($_SESSION['awaiting_dance_confirmation'], $_SESSION['dance_name'], $_SESSION['dance_description']);
        }
        exit();
    }

    // Chatbot API
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
                'content' => 'You are a chatbot assisting users on an educational website about dance traditions worldwide. If a user expresses interest in adding a dance, confirm first, then ask them for region and style step by step.'
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

            // Extract dance name and description
            if (preg_match('/\b([A-Z][a-z]+(?:\s[A-Z][a-z]+)?)\b.*?is\s.*?\b(\w+ dance|style|tradition)\b/i', $bot_message, $matches)) {
                $_SESSION['dance_name'] = trim($matches[1]);
                $_SESSION['dance_description'] = $bot_message;
                $_SESSION['awaiting_dance_confirmation'] = true;
                echo "$bot_message\n\nWould you like to add the dance '{$_SESSION['dance_name']}' to the database? (yes/no)";
                exit();
            }

            echo $bot_message;
        }
    }

    curl_close($ch);
    exit();
}
?>
