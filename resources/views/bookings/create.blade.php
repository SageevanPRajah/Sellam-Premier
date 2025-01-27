<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Your Seats') }}
        </h2>
    </x-slot> --}}

    <style>
        /* Make the entire page background gray */
        body {
            background-color: #ccc; 
            margin: 0; 
            padding: 0;
            
            /* Remove flex centering from body if previously applied */
            /* If body had flex properties from previous modifications, ensure they're removed */
        }

        /* Center only the booking container */
        .booking-container-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Optional: Ensures the booking container is vertically centered */
            
        }

        .booking-container {
            background: #fff; /* Optional: Add a white background to the container */
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* max-width: 400px;  */
            /* width: 90%; */ 
            text-align: center;
            align-content: center;
            box-sizing:none;
        }

        /* Style headers */
        .booking-container h1 {
            margin-bottom: 1em;
            font-size: 2em;
            color: #333;
        }

        /* Style messages */
        .success-message {
            color: green;
            margin-bottom: 1em;
        }

        .error-messages {
            color: red;
            margin-bottom: 1em;
        }

        /* Form elements */
        .form-group {
            width: 100%;
            margin-bottom: 1em;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing:none;
        }

        .form-group label {
            margin-bottom: 0.5em;
            font-weight: bold;
            color: #555;
        }

        .form-group input[type="date"] {
            padding: 0.5em;
            width: 100%;
            max-width: 250px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Button styling */
        .button {
            margin: 0.5em;
            padding: 0.5em 1em;
            background: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 12px;
        }

        .button:hover {
            background: #555;
        }

        /* Show times section */
        #show-times {
            width: 100%;
            margin-top: 2em;
            box-sizing:none;
        }

        #show-times h3 {
            margin-bottom: 1em;
            color: #333;
        }

        #shows-list {
            list-style: none;
            padding: 0;
            width: 100%;
        }

        #shows-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75em;
            margin-bottom: 0.5em;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        #shows-list li:last-child {
            margin-bottom: 0;
        }

        #shows-list button {
            padding: 0.5em 1em;
            background: #454545;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
            height: 35px;
            width: 75px;
        }

        #shows-list button:hover {
            background: #0056b3;
        }

        /* Responsive adjustments */
        @media (max-width: 500px) {
            .booking-container {
                padding: 1em;
            }

            .form-group input[type="date"] {
                max-width: 100%;
            }

            #shows-list li {
                flex-direction: column;
                align-items: flex-start;
            }

            #shows-list button {
                margin-top: 0.5em;
                width: 100%;
            }
        }
    </style>

    <div class="mx-80 mt-20" >
        <div class="booking-container">
            <h1>Book Your Seats</h1>

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
            <div class="form-group">
                <label for="date">Select Date:</label>
                <input type="date" id="date" name="date">
            </div>
            <button class="button" id="fetch-shows">Find Shows</button>

            <!-- Show Time Selection -->
            <div id="show-times" style="display: none;">
                <h3>Select Show Time</h3>
                <ul id="shows-list"></ul>
            </div>
        </div>
    </div>

    <script>
        let showsData = []; // Declare a global array to store shows data.

        document.getElementById('fetch-shows').addEventListener('click', function () {
            const date = document.getElementById('date').value;

            if (!date) {
                alert('Please select a date.');
                return;
            }

            fetch("{{ route('booking.getShows') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ date, _token: "{{ csrf_token() }}" })
            })
            .then(response => response.json())
            .then(data => {
                showsData = data; // Assign data to the global array
                const showList = document.getElementById('shows-list');
                showList.innerHTML = '';

                if (data.length === 0) {
                    showList.innerHTML = '<li>No shows available for the selected date.</li>';
                } else {
                    data.forEach(show => {
                        const li = document.createElement('li');

                        const showInfo = document.createElement('span');
                        showInfo.textContent = ${show.time} - ${show.movie_name};

                        const button = document.createElement('button');
                        button.textContent = 'Select';
                        button.classList.add('button');
                        button.addEventListener('click', () => {
                            window.location.href = /booking/create/${show.id};
                        });

                        li.appendChild(showInfo);
                        li.appendChild(button);
                        showList.appendChild(li);
                    });
                }

                document.getElementById('show-times').style.display = 'block';
            })
            .catch(error => {
                console.error('Error fetching shows:', error);
                alert('There was an error fetching the shows. Please try again later.');
            });
        });
    </script>
</x-app-layout>