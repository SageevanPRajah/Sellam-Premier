<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shows</title>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-p6qD4WmF1g4p8qPQ5cM+PEOj8EeA0bg65dwZ2rBt+9v9V/GMq3O36RlhjzQpYYzTCnzqqe/GJZy43k5BSYyxzg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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

        /* Add New Show Button */
        .add-link {
            text-align: center;
            margin: 20px 0;
        }

        .add-link a {
            display: inline-flex;
            align-items: center;
            padding: 12px 20px;
            background-color: var(--primary-color);
            color: var(--text-color);
            text-decoration: none;
            border-radius: 30px;
            transition: background-color 0.3s, color 0.3s;
            cursor: pointer;
            font-weight: bold;
            /* Center the button */
            display: block;
            margin: 0 auto;
            width: fit-content;
        }

        .add-link a:hover {
            background-color: #333;
            color: #fff;
        }

        .add-link a img {
            margin-right: 10px;
            filter: brightness(0) invert(1);
            /* Invert icon colors for visibility */
        }

        /* Search Bar */
        .search-bar {
            width: 80%;
            margin: 20px auto;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .search-bar .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .search-bar label {
            font-size: 14px;
            color: var(--text-color);
        }

        .search-bar input[type="text"] {
            padding: 10px 15px;
            border: none;
            border-radius: 20px;
            background-color: rgb(53, 53, 53);
            color: var(--text-color);
            font-size: 16px;
            outline: none;
            transition: box-shadow 0.3s;
            width: 300px;
        }

        .search-bar input[type="text"]:focus {
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

        /* Buttons (View) */
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
            box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light);
            transition: box-shadow 0.3s, background-color 0.3s;
            color: #ffffff;
            margin: 0 auto;
            /* Center the button within the cell */
        }

        .btn-view {
            background-color: #495057;
            /* Medium Gray */
        }

        .btn-view:hover {
            color: black;
            background-color: #6c757d;
        }

        .btn-view img {
            margin-right: 5px;
            filter: brightness(0) invert(1);
        }

        .btn-view:hover img {
            filter: brightness(0) invert(0);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }

            .add-link {
                margin-left: 0;
                text-align: center;
            }

            .search-bar {
                flex-direction: column;
                align-items: flex-start;
            }
            .search-bar .filter-group {
                width: 100%;
            }
            .search-bar select,
            .search-bar input[type="text"],
            .search-bar input[type="date"] {
                width: 100%;
            }

            .pagination-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .rows-per-page,
            .pagination {
                width: 100%;
                justify-content: flex-start;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <h1>Resereved Seats</h1>

    <!-- Success Message -->
    @if(session()->has('success'))
    <div class="success-message">
        {{ session('success') }}
    </div>
@endif

<!-- Error Messages -->
@if($errors->any())
    <div class="error-messages">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('bookings.updateSelected') }}" method="POST">
        @csrf
        @method('POST')

    <div class="form-group">
        <input type="hidden" name="status" value="0">
    </div>

    <!-- Filter by Time -->
    <div class="filter-group">
        <label for="timeInput">Time</label>
        <select 
                    id="timeInput" 
                    placeholder="am/pm" 
                    aria-label="Filter by Time"
                    >
                        @php
                            $start = strtotime('00:00'); // Start time (12:00 AM)
                            $end = strtotime('23:59'); // End time (11:59 PM)

                            while ($start <= $end) {
                                $time = date('g:i A', $start); // Format time as "6:00 AM"
                                echo "<option value=\"$time\">$time</option>";
                                $start = strtotime('+30 minutes', $start); // Increment by 30 minutes
                            }
                        @endphp
                    </select>
    </div>

    <!-- Search Bar with Filters -->
    <div class="search-bar">
        <!-- General Search -->
        <div class="filter-group">
            <label for="searchInput">Search</label>
            <input type="text" id="searchInput" placeholder="Search by Phone Number" aria-label="Search Phone Number">
        </div>
    </div>

    <!-- Shows Table -->
    <table id="showTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Movie Name</th>
                <th>Seat Type</th>
                <th>Seat Number</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings->where('status', '0') as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->date }}</td>
                    <td>{{ $booking->time }}</td>  
                    <td>{{ $booking->movie_name }}</td>
                    <td>{{ $booking->seat_type }}</td>
                    <td>{{ $booking->seat_no }}</td>
                    <td>{{ $booking->name }}</td>
                    <td>{{ $booking->phone }}</td>
                    <td>
                        <input type="checkbox" name="booking_ids[]" value="{{ $booking->id }}">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="action-buttons">
        <button type="submit" name="action" value="confirm" class="btn btn-primary">Confirm Booking</button>
        <button type="submit" name="action" value="cancel" class="btn btn-danger">Cancel Booking</button>
    </div>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const timeInput = document.getElementById('timeInput');
        const table = document.getElementById('showTable');
        const rows = table.querySelectorAll('tbody tr');

        // Function to filter rows by search input
        function filterBySearch() {
            const searchTerm = searchInput.value.toLowerCase();

            rows.forEach(row => {
                const phoneCell = row.querySelector('td:nth-child(8)'); // Phone number column
                const phoneText = phoneCell.textContent.toLowerCase();

                if (phoneText.includes(searchTerm)) {
                    row.style.display = ''; // Show row if it matches
                } else {
                    row.style.display = 'none'; // Hide row if it doesn't match
                }
            });
        }

        // Function to filter rows by time input
        function filterByTime() {
            const selectedTime = timeInput.value;

            rows.forEach(row => {
                const timeCell = row.querySelector('td:nth-child(3)'); // Time column
                const timeText = timeCell.textContent;

                if (selectedTime === '' || timeText === selectedTime) {
                    row.style.display = ''; // Show row if it matches or no time is selected
                } else {
                    row.style.display = 'none'; // Hide row if it doesn't match
                }
            });
        }

        // Event listeners for independent filters
        searchInput.addEventListener('keyup', filterBySearch);
        timeInput.addEventListener('change', filterByTime);
    });
</script>

    

</body>

</html>
