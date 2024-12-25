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
    <h1>Movie Create</h1>
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
        <div>
            <label>Name</label>
            <input type="text" name="name" placeholder="Enter Name" />
        </div>
        <div>
            <label for="poster">Poster</label>
            <input type="file" name="poster" id="poster" accept="image/*" />
        </div>
        <div>
            <label>trailer_link</label>
            <input type="text" name="trailer_link" placeholder="Enter trailer_link" />
        </div>
        {{-- <div>
            <label>duration</label>
            <input type="text" name="duration" placeholder="Enter duration" />
        </div> --}}
        <div class="form-group">
            <label>Quantity</label>
            <div class="row">
                <input type="number" id="hours" placeholder="Hours" min="0" />
                <input type="number" id="minutes" placeholder="Minutes" min="0" max="59" />
            </div>
            <!-- Hidden input field to store duration in minutes -->
            <input type="hidden" name="duration" id="duration" />
        </div>
        <div>
            <label>release_date</label>
            <input type="date" name="release_date" placeholder="Enter release_date" />
        </div>
        <div>
            <label>imdb_link</label>
            <input type="text" name="imdb_link" placeholder="Enter imdb_link" />
        </div>
        <div>
            <input type="submit" value="Save a new Movie"/>
        </div>
    </form>
    <script>
        function convertDuration() {
            // Get the values of hours and minutes
            const hours = parseInt(document.getElementById('hours').value) || 0;
            const minutes = parseInt(document.getElementById('minutes').value) || 0;

            // Convert to total minutes
            const totalMinutes = (hours * 60) + minutes;

            // Set the total minutes in the hidden input field
            document.getElementById('duration').value = totalMinutes;
        }
    </script>

</body>
</html>