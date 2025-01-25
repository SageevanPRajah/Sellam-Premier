<x-app-layout>
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
        const movieNameFilter = document.getElementById('movieNameFilter');
        const dateFilter = document.getElementById('dateFilter');
        const timeFilter = document.getElementById('timeFilter');
        const seatTypeFilter = document.getElementById('seatTypeFilter');

        const totalFullTicketsEl = document.getElementById('totalFullTickets');
        const totalHalfTicketsEl = document.getElementById('totalHalfTickets');
        const totalSeatsEl = document.getElementById('totalSeats');
        const totalAmountEl = document.getElementById('totalAmount');

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
            return `${hours.toString().padStart(2, '0')}:${minutes}`;
        }

        movieNameFilter.addEventListener('input', filterTable);
        dateFilter.addEventListener('change', filterTable);
        timeFilter.addEventListener('change', filterTable);
        seatTypeFilter.addEventListener('change', filterTable);

        function filterTable() {
            const selectedMovieName = movieNameFilter.value.trim().toLowerCase();
            const selectedDate = dateFilter.value;
            const selectedTime = timeFilter.value;
            const selectedSeatType = seatTypeFilter.value;

            let totalFullTickets = 0;
            let totalHalfTickets = 0;
            let totalSeats = 0;
            let totalAmount = 0;

            const rows = document.querySelectorAll('#billingTable tbody tr');
            rows.forEach((row) => {
                const rowMovieName = row.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();
                const rowDate = row.querySelector('td:nth-child(3)').textContent.trim();
                const rowTime = parseTime12to24(row.querySelector('td:nth-child(4)').textContent.trim());
                const rowSeatType = row.querySelector('td:nth-child(5)').textContent.trim().toLowerCase();
                const fullTickets = parseInt(row.querySelector('td:nth-child(7)').textContent.trim()) || 0;
                const halfTickets = parseInt(row.querySelector('td:nth-child(8)').textContent.trim()) || 0;
                const rowPrice = parseFloat(row.querySelector('td:nth-child(9)').textContent.replace('Rs. ', '').replace(',', '')) || 0;

                const movieNameMatches = rowMovieName.includes(selectedMovieName);
                const dateMatches = !selectedDate || rowDate === selectedDate;
                const timeMatches = !selectedTime || rowTime === selectedTime;
                const seatTypeMatches = !selectedSeatType || rowSeatType === selectedSeatType;

                if (movieNameMatches && dateMatches && timeMatches && seatTypeMatches) {
                    row.style.display = '';
                    totalFullTickets += fullTickets;
                    totalHalfTickets += halfTickets;
                    totalSeats += fullTickets + halfTickets;
                    totalAmount += rowPrice;
                } else {
                    row.style.display = 'none';
                }
            });

            totalFullTicketsEl.textContent = totalFullTickets;
            totalHalfTicketsEl.textContent = totalHalfTickets;
            totalSeatsEl.textContent = totalSeats;
            totalAmountEl.textContent = `Rs. ${totalAmount.toFixed(2)}`;
        }
    </script>

    <style>
        :root {
            --background-color: #121212;
            --primary-color: #1e1e1e;
            --secondary-color: #2e2e2e;
            --text-color: #e0e0e0;
            --accent-color: #4CAF50;
            --button-color: #2e2e2e;
            --button-hover-color: #3e3e3e;
            --shadow-light: #2b2b2b;
            --shadow-dark: #0c0c0c;
        }

        .search-bar input,
        .search-bar select {
            padding: 10px;
            border: none;
            background: var(--primary-color);
            color: var(--text-color);
            border-radius: 5px;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 90%;
            background: var(--primary-color);
            color: var(--text-color);
        }

        th, td {
            padding: 10px;
        }

        .summary-section {
            margin: 20px auto;
            padding: 20px;
            background: var(--secondary-color);
            border-radius: 10px;
        }
    </style>
</x-app-layout>
