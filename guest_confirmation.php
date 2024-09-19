<?php
include 'php/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message_Content = $_POST['message_Content'];
    $admin_email = $_POST['admin_email'];
    $guest_email = $_POST['guest_email'];

    $sql = "INSERT INTO compose_messages (admin_email, guest_email, message_content) VALUES ('$admin_email', '$guest_email', '$message_Content')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Successfully Added")</script>';
        echo '<script>window.location.href = "guest_confirmation.php";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

$email = "SELECT email FROM room_reservation";
$email_result = $conn->query($email);

$emails = array();
if ($email_result->num_rows > 0) {
    while ($row = $email_result->fetch_assoc()) {
        $emails[] = $row["email"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <div id="main-content">
        <?php include 'includes/header.php'; ?>
        <main>
            <div class="four-box-container">
                <h1>Guest Confirmation Management</h1>
            </div>
            <div class="four-box-container" style="margin-top: -20px;">
                <div class="breadcrumb">
                    <a href="#">Email and Update the Customer</a>
                    <i class='bx bx-chevron-right'></i>
                    <a class="active" href="#">Guest Confirmation</a>
                </div>
            </div>            
                
            <div class="four-box-container">
                <div class="guest-details">
                    <h2>Email Address</h2>
                    <form method="post" enctype="multipart/form-data">

                        <div class="guest-info-row">
                            <div class="form-group">
                                <label>Admin Email Address<span style="color:red"> *</span></label>
                                <input class="form-control" type="email" name="admin_email">
                            </div>
                        </div>

                        <div class="guest-info-row">
                            <div class="form-group">
                                <label>Guest Email Address<span class="login-danger">*</span></label>
                                <select class="form-control" name="guest_email">
                                    <option value="">Select Email</option>
                                    <?php foreach ($emails as $email): ?>
                                        <option value="<?php echo htmlspecialchars($email); ?>">
                                            <?php echo htmlspecialchars($email); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="guest-info-row">
                            <div class="form-group">
                                <div class="textarea-wrapper">
                                    <textarea id="messageContent" rows="10" cols="50" name="message_Content" placeholder="Type your message here..." required></textarea>
                                    <button type="button" class="delete-icon" onclick="deleteMessage()" title="Delete Message">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <div class="icon-container">
                                        <button type="button" class="icon-button" onclick="insertFile()" title="Insert File">
                                            <i class="fas fa-paperclip"></i>
                                        </button>
                                        <button type="button" class="icon-button" onclick="insertPhoto()" title="Insert Photo">
                                            <i class="fas fa-image"></i>
                                        </button>
                                        <button type="button" class="icon-button" onclick="insertLink()" title="Insert Link">
                                            <i class="fas fa-link"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="file" id="fileInput" style="display: none;" accept=".pdf,.doc,.docx">
                                <input type="file" id="photoInput" style="display: none;" accept="image/*">
                                    <div class="button-container">
                                        <button type="submit" name="submit" class="send-button">Send Message</button>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

    </div>
    </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js"
        integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw=="
        crossorigin="anonymous"></script>
    <script src="assets/js/experiment.js"></script>

    <script>
        function insertFile() {
            document.getElementById('fileInput').click();
        }

        function insertPhoto() {
            document.getElementById('photoInput').click();
        }

        function insertLink() {
            const url = prompt("Enter the URL:");
            if (url) {
                const linkText = prompt("Enter the link text:");
                const link = `<a href="${url}">${linkText || url}</a>`;
                insertToTextarea(link);
            }
        }

        function insertToTextarea(text) {
            const textarea = document.getElementById('messageContent');
            const cursorPos = textarea.selectionStart;
            const textBefore = textarea.value.substring(0, cursorPos);
            const textAfter = textarea.value.substring(cursorPos);
            textarea.value = textBefore + text + textAfter;
        }

        document.getElementById('fileInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                insertToTextarea(`[File: ${file.name}]`);
            }
        });

        document.getElementById('photoInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                insertToTextarea(`[Photo: ${file.name}]`);
            }
        });

        function deleteMessage() {
            if (confirm("Are you sure you want to delete this message?")) {
                document.getElementById('messageContent').value = '';
                showNotification('Message deleted');
            }
        }

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.textContent = message;
            notification.style.position = 'fixed';
            notification.style.bottom = '20px';
            notification.style.right = '20px';
            notification.style.padding = '10px';
            notification.style.backgroundColor = '#333';
            notification.style.color = '#fff';
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

    </script>
</body>

</html>