<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ticket Prices') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
                <style>
                    /* All your existing CSS styles go here */
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

                    /* Add your CSS styles here */
                    body {
                        font-size: 14px;
                        background-color: var(--background-color);
                    }

                    table {
                        margin: 20px auto;
                        border-collapse: collapse;
                        width: 100%;
                        text-align: center;
                        background-color: var(--primary-color);
                        box-shadow: 0 0 10px var(--shadow-dark);
                        border-radius: 15px;
                        overflow: hidden;
                    }

                    th,
                    td {
                        padding: 10px;
                        color: var(--text-color);
                    }

                    th {
                        background-color: var(--secondary-color);
                        font-weight: bold;
                        text-align: center;
                    }

                    img {
                        max-width: 60px;
                        border-radius: 10px;
                    }

                    .add-link {
                        text-align: right;
                        margin-bottom: 20px;
                    }

                    .add-link a {
                        display: inline-flex;
                        align-items: center;
                        padding: 10px 20px;
                        background-color: var(--button-color);
                        color: var(--text-color);
                        text-decoration: none;
                        border-radius: 10px;
                        font-weight: bold;
                        transition: background-color 0.3s;
                    }

                    .add-link a:hover {
                        background-color: var(--button-hover-color);
                        color: white;
                    }

                    button {
                        background-color: var(--button-color);
                        color: var(--text-color);
                        border: none;
                        padding: 10px 20px;
                        border-radius: 10px;
                        cursor: pointer;
                        transition: background-color 0.3s;
                    }

                    button:hover {
                        background-color: var(--button-hover-color);
                    }
                </style>

                <h1 class="text-center text-2xl mb-4">Ticket Prices</h1>

                <div class="add-link">
                    <a href="{{ route('price.create') }}">
                        <img src="icons/icons8-add-24.png" alt="Add" class="inline-block mr-2" />
                        Add New Price
                    </a>
                </div>

                <!-- Success Message -->
                @if(session()->has('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="error-messages text-red-500">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Prices Table -->
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Seat Type</th>
                            <th>Seat Logo</th>
                            <th>Price Code</th>
                            <th>Full Ticket Price</th>
                            <th>Half Ticket Price</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prices as $price)
                            <tr>
                                <td>{{ $price->id }}</td>
                                <td>{{ $price->seat_type }}</td>
                                <td>
                                    <img src="{{ $price->seat_logo ? asset('storage/' . $price->seat_logo) : asset('images/default-poster.jpg') }}"
                                        alt="Seat Logo" />
                                </td>
                                <td>{{ $price->movie_code }}</td>
                                <td>{{ $price->full_price }}</td>
                                <td>{{ $price->half_price }}</td>
                                <td>
                                    <form method="GET" action="{{ route('price.edit', ['price' => $price]) }}">
                                        <button type="submit" aria-label="Edit Price">
                                            <img src="icons/icons8-edit-50.png" alt="Edit"
                                                class="inline-block mr-2" />
                                            Edit
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
