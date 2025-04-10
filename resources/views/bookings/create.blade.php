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
                        
                        if (window.seatPopup && !window.seatPopup.closed) {
                            window.seatPopup.location.href = `/booking/create/gold/${show.id}`;
                        } else {
                            window.seatPopup = window.open(`/booking/create/gold/${show.id}`, 'SeatPopup');
                        }
                        
                        window.location.href = `/booking/create/${show.id}`;
                    });

                    li.appendChild(button);
                    showList.appendChild(li);
                });
                document.getElementById('show-times').style.display = 'block';
            });
        });
    </script>

<!----------------------------------------------------------------->
<!------ Customer View Popup Window - nazeemthebeta@gmail.com ----->
<!----------------------------------------------------------------->
    <script>
        
        let seatPopup = null;
        let lastShowId = null;

        // Open the popup immediately with a placeholder (blank or preview page)
        function openInitialPopup() {
            const defaultUrl = ''; // change to a safe placeholder or leave blank
            seatPopup = window.open(defaultUrl, 'SeatPopup');
        }

        // Dynamically update the popup with selected show ID
        function updatePopup(showId) {
            const url = `/booking/clone/gold/${showId}`;
            if (seatPopup && !seatPopup.closed) {
                seatPopup.location.href = url;
            } else {
                // Reopen if closed
                seatPopup = window.open(url, 'SeatPopup');
            }
        }

        function getCurrentShowId() {
            const input = document.querySelector('[name="show_id"]'); // Adjust if needed
            return input ? input.value : null;
        }

        document.addEventListener('DOMContentLoaded', function () {
            openInitialPopup(); // Popup on page load

            // Mutation observer if show_id is dynamically added/updated
            const observer = new MutationObserver(() => {
                const currentShowId = getCurrentShowId();
                if (currentShowId && currentShowId !== lastShowId) {
                    lastShowId = currentShowId;
                    updatePopup(currentShowId);
                }
            });

            const target = document.getElementById('show-selection-container'); // Adjust if needed
            if (target) {
                observer.observe(target, { childList: true, subtree: true });
            }

            // Also handle change events from dropdowns
            document.querySelectorAll('[name="movie_id"], [name="date"]').forEach(el => {
                el.addEventListener('change', () => {
                    setTimeout(() => {
                        const currentShowId = getCurrentShowId();
                        if (currentShowId && currentShowId !== lastShowId) {
                            lastShowId = currentShowId;
                            updatePopup(currentShowId);
                        }
                    }, 300);
                });
            });
        });
    </script>
    
<!---------------------------------------------------------------->


</x-app-layout>
