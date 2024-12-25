<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie</title>
    <style>
        /* Reset some default styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center;    /* Center vertically */
            min-height: 100vh;      /* Full viewport height */
        }

        .container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px; /* Set a max width for responsiveness */
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
            color: #343a40;
        }

        .error-messages {
            color: #dc3545;
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
            color: #495057;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="file"],
        select,
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
            margin-bottom: 15px; /* Space between inputs */
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        input[type="file"]:focus,
        select:focus {
            border-color: #80bdff;
            outline: none;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
        }

        input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .current-poster {
            margin-top: 10px;
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
            background-color: #ccc;
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
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #28a745;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #28a745;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
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
        <h1>Edit Movie</h1>
        <div>
            @if($errors->any())
                <ul class="error-messages">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <form method="post" action="{{ route('movie.update', ['movie' => $movie]) }}" enctype="multipart/form-data">
            @csrf
            @method('put')    
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter New Name" value="{{ $movie->name }}" required />
            </div>
            <div class="form-group">
                <label for="poster">Poster</label>
                <input type="file" name="poster" id="poster" accept="image/*" />
                <div class="current-poster">
                    <p>Current Poster:</p>
                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="Poster" style="max-width: 100px; border-radius: 4px;" />
                </div>
            </div>
            <div class="form-group">
                <label for="trailer_link">Trailer Link</label>
                <input type="text" name="trailer_link" id="trailer_link" placeholder="Enter New Trailer Link" value="{{ $movie->trailer_link }}" required />
            </div>
            <div class="form-group">
                <label for="duration">Duration (in minutes)</label>
                <input type="text" name="duration" id="duration" placeholder="Enter New Duration" value="{{ $movie->duration }}" required />
            </div>
            <div class="form-group">
                <label for="release_date">Release Date</label>
                <input type="date" name="release_date" id="release_date" placeholder="Enter New Release Date" value="{{ $movie->release_date }}" required />
            </div>
            <div class="form-group">
                <label for="imdb_link">IMDB Link</label>
                <input type="text" name="imdb_link" id="imdb_link" placeholder="Enter New IMDB Link" value="{{ $movie->imdb_link }}" required />
            </div>
            <div class="form-group">
                <label for="active">Active</label>
                <label class="toggle-switch">
                    <input type="checkbox" name="active" id="active" value="1" {{ $movie->active ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>
            <div class="form-group">
                <input type="submit" value="Update the Movie"/>
            </div>
        </form>
    </div>
</body>
</html>
