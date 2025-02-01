<x-app-layout>
    <div class="booking-container">
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

        <!-- Top Section: Seat Type Buttons & Movie Info -->
        <div class="top-section">
            <!-- Seat Type Selection -->
            <div class="seat-types">
                <a href="{{ url('/booking/create/clone/' . $show->id) }}" class="button silver-btn">Silver</a>
                <a href="{{ url('/booking/create/gold/' . $show->id) }}" class="button gold-btn">Gold</a>
                <a href="{{ url('/booking/create/platinum/' . $show->id) }}" class="button platinum-btn">Platinum</a>
            </div>

            <!-- Movie Details on the Right -->
            <div class="movie-details">
                <div>
                    <label>Date:</label>
                    <span>{{ $show->date }}</span>
                </div>
                <div>
                    <label>Time:</label>
                    <span>{{ $show->time }}</span>
                </div>
                <div>
                    <label>Movie:</label>
                    <span>{{ $show->movie_name }}</span>
                </div>
            </div>
        </div>

        <!-- Theater Layout on the right side -->
        <div class="theater-layout-wrapper">
            <div id="theater-layout">

                <!-- SILVER Section (visible by default) -->
                <div class="seat-type-layout-section" id="silver-layout" >
                    <table>
                        <thead>
                            <tr>
                                <th colspan="14">SCREEN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>EL</td>
                        <td><button class="seat available" data-seat-code="S-EL-1">EL1</button></td>
                        <td><button class="seat available" data-seat-code="S-EL-2">EL2</button></td>
                        <td><button class="seat available" data-seat-code="S-EL-3">EL3</button></td>
                        <td><button class="seat available" data-seat-code="S-EL-4">EL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-ER-5">ER5</button></td>
                        <td><button class="seat available" data-seat-code="S-ER-6">ER6</button></td>
                        <td><button class="seat available" data-seat-code="S-ER-7">ER7</button></td>
                        <td><button class="seat available" data-seat-code="S-ER-8">ER8</button></td>
                        <td><button class="seat available" data-seat-code="S-ER-9">ER9</button></td>
                        <td><button class="seat available" data-seat-code="S-ER-10">ER10</button></td>
                        <td>ER</td>
                    </tr>
                    <tr>
                        <td>DL</td>
                        <td><button class="seat available" data-seat-code="S-DL-1">DL1</button></td>
                        <td><button class="seat available" data-seat-code="S-DL-2">DL2</button></td>
                        <td><button class="seat available" data-seat-code="S-DL-3">DL3</button></td>
                        <td><button class="seat available" data-seat-code="S-DL-4">DL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-DR-5">DR5</button></td>
                        <td><button class="seat available" data-seat-code="S-DR-6">DR6</button></td>
                        <td><button class="seat available" data-seat-code="S-DR-7">DR7</button></td>
                        <td><button class="seat available" data-seat-code="S-DR-8">DR8</button></td>
                        <td><button class="seat available" data-seat-code="S-DR-9">DR9</button></td>
                        <td><button class="seat available" data-seat-code="S-DR-10">DR10</button></td>
                        <td>DR</td>
                    </tr>
                    <tr>
                        <td>CL</td>
                        <td><button class="seat available" data-seat-code="S-CL-1">CL1</button></td>
                        <td><button class="seat available" data-seat-code="S-CL-2">CL2</button></td>
                        <td><button class="seat available" data-seat-code="S-CL-3">CL3</button></td>
                        <td><button class="seat available" data-seat-code="S-CL-4">CL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-CR-5">CR5</button></td>
                        <td><button class="seat available" data-seat-code="S-CR-6">CR6</button></td>
                        <td><button class="seat available" data-seat-code="S-CR-7">CR7</button></td>
                        <td><button class="seat available" data-seat-code="S-CR-8">CR8</button></td>
                        <td><button class="seat available" data-seat-code="S-CR-9">CR9</button></td>
                        <td><button class="seat available" data-seat-code="S-CR-10">CR10</button></td>
                        <td>CR</td>
                    </tr>
                    <tr>
                        <td>BL</td>
                        <td><button class="seat available" data-seat-code="S-BL-1">BL1</button></td>
                        <td><button class="seat available" data-seat-code="S-BL-2">BL2</button></td>
                        <td><button class="seat available" data-seat-code="S-BL-3">BL3</button></td>
                        <td><button class="seat available" data-seat-code="S-BL-4">BL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-BR-5">BR5</button></td>
                        <td><button class="seat available" data-seat-code="S-BR-6">BR6</button></td>
                        <td><button class="seat available" data-seat-code="S-BR-7">BR7</button></td>
                        <td><button class="seat available" data-seat-code="S-BR-8">BR8</button></td>
                        <td><button class="seat available" data-seat-code="S-BR-9">BR9</button></td>
                        <td><button class="seat available" data-seat-code="S-BR-10">BR10</button></td>
                        <td>BR</td>
                    </tr>
                    <tr>
                        <td>AL</td>
                        <td><button class="seat available" data-seat-code="S-AL-1">AL1</button></td>
                        <td><button class="seat available" data-seat-code="S-AL-2">AL2</button></td>
                        <td><button class="seat available" data-seat-code="S-AL-3">AL3</button></td>
                        <td><button class="seat available" data-seat-code="S-AL-4">AL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-AR-5">AR5</button></td>
                        <td><button class="seat available" data-seat-code="S-AR-6">AR6</button></td>
                        <td><button class="seat available" data-seat-code="S-AR-7">AR7</button></td>
                        <td><button class="seat available" data-seat-code="S-AR-8">AR8</button></td>
                        <td><button class="seat available" data-seat-code="S-AR-9">AR9</button></td>
                        <td><button class="seat available" data-seat-code="S-AR-10">AR10</button></td>
                        <td>AR</td>
                            </tr>
                            <!-- ( Remaining rows for Silver layout go here ) -->
                            <!-- ... -->
                        </tbody>
                    </table>
                </div>

                <!-- PLATINUM Section (hidden by default) -->
               
            </div>
        </div>

        <!-- Booking Form & Buttons -->
        <form action="{{ route('booking.store') }}" method="POST" class="booking-form">
                    @csrf
                    @method('post')

                    <input type="hidden" id="selected-seats" name="selected_seats">
                    <!-- Hidden fields (still needed by your logic) -->
                    <input type="hidden" id="selected-date" name="selected_date" value="{{ $show->date }}">
                    <input type="hidden" id="time" name="time" value="{{ $show->time }}">
                    <input type="hidden" id="selected-movie-id" name="movie_id" value="{{ $show->id }}">
                    <input type="hidden" id="selected-movie-name" name="movie_name" value="{{ $show->movie_name }}">
                    <!-- Default seat type set to Silver -->
                    <input type="hidden" id="selected-seat-type" name="seat_type" value="Silver">

                    {{-- <div class="form-buttons">
                        <button type="submit" name="reserve_seats" class="button reserve-btn">Reserve Seats</button>
                        <button type="submit" name="confirm_booking" id="confirm-booking" class="button confirm-btn">Confirm Booking</button>
                    </div> --}}
                </form>
    </div>

    <script>
        let selectedSeats = []; // Array to hold selected seats.
        // Use booked seats passed from the backend
        const bookedSeats = @json($bookedSeats); // This array is injected from the backend

        document.addEventListener('DOMContentLoaded', () => {
            // Mark booked seats dynamically
            document.querySelectorAll('.seat').forEach(seat => {
                const seatCode = seat.getAttribute('data-seat-code');

                if (bookedSeats.hasOwnProperty(seatCode)) {
                    // If seat is fully booked or reserved (from backend data)
                    if (bookedSeats[seatCode]) {
                        // If true => booked
                        seat.classList.add('booked');
                        seat.disabled = true;
                    } else {
                        // If false => reserved
                        seat.classList.add('reserved');
                        seat.disabled = true;
                    }
                }

                // Only add click event if seat is neither booked nor reserved
                if (!seat.classList.contains('booked') && !seat.classList.contains('reserved')) {
                    seat.addEventListener('click', (e) => {
                        e.preventDefault();
                        toggleSeatSelection(seatCode, seat);
                    });
                }
            });

            // Event listeners for seat type selection
            document.querySelectorAll('#seat-types button').forEach(button => {
                button.addEventListener('click', () => {
                    const seatType = button.dataset.type;

                    // Hide all seat layouts
                    document.querySelectorAll('.seat-type-layout-section').forEach(section => {
                        section.style.display = 'none';
                    });

                    // Show the chosen seat layout
                    document.getElementById(seatType.toLowerCase() + '-layout').style.display = 'block';

                    // Update hidden input
                    document.getElementById('selected-seat-type').value = seatType;
                });
            });
        });

        function toggleSeatSelection(seatCode, seatButton) {
            if (!seatCode) return;

            if (selectedSeats.includes(seatCode)) {
                // Remove seat from selected
                selectedSeats = selectedSeats.filter(s => s !== seatCode);
                seatButton.classList.remove('selected');
            } else {
                // Add seat to selected
                selectedSeats.push(seatCode);
                seatButton.classList.add('selected');
            }

            // Update hidden input with current selection
            document.getElementById('selected-seats').value = JSON.stringify(selectedSeats);
        }

        setTimeout(function() {
        location.reload();
    }, 10000); // Reloads the page every 5 seconds
    </script>

    <style>
        /* Make the page take full screen (reset default body margin/padding) */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        /* Container to fill the viewport */
        .booking-container {
            width: 100%;
            min-height: 100vh; /* Occupy full vertical space */
            background-color: #ffffff;
            padding: 20px;
            box-sizing: border-box; /* Ensure padding doesn't add to total width */
        }

        /* Top Section: Buttons & Movie Info */
        .top-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        /* Seat Type Buttons Container */
        .seat-types {
            display: flex;
            flex: 1;
            justify-content: space-between;
            max-width: 500px; /* Adjust as needed */
        }

        /* Align Silver button left, Gold center, Platinum right */
        .seat-types .silver-btn {
            margin-right: auto; /* push left */
        }
        .seat-types .gold-btn {
            margin: 0 auto;     /* center */
        }
        .seat-types .platinum-btn {
            margin-left: auto;  /* push right */
        }

        /* Movie details on the right */
        .movie-details {
            text-align: right;
        }
        .movie-details div {
            margin: 5px 0;
        }
        .movie-details label {
            font-weight: bold;
        }

        /* Theater layout container – align to the right */
        .theater-layout-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        /* Table styling */
        table {
            margin: 10px auto;
            border-collapse: collapse;
            width: 40%;
        }
        th, td {
            border: 0px solid black;
            padding: 5px;
            text-align: center;
            width: 30px;
            height: 30px;
        }

        table thead th {
            border-top: 5px solid black;
        }

        .seat-type-layout-section table {
            margin: 0 auto;
            border-collapse: collapse;
        }
        .seat-type-layout-section th {
            text-align: center;
            font-weight: bold;
        }

        /* Seat styles */
        .seat {
            width: 40px;
            height: 30px;
            margin: 0;
            font-size: 10px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }
        .seat:hover {
            background-color: #ddd;
        }
        .seat.selected {
            background-color: #007bff;
            color: white;
            border: 1px solid #0056b3;
        }
        .seat.booked {
            background-color: #e81414;
            cursor: not-allowed;
        }
        .seat.reserved {
            background-color: #ffc107;
            cursor: not-allowed;
        }

        /* Form Buttons at the bottom */
        .form-buttons {
            text-align: right;
            margin-top: 20px;
        }
        .form-buttons .button {
            margin-left: 10px;
        }

        /* Success & Error Messages */
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .error-messages {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }

        /* Basic button style */
        .button {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            background-color: #444;
            color: #fff;
            cursor: pointer;
        }
        .button:hover {
            background-color: #333;
        }
    </style>
</x-app-layout>