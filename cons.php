<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success</title>
    <style>
        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Could be more or less, depending on screen size */
            text-align: center;
        }

        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .btn {
            padding: 10px 20px;
            margin: 10px;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #3085d6;
        }

        .btn-secondary {
            background-color: #6c757d;
        }
    </style>
</head>

<body>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Registered Successfully!</h2>
            <p>Your registration was successful. Click the button below to go to your Gmail account.</p>
            <button class="btn btn-primary" id="gmailButton">Go to Gmail</button>
            <button class="btn btn-secondary" id="stayButton">Stay Here</button>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var gmailButton = document.getElementById("gmailButton");
        var stayButton = document.getElementById("stayButton");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // Open the modal
        function openModal() {
            modal.style.display = "block";
        }

        // Close the modal
        function closeModal() {
            modal.style.display = "none";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            closeModal();
        }

        // When the user clicks on the Gmail button, redirect to Gmail
        gmailButton.onclick = function () {
            window.location.href = "https://mail.google.com/";
        }

        // When the user clicks on the Stay Here button, redirect to another page (e.g., index.php)
        stayButton.onclick = function () {
            window.location.href = "index.php";
        }

        // Trigger the modal (this should be done after a successful registration)
        window.onload = function () {
            openModal();
        }
    </script>

</body>

</html>