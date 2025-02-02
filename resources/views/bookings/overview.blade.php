<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ isOpen: true }"
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

        <!-- Alpine.js for sidebar toggle -->
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- 
                If you have a top navigation in layouts.navigation 
                but want to remove it for this page,
                just comment it out or delete it:
            -->
            {{-- @include('layouts.navigation') --}}

            <!-- Merged layout + content -->
            <div class="min-h-screen flex"
                 style="background-image: url('/icons/back.jpg'); background-repeat: repeat; background-size: auto; background-position: center; min-height: 100vh;">
                
                <!-- BEGIN: Custom Sidebar for Overview Page -->
                <aside 
                    class="bg-white shadow-md min-h-screen transition-all duration-300"
                    :class="isOpen ? 'w-1/18' : 'w-10'"
                    style="background-color: #f7f9f9;">
                    
                    <ul class="space-y-4 mt-4">
                        <!-- Customize the sidebar items as you wish for the Overview page -->
                        <li class="mt-5 mx-5">
                            <a href="/dashboard" class="flex items-center text-gray-600 hover:text-gray-900 px-4 py-2">
                                <i class="fas fa-user-edit mr-2"></i>
                                <span x-show="isOpen" x-transition>O</span>
                            </a>
                        </li>
                        
                        
                        <!-- Etc. or remove items you don't need -->
                    </ul>
                </aside>
                <!-- END: Sidebar -->

                <!-- BEGIN: Main Content Area -->
                <div class="p-6 transition-all duration-300"
                     :class="isOpen ? 'w-17/18' : 'flex-1'"
                     style="background-color: #f7f9f9;"
                >
                    <main class="w-[1200px] mx-auto">
                        
                        <style>
                            body {
                                background-color: #ccc;
                                margin: 0;
                                padding: 0;
                            }
                            .container {
                                min-height: 100vh;
                                display: flex;
                                flex-direction: column;
                                justify-content: center;
                                align-items: center;
                                text-align: center;
                            }
                            .success-message {
                                color: green;
                                margin-bottom: 1em;
                            }
                            .error-messages {
                                color: red;
                                margin-bottom: 1em;
                            }
                            .button {
                                margin: 0.5em;
                                padding: 0.5em 1em;
                                background: #333;
                                color: #fff;
                                border: none;
                                cursor: pointer;
                            }
                            .seat-count-table {
                                margin-top: 2em;
                                border-collapse: collapse;
                                width: 60%;
                            }
                            .seat-count-table th, .seat-count-table td {
                                border: 1px solid #999;
                                padding: 8px;
                                text-align: center;
                            }
                            .seat-count-table th {
                                background-color: #333;
                                color: #fff;
                            }
                        </style>

                        <div class="container">
                            <h1>Booking Overview</h1>

                            @if(session()->has('success'))
                                <div class="success-message">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="error-messages">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Date Selection -->
                            <label for="date">Select Date:</label>
                            <input type="date" id="date" name="date">
                            <button class="button" id="fetch-shows">Find Shows</button>

                            <!-- Show Selection -->
                            <div id="show-selection" style="display: none; margin-top: 2em;">
                                <h3>Select Show</h3>
                                <ul id="show-list"></ul>
                            </div>

                            <!-- Seat Count Table -->
                            <div id="seat-count-section" style="display: none; margin-top: 2em;">
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
                            document.getElementById('fetch-shows').addEventListener('click', function () {
                                const date = document.getElementById('date').value;

                                fetch("{{ route('booking.getShows') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({ date })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    const showList = document.getElementById('show-list');
                                    showList.innerHTML = '';

                                    // Populate the list of shows
                                    data.forEach(show => {
                                        const li = document.createElement('li');
                                        li.textContent = `${show.time} - ${show.movie_name}`;
                                        li.dataset.showId = show.id;

                                        const button = document.createElement('button');
                                        button.textContent = 'Select Show';
                                        button.classList.add('button');
                                        // On click, fetch seat counts for that show
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
                                    body: JSON.stringify({ show_id: showId })
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        return response.json().then(err => { throw new Error(err.error); });
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    console.log("Seat count data received:", data);

                                    ['Gold', 'Silver', 'Platinum'].forEach(type => {
                                        document.getElementById(`${type.toLowerCase()}-booked`).textContent = data[type]?.booked || 0;
                                        document.getElementById(`${type.toLowerCase()}-reserved`).textContent = data[type]?.reserved || 0;
                                        document.getElementById(`${type.toLowerCase()}-available`).textContent = data[type]?.available || 0;
                                    });

                                    document.getElementById('seat-count-section').style.display = 'block';
                                })
                                .catch(error => {
                                    console.error("Error fetching seat counts:", error);
                                });
                            }
                        </script>
                        <!-- End of your Overview content -->
                    </main>
                </div>
                <!-- END: Main Content -->
            </div>
        </div>
    </body>
</html>
