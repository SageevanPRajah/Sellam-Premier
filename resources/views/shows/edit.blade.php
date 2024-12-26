<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Show</title>

    <!-- (Optional) Font Awesome -->
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
            font-family: Arial, sans-serif;
        }

        h1 {
            margin: 20px 0;
            text-align: center;
            color: var(--text-color);
        }

        /* Container */
        .container {
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Success and Error Messages */
        .message {
            text-align: center; 
            margin-bottom: 20px;
            font-size: 18px;
            padding: 10px;
            border-radius: 5px;
        }

        .success-message {
            background-color: var(--success-color);
            color: #ffffff;
        }

        .error-message {
            background-color: var(--danger-color);
            color: #ffffff;
        }

        /* Form Styles */
        form {
            background-color: var(--primary-color);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: var(--text-color);
        }

        /* Example for advanced "drag-and-drop" or styled select:
           We'll just do a basic select below. You can replace it with
           a chosen.js or select2 or any library as needed. */

        select,
        input[type="date"],
        input[type="time"] {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            background-color: var(--secondary-color);
            color: var(--text-color);
            box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
            transition: border-color 0.3s;
            appearance: none;
        }

        select:focus,
        input[type="date"]:focus,
        input[type="time"]:focus {
            border-color: var(--accent-color);
            outline: none;
        }

        /* Button Styles */
        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .action-button {
            padding: 10px 20px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light);
            transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
            font-weight: bold;
        }

        .btn-submit {
            background-color: var(--accent-color);
        }

        .btn-cancel {
            background-color: var(--button-color);
        }

        .action-button:hover {
            box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
            background-color: var(--button-hover-color);
            color: #000;
        }

        /* Icon styles (if needed) */
        .action-button img {
            margin-right: 5px;
            filter: brightness(0) invert(1);
            width: 16px;
            height: 16px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            .action-button {
                padding: 8px 16px;
                font-size: 14px;
            }

            .action-button img {
                width: 14px;
                height: 14px;
            }
        }
    </style>
</head>
<body>
    <h1>Edit Show</h1>
    <div class="container">
        <!-- Success Message -->
        @if(session()->has('success'))
            <div class="message success-message">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <div class="message error-message">
                <ul style="list-style: none; padding: 0; margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit Show Form -->
        <form method="POST" action="{{ route('show.update', ['show' => $show->id]) }}">
            @csrf
            @method('PUT')

            <!-- 1) Movie Name -->
            <div class="form-group">
                <label for="movie_name">Movie Name</label>
                {{-- 
                    Example: If you have a list of movies from DB, 
                    you might do something like:
                        <select id="movie_name" name="movie_name">
                            <option value="">Select a Movie</option>
                            @foreach ($movies as $movie)
                                <option value="{{ $movie->name }}"
                                  {{ old('movie_name', $show->movie_name) == $movie->name ? 'selected' : '' }}>
                                    {{ $movie->name }}
                                </option>
                            @endforeach
                        </select>
                --}}
                <select id="movie_name" name="movie_name" required>
                    <option value="">-- Select Movie Name --</option>
                    <option value="Movie 1" {{ old('movie_name', $show->movie_name) == 'Movie 1' ? 'selected' : '' }}>Movie 1</option>
                    <option value="Movie 2" {{ old('movie_name', $show->movie_name) == 'Movie 2' ? 'selected' : '' }}>Movie 2</option>
                    <option value="Movie 3" {{ old('movie_name', $show->movie_name) == 'Movie 3' ? 'selected' : '' }}>Movie 3</option>
                    <!-- Add more as needed -->
                </select>
            </div>

            <!-- 2) Movie Code -->
            <div class="form-group">
                <label for="movie_code">Movie Code</label>
                {{-- 
                    Same logic as movie_name: this could be a dynamic dropdown
                    if you store codes in the DB. For now, we hardcode options.
                --}}
                <select id="movie_code" name="movie_code" required>
                    <option value="">-- Select Movie Code --</option>
                    <option value="CODE-101" {{ old('movie_code', $show->movie_code) == 'CODE-101' ? 'selected' : '' }}>CODE-101</option>
                    <option value="CODE-202" {{ old('movie_code', $show->movie_code) == 'CODE-202' ? 'selected' : '' }}>CODE-202</option>
                    <option value="CODE-303" {{ old('movie_code', $show->movie_code) == 'CODE-303' ? 'selected' : '' }}>CODE-303</option>
                    <!-- Add more as needed -->
                </select>
            </div>

            <!-- 3) Date -->
            <div class="form-group">
                <label for="date">Date</label>
                <input
                    type="date"
                    id="date"
                    name="date"
                    value="{{ old('date', \Carbon\Carbon::parse($show->date)->format('Y-m-d')) }}"
                    required
                >
            </div>

            <!-- 4) Time -->
            <div class="form-group">
                <label for="time">Time</label>
                <input
                    type="time"
                    id="time"
                    name="time"
                    value="{{ old('time', \Carbon\Carbon::parse($show->time)->format('H:i')) }}"
                    required
                >
            </div>

            <!-- Button Group -->
            <div class="button-group">
                <!-- Cancel button goes back to the show index page -->
                <a
                    href="{{ route('show.index') }}"
                    class="action-button btn-cancel"
                    aria-label="Cancel"
                >
                    Cancel
                </a>

                <!-- Submit button updates the show -->
                <button
                    type="submit"
                    class="action-button btn-submit"
                    aria-label="Update Show"
                >
                    Update
                </button>
            </div>
        </form>
    </div>

    <!-- 
        Optional: If you truly want a "drag and drop" approach for selecting 
        or reordering items, you'd integrate a JS library here (e.g., SortableJS).
        For a typical "dropdown" selection, the code above will suffice.
    -->
</body>
</html>
