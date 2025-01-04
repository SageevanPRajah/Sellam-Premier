<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Show</title>

    <!-- Font Awesome for icons -->
    <link 
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-p6qD4WmF1g4p8qPQ5cM+PEOj8EeA0bg65dwZ2rBt+9v9V/GMq3O36RlhjzQpYYzTCnzqqe/GJZy43k5BSYyxzg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />

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

        body {
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
            /* font-family: Arial, sans-serif; */
        }

        h1 {
            margin: 20px 0;
            text-align: center;
            color: var(--text-color);
        }

        /* Container */
        .container {
            background-color: var(--primary-color);
            padding: 30px;
            border-radius: 15px;
            box-shadow: inset 5px 5px 15px var(--shadow-dark), inset -5px -5px 15px var(--shadow-light);
            width: 90%;
            max-width: 800px; /* Increased max-width to accommodate more fields in a row */
            margin: 40px auto;
        }

        /* Success and Error Messages */
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
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .error-messages ul li {
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-messages ul li i {
            margin-right: 8px;
        }

        /* Form Styles */
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

        .form-row .form-group {
            flex: 1 1 200px; /* Allows each field to grow and shrink, with a minimum width of 200px */
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: var(--text-color);
        }

        input[type="text"],
        input[type="date"],
        select {
            /* width: 100%; */
            padding: 12px 20px;
            border: none;
            border-radius: 20px;
            background-color: var(--secondary-color);
            color: var(--text-color);
            box-shadow: inset 5px 5px 15px var(--shadow-dark), inset -5px -5px 15px var(--shadow-light);
            font-size: 16px;
            outline: none;
            transition: box-shadow 0.3s, background-color 0.3s;
        }

        input[type="text"]::placeholder,
        select::placeholder {
            color: #aaa;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        select:focus {
            box-shadow: 0 0 10px var(--accent-color);
        }

        /* Submit Button */
        .submit-button {
            background-color: var(--accent-color);
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light);
            transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .submit-button:hover {
            background-color: var(--button-hover-color);
            box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
            color: #000;
        }

        .submit-button i {
            margin-right: 8px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-row .form-group {
                flex: 1 1 100%; /* Stack fields vertically on smaller screens */
            }
        }

        @media (max-width: 576px) {
            .container {
                padding: 20px;
            }

            .submit-button {
                padding: 10px 16px;
                font-size: 14px;
            }

            .submit-button i {
                margin-right: 6px;
            }
        }

        /* Additional Styles */
        .hidden-input {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Create a New Show</h1>
    <div class="container">
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
                        <li><i class="fa fa-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Show Create Form -->
        <form method="post" action="{{ route('show.store') }}" onsubmit="return convertDuration()" enctype="multipart/form-data">
            @csrf
            @method('post')    
            
            <div class="form-row">
                <div class="form-group">
                    <label for="movie_name">Movie Name</label>
                    <select 
                        name="movie_name" 
                        id="movie_name" 
                        onchange="getMoviePoster()" 
                        required 
                        aria-label="Movie Name"
                    >
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
                    <select 
                        name="movie_code" 
                        id="movie_code" 
                        required 
                        aria-label="Movie Code"
                    >
                        <option value="">Select Price Type</option>
                        <option value="Price 1">Price 1</option>
                        <option value="Price 2">Price 2</option>
                        <option value="Price 3">Price 3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date">Date</label>
                    <input 
                        type="date" 
                        name="date" 
                        id="date" 
                        placeholder="Enter date" 
                        required 
                        aria-label="Show Date"
                    />
                </div>

                <div class="form-group">
                    <label for="time">Time</label>
                    <select 
                        name="time" 
                        id="time" 
                        required 
                        aria-label="Show Time"
                    >
                        @php
                            $start = strtotime('00:00'); // Start time (12:00 AM)
                            $end = strtotime('23:59'); // End time (11:59 PM)

                            while ($start <= $end) {
                                $time = date('g:i A', $start); // Format time as "6:00 AM"
                                echo "<option value=\"$time\">$time</option>";
                                $start = strtotime('+30 minutes', $start); // Increment by 30 minutes
                            }
                        @endphp
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="poster">Movie Poster</label>
                <!-- You can display the poster if needed -->
                <img id="poster_display" src="" alt="Poster" style="max-width: 100%; height: auto; margin-bottom: 20px;" />
            </div>

            <input type="hidden" id="poster" name="poster" />

            <div class="form-group">
                <button type="submit" class="submit-button">
                    <i class="fa fa-save"></i> Save Show
                </button>
            </div>
        </form>
    </div>

    <script>
        function getMoviePoster() {
    const selectedMovie = document.getElementById('movie_name').selectedOptions[0];
    const posterPath = selectedMovie.getAttribute('data-poster');
    console.log(posterPath); // Debugging line
    document.getElementById('poster').value = posterPath;
}

        
    </script>
</body>
</html>
