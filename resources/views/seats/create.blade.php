<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Seat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
                <style>
                    /* All your existing CSS styles go here */
                    :root {
                        --background-color: #121212;
                        --primary-color: #1e1e1e;
                        --secondary-color: #2e2e2e;
                        --text-color: #e0e0e0;
                        --accent-color: #4CAF50;
                        --button-color: #2e2e2e;
                        --button-hover-color: #3e3e3e;
                        --border-color: #555;
                        --success-color: #4CAF50;
                        --danger-color: #FF5555;
                        --info-color: #2196F3;
                        --muted-color: #777;
                        --shadow-light: #2b2b2b;
                        --shadow-dark: #0c0c0c;
                    }

                    .container {
                        background-color: var(--primary-color);
                        padding: 30px;
                        border-radius: 15px;
                        max-width: 600px;
                        color: var(--text-color);
                        margin: 0 auto;
                    }

                    h1 {
                        margin-bottom: 20px;
                        text-align: center;
                        color: var(--text-color);
                    }

                    .form-group {
                        margin-bottom: 15px;
                    }

                    label {
                        font-weight: bold;
                        display: block;
                        margin-bottom: 5px;
                        color: var(--text-color);
                    }

                    input,
                    select {
                        width: 100%;
                        padding: 10px;
                        border: none;
                        border-radius: 20px;
                        background-color: var(--secondary-color);
                        color: var(--text-color);
                        box-shadow: inset 1px 1px 3px var(--shadow-dark), inset -1px -1px 3px var(--shadow-light);
                    }

                    input[type="submit"] {
                        background-color: var(--accent-color);
                        color: #fff;
                        font-weight: bold;
                        border-radius: 30px;
                        padding: 10px;
                        cursor: pointer;
                    }

                    input[type="submit"]:hover {
                        background-color: var(--button-hover-color);
                    }

                    .success-message {
                        color: var(--success-color);
                        margin-bottom: 20px;
                        text-align: center;
                    }

                    .error-messages {
                        color: var(--danger-color);
                        margin-bottom: 15px;
                        text-align: center;
                    }

                    .error-messages ul {
                        list-style: none;
                        padding: 0;
                    }
                </style>

                <div class="container">
                    <h1>Create Seat</h1>

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

                    <form method="post" action="{{ route('seat.store') }}" onsubmit="return updateHiddenFields()" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="seat_code" id="seat_code" />
                        <input type="hidden" name="seat_no" id="seat_no" />

                        <div class="form-group">
                            <label for="seat_type">Seat Type</label>
                            <select name="seat_type" id="seat_type" onchange="updateHiddenFields()" required>
                                <option value="" disabled selected>Select seat type</option>
                                <option value="Silver">Silver</option>
                                <option value="Gold">Gold</option>
                                <option value="Platinum">Platinum</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="seat_letter">Seat Letter</label>
                            <input type="text" name="seat_letter" id="seat_letter" placeholder="Enter Seat Letter" oninput="updateHiddenFields()" required />
                        </div>

                        <div class="form-group">
                            <label for="seat_digit">Seat Digit</label>
                            <input type="number" name="seat_digit" id="seat_digit" placeholder="Enter Seat Digit" oninput="updateHiddenFields()" required />
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Save New Seat" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateHiddenFields() {
            const seatType = document.getElementById('seat_type').value;
            const seatLetter = document.getElementById('seat_letter').value.toUpperCase();
            const seatDigit = document.getElementById('seat_digit').value;

            if (!seatType || !seatLetter || !seatDigit) {
                return false;
            }

            const seatTypeMap = {
                'Silver': 'S',
                'Gold': 'G',
                'Platinum': 'P'
            };
            const seatTypeInitial = seatTypeMap[seatType] || '';
            const seatNo = `${seatLetter}-${seatDigit}`;
            const seatCode = `${seatTypeInitial}-${seatLetter}-${seatDigit}`;

            document.getElementById('seat_no').value = seatNo;
            document.getElementById('seat_code').value = seatCode;

            return true;
        }
    </script>
</x-app-layout>
