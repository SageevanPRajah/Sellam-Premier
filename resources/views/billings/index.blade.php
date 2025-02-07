<x-app-layout>
    <h1> <b> Billing Details </b> </h1>

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
            <input type="text" id="movieNameFilter" placeholder="Search movie name..." />
        </div>

        <!-- Start Date Filter -->
        <div class="filter-group">
            <label for="startDateFilter">Start Date:</label>
            <input type="date" id="startDateFilter" />
        </div>

        <!-- End Date Filter -->
        <div class="filter-group">
            <label for="endDateFilter">End Date:</label>
            <input type="date" id="endDateFilter" />
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
                <option value="silver">Silver</option>
                <option value="gold">Gold</option>
                <option value="platinum">Platinum</option>
            </select>
        </div>
    </div>

    <!-- Billing Table -->
    <div id="billingTableContainer">
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
                            <form method="GET" action="{{ route('billing.detail', $billing->id) }}"
                                style="display:inline;">
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
    </div>

    <!-- PDF Generation Button -->
    <div style="text-align: center; margin: 20px; background-color: gray; padding: 10px; border-radius: 10px; max-width: 200px; margin: 0 auto; height: 50px;">
        <button id="generatePdfButton" class="action-button">Generate PDF</button>
    </div>

    <!-- JavaScript -->
    <script>
        // Grab all filter inputs
        const movieNameFilter = document.getElementById('movieNameFilter');
        const startDateFilter = document.getElementById('startDateFilter');
        const endDateFilter = document.getElementById('endDateFilter');
        const timeFilter = document.getElementById('timeFilter');
        const seatTypeFilter = document.getElementById('seatTypeFilter');

        // Summary fields
        const totalFullTicketsEl = document.getElementById('totalFullTickets');
        const totalHalfTicketsEl = document.getElementById('totalHalfTickets');
        const totalSeatsEl = document.getElementById('totalSeats');
        const totalAmountEl = document.getElementById('totalAmount');

        // Convert "HH:MM AM/PM" to "HH:MM" in 24-hour format
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
        startDateFilter.addEventListener('change', filterTable);
        endDateFilter.addEventListener('change', filterTable);
        timeFilter.addEventListener('change', filterTable);
        seatTypeFilter.addEventListener('change', filterTable);

        // Filter on page load
        window.onload = filterTable;

        function filterTable() {
            // Gather filter values
            const selectedMovieName = movieNameFilter.value.trim().toLowerCase();
            const selectedStartDate = startDateFilter.value; // "YYYY-MM-DD"
            const selectedEndDate = endDateFilter.value; // "YYYY-MM-DD"
            const selectedTime = timeFilter.value; // "HH:MM" (24-hour)
            const selectedSeatType = seatTypeFilter.value; // "silver", "gold", "platinum", or ""

            // Reset totals
            let totalFullTickets = 0;
            let totalHalfTickets = 0;
            let totalSeats = 0;
            let totalAmount = 0;

            const rows = document.querySelectorAll('#billingTable tbody tr');
            rows.forEach((row) => {
                // Extract row data
                const rowMovieNameRaw = row.querySelector('td:nth-child(2)')?.textContent || "";
                const rowMovieName = rowMovieNameRaw.trim().toLowerCase();

                const rowTimeRaw = row.querySelector('td:nth-child(4)')?.textContent.trim() || "";
                const rowTime24 = parseTime12to24(rowTimeRaw);

                const rowSeatTypeRaw = row.querySelector('td:nth-child(5)')?.textContent.trim() || "";
                const rowSeatType = rowSeatTypeRaw.toLowerCase();

                const fullTickets = parseInt(row.querySelector('td:nth-child(7)')?.textContent.trim()) || 0;
                const halfTickets = parseInt(row.querySelector('td:nth-child(8)')?.textContent.trim()) || 0;

                let priceText = row.querySelector('td:nth-child(9)')?.textContent.trim() || "0";
                priceText = priceText.replace("Rs. ", "").replace(",", "");
                const rowPrice = parseFloat(priceText) || 0;

                // Created At is in the 10th column
                let rowCreatedAtRaw = row.querySelector('td:nth-child(10)')?.textContent.trim() || "";
                // Substring only "YYYY-MM-DD" from e.g. "2024-01-31 13:45:22"
                let rowCreatedAtDate = rowCreatedAtRaw.substring(0, 10);

                // Filters:
                // 1) Movie name (partial match)
                const movieNameMatches = rowMovieName.includes(selectedMovieName);

                // 2) Date range filter based on Created At column
                const dateMatches =
                    (!selectedStartDate || rowCreatedAtDate >= selectedStartDate) &&
                    (!selectedEndDate || rowCreatedAtDate <= selectedEndDate);

                // 3) Time (24-hour match) from the "Time (AM/PM)" column
                const timeMatches = (!selectedTime || selectedTime === rowTime24);

                // 4) Seat Type (exact match)
                const seatTypeMatches = (!selectedSeatType || rowSeatType === selectedSeatType);

                // If all filters pass, show row; else hide it
                if (
                    movieNameMatches &&
                    dateMatches &&
                    timeMatches &&
                    seatTypeMatches
                ) {
                    row.style.display = '';
                    totalFullTickets += fullTickets;
                    totalHalfTickets += halfTickets;
                    totalSeats += (fullTickets + halfTickets);
                    totalAmount += rowPrice;
                } else {
                    row.style.display = 'none';
                }
            });

            // Update summary
            totalFullTicketsEl.textContent = totalFullTickets;
            totalHalfTicketsEl.textContent = totalHalfTickets;
            totalSeatsEl.textContent = totalSeats;
            totalAmountEl.textContent = "Rs. " + totalAmount.toFixed(2);
        }
    </script>

    <!-- JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <!-- JavaScript -->
    <script>
        // PDF Generation
        document.getElementById('generatePdfButton').addEventListener('click', function() {
            const table = document.getElementById('billingTableContainer');
            html2canvas(table).then((canvas) => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jspdf.jsPDF('p', 'mm', 'a4');
                const imgWidth = 210;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
                pdf.save('billing_details.pdf');
            });
        });

        // Rest of your existing JavaScript code for filtering...
    </script>

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
            color: black;
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
            color: black;
        }

        .search-bar select,
        .search-bar input[type="text"],
        .search-bar input[type="date"],
        .search-bar input[type="time"] {
            padding: 10px 15px;
            border: none;
            border-radius: 20px;
            background-color: rgb(212, 212, 212);
            color: black;
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
            background-color: rgb(255, 255, 255);
            /* box-shadow: 0 0 10px var(--shadow-dark); */
            border-radius: 15px;
            overflow: hidden;
        }

        th,
        td {
            padding: 15px;
            color:black;
        }

        th {
            background-color: rgb(175, 175, 175);
            font-weight: bold;
            color: #000000;
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
            /* box-shadow: 5px 5px 15px var(--shadow-dark),
                -5px -5px 15px var(--shadow-light); */
            transition: box-shadow 0.3s, background-color 0.3s;
            color: #ffffff;
            margin: 0 auto;
            /* Center the button within the cell */
        }

        .btn-delete {
            background-color: #343a40;
            /* Dark Gray */
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
            color:black;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            background-color: rgb(175, 175, 175);
            padding: 20px;
            border-radius: 15px;
            /* box-shadow: 0 0 10px var(--shadow-dark); */
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
</x-app-layout>
