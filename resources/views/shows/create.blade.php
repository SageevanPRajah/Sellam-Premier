<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Show') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
                <style>
                    /* Add your CSS here */
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
                        width: 90%;
                        max-width: 800px;
                        margin: 40px auto;
                    }

                    .success-message, .error-messages {
                        text-align: center;
                        margin-bottom: 20px;
                    }

                    .success-message {
                        color: var(--success-color);
                        font-size: 18px;
                    }

                    .error-messages ul {
                        color: var(--danger-color);
                        list-style: none;
                        padding: 0;
                        margin: 0;
                    }

                    .error-messages ul li {
                        margin-bottom: 5px;
                    }

                    form {
                        display: flex;
                        flex-direction: column;
                    }

                    .form-row {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 20px;
                        margin-bottom: 20px;
                    }

                    .form-group {
                        flex: 1 1 200px;
                        margin-bottom: 20px;
                    }

                    label {
                        display: block;
                        font-weight: bold;
                        margin-bottom: 8px;
                        color: var(--text-color);
                    }

                    input[type="text"], input[type="date"], select {
                        padding: 12px 20px;
                        border: none;
                        border-radius: 20px;
                        background-color: var(--secondary-color);
                        color: var(--text-color);
                        font-size: 16px;
                        outline: none;
                        transition: box-shadow 0.3s, background-color 0.3s;
                    }

                    input[type="text"]:focus, input[type="date"]:focus, select:focus {
                        box-shadow: 0 0 10px var(--accent-color);
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
                        transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .submit-button:hover {
                        background-color: var(--button-hover-color);
                        color: #000;
                    }

                    @media (max-width: 768px) {
                        .form-row .form-group {
                            flex: 1 1 100%;
                        }
                    }
                </style>

                <h1 class="text-2xl text-center mb-4">Create a New Show</h1>

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

                <form method="post" action="{{ route('show.store') }}" onsubmit="return getMoviePoster()" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="movie_name">Movie Name</label>
                            <select name="movie_name" id="movie_name" onchange="getMoviePoster()" required>
                                <option value="">Select Movie Name</option>
                                @foreach (\App\Models\Movie::where('active', true)->get() as $movie)
                                    <option value="{{ $movie->name }}" data-poster="{{ $movie->poster }}">
                                        {{ $movie->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="movie_code">Price Type</label>
                            <select name="movie_code" id="movie_code" required>
                                <option value="">Select Price Type</option>
                                <option value="Price 1">Price 1</option>
                                <option value="Price 2">Price 2</option>
                                <option value="Price 3">Price 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" required>
                        </div>

                        <div class="form-group">
                            <label for="time">Time</label>
                            <select name="time" id="time" required>
                                @php
                                    $start = strtotime('00:00');
                                    $end = strtotime('23:59');
                                    while ($start <= $end) {
                                        $time = date('g:i A', $start);
                                        echo "<option value=\"$time\">$time</option>";
                                        $start = strtotime('+30 minutes', $start);
                                    }
                                @endphp
                            </select>
                        </div>
                    </div>

                    <input type="hidden" id="poster" name="poster" />

                    <div class="form-group">
                        <button type="submit" class="submit-button">
                            Save Show
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function getMoviePoster() {
            const selectedMovie = document.getElementById('movie_name').selectedOptions[0];
            const posterPath = selectedMovie.getAttribute('data-poster');
            document.getElementById('poster').value = posterPath;
            return true;
        }
    </script>
</x-app-layout>
