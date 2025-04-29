<div class="chat-container" id="chatbot" style="display: none;">
    <div class="chat-header">
        Chatbot
        <button type="button" class="close" aria-label="Close" id="close-chat">&times;</button>
    </div>
    <div class="chat-body" id="chat-messages"></div>
    <div class="modal-footer">
        <textarea id="message-input" placeholder="Ask a question"></textarea>
        <button id="chat-submit">Send</button>
        
        <!-- Hidden File Input for Image Upload -->
        <input type="file" id="imageUpload" accept="image/*" style="display: none;">
        <button id="uploadButton" style="display: none;">Upload Image</button>
        
        <!-- Video URL Input -->
        <input type="text" id="videoUrlInput" placeholder="Enter Video URL" style="display: none;">
        <button id="submitVideoUrl" style="display: none;">Submit Video URL</button>

        <!-- Progress Bar -->
        <div id="progressWrapper" style="display:none;">
            <progress id="uploadProgress" value="0" max="100"></progress>
            <span id="progressPercent">0%</span>
        </div>
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

                $.ajax({
                    url: "chatbot.php",
                    type: "POST",
                    data: { user_message: message },
                    success: function(response) {
                        console.log("Server Response: ", response);  // Debugging: Log the response to the console
                        $("#chat-messages").append("<div class='bot-message'><strong>Bot:</strong> " + response + "</div>");
                        
                        // Display Upload Button
                        if (/upload.*image/i.test(response)) {  
                            $("#uploadButton").show();
                        } else {
                            $("#uploadButton").hide();
                        }
                        
                        // Display Video URL 
                        if (response.includes("Please enter a video URL")) {
                            $("#videoUrlInput").show();
                            $("#submitVideoUrl").show();
                        }
                    }
                });
            }
        });

        //  to send messages
        $("#message-input").keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                $("#chat-submit").click();
            }
        });

        // Image Upload Handling
        $("#uploadButton").click(function() {
            $("#imageUpload").click();
        });

        $("#imageUpload").change(function() {
            let formData = new FormData();
            formData.append("dance_image", $("#imageUpload")[0].files[0]);

            $("#progressWrapper").show();

            $.ajax({
                url: "chatbot.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                xhr: function() {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(event) {
                        if (event.lengthComputable) {
                            var percent = (event.loaded / event.total) * 100;
                            $("#uploadProgress").val(percent);
                            $("#progressPercent").text(Math.round(percent) + "%");
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    console.log("Image Upload Response: ", response);  // Debugging: Log the response to the console
                    $("#chat-messages").append("<div class='bot-message'><strong>Bot:</strong> " + response + "</div>");
                    $("#uploadButton").hide();
                    $("#progressWrapper").hide();
                    $("#videoUrlInput").show();
                    $("#submitVideoUrl").show();
                },
                error: function() {
                    $("#chat-messages").append("<div class='bot-message'><strong>Bot:</strong> Error uploading image.</div>");
                    $("#progressWrapper").hide();
                }
            });
        });

        // Video URL 
        $("#submitVideoUrl").click(function() {
            var videoUrl = $("#videoUrlInput").val().trim();

            if (videoUrl !== "") {
                $.ajax({
                    url: "chatbot.php",
                    type: "POST",
                    data: { video_url: videoUrl },
                    success: function(response) {
                        console.log("Video URL Response: ", response);  // Debugging: Log the response to the console
                        $("#chat-messages").append("<div class='bot-message'><strong>Bot:</strong> " + response + "</div>");
                        $("#videoUrlInput").hide();
                        $("#submitVideoUrl").hide();
                    }
                });
            }
        });
    });
</script>