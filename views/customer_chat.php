<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ChatApp - Stunning UI</title>
  <link rel="stylesheet" href="../global.css">
  <link rel="stylesheet" href="../css/chat.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <main class="chat-area">
      <div class="chat-header">
        <!-- Back arrow button -->
        <button class="back-button" onclick="goBack()">
          <i class="fas fa-arrow-left"></i>
        </button>
        <img src="https://i.pravatar.cc/100?img=1" alt="User Avatar" class="chat-avatar">
        <div class="chat-name">JPAMS Customer Service</div>
      </div>
      <div class="message-list" id="message-list"></div>
      <div class="chat-input-container">
        <form class="chat-input" id="chat-input-form" method="POST">
          <input name="message" type="text" placeholder="Type your message..." id="chat-input">
          <button type="submit" id="chat-send-button">
            <i class="fas fa-paper-plane"></i>
          </button>
        </form>
      </div>
    </main>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
  <script>
    // Function to go back to the previous page
    function goBack() {
      window.history.back(); // Use this to navigate back to the previous page
    }

    $(document).ready(() => {
      function fetchMessages() {
        $.ajax({
          type: 'GET',
          url: '../php/customer/get-message.php',
          dataType: 'json',
          success: (response) => {
            if (response.success) {
              displayMessages(response.messages);
            } else {
              console.log('Error fetching messages:', response.message);
            }
          },
          error: (xhr, status, error) => {
            console.log('Error fetching messages:', error);
          }
        });
      }

      const displayMessages = (messages) => {
        const messageList = $('#message-list');
        messageList.empty();

        messages.forEach((message) => {
          const messageClass = message.sender_type === 'user' ? 'outgoing' : 'incoming';
          const messageHtml = `
            <div class="message ${messageClass}">
              ${message.content}
            </div>
          `;
          messageList.append(messageHtml);
        });

        // Scroll to the bottom of the message list
        messageList.scrollTop(messageList[0].scrollHeight);
      }

      fetchMessages();
      setInterval(fetchMessages, 3000);

      $('#chat-input-form').submit((e) => {
        e.preventDefault();

        $.ajax({
          type: 'POST',
          url: '../php/customer/send-message.php',
          data: $('#chat-input-form').serialize(),
          dataType: 'json',
          success: (response) => {
            if (response.success) {
              console.log(response);
              $('#chat-input').val('');
              $('#chat-send-button i').css('color', '');
              // Fetch messages after sending a new one
              fetchMessages();
            }
          },
          error: (xhr, status, error) => {
            console.log('error:', error);
          }
        });
      });

      $('#chat-input').on('input', function() {
        if ($(this).val().length > 0) {
          $('#chat-send-button i').css('color', 'white');
        } else {
          $('#chat-send-button i').css('color', '');
        }
      });
    });
  </script>

  <!-- Add CSS styling for the back button -->
  <style>
    .back-button {
      background: none;
      border: none;
      font-size: 20px;
      cursor: pointer;
      color: #333;
      margin-right: 15px;
    }

    .chat-header {
      display: flex;
      align-items: center;
      padding: 10px;
      background-color: #f4f4f4;
      border-bottom: 1px solid #ddd;
    }

    .chat-avatar {
      margin-left: 10px;
      width: 40px;
      height: 40px;
      border-radius: 50%;
    }

    .chat-name {
      margin-left: 10px;
      font-weight: bold;
      font-size: 18px;
    }
  </style>
</body>
</html>
