<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Seat Price') }}
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
                        font-size: 14px;
                        outline: none;
                        box-shadow: inset 1px 1px 3px var(--shadow-dark), inset -1px -1px 3px var(--shadow-light);
                    }

                    .current-poster img {
                        max-width: 100px;
                        border-radius: 10px;
                        box-shadow: 3px 3px 10px var(--shadow-dark), -3px -3px 10px var(--shadow-light);
                    }

                    .toggle-switch {
                        position: relative;
                        display: inline-block;
                        width: 60px;
                        height: 34px;
                    }

                    .toggle-switch input {
                        opacity: 0;
                        width: 0;
                        height: 0;
                    }

                    .slider {
                        position: absolute;
                        cursor: pointer;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background-color: var(--secondary-color);
                        transition: 0.4s;
                        border-radius: 34px;
                    }

                    .slider:before {
                        position: absolute;
                        content: "";
                        height: 26px;
                        width: 26px;
                        left: 4px;
                        bottom: 4px;
                        background-color: var(--primary-color);
                        transition: 0.4s;
                        border-radius: 50%;
                    }

                    input:checked + .slider {
                        background-color: var(--accent-color);
                    }

                    input[type="submit"] {
                        background-color: var(--accent-color);
                        color: #fff;
                        border: none;
                        cursor: pointer;
                        font-size: 16px;
                        font-weight: bold;
                        border-radius: 30px;
                        padding: 12px 20px;
                        width: 100%;
                        text-align: center;
                    }
                </style>

                <div class="container">
                    <h1>Edit Seat Price</h1>

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

                    <form method="post" action="{{ route('price.update', ['price' => $price]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="seat_type">Seat Type</label>
                            <input type="text" name="seat_type" id="seat_type" placeholder="Enter Seat Type"
                                value="{{ $price->seat_type }}" readonly />
                        </div>

                        <div class="form-group">
                            <label for="seat_logo">Seat Logo</label>
                            <input type="file" name="seat_logo" id="seat_logo" accept="image/*" />
                            <div class="current-poster">
                                <p>Current Seat Logo:</p>
                                <img src="{{ asset('storage/' . $price->seat_logo) }}" alt="Seat Logo" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="full_price">Full Price</label>
                            <input type="text" name="full_price" id="full_price" placeholder="Enter New Full Price"
                                value="{{ $price->full_price }}" required />
                        </div>

                        <div class="form-group">
                            <label for="half_price">Half Price</label>
                            <input type="text" name="half_price" id="half_price" placeholder="Enter New Half Price"
                                value="{{ $price->half_price }}" required />
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Update the Seat Price" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
