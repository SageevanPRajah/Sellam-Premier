<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Movie</title>
    <style>
        /* Reset some default styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #1e1e1e;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
            width: 450px;
            max-width: 800px;
            padding: 20px;
        }

        .poster img {
            width: 400px;
            border-radius: 8px;
            margin-bottom: 20px;
            justify-self: start;
        }

        .movie-details {
            text-align: center;
        }

        .movie-details h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .movie-details .release-date {
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: #bbb;
        }

        .movie-details .links {
            margin-bottom: 20px;
        }

        .movie-details .links a {
            display: inline-block;
            margin: 0 10px;
            padding: 10px 20px;
            background-color: #e50914;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .movie-details .links a:hover {
            background-color: #f40612;
        }

        .movie-details .metadata {
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: #bbb;
        }

        .movie-details .rating {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-bottom: 20px;
        }

        .rating div {
            text-align: center;
        }

        .rating .score {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .synopsis {
            margin-bottom: 20px;
            font-size: 1rem;
            line-height: 1.5;
            text-align: left;
        }

        .photogallery {
            margin-top: 20px;
        }

        .photogallery h2 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .photogallery img {
            width: 100px;
            height: auto;
            margin-right: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="poster">
            <img src="{{ asset('storage/' . $movie->poster) }}" alt="Movie Poster">
        </div>
        <div class="movie-details">
            <h1>{{ $movie->name }} ({{ date('Y', strtotime($movie->release_date)) }})</h1>
            
            <!-- Release Date -->
            <div class="release-date">
                Release Date: {{ date('F d, Y', strtotime($movie->release_date)) }}
            </div>

           
            <div class="form-group" style="display: flex; justify-content: space-between;">
                <p id="trailer_link" style="margin: 0;">
                    <a href="{{ $movie->trailer_link }}" target="_blank">Trailer Link</a>
                </p>
                <p id="imdb_link" style="margin: 0;">
                    <a href="{{ $movie->imdb_link }}" target="_blank">IMDB Link</a>
                </p>
            </div>
           

            

            <!-- Synopsis -->
            <div class="synopsis">
                <p>{{ $movie->synopsis }}</p>
            </div>
        </div>
        
    </div>
</body>
</html>