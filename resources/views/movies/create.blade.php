<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Movie</title>

    <!-- Font Awesome for icons (optional, if you plan to use icons) -->
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
            font-family: Arial, sans-serif;
            background-color: rgb(39, 40, 43);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        /* Container */
        .container {
            background-color: rgb(33, 34, 35);
            padding: 60px;
            border-radius: 15px;
            /* box-shadow: inset 5px 5px 15px var(--shadow-dark), inset -5px -5px 15px var(--shadow-light); */
            width: 90%;
            max-width: 600px;
            max-height: 1000px;
            color: var(--text-color);
            
        }

        h1 {
            margin-bottom: 30px;
            text-align: center;
            color: var(--text-color);
        }

        /* Success and Error Messages */
        .success-message {
            text-align: center; 
            color: var(--success-color); 
            margin-bottom: 20px;
            font-size: 18px;
        }

        .error-messages ul {
            color: var(--danger-color);
            list-style-type: none;
            padding: 0;
            margin: 0 0 15px;
        }

        .error-messages ul li {
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }

        .error-messages ul li::before {
            content: "\f071"; /* Font Awesome exclamation-circle icon */
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            margin-right: 8px;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
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
        input[type="number"],
        input[type="date"],
        input[type="file"] {
            width: 100%;
            padding: 6px 13px;
            border: none;
            border-radius: 20px;
            background-color:rgb(39, 40, 43);
            color: var(--text-color);
            box-shadow: inset 0.5px 0.5px 1.5px var(--shadow-dark), inset -0.5px -0.5px 1.5px var(--shadow-light);
            font-size: 13px;
            outline: none;
            transition: box-shadow 0.3s, background-color 0.3s;
        }

        input[type="text"]::placeholder,
        input[type="number"]::placeholder,
        input[type="file"]::placeholder {
            color: #aaa;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        input[type="file"]:focus {
            box-shadow: 0 0 10px var(--info-color);
        }

        /* Duration Inputs */
        .row {
            display: flex;
            gap: 15px;
        }

        .row input {
            flex: 1;
        }

        /* Submit Button */
        .submit-button {
            background-color: var(--accent-color);
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 6px 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            /* box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light); */
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

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .row {
                flex-direction: column;
            }
        }

        /* Optional: Add New Movie Link (if navigating from another page) */
        .add-link {
            text-align: center;
            margin-top: 20px;
        }

        .add-link a {
            display: inline-flex;
            align-items: center;
            padding: 12px 20px;
            background-color: var(--button-color);
            color: var(--text-color);
            text-decoration: none;
            border-radius: 30px;
            box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light);
            transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
            cursor: pointer;
            font-weight: bold;
        }

        .add-link a:hover {
            box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
            background-color: var(--button-hover-color);
            color: #fff;
        }

        .add-link a img {
            margin-right: 10px;
            filter: brightness(0) invert(1); /* Invert icon colors for visibility */
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create a New Movie</h1>

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
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ route('movie.store') }}" onsubmit="return convertDuration()" enctype="multipart/form-data">
            @csrf
            @method('post')    
            <div class="form-group">
                <label for="name">Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    placeholder="Enter Name" 
                    required 
                    aria-label="Movie Name"
                />
            </div>
            <div class="form-group">
                <label for="poster">Poster</label>
                <input 
                    type="file" 
                    name="poster" 
                    id="poster" 
                    accept="image/*" 
                    required 
                    aria-label="Upload Movie Poster"
                />
            </div>
            <div class="form-group">
                <label for="trailer_link">Trailer Link</label>
                <input 
                    type="text" 
                    name="trailer_link" 
                    id="trailer_link" 
                    placeholder="Enter Trailer Link" 
                    required 
                    aria-label="Trailer Link"
                />
            </div>
            <div class="form-group">
                <label>Duration</label>
                <div class="row">
                    <input 
                        type="number" 
                        id="hours" 
                        placeholder="Hours" 
                        min="0" 
                        required 
                        aria-label="Duration Hours"
                    />
                    <input 
                        type="number" 
                        id="minutes" 
                        placeholder="Minutes" 
                        min="0" 
                        max="59" 
                        required 
                        aria-label="Duration Minutes"
                    />
                </div>
                <!-- Hidden input field to store duration in minutes -->
                <input type="hidden" name="duration" id="duration" />
            </div>
            <div class="form-group">
                <label for="release_date">Release Date</label>
                <input 
                    type="date" 
                    name="release_date" 
                    id="release_date" 
                    required 
                    aria-label="Release Date"
                />
            </div>
            <div class="form-group">
                <label for="imdb_link">IMDB Link</label>
                <input 
                    type="text" 
                    name="imdb_link" 
                    id="imdb_link" 
                    placeholder="Enter IMDB Link" 
                    required 
                    aria-label="IMDB Link"
                />
            </div>
            <div class="form-group">
                <button type="submit" class="submit-button">
                    <i class="fas fa-save" style="margin-right: 8px;"></i> Save Movie
                </button>
            </div>
        </form>

        <!-- Optional: Add New Movie Link (if navigating from another page) -->
        <!-- 
        <div class="add-link">
            <a href="{{ route('movie.create') }}">
                <i class="fas fa-plus"></i> Add New Movie
            </a>
        </div>
        -->
    </div>

    <script>
        function convertDuration() {
            // Get the values of hours and minutes
            const hours = parseInt(document.getElementById('hours').value) || 0;
            const minutes = parseInt(document.getElementById('minutes').value) || 0;

            // Validate minutes
            if (minutes > 59) {
                alert("Minutes should be less than 60.");
                return false; // Prevent form submission
            }

            // Convert to total minutes
            const totalMinutes = (hours * 60) + minutes;

            // Set the total minutes in the hidden input field
            document.getElementById('duration').value = totalMinutes;

            return true; // Allow form submission
        }

        // Optional: You can add real-time validation or enhancements here
    </script>
</body>
</html>
