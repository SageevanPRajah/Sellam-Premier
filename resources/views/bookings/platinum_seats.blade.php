<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ isOpen: true }"  {{-- Alpine.js state for toggling sidebar --}}
      x-cloak>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
            integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4MNol7QzPxwOWa5t4lRDs9C4vGdAN3E6bOozcKW7v1z4+pbjMZtm2VWwg=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Alpine.js -->
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- 
                We are NOT including the usual layouts.navigation 
                because we want a custom sidebar for this page.
            -->

            <!-- Full page container with the custom background -->
            <div class="min-h-screen flex"
                 style="background-image: url('/icons/sdvs.jpg'); background-repeat: repeat; background-size: auto; background-position: center; min-height: 100vh;"
            >
                <!-- BEGIN: CUSTOM SIDEBAR FOR PLATINUM PAGE -->
                <aside 
                    class="bg-white shadow-md min-h-screen transition-all duration-300"
                    :class="isOpen ? 'w-1/18' : 'w-10'"
                    style="background-color: #f7f9f9;"
                >
                    <ul class="space-y-4 mt-4">
                        <!-- Customize sidebar links as needed -->
                        <li class="mt-5 mx-5">
                            <a href="/booking/create/clone" class="flex items-center text-gray-600 hover:text-gray-900 px-4 py-2">
                                <i class="fas fa-user mr-2"></i>
                                <span x-show="isOpen" x-transition>O</span>
                            </a>
                        </li>
                        <!-- Add or remove sidebar items as you wish -->
                    </ul>
                </aside>
                <!-- END: CUSTOM SIDEBAR -->

                <!-- BEGIN: MAIN CONTENT AREA -->
                <div class="p-6 transition-all duration-300"
                     :class="isOpen ? 'w-17/18' : 'flex-1'"
                     style="background-color: #f7f9f9;"
                >
                    <main class="w-[1200px] mx-auto">

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

                            <!-- Top Section: Movie Info -->
                            <div class="top-section">
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

                            <!-- Seat Type Buttons -->
                            <div class="seat-types">
                                <a href="{{ route('booking.cloneSeats', $show->id) }}" 
                                   class="button silver-btn {{ Route::is('booking.cloneSeats') ? 'active' : '' }}">
                                    Silver
                                </a>
                                <a href="{{ route('booking.goldSeats', $show->id) }}" 
                                   class="button gold-btn {{ Route::is('booking.goldSeats') ? 'active' : '' }}">
                                    Gold
                                </a>
                                <a href="{{ route('booking.platinumSeats', $show->id) }}" 
                                   class="button platinum-btn {{ Route::is('booking.platinumSeats') ? 'active' : '' }}">
                                    Platinum
                                </a>
                            </div>

                            <!-- Theater Layout -->
                            <div class="theater-layout-wrapper">
                                <div id="theater-layout">
                                    <!-- PLATINUM Section -->
                                    <div class="seat-type-layout-section" id="platinum-layout">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th colspan="14">PLATINUM</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td><td></td><td></td><td></td><td></td><td></td>
                                                    <td><button class="seat available" data-seat-code="P-X-19">X19</button></td>
                                                    <td><button class="seat available" data-seat-code="P-X-18">X18</button></td>
                                                    <td><button class="seat available" data-seat-code="P-X-17">X17</button></td>
                                                    <td><button class="seat available" data-seat-code="P-X-16">X16</button></td>
                                                    <td><button class="seat available" data-seat-code="P-X-15">X15</button></td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <td></td><td></td><td></td><td></td><td></td><td></td>
                                                    <td><button class="seat available" data-seat-code="P-X-14">X14</button></td>
                                                    <td><button class="seat available" data-seat-code="P-X-13">X13</button></td>
                                                    <td><button class="seat available" data-seat-code="P-X-12">X12</button></td>
                                                    <td><button class="seat available" data-seat-code="P-X-11">X11</button></td>
                                                    <td><button class="seat available" data-seat-code="P-X-10">X10</button></td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <td></td><td></td><td></td><td></td><td></td><td></td>
                                                    <td><button class="seat available" data-seat-code="P-X-9">X9</button></td>
                                                    <td><button class="seat available" data-seat-code="P-X-8">X8</button></td>
                                                    <td><button class="seat available" data-seat-code="P-X-7">X7</button></td>
                                                    <td><button class="seat available" data-seat-code="P-X-6">X6</button></td>
                                                    <td><button class="seat available" data-seat-code="P-X-5">X5</button></td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <td></td><td></td><td></td><td></td><td></td><td></td>
                                                    <td><button class="seat available" data-seat-code="P-X-4">X4</button></td>
                                                    <td><button class="seat available" data-seat-code="P-X-3">X3</button></td>
                                                    <td><button class="seat available" data-seat-code="P-X-2">X2</button></td>
                                                    <td><button class="seat available" data-seat-code="P-X-1">X1</button></td>
                                                    <td></td><td></td><td></td><td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Form -->
                            <form action="{{ route('booking.store') }}" method="POST" class="booking-form">
                                @csrf
                                @method('post')
                                <input type="hidden" id="selected-seats" name="selected_seats">
                                <input type="hidden" name="selected_date" value="{{ $show->date }}">
                                <input type="hidden" name="time" value="{{ $show->time }}">
                                <input type="hidden" name="movie_id" value="{{ $show->id }}">
                                <input type="hidden" name="movie_name" value="{{ $show->movie_name }}">
                                <input type="hidden" id="selected-seat-type" name="seat_type" value="Silver">
                            </form>
                        </div>
                    </main>
                </div>
                <!-- END: MAIN CONTENT AREA -->
            </div>
        </div>

        <!-- JavaScript for seat selection -->
        <script>
            let selectedSeats = []; 
            const bookedSeats = @json($bookedSeats); // from the controller

            document.addEventListener('DOMContentLoaded', () => {
                // Mark booked seats
                document.querySelectorAll('.seat').forEach(seat => {
                    const seatCode = seat.getAttribute('data-seat-code');
                    if (bookedSeats.hasOwnProperty(seatCode)) {
                        if (bookedSeats[seatCode]) {
                            seat.classList.add('booked');
                            seat.disabled = true;
                        } else {
                            seat.classList.add('reserved');
                            seat.disabled = true;
                        }
                    }

                    // Enable click if not booked/reserved
                    if (!seat.classList.contains('booked') && !seat.classList.contains('reserved')) {
                        seat.addEventListener('click', (e) => {
                            e.preventDefault();
                            toggleSeatSelection(seatCode, seat);
                        });
                    }
                });
            });

            function toggleSeatSelection(seatCode, seatButton) {
                if (!seatCode) return;
                if (selectedSeats.includes(seatCode)) {
                    selectedSeats = selectedSeats.filter(s => s !== seatCode);
                    seatButton.classList.remove('selected');
                } else {
                    selectedSeats.push(seatCode);
                    seatButton.classList.add('selected');
                }
                document.getElementById('selected-seats').value = JSON.stringify(selectedSeats);
            }

            // Optional auto reload every 10 seconds if you want
            setTimeout(function() {
                location.reload();
            }, 10000);
        </script>

        <!-- Custom styles for seats, etc. (copy from your original platinum_seats.blade) -->
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
            background-color: #f7f9f9;
            padding: 20px;
            box-sizing: border-box; /* Ensure padding doesn't add to total width */
        }

        /* Top Section: Buttons & Movie Info */
        .top-section {
            display: flex;
            flex-wrap: wrap;/* Ensures proper wrapping on smaller screens */
            justify-content: left;/* Centers the buttons horizontally */
            align-items: left;/* Centers vertically */
            gap: 25px;/* Adds spacing between buttons */
            margin: 0 auto 20px 100px;/* Centers horizontally */
        }

        /* Seat Type Buttons Container */
        .seat-types {
            display: flex;
            flex: 1;
            justify-content: center;/* Centers the buttons horizontally */
            align-items: center;/* Centers vertically */
            gap: 15px;/* Adds spacing between buttons */
            max-width: 500px;/* Adjust as needed */
            margin: 0 10px 20px 65px;/* Centers horizontally */

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
            justify-content: left;
            margin-bottom: 20px;
            margin-left: 100px;
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
        .button.active {
            background-color: #007bff;
            color: white;
            border: 1px solid #0056b3;
        }
            /* etc. */
        </style>
    </body>
</html>
