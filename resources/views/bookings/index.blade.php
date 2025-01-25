<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Details') }}
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

            <!-- Add New Booking Button -->
            <div class="add-link">
                <a href="{{ route('show.create') }}">
                    <img src="icons/icons8-add-24.png" alt="Add" style="width: 19px; height: 19px; margin-bottom: -3px;" />
                    Add Booking
                </a>
            </div>

            <!-- Search Bar with Filters -->
            <div class="search-bar">
                <div class="filter-group">
                    <label for="movieCodeSelect">Show Type</label>
                    <select id="movieCodeSelect" aria-label="Select Show Type">
                        <option value="all">All Show Types</option>
                        <option value="Morning Show">Morning Show</option>
                        <option value="Matinee Show">Matinee Show</option>
                        <option value="Night Show">Night Show</option>
                        <option value="Midnight Show">Midnight Show</option>
                        <option value="Special Show">Special Show</option>
                        <option value="Premiere Show">Premiere Show</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="timeInput">Time</label>
                    <input type="text" id="timeInput" placeholder="e.g. 19:30" aria-label="Filter by Time">
                </div>
                <div class="filter-group">
                    <label for="startDate">From Date</label>
                    <input type="date" id="startDate" aria-label="Filter Shows From Date">
                </div>
                <div class="filter-group">
                    <label for="endDate">To Date</label>
                    <input type="date" id="endDate" aria-label="Filter Shows To Date">
                </div>
                <div class="filter-group">
                    <label for="searchInput">Search</label>
                    <input type="text" id="searchInput" placeholder="Search by Movie Name" aria-label="Search Shows">
                </div>
            </div>

            <!-- Shows Table -->
            <table id="showTable" class="min-w-full bg-white border-collapse">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Show ID</th>
                        <th>Movie Name</th>
                        <th>Seat Type</th>
                        <th>Seat Number</th>
                        <th>Seat Code</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Status</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->date }}</td>
                            <td>{{ $booking->time }}</td>
                            <td>{{ $booking->movie_id }}</td>
                            <td>{{ $booking->movie_name }}</td>
                            <td>{{ $booking->seat_type }}</td>
                            <td>{{ $booking->seat_no }}</td>
                            <td>{{ $booking->seat_code }}</td>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->phone }}</td>
                            <td>{{ $booking->status }}</td>
                            <td>
                                <form method="GET" action="{{ route('booking.detail', ['booking' => $booking]) }}">
                                    <button type="submit" class="action-button btn-view">
                                        <img src="icons/icons8-eye-32.png" alt="View"
                                            style="width: 17px; height: 17px; margin-right: 5px;" />
                                        View
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <style>
        /* Include your previous styles here */
    </style>

</x-app-layout>
