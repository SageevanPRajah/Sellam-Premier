<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reserved Seats') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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
                            <li>{{ $error }}</li>
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
                        aria-label="Filter by Time">
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
                <table id="showTable" class="min-w-full bg-white border-collapse">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
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

                <div class="action-buttons mt-4">
                    <button type="submit" name="action" value="confirm" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
                        Confirm Booking
                    </button>
                    <button type="submit" name="action" value="cancel" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">
                        Cancel Booking
                    </button>
                </div>
            </form>

        </div>
    </div>

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
