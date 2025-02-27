<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reserved Seats') }}
        </h2>
    </x-slot>

    <div>
        <h1><b>Cancel booked seats</b></h1>

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

        <form action="{{ route('booking.actionSelected') }}" method="POST">
            @csrf
            @method('POST')

            <div class="form-group">
                <input type="hidden" name="status" value="0">
            </div>

            <!-- Filter Bar -->
            <div class="search-bar">
                <!-- Filter by Date -->
                <div class="filter-group">
                    <label for="dateInput">Date</label>
                    <input 
                        type="date" 
                        id="dateInput" 
                        aria-label="Filter by Date"
                        class="border-radius-10"
                    >
                </div>

                <!-- Filter by Time -->
                <div class="filter-group">
                    <label for="timeInput">Time</label>
                    <select 
                        id="timeInput"
                        aria-label="Filter by Time"
                        class="border-radius-10"
                    >
                        <option value="">-- All Times --</option>
                        @php
                            $start = strtotime('00:00'); // Start time (12:00 AM)
                            $end   = strtotime('23:59'); // End time (11:59 PM)
                            while ($start <= $end) {
                                $time = date('g:i A', $start); // Format time as "6:00 AM"
                                echo "<option value=\"$time\">$time</option>";
                                $start = strtotime('+30 minutes', $start); // Increment by 30 minutes
                            }
                        @endphp
                    </select>
                </div>

                <!-- Filter by Seat Number -->
                <div class="filter-group">
                    <label for="seatNumberInput">Seat Number</label>
                    <input 
                        type="text" 
                        id="seatNumberInput" 
                        placeholder="Search by Seat Number" 
                        aria-label="Search Seat Number"
                    >
                </div>
            </div>
            <!-- End Filter Bar -->

            <!-- Bookings Table -->
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
                    @foreach ($bookings->where('status', '1') as $booking)
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

            <!-- Pagination + Rows per Page -->
            <div class="pagination-container">
                <div class="rows-per-page">
                    <label for="rowsPerPage">Rows per page:</label>
                    <select id="rowsPerPage">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div class="pagination" id="pagination"></div>
            </div>

            <div class="action-buttons">
                <!-- Example Re-print -->
                <button type="submit" name="action" value="reprint" class="btn bg-black text-white mt-10 px-4 py-2 rounded-md hover:bg-green-800 transition">
                    Re-Print Ticket
                </button>

                <!-- Cancel Booking -->
                <button type="submit" name="action" value="cancel" class="btn bg-black text-white mx-10 mt-10 px-4 py-2 rounded-md hover:bg-red-800 transition">
                    Cancel Booking
                </button>
            </div>
        </form>
    </div>

    <!-- Styles -->
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
            font-size: 20px;
        }

        .success-message {
            text-align: center;
            color: var(--success-color);
            margin-bottom: 10px;
        }

        .error-messages {
            text-align: center;
            color: var(--danger-color);
            margin-bottom: 10px;
        }

        .search-bar {
            width: 80%;
            margin: 20px auto;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .search-bar .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-bar label {
            font-size: 14px;
            color: black;
        }

        .search-bar input,
        .search-bar select {
            padding: 8px 12px;
            border: none;
            border-radius: 20px;
            background-color: rgb(53, 53, 53);
            color: var(--text-color);
            font-size: 14px;
            outline: none;
            transition: box-shadow 0.3s;
        }

        .search-bar input::placeholder {
            color: #aaa;
        }

        .search-bar input:focus,
        .search-bar select:focus {
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

        td input[type="checkbox"] {
            transform: scale(1.2);
            cursor: pointer;
        }

        .action-buttons {
            text-align: center;
            margin-top: 20px;
        }

        .action-buttons .btn {
            margin: 0 5px;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 20px;
            background-color: var(--button-color);
            color: #ffffff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: var(--button-hover-color);
        }

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

        .rows-per-page select {
            padding: 8px 12px;
            border: none;
            border-radius: 20px;
            background-color: var(--secondary-color);
            color: var(--text-color);
            font-size: 16px;
            outline: none;
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
            cursor: pointer;
            transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
        }

        .pagination button.active {
            background-color: #2196F3;
            color: #ffffff;
            /* box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light); */
        }

        .pagination button:hover:not(.active) {
            box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
            background-color: #555555;
        }

        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }
            .search-bar {
                width: 90%;
                flex-direction: column;
                align-items: flex-start;
            }
            .search-bar .filter-group {
                width: 100%;
                justify-content: space-between;
            }
            .search-bar input,
            .search-bar select {
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

    <!-- Script for Filtering + Pagination -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Filter elements
            const dateInput        = document.getElementById('dateInput');
            const timeInput        = document.getElementById('timeInput');
            const seatNumberInput  = document.getElementById('seatNumberInput');

            // Table/Rows
            const table            = document.getElementById('showTable');
            const allRows          = Array.from(table.querySelectorAll('tbody tr'));

            // Pagination elements
            const rowsPerPageSelect = document.getElementById('rowsPerPage');
            const paginationDiv     = document.getElementById('pagination');

            let currentPage = 1;
            let rowsPerPage = parseInt(rowsPerPageSelect.value);

            // 1) Filter logic: returns an array of rows that match
            function getFilteredRows() {
                const selectedDate = dateInput.value.trim();  // "YYYY-MM-DD" if chosen
                const selectedTime = timeInput.value.trim();  // e.g. "6:00 AM"
                const seatSearch   = seatNumberInput.value.toLowerCase().trim();

                // Return only the rows that match all filters
                return allRows.filter(row => {
                    const dateCell = row.querySelector('td:nth-child(2)').textContent.trim();
                    const timeCell = row.querySelector('td:nth-child(3)').textContent.trim();
                    const seatCell = row.querySelector('td:nth-child(6)').textContent.toLowerCase().trim();

                    // Check date
                    if (selectedDate && dateCell !== selectedDate) {
                        return false;
                    }
                    // Check time
                    if (selectedTime && timeCell !== selectedTime) {
                        return false;
                    }
                    // Check seat number (substring match)
                    if (seatSearch && !seatCell.includes(seatSearch)) {
                        return false;
                    }

                    return true; // Passed all filters
                });
            }

            // 2) Pagination logic: show only the slice of rows for the current page
            function paginateRows(filteredRows) {
                const totalPages = Math.ceil(filteredRows.length / rowsPerPage) || 1;

                // Adjust current page if out of range
                if (currentPage > totalPages) currentPage = totalPages;
                if (currentPage < 1) currentPage = 1;

                // Hide all rows
                allRows.forEach(row => (row.style.display = 'none'));

                // Calculate slice for this page
                const startIndex = (currentPage - 1) * rowsPerPage;
                const endIndex   = startIndex + rowsPerPage;

                // Show only those rows
                filteredRows.slice(startIndex, endIndex).forEach(row => (row.style.display = ''));

                // Update pagination controls
                updatePagination(totalPages);
            }

            // 3) Build pagination buttons (Prev, page numbers, Next)
            function updatePagination(totalPages) {
                paginationDiv.innerHTML = '';
                if (totalPages <= 1) return; // No need if only one page

                // Prev button
                const prevBtn = document.createElement('button');
                prevBtn.textContent = 'Prev';
                prevBtn.disabled = (currentPage === 1);
                prevBtn.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        applyFiltersAndPagination();
                    }
                });
                paginationDiv.appendChild(prevBtn);

                // Page number buttons
                let startPage = Math.max(1, currentPage - 2);
                let endPage   = Math.min(totalPages, currentPage + 2);

                // Adjust if near boundaries
                if (currentPage <= 3) {
                    endPage = Math.min(5, totalPages);
                }
                if (currentPage >= totalPages - 2) {
                    startPage = Math.max(1, totalPages - 4);
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.textContent = i;
                    if (i === currentPage) {
                        pageBtn.classList.add('active');
                    }
                    pageBtn.addEventListener('click', () => {
                        currentPage = i;
                        applyFiltersAndPagination();
                    });
                    paginationDiv.appendChild(pageBtn);
                }

                // Next button
                const nextBtn = document.createElement('button');
                nextBtn.textContent = 'Next';
                nextBtn.disabled = (currentPage === totalPages);
                nextBtn.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        applyFiltersAndPagination();
                    }
                });
                paginationDiv.appendChild(nextBtn);
            }

            // 4) Master function to do both filter + pagination
            function applyFiltersAndPagination() {
                const filtered = getFilteredRows();
                paginateRows(filtered);
            }

            // 5) Hook up filter events
            dateInput.addEventListener('change', () => {
                currentPage = 1;
                applyFiltersAndPagination();
            });
            timeInput.addEventListener('change', () => {
                currentPage = 1;
                applyFiltersAndPagination();
            });
            seatNumberInput.addEventListener('keyup', () => {
                currentPage = 1;
                applyFiltersAndPagination();
            });

            // Rows per page event
            rowsPerPageSelect.addEventListener('change', () => {
                rowsPerPage = parseInt(rowsPerPageSelect.value);
                currentPage = 1;
                applyFiltersAndPagination();
            });

            // 6) On load, apply once
            applyFiltersAndPagination();
        });
    </script>
</x-app-layout>