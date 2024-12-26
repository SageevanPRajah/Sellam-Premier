<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #495057;
        }

        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="text"]:focus {
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
            margin-top: 10px;
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
    </style>
</head>
<body>
    <h1>Show Create</h1>
    <div>
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
    </div>
    <form method="post" action="{{route('show.store')}}">
    @csrf
    @method('post')    
        <div>
            <label>date</label>
            <input type="date" name="date" placeholder="Enter date" />
        </div>
        <div>
            <label>Time</label>
            <select name="time">
                <?php
                $start = strtotime('00:00'); // Start time (12:00 AM)
                $end = strtotime('23:59'); // End time (11:59 PM)
        
                while ($start <= $end) {
                    $time = date('g:i A', $start); // Format time as "6:00 AM"
                    echo "<option value=\"$time\">$time</option>";
                    $start = strtotime('+30 minutes', $start); // Increment by 30 minutes
                }
                ?>
            </select>
        </div>
        <div>
            <label for="movie_code">Movie Code</label>
            <select name="movie_code" id="movie_code">
                <option value="Morning Show">Morning Show</option>
                <option value="Matinee Show">Matinee Show</option>
                <option value="Night Show">Night Show</option>
                <option value="Midnight Show">Midnight Show</option>
                <option value="Special Show">Special Show</option>
                <option value="Premiere Show">Premiere Show</option>
            </select>
        </div>
        <div>
            <label for="movie_name">Movie Name</label>
            <select name="movie_name" id="movie_name" onchange="getMoviePoster()">
                @foreach (\App\Models\Movie::where('active', true)->get() as $movie)
                    <option value="{{ $movie->name }}" data-poster="{{ $movie->poster }}">{{ $movie->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Hidden input to store movie poster path -->
        <div>
            <input type="hidden" id="poster" name="poster" />
        </div>
        
        
        <div>
            <input type="submit" value="Save a new Show"/>
        </div>
    </form>

    <script>
        function getMoviePoster() {
    const selectedMovie = document.getElementById('movie_name').selectedOptions[0];
    const posterPath = selectedMovie.getAttribute('data-poster');
    console.log(posterPath); // Debugging line
    document.getElementById('poster').value = posterPath;
}
    </script>

</body>
</html>