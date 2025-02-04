<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ isOpen: true }" x-cloak>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4MNol7QzPxwOWa5t4lRDs9C4vGdAN3E6bOozcKW7v1z4+pbjMZtm2VWwg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js for sidebar toggle -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        /* Base font size increased from 16px to 24px (1.5×) */
        body {
            background-color: #ccc;
            margin: 0;
            padding: 0;
            font-size: 24px;
        }

        /* Container aligned to left with increased padding */
        .container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            padding: 1.5em;
            /* increased from 1em */
        }

        /* Headings and labels (scaling remains relative to base size) */
        h1,
        h3,
        label {
            text-align: left;
            width: 100%;
            /* 1.5em relative to 24px = 36px */
            font-size: 1.5em;
        }

        .success-message,
        .error-messages {
            width: 100%;
            text-align: left;
            margin-bottom: 1.5em;
            /* increased margin */
            font-size: 1.2em;
        }

        .success-message {
            color: green;
        }

        .error-messages {
            color: red;
        }

        /* Date Selection Section: increased max-width from 300px to 450px */
        .date-selection {
            width: auto;
            max-width: 450px;
            margin-bottom: 1.5em;
        }

        .date-selection label,
        .date-selection input,
        .date-selection button {
            display: block;
            width: 100%;
            margin-bottom: 0.75em;
            /* increased margin */
            font-size: 1em;
        }

        /* Increase padding on input and button (from 0.5em to 0.75em) */
        .date-selection input,
        .date-selection button {
            padding: 0.75em;
        }

        .button {
            padding: 0.75em 1em;
            background: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            text-align: left;
            font-size: 1em;
        }

        /* Show Selection List */
        #show-list {
            list-style: none;
            padding-left: 0;
            width: 100%;
        }

        .show-item {
            margin-bottom: 1.5em;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .show-item span {
            font-weight: bold;
            font-size: 1.2em;
        }

        /* Seat Count Table: increased font size and max-width scaling */
        .seat-count-table {
            margin-top: 2em;
            border-collapse: collapse;
            width: 100%;
            max-width: 900px;
            /* increased from 600px */
        }

        .seat-count-table th,
        .seat-count-table td {
            border: 1px solid #999;
            padding: 12px;
            /* increased from 8px */
            text-align: left;
            font-size: 1em;
        }

        .seat-count-table th {
            background-color: #333;
            color: #fff;
        }

        /* Responsive adjustments for mobile screens */
        @media only screen and (max-width: 480px) {
            .container {
                padding: 1em;
            }

            .date-selection label,
            .date-selection input,
            .date-selection button,
            .button {
                font-size: 1em;
            }

            .seat-count-table {
                width: 100%;
                font-size: 1em;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Merged layout + content -->
        <div class="min-h-screen flex"
            style="background-image: url('/icons/sdvs[1].jpg'); background-repeat: no-repeat; 
           background-size: cover; background-position: center; min-height: 100vh;">

            <!-- BEGIN: Custom Sidebar for Overview Page -->
            <aside class="bg-white shadow-md min-h-screen transition-all duration-300"
                :class="isOpen ? 'w-1/18' : 'w-10'" style="background-color: #f7f9f9;">

                <ul class="space-y-4 mt-4">
                    <!-- Sidebar Item Example -->
                    <li class="mt-5 mx-5">
                        <a href="/dashboard" class="flex items-center text-gray-600 hover:text-gray-900 px-4 py-2">
                            <i class="fas fa-user-edit mr-2"></i>
                            <span x-show="isOpen" x-transition>O</span>
                        </a>
                    </li>
                    <!-- Additional sidebar items can be added here -->
                </ul>
            </aside>
            <!-- END: Sidebar -->

            <!-- BEGIN: Main Content Area -->
            <div class="p-6 transition-all duration-300" :class="isOpen ? 'w-17/18' : 'flex-1'"
                style="background-color: #f7f9f9;">
                <main class="w-[1200px] mx-auto">

                    <div class="container">
                        <h1>Booking Overview</h1>

                        @if (session()->has('success'))
                            <div class="success-message">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="error-messages">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Date Selection -->
                        <div class="date-selection">
                            <label for="date">Select Date:</label>
                            <input type="date" id="date" name="date">
                            <button class="button" id="fetch-shows">Find Shows</button>
                        </div>

                        <!-- Show Selection -->
                        <div id="show-selection" style="display: none; width: 100%;">
                            <h3>Select Show</h3>
                            <ul id="show-list"></ul>
                        </div>

                        <!-- Seat Count Table -->
                        <div id="seat-count-section" style="display: none; width: 100%;">
                            <h3>Seat Overview</h3>
                            <table class="seat-count-table">
                                <thead>
                                    <tr>
                                        <th>Seat Type</th>
                                        <th>Total Seats</th>
                                        <th>Booked Seats</th>
                                        <th>Reserved Seats</th>
                                        <th>Available Seats</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Gold</td>
                                        <td>182</td>
                                        <td id="gold-booked">0</td>
                                        <td id="gold-reserved">0</td>
                                        <td id="gold-available">182</td>
                                    </tr>
                                    <tr>
                                        <td>Silver</td>
                                        <td>50</td>
                                        <td id="silver-booked">0</td>
                                        <td id="silver-reserved">0</td>
                                        <td id="silver-available">50</td>
                                    </tr>
                                    <tr>
                                        <td>Platinum</td>
                                        <td>19</td>
                                        <td id="platinum-booked">0</td>
                                        <td id="platinum-reserved">0</td>
                                        <td id="platinum-available">19</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <script>
                        // 1) Fetch shows for the selected date
                        document.getElementById('fetch-shows').addEventListener('click', function() {
                            const date = document.getElementById('date').value;
                            fetch("{{ route('booking.getShows') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({
                                        date
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    const showList = document.getElementById('show-list');
                                    showList.innerHTML = '';

                                    // Populate the list of shows
                                    data.forEach(show => {
                                        // Create a container for the show item
                                        const li = document.createElement('li');
                                        li.className = 'show-item';

                                        // Create a span for show information
                                        const info = document.createElement('span');
                                        info.textContent = ${show.time} - ${show.movie_name};
                                        li.appendChild(info);

                                        // Create the "Select Show" button on a new line
                                        const button = document.createElement('button');
                                        button.textContent = 'Select Show';
                                        button.classList.add('button');
                                        button.style.marginTop = '0.5em';
                                        button.addEventListener('click', () => fetchSeatCounts(show.id));
                                        li.appendChild(button);

                                        showList.appendChild(li);
                                    });
                                    document.getElementById('show-selection').style.display = 'block';
                                });
                        });

                        // 2) Fetch seat counts for a selected show
                        function fetchSeatCounts(showId) {
                            console.log("Fetching seat counts for show:", showId);
                            fetch("{{ route('booking.getSeatCounts') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({
                                        show_id: showId
                                    })
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        return response.json().then(err => {
                                            throw new Error(err.error);
                                        });
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    console.log("Seat count data received:", data);
                                    ['Gold', 'Silver', 'Platinum'].forEach(type => {
                                        document.getElementById(${type.toLowerCase()}-booked).textContent = data[type]
                                            ?.booked || 0;
                                        document.getElementById(${type.toLowerCase()}-reserved).textContent = data[type]
                                            ?.reserved || 0;
                                        document.getElementById(${type.toLowerCase()}-available).textContent = data[type]
                                            ?.available || 0;
                                    });
                                    document.getElementById('seat-count-section').style.display = 'block';
                                })
                                .catch(error => {
                                    console.error("Error fetching seat counts:", error);
                                });
                        }
                    </script>
                    <!-- End of Overview content -->
                </main>
            </div>
            <!-- END: Main Content -->
        </div>
    </div>
</body>

</html>