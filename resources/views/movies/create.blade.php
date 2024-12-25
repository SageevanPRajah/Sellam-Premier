<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Create</title>
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
            height: 100vh;          /* Full viewport height */
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px; /* Set a max width for responsiveness */
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
            color: #343a40;
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
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
            margin-bottom: 15px; /* Add space between inputs */
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        input[type="file"]:focus {
            border-color: #80bdff;
            outline: none;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        ul {
            color: #dc3545;
            list-style-type: none;
            padding: 0;
            margin: 0 0 15px;
        }

        ul li {
            margin-bottom: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .row {
            display: flex;
            gap: 10px;
        }

        .row input {
            flex: 1;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create a New Movie</h1>
        <div>
            @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
            @endif
        </div>
        <form method="post" action="{{route('movie.store')}}" onsubmit="convertDuration()" enctype="multipart/form-data">
            @csrf
            @method('post')    
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter Name" required />
            </div>
            <div class="form-group">
                <label for="poster">Poster</label>
                <input type="file" name="poster" id="poster" accept="image/*" required />
            </div>
            <div class="form-group">
                <label for="trailer_link">Trailer Link</label>
                <input type="text" name="trailer_link" id="trailer_link" placeholder="Enter Trailer Link" required />
            </div>
            <div class="form-group">
                <label>Duration</label>
                <div class="row">
                    <input type="number" id="hours" placeholder="Hours" min="0" required />
                    <input type="number" id="minutes" placeholder="Minutes" min="0" max="59" required />
                </div>
                <!-- Hidden input field to store duration in minutes -->
                <input type="hidden" name="duration" id="duration" />
            </div>
            <div class="form-group">
                <label for="release_date">Release Date</label>
                <input type="date" name="release_date" id="release_date" required />
            </div>
            <div class="form-group">
                <label for="imdb_link">IMDB Link</label>
                <input type="text" name="imdb_link" id="imdb_link" placeholder="Enter IMDB Link" required />
            </div>
            <div class="form-group">
                <input type="submit" value="Save Movie"/>
            </div>
        </form>
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
