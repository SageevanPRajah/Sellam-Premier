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
        .add-link {
            margin-bottom: 20px;
            display: inline-block;
        }
        h1 {
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 80%;
            font-size: 16px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background-color: #f4f4f4;
        }
        form button, form input[type="submit"] {
            padding: 5px 10px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 3px;
            cursor: pointer;
        }

        form input[type="submit"] {
            background-color: #FF5733;
        }

        form button:hover, form input[type="submit"]:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <h1>Movie</h1>
    <div>
        @if(session()->has('success'))
            <div>
                {{session('success')}}
            </div>
        @endif
    </div>
    <div>
        <div class="add-link">
            <a href="{{route('movie.create')}}">Add New Movie</a>
        </div>
        <table border="1">
            <tr>
               <th>ID</th> 
               <th>Name</th> 
               <th>trailer_link</th> 
               <th>duration</th> 
               <th>release_date</th> 
               <th>imdb_link</th> 
               <th>active</th> 
               <th>Edit</th>
               <th>Delete</th>
               <th>View</th>
            </tr>
            @foreach($movies as $movie)
                <tr>
                    <td>{{$movie->id}}</td> 
                    <td>{{$movie->name}}</td>
                    <td>{{$movie->trailer_link}}</td>
                    <td>{{$movie->duration}}</td>
                    <td>{{$movie->release_date}}</td>
                    <td>{{$movie->imdb_link}}</td>
                    <td>{{$movie->active}}</td>
                    <td>
                        <form method="GET" action="{{ route('movie.edit', ['movie' => $movie]) }}">
                            <button type="submit">Edit</button>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="{{route('movie.destroy', ['movie' => $movie])}}">
                            @csrf
                            @method('delete')
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                    <td>
                        <form method="GET" action="{{ route('movie.detail', ['movie' => $movie]) }}">
                            <button type="submit">View</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>