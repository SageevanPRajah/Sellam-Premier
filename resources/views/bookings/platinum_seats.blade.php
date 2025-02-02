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

        <!-- Seat Type Selection -->
            <div class="seat-types">
                <a href="{{ url('/booking/create/clone/' . $show->id) }}" class="button silver-btn">Silver</a>
                <a href="{{ url('/booking/create/gold/' . $show->id) }}" class="button gold-btn">Gold</a>
                <a href="{{ url('/booking/create/platinum/' . $show->id) }}" class="button platinum-btn">Platinum</a>
            </div>

        <!-- Theater Layout on the right side -->
        <div class="theater-layout-wrapper">
            <div id="theater-layout">

                

                <!-- PLATINUM Section (hidden by default) -->
                <div class="seat-type-layout-section" id="platinum-layout" >
                    <table>
                        <thead>
                            <tr>
                                <th colspan="14">PLATINUM</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td><td ></td><td ></td><td ></td><td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="P-X-19">X19</button></td>
                        <td><button class="seat available" data-seat-code="P-X-18">X18</button></td>
                        <td><button class="seat available" data-seat-code="P-X-17">X17</button></td>
                        <td><button class="seat available" data-seat-code="P-X-16">X16</button></td>
                        <td><button class="seat available" data-seat-code="P-X-15">X15</button></td>
                        <td></td><td ></td><td ></td>
                    </tr>
                    <tr>
                        <td></td><td ></td><td ></td><td ></td><td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="P-X-14">X14</button></td>
                        <td><button class="seat available" data-seat-code="P-X-13">X13</button></td>
                        <td><button class="seat available" data-seat-code="P-X-12">X12</button></td>
                        <td><button class="seat available" data-seat-code="P-X-11">X11</button></td>
                        <td><button class="seat available" data-seat-code="P-X-10">X10</button></td>
                        <td></td><td ></td><td ></td>
                    </tr>
                    <tr>
                        <td></td><td ></td><td ></td><td ></td><td ></td><td></td>
                        <td><button class="seat available" data-seat-code="P-X-9">X9</button></td>
                        <td><button class="seat available" data-seat-code="P-X-8">X8</button></td>
                        <td><button class="seat available" data-seat-code="P-X-7">X7</button></td>
                        <td><button class="seat available" data-seat-code="P-X-6">X6</button></td>
                        <td><button class="seat available" data-seat-code="P-X-5">X5</button></td>
                        <td ></td><td ></td><td ></td>
                    </tr>
                    <tr>
                        <td></td><td ></td><td ></td><td ></td><td ></td><td></td>
                        <td><button class="seat available" data-seat-code="P-X-4">X4</button></td>
                        <td><button class="seat available" data-seat-code="P-X-3">X3</button></td>
                        <td><button class="seat available" data-seat-code="P-X-2">X2</button></td>
                        <td><button class="seat available" data-seat-code="P-X-1">X1</button></td>
                        <td></td><td ></td><td ></td><td ></td>
                            </tr>
                           
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
            flex-wrap: wrap; /* Ensures proper wrapping on smaller screens */
            justify-content: center; /* Centers the buttons horizontally */
            align-items: center; /* Centers vertically */
            gap: 25px; /* Adds spacing between buttons */
            margin: 0 auto 20px auto; /* Centers horizontally */
        }

        /* Seat Type Buttons Container */
        .seat-types {
            display: flex;
            flex: 1;
            justify-content: center; /* Centers the buttons horizontally */
            align-items: center; /* Centers vertically */
            gap: 15px; /* Adds spacing between buttons */
            max-width: 500px; /* Adjust as needed */
            margin: 0 auto 20px auto; /* Centers horizontally */
            
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

        /* Ensure Movie Details are aligned in one line */
        .movie-details {
            display: flex;
            gap: 20px; /* Adds spacing between Date, Time, and Movie */
            align-items: center;
        }

        .movie-details div {
            margin: 0; /* Remove extra margin to keep everything in one line */
        }

        .movie-details label {
            font-weight: bold;
            margin-right: 5px; /* Adds spacing between label and value */
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