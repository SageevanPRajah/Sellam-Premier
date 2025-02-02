<x-app-layout>
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

                // For each seat type in data, update the table
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
</x-app-layout>
