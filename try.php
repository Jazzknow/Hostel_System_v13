<?php
include 'php/connection.php';

if (isset($_GET['del'])) {
    mysqli_query($conn, "delete from room_reservation where room_id = '" . $_GET['id'] . "'");
    $_SESSION['delmsg'] = "Guest Information deleted !!";
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
                <h1>Room Booking Information</h1>
                <div class="breadcrumb">
                    <a href="facilitybooking.php" id="refreshStats" class="btn btn-refresh">Facility Booking</a>
                </div>
            </div>
            <div class="four-box-container" style="margin-top: -20px;">
                <div class="breadcrumb">
                    <a href="#">Information about the Guest</a>
                    <i class='bx bx-chevron-right'></i>
                    <a class="active" href="#">Room Booking</a>
                </div>
            </div>      

            <div class="box-info-container">
                <div class="header-container" style="width: 100%; ">
                    <h4>Room Information</h4>
                    <div class="search-bar">
                        <input type="text" id="searchInput" placeholder="Search..." onkeyup="searchTable()">
                    </div>
                </div>
                
                <div class="horizontal-box" style="width: 100%; margin-top: -15px;">
                    <table id="bookingTable">
                        <thead>
                            <tr>
                                <th>Room ID <span class="sort-icon" onclick="sortTable(0)">&#x25B2;&#x25BC;</span>
                                </th>
                                <th>Room Number</th>
                                <th>Name</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Guest</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT room_id, roomnumber, fullname, checkin, checkout, Totalguest, status FROM room_reservation";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['room_id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['roomnumber']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['checkin']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['checkout']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Totalguest']) . "</td>";
                                    echo "<td style='color:grey;'><strong>" . htmlspecialchars($row['status']) . "</strong></td>";
                                    echo "<td>
                                                <a href='#' onclick='openViewModal(" . htmlspecialchars($row['room_id']) . ")'>View</a> |
                                                <a href='#' onclick='openModal(" . htmlspecialchars($row['room_id']) . ")'>Edit</a> |
                                                <a href='roombooking.php?id=" . htmlspecialchars($row['room_id']) . "&del=delete'
                                                onClick='return confirm('Are you sure you want to delete?')'>Delete</a>
                                                <span class='fas fa-ellipsis-vertical' onclick='openActionModal(" . htmlspecialchars($row['room_id']) . ")'></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                            </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8'>No bookings found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <div id="noResults">No results found</div>
                </div>
            </div>
        </main>
    </div>

    <div id="actionModal" class="modal">
        <div class="modal-content">
            <button onclick='openModal()'>Check-in</button>
            <button onclick="handleCheckOut()">Check-out</button>
        </div>
    </div>

    <!----MODAL FOR EDITING THE STATUS--->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Booking</h2>
            <form id="editForm">
                <input type="hidden" id="editRoomId" name="roomId">
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="checkin" style="color:green;">Check-in</option>
                    <option value="checkout">Check-out</option>
                    <option value="reserved">Reserved</option>
                </select>
                <label for="arrivalTime">Arrival Time:</label>
                <input type="time" id="arrivalTime" name="arrivalTime">
                <label for="departureTime">Number of Days</label>
                <input type="number" id="departureTime" name="days">
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>
<!----MODAL FOR VIEWING THE BOOKING--->
    <div id='viewModal' class='modal'>
    <div class='modal-content'>
        <span class='close' onclick='closeViewModal()'>&times;</span>
        <h2>Another Details</h2>
        <table id='viewBookingTable'>
            <tr><th>Arrival Time</th><td id='viewArrivaltime'></td></tr>
            <tr><th>Accompany By</th><td id='viewAccompany'></td></tr>
            <tr><th>Departure Time</th><td id='viewDeparturetime'></td></tr>
        </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js"
        integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw=="
        crossorigin="anonymous"></script>
    <script src="assets/js/experiment.js"></script>
    <script src="assets/js/roombooking.js"></script>
    <script>
        function searchTable() {
            var input, filter, table, tr, tdName, tdRoom, i, txtValueName, txtValueRoom;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("bookingTable");
            tr = table.getElementsByTagName("tr");
            var noResults = document.getElementById("noResults");
            var resultsFound = false;

            for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
                tdRoom = tr[i].getElementsByTagName("td")[1];
                tdName = tr[i].getElementsByTagName("td")[2];
                if (tdRoom && tdName) {
                    txtValueRoom = tdRoom.textContent || tdRoom.innerText;
                    txtValueName = tdName.textContent || tdName.innerText;
                    if (txtValueRoom.toUpperCase().indexOf(filter) > -1 || txtValueName.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        resultsFound = true;
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }

            if (resultsFound) {
                noResults.style.display = "none";
                table.style.display = "";
            } else {
                noResults.style.display = "block";
                table.style.display = "none";
            }
        }

        let sortColumn = 1;
        let sortDirection = 1;

        function sortTable(columnIndex) {
            const table = document.getElementById("bookingTable");
            const tbody = table.getElementsByTagName("tbody")[0];
            const rows = Array.from(tbody.getElementsByTagName("tr"));

            if (sortColumn === columnIndex) {
                sortDirection *= -1;
            } else {
                sortDirection = 1;
            }
            sortColumn = columnIndex;

            rows.sort((a, b) => {
                const aColText = a.getElementsByTagName("td")[columnIndex].textContent.trim();
                const bColText = b.getElementsByTagName("td")[columnIndex].textContent.trim();

                if (columnIndex === 0) {
                    return sortDirection * (parseInt(aColText) - parseInt(bColText));
                } else {
                    return sortDirection * aColText.localeCompare(bColText);
                }
            });

            rows.forEach(row => tbody.appendChild(row));

            updateSortIcons(columnIndex);
        }

        function updateSortIcons(activeColumn) {
            const sortIcons = document.querySelectorAll(".sort-icon");
            sortIcons.forEach((icon, index) => {
                if (index === activeColumn) {
                    icon.textContent = sortDirection === 1 ? "\u25B2" : "\u25BC";
                } else {
                    icon.textContent = "\u25B2\u25BC";
                }
            });
        }
        sortTable(1); 
    </script>

    <!-- script of modal -->
    <script>
        var modal = document.getElementById("editModal");
        var span = document.getElementsByClassName("close")[0];
        function openModal(roomId) {
            document.getElementById("editRoomId").value = roomId;
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        document.getElementById("editForm").onsubmit = function(e) {
    e.preventDefault();
    var roomId = document.getElementById("editRoomId").value;
    var status = document.getElementById("status").value;
    var arrivalTime = document.getElementById("arrivalTime").value;
    var days = document.getElementById("departureTime").value;

    console.log('Submitting form with:', { roomId, status, arrivalTime, days });

    fetch('update_roombooking.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'roomId=' + encodeURIComponent(roomId) + 
              '&status=' + encodeURIComponent(status) + 
              '&arrivalTime=' + encodeURIComponent(arrivalTime) +
              '&days=' + encodeURIComponent(days)
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.text();
    })
    .then(text => {
        console.log('Response text:', text);
        return JSON.parse(text);
    })
    .then(data => {
        if (data.success) {
            alert('Booking updated successfully');
            location.reload();
        } else {
            alert('Error updating booking: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the booking: ' + error.message);
    });

    modal.style.display = "none";
}
</script>

<!----SCRIPT FOR VIEWING THE BOOKING--->
<script>
function openViewModal(roomId) {
    var modal = document.getElementById('viewModal');
    modal.style.display = 'block';

    // Fetch booking details using AJAX
    fetch('view_room_booking_details.php?id=' + roomId)
        .then(response => response.json())
        .then(data => {
            document.getElementById('viewArrivaltime').textContent = data.arrival_time;
            document.getElementById('viewAccompany').textContent = data.accompany;
            document.getElementById('viewDeparturetime').textContent = data.departure_time;
        })
        .catch(error => console.error('Error:', error));
}

function closeViewModal() {
    var modal = document.getElementById('viewModal');
    modal.style.display = 'none';
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    var modal = document.getElementById('viewModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>

</script>

<!----SCRIPT FOR ACTION MODAL---->
<script>
        let currentRoomId;

        function openActionModal(roomId) {
            currentRoomId = roomId;
            document.getElementById('actionModal').style.display = 'block';
        }

        function closeActionModal() {
            document.getElementById('actionModal').style.display = 'none';
        }

        function handleCheckIn() {
            console.log('Check-in for room', currentRoomId);
            // Implement check-in logic here
            closeActionModal();
        }

        function handleCheckOut() {
            console.log('Check-out for room', currentRoomId);
            // Implement check-out logic here
            closeActionModal();
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == document.getElementById('actionModal')) {
                closeActionModal();
            }
        }
    </script>

<style>
.ellipsis-button {
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
    font-size: 16px;
    color: #333;
}

.ellipsis-button:hover {
    background-color: #f0f0f0;
    border-radius: 50%;
}

/* New styles for the modal */
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
    width: 300px;
    text-align: center;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.modal-content button {
    margin: 10px;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

.modal-content button:hover {
    background-color: #45a049;
}
</style>

</body>

</html>