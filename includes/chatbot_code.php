<div class="chat-container" id="chatbot" style="display: none;">
    <div class="chat-header">
        Chatbot
        <button type="button" class="close" aria-label="Close" id="close-chat">&times;</button>
    </div>
    <div class="chat-body" id="chat-messages"></div>
    <div class="modal-footer">
        <textarea id="message-input" placeholder="Ask a question"></textarea>
        <button id="chat-submit">Send</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Open chatbot
        $("#open-chat").click(function(e) {
            e.preventDefault();
            $("#chatbot").fadeIn();
        });

        // Close chatbot
        $("#close-chat").click(function() {
            $("#chatbot").fadeOut();
        });

        // Send chat message
        $("#chat-submit").click(function() {
            var message = $("#message-input").val().trim();
            if (message !== "") {
                $("#chat-messages").append("<div class='user-message'><strong>You:</strong> " + message + "</div>");
                $("#message-input").val("");

                // Fetch response from chatbot.php
                $.ajax({
                    url: "chatbot.php",
                    type: "POST",
                    data: { user_message: message },
                    success: function(response) {
                        $("#chat-messages").append("<div class='bot-message'><strong>Bot:</strong> " + response + "</div>");
                    }
                });
            }
        });

        // Allow Enter key to send messages
        $("#message-input").keypress(function(e) {
            if (e.which == 13) { // Enter key
                e.preventDefault();
                $("#chat-submit").click();
            }
        });
    });
</script>