<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reserved Seats') }}
        </h2>
    </x-slot>

    <div >
        <h1> <B> Resereved Seats </B> </h1>

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
                        class=" border-radius-10"
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
        <div class="search-bar ">
            <!-- General Search -->
            <div class="filter-group ">
                <label for="searchInput">Search</label>
                <input type="text" id="searchInput" placeholder="Search by Phone Number" aria-label="Search Phone Number">
            </div>
        </div>
    
        <!-- Shows Table -->
        <table id="showTable" >
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
            <button type="submit" name="action" value="confirm" class="btn btn-primary mt-10">Confirm Booking</button>
            <button type="submit" name="action" value="cancel" class="btn btn-danger mx-10 mt-10">Cancel Booking</button>
        </div>
    </form>
    </div>

    <!-- Shtyle tag -->
    <style>
        /* CSS Variables for Neumorphic Black and Gray Theme */
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
            font-size: 12px;
        }

        h1 {
            margin: 20px 0;
            text-align: center;
            color: black;
        }

        /* Success Message */
        .success-message {
            text-align: center;
            color: var(--success-color);
            margin-bottom: 10px;
        }

        /* Slider Controls Container */
        .slider-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80%;
            margin: 0 auto 20px auto;
        }

        /* Slider Container */
        .slider-container {
            width: 100%;
            overflow: hidden;
            /* Hides overflow for slider effect */
            border: 1px solid var(--border-color);
            border-radius: 15px;
            background-color: var(--primary-color);
            box-shadow: inset 5px 5px 15px var(--shadow-dark), inset -5px -5px 15px var(--shadow-light);
            text-align: center;
        }

        .slider-wrapper {
            display: flex;
            transition: transform 0.5s ease;
            margin: 0;
            padding: 0;
            justify-content: center;
        }

        .slider-item {
            flex: 1 1 auto;
            width: 180px;
            margin: 10px 5px;
            /* gap between items */
            text-align: center;
            background-color: var(--primary-color);
            border-radius: 15px;
            box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light);
            padding: 10px;
            height: 220px;
        }

        .slider-item img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            border-radius: 10px;
        }

        .slider-item a {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #2196F3;
            font-weight: bold;
        }

        .slider-item a:hover {
            text-decoration: underline;
        }

        /* Slider Control Buttons (Neumorphic Gray and Black) */
        .slider-control-btn {
            background-color: var(--button-color);
            border-radius: 50%;
            /* box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light); */
            color: var(--text-color);
            border: none;
            width: 50px;
            height: 50px;
            cursor: pointer;
            font-size: 16px;
            transition: box-shadow 0.3s, background-color 0.3s;
            margin: 0 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slider-control-btn:hover {
            box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
        }

        .slider-control-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Add New Movie Button (Neumorphic Gray and Black) */
        .add-link {
            text-align: center;
            margin: 20px 0;
        }

        .add-link a {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            background-color: var(--primary-color);
            color: var(--text-color);
            text-decoration: none;
            border-radius: 30px;
            /* box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light); */
            transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
            cursor: pointer;
            font-weight: bold;
            margin-left: 57%;
        }

        .add-link a:hover {
            /* box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light); */
            background-color: #333;
            color: #fff;
        }

        .add-link a img {
            margin-right: 10px;
            filter: brightness(0) invert(1);
            /* Invert icon colors for visibility */
        }

        /* Search Bar with Status and Date Range Filter */
        .search-bar {
            width: 80%;
            margin: 20px auto;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 15px;
            /* Adds space between elements */
            flex-wrap: wrap;
            /* Allows wrapping on smaller screens */
        }

        .search-bar .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-bar input,
        .search-bar select,
        .search-bar input[type="date"] {
            padding: 8px 12px;
            border: none;
            border-radius: 20px;
            background-color: rgb(53, 53, 53);
            color: var(--text-color);
            /* box-shadow: inset 5px 5px 15px var(--shadow-dark), inset -5px -5px 15px var(--shadow-light); */
            font-size: 14px;
            outline: none;
            transition: box-shadow 0.3s;
        }

        .search-bar input::placeholder {
            color: #aaa;
        }

        a:-webkit-any-link {
            color: gray;
        }

        .search-bar input:focus,
        .search-bar select:focus,
        .search-bar input[type="date"]:focus {
            box-shadow: 0 0 10px #2196F3;
        }

        .search-bar select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23e0e0e0' d='M6 8.4L2.4 4.8l1.2-1.2L6 6l2.4-2.4 1.2 1.2z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
            cursor: pointer;
            padding-right: 30px;
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
            padding: 10px;
            color: var(--text-color);
        }

        th {
            background-color: rgb(35, 36, 36);
            font-weight: bold;
            text-align: center;
            color: #ffffff;
        }

        /* Status Badge */
        .status-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgb(37, 39, 39);
            padding: 5px 10px;
            border-radius: 20px;
            text-align: center;
            color: #ffffff;
            position: relative;
        }

        .status-badge::before {
            content: '';
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .status-active::before {
            background-color: rgb(6, 248, 14);
        }

        .status-inactive::before {
            background-color: rgb(255, 0, 0);
        }

        /* Buttons in table (Neumorphic Gray and Black) */
        .action-button {
            width: 100px;
            /* height: 40px; */
            padding: 7px 0;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light);
            transition: box-shadow 0.3s, background-color 0.3s;
            color: #ffffff;
            margin: 0 auto;
            /* Center the button within the cell */
        }

        .btn-edit {
            background-color: rgb(81, 88, 94);
            /* Gray */
        }

        .btn-delete {
            background-color: #343a40;
            /* Dark Gray */
        }

        .btn-view {
            background-color: #495057;
            /* Medium Gray */
        }

        .btn-edit:hover,
        .btn-delete:hover,
        .btn-view:hover {
            /* box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light); */
            color: black;

        }

        .btn-edit:hover img,
        .btn-delete:hover img,
        .btn-view:hover img {
            filter: brightness(0) invert(0);
            /* Remove inversion to make the image black */
        }

        /* .btn-edit img, .btn-delete img, .btn-view img:hover {
    color: black;
    } */

        .btn-edit img,
        .btn-delete img,
        .btn-view img {
            margin-right: 5px;
            filter: brightness(0) invert(1);
            /* Invert icon colors for visibility */
        }

        /* Modal Styles (Neumorphic Gray and Black) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            z-index: 1000;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.7);
            /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            /* 10% from top and centered */
            padding: 20px;
            border: none;
            width: 300px;
            /* Could be more or less, depending on screen size */
            border-radius: 20px;
            /* box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light); */
            text-align: center;
            color: rgb(41, 43, 44);
        }

        .close-button {
            color: #ffffff;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-button:hover,
        .close-button:focus {
            color: #FF5555;
            text-decoration: none;
        }

        .modal-actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
        }

        .modal-actions button {
            width: 100px;
            padding: 10px 0;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 14px;
            color: #ffffff;
            /* box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light); */
            transition: box-shadow 0.3s, background-color 0.3s;
        }

        #confirmDelete {
            background-color: #FF5555;
            /* Danger */
        }

        #cancelDelete {
            background-color: #6c757d;
            /* Gray */
        }

        #confirmDelete:hover,
        #cancelDelete:hover {
            /* box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light); */
        }

        /* Pagination and Rows per Page */
        .pagination-container {
            width: 80%;
            margin: 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .rows-per-page {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .search-bar label {
            font-size: 14px;
            color: black;
        }

        .rows-per-page select {
            padding: 8px 12px;
            border: none;
            border-radius: 20px;
            background-color: var(--secondary-color);
            color: var(--text-color);
            box-shadow: inset 5px 5px 15px var(--shadow-dark), inset -5px -5px 15px var(--shadow-light);
            font-size: 16px;
            outline: none;
            transition: box-shadow 0.3s;
        }

        .rows-per-page select:focus {
            box-shadow: 0 0 10px #2196F3;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pagination button {
            padding: 8px 12px;
            border: none;
            border-radius: 20px;
            background-color: var(--secondary-color);
            color: var(--text-color);
            /* box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light); */
            cursor: pointer;
            transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
        }

        .pagination button.active {
            background-color: #2196F3;
            color: #ffffff;
            box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
        }

        .pagination button:hover:not(.active) {
            box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
            background-color: #555555;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .slider-container {
                width: 100%;
            }

            .slider-item {
                width: 120px;
            }

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
                justify-content: space-between;
            }

            .search-bar input,
            .search-bar select,
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


    <!-- Script tag -->
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
</x-app-layout>