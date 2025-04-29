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

$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// OpenAI API Key
$apiKey = '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';
$apiUrl = 'https://api.openai.com/v1/chat/completions';

// Handle Image Upload
if (isset($_FILES['dance_image'])) {
    $image = $_FILES['dance_image'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileType = mime_content_type($image['tmp_name']);

    if (in_array($fileType, $allowedTypes)) {
        $fileName = uniqid() . "_" . basename($image['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($image['tmp_name'], $filePath)) {
            $_SESSION['dance_image'] = $filePath;
            echo "✅ Image uploaded successfully! Please enter a video URL.";
        } else {
            echo "❌ Error moving uploaded file.";
        }
    } else {
        echo "❌ Invalid image format. Please upload a JPG, PNG, or GIF.";
    }
    exit();
}

// Video URL Submission
if (isset($_POST['video_url'])) {
    $_SESSION['dance_video'] = $_POST['video_url'];
    
    $stmt = $conn->prepare("INSERT INTO dances (name, creator_email, region, style, description, status, image, MimeType, Link) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $dance_name = $_SESSION['dance_name'] ?? "Unknown Dance";
    $region = $_SESSION['dance_region'] ?? "Unknown Region";
    $style = $_SESSION['dance_style'] ?? "Unknown Style";
    $creator_email = "admin@example.com";
    $status = 0;
    $description = $_SESSION['dance_description'] ?? 'No description available.';
    $imagePath = $_SESSION['dance_image'] ?? "default.jpg";
    $videoUrl = $_SESSION['dance_video'] ?? null;

    $mimeType = mime_content_type($imagePath);

    $stmt->bind_param("ssssissss", $dance_name, $creator_email, $region, $style, $description, $status, $imagePath, $mimeType, $videoUrl);

    if ($stmt->execute()) {
        echo "✅ The dance '$dance_name' has been successfully added to the database!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    exit();
}

// Handle Text Input from Chat
if (isset($_POST['user_message'])) {
    $message = strtolower(trim($_POST['user_message']));
    $pattern = '/(what is|tell me about|explain|describe|give me information about|talk about)\s(.+)/i';

    if (preg_match($pattern, $message, $matches)) {
        $dance_name = ucfirst(trim($matches[2])); // Extract dance name from user message
        $_SESSION['dance_name'] = $dance_name;

        // Fetch description from GPT-4o-mini
        $postData = [
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an assistant knowledgeable about dance traditions from all over the world. Provide detailed descriptions when asked about specific dances.'],
                ['role' => 'user', 'content' => $message]  // Send the user's original message directly
            ],
            'temperature' => 0.7
        ];


        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            echo "❌ Error: " . curl_error($ch);
            curl_close($ch);
            exit();
        }

        $decodedResponse = json_decode($response, true);

        if ($httpCode !== 200 || empty($decodedResponse['choices'][0]['message']['content'])) {
            echo "❌ Error: Could not retrieve description for $dance_name.";
        } else {
            $description = $decodedResponse['choices'][0]['message']['content'];
            $_SESSION['dance_description'] = $description;

            echo "$description\n\nWould you like to add the dance '$dance_name' to the database? (yes/no)";
        }

        curl_close($ch);
        exit();
    }

    if ($message === 'yes') {
        $_SESSION['awaiting_region'] = true;
        echo "Great! What region is '{$_SESSION['dance_name']}' associated with?";
        exit();
    }

    if (isset($_SESSION['awaiting_region'])) {
        $_SESSION['dance_region'] = ucfirst($message);
        unset($_SESSION['awaiting_region']);
        $_SESSION['awaiting_style'] = true;
        echo "Got it! Now, what style does '{$_SESSION['dance_name']}' belong to?";
        exit();
    }

    if (isset($_SESSION['awaiting_style'])) {
        $_SESSION['dance_style'] = ucfirst($message);
        unset($_SESSION['awaiting_style']);
        $_SESSION['awaiting_image_upload'] = true;
        echo "Great! Please upload an image for '{$_SESSION['dance_name']}'.";
        exit();
    }

    echo "Sorry, I didn't understand your message.";
    exit();
}

echo "No valid request received.";
exit();
