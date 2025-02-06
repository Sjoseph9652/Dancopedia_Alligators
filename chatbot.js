$(document).ready(function () {
    // Close chatbot modal when clicking the close button
    $(".close").click(function () {
        $(".chat-container").hide(); // Hide the chatbot container
    });

    // Handle opening the chatbot when clicking the "Chat" link in the navbar
    $("#open-chat").click(function (event) {
        event.preventDefault(); // Prevent the default link behavior
        $(".chat-container").toggle(); // Toggle the visibility of the chatbot container
    });

    // Handle sending messages
    $("#chat-submit").click(function (event) {
        event.preventDefault(); // Prevent default behavior (form submission)
        
        var userMessage = $("#message-input").val();
        if (userMessage.trim() !== "") {
            appendUserMessage(userMessage);
            sendMessageToChatbot(userMessage);
            $("#message-input").val(""); // Clear the input field
        }
    });

    function appendUserMessage(message) {
        // Append the user message to the chat
        $("#chat-messages").append('<div class="message user-message">' + message + '</div>');
        $("#chat-messages").scrollTop($("#chat-messages")[0].scrollHeight); // Auto-scroll to the bottom
    }

    function sendMessageToChatbot(message) {
        $("#chat-submit").prop("disabled", true); // Disable the send button while sending

        $.ajax({
            type: "POST",
            url: "chatbot.php", // Your chatbot PHP endpoint
            data: { input: message }, // Send the user message to the server
            success: function (response) {
                // Append the bot's response to the chat
                $("#chat-messages").append('<div class="message bot-message">' + response + '</div>');
                $("#chat-messages").scrollTop($("#chat-messages")[0].scrollHeight); // Auto-scroll to the bottom
            },
            error: function () {
                // In case of error, append an error message
                $("#chat-messages").append('<div class="message error-message">Error: Unable to connect.</div>');
                $("#chat-messages").scrollTop($("#chat-messages")[0].scrollHeight); // Auto-scroll to the bottom
            },
            complete: function () {
                $("#chat-submit").prop("disabled", false); // Enable the send button again
            }
        });
    }
});
