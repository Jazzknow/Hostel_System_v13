<?php
include 'php/connection.php';
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
                <h1>Facility Booking Information</h1>
                <div class="breadcrumb">
                    <a href="roombooking.php" id="refreshStats" class="btn btn-refresh">Room Booking</a>
                </div>
            </div>
            <div class="four-box-container" style="margin-top: -20px;">
                <div class="breadcrumb">
                    <a href="#">Information about the Guest</a>
                    <i class='bx bx-chevron-right'></i>
                    <a class="active" href="#">facility Booking</a>
                </div>
            </div>          

            <div class="box-info-container">
                <div class="header-container" style="width: 100%; ">
                    <h4>Facility Information</h4>
                    <div class="search-bar">
                        <input type="text" id="searchInput" placeholder="Search..." onkeyup="searchTable()">
                    </div>
                </div>
                <div class="horizontal-box" style="width: 100%; margin-top: -15px;">
                    <table id="bookingTable">
                        <thead>
                            <tr>
                                <th>Facility ID <span class="sort-icon" onclick="sortTable(0)">&#x25B2;&#x25BC;</span>
                                </th>
                                <th style="text-align: center;">Facility Name</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Check-in</th>
                                <th style="text-align: center;">Check-out</th>
                                <th style="text-align: center;">Guest</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT facility_id, facilityname, fullname, checkin, checkout, numguest, status FROM facility_reservation";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['facility_id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['facilityname']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['checkin']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['checkout']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['numguest']) . "</td>";
                                    echo "<td style=color:grey; ><strong>" . htmlspecialchars($row['status']) . "</strong></td>";
                                    echo "<td>
                                                    <a href='roombooking.php?id=" . htmlspecialchars($row['facility_id']) . "'>View</a> |
                                                    <a href='roombooking.php?id=" . htmlspecialchars($row['facility_id']) . "'>Edit</a> |
                                                    <a href='roombooking.php?id=" . htmlspecialchars($row['facility_id']) . "' onclick='return confirm(\"Are you sure you want to delete this booking?\")'>Delete</a>
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

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js"
        integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw=="
        crossorigin="anonymous"></script>
    <script src="assets/js/experiment.js"></script>
    <script src="assets/js/roombooking.js"></script>

    <script>
        function searchTable() {
            var input, filter, table, tr, tdFacility, tdName, i, txtValueFacility, txtValueName;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("bookingTable");
            tr = table.getElementsByTagName("tr");
            var noResults = document.getElementById("noResults");
            var resultsFound = false;

            for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
                tdFacility = tr[i].getElementsByTagName("td")[1]; // Facility Name column (index 1)
                tdName = tr[i].getElementsByTagName("td")[2]; // Name column (index 2)
                if (tdFacility && tdName) {
                    txtValueFacility = tdFacility.textContent || tdFacility.innerText;
                    txtValueName = tdName.textContent || tdName.innerText;
                    if (txtValueFacility.toUpperCase().indexOf(filter) > -1 || txtValueName.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        resultsFound = true;
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }

            // Show or hide the "No results found" message
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

        // Initial sort on page load
        sortTable(1); // Sort by Facility Name column (index 1)
    </script>

</body>

</html>