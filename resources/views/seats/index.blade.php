<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seats') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
                <style>
                    /* Add your CSS styles here */
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

                    .add-link {
                        text-align: center;
                        margin-bottom: 20px;
                    }

                    .add-link a {
                        display: inline-flex;
                        align-items: center;
                        padding: 8px 12px;
                        background-color: var(--primary-color);
                        color: var(--text-color);
                        text-decoration: none;
                        border-radius: 30px;
                        transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
                        font-weight: bold;
                    }

                    .add-link a:hover {
                        background-color: var(--button-hover-color);
                        color: #fff;
                    }

                    table {
                        margin: 0 auto;
                        border-collapse: collapse;
                        width: 100%;
                        text-align: center;
                        background-color: rgb(41, 43, 44);
                        border-radius: 15px;
                        overflow: hidden;
                    }

                    th, td {
                        padding: 10px;
                        color: var(--text-color);
                    }

                    th {
                        background-color: rgb(35, 36, 36);
                        font-weight: bold;
                        color: #ffffff;
                    }

                    .success-message {
                        color: var(--success-color);
                        text-align: center;
                        margin-bottom: 20px;
                    }

                    .error-messages ul {
                        color: var(--danger-color);
                        list-style: none;
                        padding: 0;
                        margin-bottom: 15px;
                        text-align: center;
                    }

                    .btn-view {
                        padding: 5px 10px;
                        background-color: var(--accent-color);
                        color: #fff;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                        transition: background-color 0.3s;
                    }

                    .btn-view:hover {
                        background-color: var(--button-hover-color);
                    }
                </style>

                <h1 class="text-center text-2xl mb-4">Seats</h1>

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

                <div class="add-link mb-4">
                    <a href="{{ route('seat.create') }}">
                        <img src="icons/icons8-add-24.png" alt="Add" style="width: 19px; height: 19px; margin-bottom: 3px;" /> 
                        Add New Seat
                    </a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Seat Code</th>
                            <th>Seat Type</th>
                            <th>Seat No</th>
                            <th>Row</th>
                            <th>Number</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seats as $seat)
                            <tr>
                                <td>{{ $seat->id }}</td>
                                <td>{{ $seat->seat_code }}</td>
                                <td>{{ $seat->seat_type }}</td>
                                <td>{{ $seat->seat_no }}</td>
                                <td>{{ $seat->seat_letter }}</td>
                                <td>{{ $seat->seat_digit }}</td>
                                <td>
                                    <form method="GET" action="{{ route('seat.detail', ['seat' => $seat]) }}">
                                        <button type="submit" class="btn-view">View</button>
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
