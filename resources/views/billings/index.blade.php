<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Shows</title>

    <!-- Font Awesome for icons -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-p6qD4WmF1g4p8qPQ5cM+PEOj8EeA0bg65dwZ2rBt+9v9V/GMq3O36RlhjzQpYYzTCnzqqe/GJZy43k5BSYyxzg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />

    <style>
        /* CSS Variables */
        :root {
            --background-color: #121212;
            --primary-color: #1e1e1e;
            --secondary-color: #2e2e2e;
            --text-color: #e0e0e0;
            --accent-color: #4CAF50;
            --button-color: #2e2e2e;
            --button-hover-color: #3e3e3e;
            --border-color: #555;
            --success-color: #4CAF50;
            --danger-color: #FF5555;
            --info-color: #2196F3;
            --muted-color: #777;
            --shadow-light: #2b2b2b;
            --shadow-dark: #0c0c0c;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: rgb(40, 43, 46);
            color: var(--text-color);
            font-family: Arial, sans-serif;
        }

        h1 {
            margin: 20px 0;
            text-align: center;
            color: var(--text-color);
        }

        /* Success Message */
        .success-message {
            text-align: center;
            color: var(--success-color);
            margin-bottom: 10px;
        }

        /* Search Bar / Filter Bar */
        .search-bar {
            width: 80%;
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .search-bar label {
            font-size: 14px;
            color: var(--text-color);
        }

        .search-bar select,
        .search-bar input[type="text"],
        .search-bar input[type="date"],
        .search-bar input[type="time"] {
            padding: 10px 15px;
            border: none;
            border-radius: 20px;
            background-color: rgb(53, 53, 53);
            color: var(--text-color);
            font-size: 16px;
            outline: none;
            transition: box-shadow 0.3s;
        }

        .search-bar select:focus,
        .search-bar input[type="text"]:focus,
        .search-bar input[type="date"]:focus,
        .search-bar input[type="time"]:focus {
            box-shadow: 0 0 10px #2196F3;
        }

        .search-bar input[type="text"]::placeholder {
            color: #aaa;
        }

        /* Table */
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 80%;
            font-size: 16px;
            text-align: center;
            background-color: rgb(41, 43, 44);
            box-shadow: 0 0 10px var(--shadow-dark);
            border-radius: 15px;
            overflow: hidden;
        }

        th,
        td {
            padding: 15px;
            color: var(--text-color);
        }

        th {
            background-color: rgb(35, 36, 36);
            font-weight: bold;
            color: #ffffff;
        }

        /* Buttons (Detail, etc.) */
        .action-button {
            width: 100px;
            padding: 10px 0;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 5px 5px 15px var(--shadow-dark),
                        -5px -5px 15px var(--shadow-light);
            transition: box-shadow 0.3s, background-color 0.3s;
            color: #ffffff;
            margin: 0 auto; /* Center the button within the cell */
        }

        .btn-delete {
            background-color: #343a40; /* Dark Gray */
        }

        .btn-delete:hover {
            color: black;
        }

        .btn-delete img {
            margin-right: 5px;
            filter: brightness(0) invert(1);
        }

        .btn-delete:hover img {
            filter: brightness(0) invert(0);
        }

        /* Summary Section at the bottom */
        .summary-section {
            width: 80%;
            margin: 20px auto;
            color: var(--text-color);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            background-color: rgb(53, 53, 53);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px var(--shadow-dark);
            gap: 20px;
        }

        .summary-item {
            font-size: 18px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }

            .search-bar {
                flex-direction: column;
            }

            .summary-section {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <h1>Billing Details</h1>

    <!-- Success Message -->
    @if (session()->has('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="search-bar">
        <!-- Movie Name Filter -->
        <div class="filter-group">
            <label for="movieNameFilter">Movie Name:</label>
            <input
                type="text"
                id="movieNameFilter"
                placeholder="Search movie name..."
            />
        </div>

        <!-- Date Filter -->
        <div class="filter-group">
            <label for="dateFilter">Filter by Date:</label>
            <input type="date" id="dateFilter" />
        </div>

        <!-- Time Filter -->
        <div class="filter-group">
            <label for="timeFilter">Filter by Time (AM/PM):</label>
            <input type="time" id="timeFilter" />
        </div>

        <!-- Seat Type Filter -->
        <div class="filter-group">
            <label for="seatTypeFilter">Seat Type:</label>
            <select id="seatTypeFilter">
                <option value="">All</option>
                <!-- Storing values in lowercase so the logic can be straightforward. -->
                <option value="silver">Silver</option>
                <option value="gold">Gold</option>
                <option value="platinum">Platinum</option>
            </select>
        </div>
    </div>

    <!-- Billing Table -->
    <table id="billingTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Movie Name</th>
                <th>Date</th>
                <th>Time (AM/PM)</th>
                <th>Seat Type</th>
                <th>Total Tickets</th>
                <th>Full Tickets</th>
                <th>Half Tickets</th>
                <th>Total Price</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example rows from your server -->
            @foreach ($billings as $billing)
            <tr>
                <td>{{ $billing->id }}</td>
                <td>{{ $billing->movie_name }}</td>
                <td>{{ $billing->date }}</td>
                <td>{{ $billing->time }}</td>
                <td>{{ $billing->seat_type }}</td>
                <td>{{ $billing->total_tickets }}</td>
                <td>{{ $billing->full_tickets }}</td>
                <td>{{ $billing->half_tickets }}</td>
                <td>Rs. {{ number_format($billing->total_price, 2) }}</td>
                <td>{{ $billing->created_at }}</td>
                <td>
                    <!-- Action Button -->
                    <form method="GET" action="{{ route('billing.detail', $billing->id) }}" style="display:inline;">
                        <button type="submit" class="action-button btn-delete">
                            Detail
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary Section -->
    <div class="summary-section">
        <div class="summary-item">
            <strong>Total Full Tickets: </strong>
            <span id="totalFullTickets">0</span>
        </div>
        <div class="summary-item">
            <strong>Total Half Tickets: </strong>
            <span id="totalHalfTickets">0</span>
        </div>
        <div class="summary-item">
            <strong>Total Seats: </strong>
            <span id="totalSeats">0</span>
        </div>
        <div class="summary-item">
            <strong>Total Amount: </strong>
            <span id="totalAmount">Rs. 0.00</span>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Grab all filter inputs
        const movieNameFilter  = document.getElementById('movieNameFilter');
        const dateFilter       = document.getElementById('dateFilter');
        const timeFilter       = document.getElementById('timeFilter');
        const seatTypeFilter   = document.getElementById('seatTypeFilter');

        // Summary fields
        const totalFullTicketsEl = document.getElementById('totalFullTickets');
        const totalHalfTicketsEl = document.getElementById('totalHalfTickets');
        const totalSeatsEl       = document.getElementById('totalSeats');
        const totalAmountEl      = document.getElementById('totalAmount');

        // Convert "HH:MM AM/PM" to "HH:MM" in 24-hour format
        // e.g., "09:30 PM" => "21:30"
        function parseTime12to24(twelveHourTime) {
            if (!/AM|PM/i.test(twelveHourTime)) return twelveHourTime.trim();
            const [time, modifier] = twelveHourTime.split(' ');
            let [hours, minutes] = time.split(':');

            hours = parseInt(hours, 10);
            if (modifier.toUpperCase() === 'PM' && hours !== 12) {
                hours += 12;
            }
            if (modifier.toUpperCase() === 'AM' && hours === 12) {
                hours = 0;
            }
            const hoursStr = hours < 10 ? '0' + hours : '' + hours;
            return hoursStr + ':' + minutes;
        }

        // Listen for changes in all filters
        movieNameFilter.addEventListener('input', filterTable);
        dateFilter.addEventListener('change', filterTable);
        timeFilter.addEventListener('change', filterTable);
        seatTypeFilter.addEventListener('change', filterTable);

        // Filter on page load
        window.onload = filterTable;

        function filterTable() {
            const selectedMovieName = movieNameFilter.value.trim().toLowerCase();
            const selectedDate      = dateFilter.value; // e.g., "YYYY-MM-DD"
            const selectedTime      = timeFilter.value; // "HH:MM" (24-hour)
            // We store seatTypeFilter values in lowercase in the <select>
            const selectedSeatType  = seatTypeFilter.value; // "silver", "gold", "platinum", or ""

            // Reset totals
            let totalFullTickets = 0;
            let totalHalfTickets = 0;
            let totalSeats       = 0;
            let totalAmount      = 0;

            // Iterate over table rows
            const rows = document.querySelectorAll('#billingTable tbody tr');
            rows.forEach((row) => {
                // Extract row data
                const rowMovieNameRaw = row.querySelector('td:nth-child(2)')?.textContent || "";
                const rowMovieName    = rowMovieNameRaw.trim().toLowerCase();

                const rowDate         = row.querySelector('td:nth-child(3)')?.textContent.trim() || "";
                const rowTimeRaw      = row.querySelector('td:nth-child(4)')?.textContent.trim() || "";
                const rowTime24       = parseTime12to24(rowTimeRaw);

                const rowSeatTypeRaw  = row.querySelector('td:nth-child(5)')?.textContent.trim() || "";
                // convert seat type to lowercase for comparison
                const rowSeatType     = rowSeatTypeRaw.toLowerCase();

                const fullTickets     = parseInt(row.querySelector('td:nth-child(7)')?.textContent.trim()) || 0;
                const halfTickets     = parseInt(row.querySelector('td:nth-child(8)')?.textContent.trim()) || 0;

                let priceText         = row.querySelector('td:nth-child(9)')?.textContent.trim() || "0";
                // remove "Rs. " and any commas
                priceText             = priceText.replace("Rs. ", "").replace(",", "");
                const rowPrice        = parseFloat(priceText) || 0;

                // Apply filters:
                // 1) Movie name (partial match, case-insensitive)
                const movieNameMatches = rowMovieName.includes(selectedMovieName);

                // 2) Date
                const dateMatches      = (!selectedDate || selectedDate === rowDate);

                // 3) Time (must match 24-hour string)
                const timeMatches      = (!selectedTime || selectedTime === rowTime24);

                // 4) Seat Type (case-insensitive exact or substring)
                //    For exact match with the dropdown, since the <option> values are "silver", "gold", or "platinum",
                //    we compare them directly to rowSeatType.
                const seatTypeMatches  = (!selectedSeatType || rowSeatType === selectedSeatType);

                // If all filters pass, show the row; else hide it
                if (
                    movieNameMatches &&
                    dateMatches &&
                    timeMatches &&
                    seatTypeMatches
                ) {
                    row.style.display = '';
                    // Accumulate totals
                    totalFullTickets += fullTickets;
                    totalHalfTickets += halfTickets;
                    totalSeats       += (fullTickets + halfTickets);
                    totalAmount      += rowPrice;
                } else {
                    row.style.display = 'none';
                }
            });

            // Update summary
            totalFullTicketsEl.textContent = totalFullTickets;
            totalHalfTicketsEl.textContent = totalHalfTickets;
            totalSeatsEl.textContent       = totalSeats;
            totalAmountEl.textContent      = "Rs. " + totalAmount.toFixed(2);
        }
    </script>
</body>
</html>
