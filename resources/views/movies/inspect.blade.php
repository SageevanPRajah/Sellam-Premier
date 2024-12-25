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
    overflow: hidden;
}
        
        .carousel {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
}

.movie-card {
    text-align: center;
    transition: transform 0.3s, opacity 0.3s;
}

.movie-card img {
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
}

.movie-card.current img {
    width: 300px;
    transform: scale(1.2);
}

.movie-card.nearby img {
    width: 200px;
    opacity: 0.8;
}

.movie-card.far img {
    width: 100px;
    opacity: 0.5;
}

.movie-card h1 {
            margin-top: 10px;
            font-size: 1.5em;
            text-transform: capitalize;
        }

    </style>
</head>
<body>
    <div class="carousel">
        @for ($i = -2; $i <= 2; $i++)
            @php
                // Circular array logic to determine the movie index
                $index = ($currentIndex + $i + count($movies)) % count($movies);
                $position = $i; // Position relative to the current movie
            @endphp
            <div class="movie-card {{ $position === 0 ? 'current' : ($position === -1 || $position === 1 ? 'nearby' : 'far') }}">
                <img src="{{ asset('storage/' . $movies[$index]->poster) }}" alt="Movie Poster">
                <h1>{{ $movies[$index]->name }}</h1>
                <div class="form-group" style="display: flex; justify-content: space-between;">
                    <p id="trailer_link" style="margin: 0;">
                        <a href="{{ $movie->trailer_link }}" target="_blank">Trailer Link</a>
                    </p>
                    <p id="imdb_link" style="margin: 0;">
                        <a href="{{ $movie->imdb_link }}" target="_blank">IMDB Link</a>
                    </p>
                </div>
            </div>
        @endfor
    </div>
    
</body>
</html>
