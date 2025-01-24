<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Your Seats') }}
        </h2>
    </x-slot>

    <style>
        /* Make the entire page background gray */
        body {
            background-color: #ccc; 
            margin: 0; 
            padding: 0;
        }

        /* Center all content inside the container */
        .container {
            min-height: 100vh;  
            display: flex;  
            flex-direction: column;  
            justify-content: center;  
            align-items: center; 
            text-align: center;
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

        /* Button styling */
        .button {
            margin: 0.5em;
            padding: 0.5em 1em;
            background: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>

    <div class="container">
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
        <label for="date">Select Date:</label>
        <input type="date" id="date" name="date">
        <button class="button" id="fetch-shows">Find Shows</button>

        <!-- Show Time Selection -->
        <div id="show-times" style="display: none; margin-top: 2em;">
            <h3>Select Show Time</h3>
            <ul id="shows-list"></ul>
        </div>
    </div>

    <script>
        let showsData = []; // Declare a global array to store shows data.

        document.getElementById('fetch-shows').addEventListener('click', function () {
            const date = document.getElementById('date').value;

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
                data.forEach(show => {
                    const li = document.createElement('li');
                    li.textContent = `${show.time} - ${show.movie_name}`;
                    li.dataset.showId = show.id;

                    const button = document.createElement('button');
                    button.textContent = 'Select Show';
                    button.classList.add('button');
                    button.addEventListener('click', () => {
                        window.location.href = `/booking/create/${show.id}`;
                    });

                    li.appendChild(button);
                    showList.appendChild(li);
                });
                document.getElementById('show-times').style.display = 'block';
            });
        });
    </script>
</x-app-layout>
