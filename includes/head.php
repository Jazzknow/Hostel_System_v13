<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- ICONS -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- STYLESHEET -->
    <link rel="stylesheet" href="assets/css/sidebarr.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/style2.css" />
    <link rel="stylesheet" href="assets/css/image.css" />

    <title>Sidebar</title>

    <style>
        .box-info-container {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-container h4 {
            margin: 0;
        }

        .search-bar {
            display: flex;
            align-items: center;
        }

        .search-bar input[type="text"] {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            outline: none;
            width: 300px;
        }

        .horizontal-box {
            overflow-x: auto;
        }

        #bookingTable {
            width: 100%;
            border-collapse: collapse;
        }

        #bookingTable th,
        #bookingTable td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        #bookingTable th {
            background-color: #f4f4f4;
        }

        #bookingTable td a {
            color: #007bff;
            text-decoration: none;
        }

        #bookingTable td a:hover {
            text-decoration: underline;
        }

        #noResults {
            display: none;
            text-align: center;
            color: #ff0000;
            font-weight: bold;
        }

        .sort-icon {
            cursor: pointer;
            user-select: none;
            padding-left: 5px;
            font-size: 0.8em;
        }

        th {
            white-space: nowrap;
        }

        /***
        .datetime-display {
            width: 100%;

            text-align: center;
            margin: 5px 0;
            font-size: 1em;
            color: #333;
        }

        .current-date {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .current-time {
            font-weight: bold;
        }

        .search-and-filter-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-top: 10px;
        }

        .search-container {
            margin-right: 10px;
        }

        .filter-container {
            margin-right: 10px;
        }

        .view-toggle {
            margin-left: 10px;
        }  */

        .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
}

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

#editForm {
    display: flex;
    flex-direction: column;
}

#editForm label, #editForm select, #editForm input, #editForm button {
    margin-bottom: 10px;
}

        /** Compose MEssage */
        .textarea-wrapper {
            position: relative;
        }
        #messageContent {
            width: 100%;
            padding: 30px 30px 40px 10px; /* Top Right Bottom Left */
            box-sizing: border-box;
            resize: vertical;
        }
        .delete-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            color: #ff4d4d;
            background: none;
            border: none;
            font-size: 1.2em;
            padding: 0;
        }
        .icon-container {
            position: absolute;
            bottom: 10px;
            left: 10px;
            display: flex;
            gap: 10px;
        }
        .icon-button {
            background: none;
            border: none;
            font-size: 1.2em;
            cursor: pointer;
            color: #007bff;
            padding: 0;
        }

        .send-button {
            padding: 10px 20px;
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 10px;
    }

    /* KEBAB MENU */
    .kebab-menu {
        display: inline-block;
        cursor: pointer;
        font-size: 16px;
        color: #333;
        vertical-align: middle;
        margin-left: 8px;
    }
    .kebab-menu .dot {
        width: 6px;
        height: 6px;
        background-color: #333;
        border-radius: 50%;
        display: block;
        margin: 2px auto;
    }
    </style>

</head>