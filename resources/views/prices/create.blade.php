<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ticket Price Create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
                <style>
                    /* CSS Variables for Neumorphic Black and Gray Theme */
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
                        color: var(--text-color);
                        max-width: 600px;
                        margin: 0 auto;
                    }

                    h1 {
                        margin-bottom: 20px;
                        text-align: center;
                        color: var(--text-color);
                    }

                    .form-group {
                        margin-bottom: 25px;
                        position: relative;
                    }

                    label {
                        display: block;
                        font-weight: bold;
                        margin-bottom: 8px;
                        color: var(--text-color);
                    }

                    input[type="text"],
                    input[type="file"],
                    select {
                        width: 100%;
                        padding: 10px 15px;
                        border: none;
                        border-radius: 20px;
                        background-color: var(--secondary-color);
                        color: var(--text-color);
                        box-shadow: inset 0.5px 0.5px 1.5px var(--shadow-dark), inset -0.5px -0.5px 1.5px var(--shadow-light);
                        font-size: 14px;
                        outline: none;
                    }

                    select {
                        appearance: none;
                        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D'10'%20height%3D'6'%20viewBox%3D'0%200%2010%206'%20xmlns%3D'http%3A//www.w3.org/2000/svg'%3E%3Cpath%20d%3D'M0,0 L5,6 L10,0' fill='%23e0e0e0'/%3E%3C/svg%3E");
                        background-repeat: no-repeat;
                        background-position: right 15px center;
                        background-size: 10px 6px;
                        padding-right: 40px;
                    }

                    .submit-button {
                        background-color: var(--accent-color);
                        color: #fff;
                        border: none;
                        border-radius: 30px;
                        padding: 12px 20px;
                        font-size: 16px;
                        font-weight: bold;
                        cursor: pointer;
                        width: 100%;
                    }

                    .submit-button:hover {
                        background-color: var(--button-hover-color);
                        color: #000;
                    }
                </style>

                <div class="container">
                    <h1>Ticket Price Create</h1>
                    <div>
                        @if ($errors->any())
                            <ul class="error-messages">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if(session()->has('success'))
                            <div class="success-message">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <form method="post" action="{{ route('price.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="seat_type">Seat Type</label>
                            <select name="seat_type" id="seat_type" required>
                                <option value="" disabled selected>Select seat type</option>
                                <option value="Silver" {{ old('seat_type') == 'Silver' ? 'selected' : '' }}>Silver</option>
                                <option value="Gold" {{ old('seat_type') == 'Gold' ? 'selected' : '' }}>Gold</option>
                                <option value="Platinum" {{ old('seat_type') == 'Platinum' ? 'selected' : '' }}>Platinum</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="seat_logo">Seat Logo</label>
                            <input type="file" name="seat_logo" id="seat_logo" accept="image/*" required />
                        </div>

                        <div class="form-group">
                            <label for="movie_code">Price Type</label>
                            <select name="movie_code" id="movie_code" required>
                                <option value="" disabled selected>Select Price Type</option>
                                <option value="Price 1" {{ old('movie_code') == 'Price 1' ? 'selected' : '' }}>Price 1</option>
                                <option value="Price 2" {{ old('movie_code') == 'Price 2' ? 'selected' : '' }}>Price 2</option>
                                <option value="Price 3" {{ old('movie_code') == 'Price 3' ? 'selected' : '' }}>Price 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="full_price">Full Price</label>
                            <input type="text" name="full_price" id="full_price" placeholder="Enter full price" value="{{ old('full_price') }}" required />
                        </div>

                        <div class="form-group">
                            <label for="half_price">Half Price</label>
                            <input type="text" name="half_price" id="half_price" placeholder="Enter half price" value="{{ old('half_price') }}" required />
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Save a New Seat Price" class="submit-button" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
