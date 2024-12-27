<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Show</title>

    <!-- Font Awesome for icons (if needed) -->
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
            background-color: rgb(41, 43, 44);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: rgb(40, 42, 42);
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 3px 3px 9px var(--shadow-dark), -3px -3px 9px var(--shadow-light);
            width: 100%;
            max-width: 600px; /* Set a max width for responsiveness */
            color: var(--text-color);
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
            color: var(--text-color);
        }

        .error-messages {
            color: var(--danger-color);
            list-style-type: none;
            margin-bottom: 15px;
        }

        .error-messages li {
            margin-bottom: 5px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: var(--text-color);
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        select,
        input[type="submit"] {
            width: 100%;
            padding: 10px 15px;
            border: none;
            border-radius: 20px;
            background-color: rgb(47, 48, 49);
            color: var(--text-color);
            box-shadow: inset 1px 1px 3px var(--shadow-dark), inset -1px -1px 3px var(--shadow-light);
            font-size: 16px;
            margin-bottom: 15px; /* Space between inputs */
            transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
        }

        input[type="text"]::placeholder,
        select::placeholder {
            color: #aaa;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="file"]:focus,
        select:focus {
            box-shadow: 0 0 10px var(--info-color);
            outline: none;
            background-color: var(--button-hover-color);
        }

        input[type="submit"] {
            background-color: var(--accent-color);
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            border-radius: 30px;
            box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light);
            transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
        }

        input[type="submit"]:hover {
            /* You may replace `darken()` with a slightly darker hex or use a custom color */
            background-color: #3c9c48;
            box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .current-poster {
            margin-top: 10px;
            text-align: center;
        }

        .current-poster img {
            max-width: 150px;
            border-radius: 10px;
            box-shadow: 3px 3px 10px var(--shadow-dark), -3px -3px 10px var(--shadow-light);
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Show</h1>

        <!-- Display validation errors (if any) -->
        @if($errors->any())
            <ul class="error-messages">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <!-- Form to edit an existing Show -->
        <form method="POST" action="{{ route('show.update', ['show' => $show]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Show Date -->
            <div class="form-group">
                <label for="date">Date</label>
                <input 
                    type="date" 
                    name="date" 
                    id="date" 
                    placeholder="YYYY-MM-DD" 
                    value="{{ old('date', $show->date) }}" 
                    required 
                />
            </div>

            <!-- Show Time -->
            <div class="form-group">
                <label for="time">Time</label>
                <input 
                    type="text" 
                    name="time" 
                    id="time" 
                    placeholder="e.g. 19:30" 
                    value="{{ old('time', $show->time) }}" 
                    required 
                />
            </div>

            <!-- Show Type (movie_code) -->
            <div class="form-group">
                <label for="movie_code">Show Type</label>
                <select name="movie_code" id="movie_code" required>
                    <option value="">-- Select Show Type --</option>
                    <option value="Morning Show"  {{ $show->movie_code === 'Morning Show' ? 'selected' : '' }}>Morning Show</option>
                    <option value="Matinee Show"  {{ $show->movie_code === 'Matinee Show' ? 'selected' : '' }}>Matinee Show</option>
                    <option value="Night Show"    {{ $show->movie_code === 'Night Show' ? 'selected' : '' }}>Night Show</option>
                    <option value="Midnight Show" {{ $show->movie_code === 'Midnight Show' ? 'selected' : '' }}>Midnight Show</option>
                    <option value="Special Show"  {{ $show->movie_code === 'Special Show' ? 'selected' : '' }}>Special Show</option>
                    <option value="Premiere Show" {{ $show->movie_code === 'Premiere Show' ? 'selected' : '' }}>Premiere Show</option>
                </select>
            </div>

            <!-- Movie Name -->
            <div class="form-group">
                <label for="movie_name">Movie Name</label>
                <input 
                    type="text" 
                    name="movie_name" 
                    id="movie_name" 
                    placeholder="Enter Movie Name" 
                    value="{{ old('movie_name', $show->movie_name) }}" 
                    required 
                />
            </div>

            <!-- Poster Field + Current Poster Preview -->
            <div class="form-group">
                <label for="poster">Show Poster</label>
                <input 
                    type="file" 
                    name="poster" 
                    id="poster" 
                    accept="image/*" 
                />
                @if($show->poster)
                    <div class="current-poster">
                        <p>Current Poster:</p>
                        <img 
                            src="{{ asset('storage/' . $show->poster) }}" 
                            alt="Current Show Poster" 
                        />
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <input type="submit" value="Update the Show" />
            </div>
        </form>
    </div>
</body>
</html>
