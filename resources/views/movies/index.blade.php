<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie</title>

    <!-- Font Awesome for icons -->
    <link 
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-p6qD4WmF1g4p8qPQ5cM+PEOj8EeA0bg65dwZ2rBt+9v9V/GMq3O36RlhjzQpYYzTCnzqqe/GJZy43k5BSYyxzg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />

    <style>
        body {
            margin: 0;
            padding: 0;
        }
        h1 {
            margin: 20px 0;
            text-align: center;
        }

        /* Success Message */
        .success-message {
            text-align: center; 
            color: green; 
            margin-bottom: 10px;
        }

        /* Slider Controls Container */
        .slider-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80%;
            margin: 0 auto 20px auto;
        }

        /* Slider Container */
        .slider-container {
            width: 80%;
            overflow: hidden;   /* Hides overflow for slider effect */
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        .slider-wrapper {
            display: flex;
            transition: transform 0.5s ease;
            margin: 0; 
            padding: 0;
        }
        .slider-item {
            flex: 0 0 auto;
            width: 180px;
            margin: 10px 5px; /* gap between items */
            text-align: center;
        }
        .slider-item img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .slider-item a {
            display: block;
            margin-top: 5px;
            text-decoration: none;
            color: #007BFF;
        }
        .slider-item a:hover {
            text-decoration: underline;
        }

        /* Slider Control Buttons (light gray background, black icons) */
        .slider-control-btn {
            background-color: #ccc;
            color: #000;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            line-height: 40px;
            opacity: 0.8;
            transition: opacity 0.3s;
            margin: 0 10px;
        }
        .slider-control-btn:hover {
            opacity: 1;
        }
        .slider-control-btn i {
            color: #000;
        }

        /* Add New Movie Button */
        .add-link {
            text-align: center;
            margin: 20px 0;
        }
        .add-link a {
            display: inline-block;
            padding: 8px 12px;
            background-color: rgb(178, 201, 163); 
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            margin-left: 1750px;        }
        .add-link a:hover {
            background-color: rgb(35, 86, 60);
            color: rgb(237, 240, 239);
        }
        .add-link a i {
            margin-right: 5px;
        }

        /* Table */
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 80%;
            font-size: 16px;
            text-align: center;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 15px;
        }
        th {
            background-color: rgb(120, 120, 120);
            font-weight: bold;
            text-align: center;
            color: #fff;
        }

        /* Buttons in table */
        .btn-edit {
            background-color: #007BFF;
            padding: 6px 8px;
            border: none;
            color: white;
            border-radius: 3px;
            cursor: pointer;
        }
        .btn-delete {
            background-color: #FF0000;
            padding: 6px 8px;
            border: none;
            color: white;
            border-radius: 3px;
            cursor: pointer;
        }
        .btn-view {
            background-color: #28a745;
            padding: 6px 8px;
            border: none;
            color: white;
            border-radius: 3px;
            cursor: pointer;
        }
        .btn-edit:hover,
        .btn-delete:hover,
        .btn-view:hover {
            opacity: 0.8;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 10px;
            text-align: center;
            width: 100px;
            font-weight: bold;
            color: #fff;
        }
        .status-active {
            background-color: green;
        }
        .status-inactive {
            background-color: red;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .slider-container {
                width: 100%;
            }
            .slider-item {
                width: 100px;
            }
            table {
                font-size: 12px;
            }
            .add-link {
                margin-left: 0;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <h1>Movie</h1>

    @if(session()->has('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <!-- Slider Controls Container -->
    <div class="slider-controls">
        <!-- Prev Button -->
        <button id="prev" class="slider-control-btn" aria-label="Previous">
            <!-- Custom SVG for the 'Previous' icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="18" height="18">
                <path fill="currentColor" d="M16 4l-8 8 8 8z" />
            </svg>
        </button>

        <!-- Slider Container -->
        <div class="slider-container">
            <!-- Slider Wrapper -->
            <div class="slider-wrapper">
                @foreach($movies as $movie)
                    <div class="slider-item">
                        <img src="{{ $movie->poster ? asset('storage/' . $movie->poster) : asset('images/default-poster.jpg') }}" alt="Poster">
                        <a href="{{ route('movie.detail', ['movie' => $movie]) }}">More...</a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Next Button -->
        <button id="next" class="slider-control-btn" aria-label="Next">
            <!-- Custom SVG for the 'Next' icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="18" height="18">
                <path fill="currentColor" d="M8 4l8 8-8 8z" />
            </svg>
        </button>
    </div>

    <!-- Add New Movie Button -->
    <div class="add-link">
        <a href="{{ route('movie.create') }}">
            <i class="fas fa-plus"></i> +  Add New Movie
        </a>
    </div>

    <!-- Movie Table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Poster</th>
            <th>Trailer Link</th>
            <th>Duration</th>
            <th>Release Date</th>
            <th>IMDB Link</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>View</th>
        </tr>
        @foreach($movies as $movie)
            <tr>
                <td>{{ $movie->id }}</td>
                <td>{{ $movie->name }}</td>
                <td>
                    <img 
                        src="{{ $movie->poster ? asset('storage/' . $movie->poster) : asset('images/default-poster.jpg') }}" 
                        alt="Poster" 
                        style="max-width: 100px; height: auto;" 
                    />
                </td>
                <td>
                    <a href="{{ $movie->trailer_link }}" target="_blank">Watch Trailer</a>
                </td>
                <td>{{ $movie->duration }} minutes</td>
                <td>{{ $movie->release_date }}</td>
                <td>
                    <a href="{{ $movie->imdb_link }}" target="_blank">IMDB Link</a>
                </td>
                <td>
                    @if($movie->active == 1)
                        <span class="status-badge status-active">Active</span>
                    @else
                        <span class="status-badge status-inactive">Not Active</span>
                    @endif
                </td>
                <td>
                    <form method="GET" action="{{ route('movie.edit', ['movie' => $movie]) }}">
                        <button type="submit" class="btn-edit" aria-label="Edit Movie">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </form>
                </td>
                <td>
                    <form method="POST" action="{{ route('movie.destroy', ['movie' => $movie]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" aria-label="Delete Movie">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
                <td>
                    <form method="GET" action="{{ route('movie.detail', ['movie' => $movie]) }}">
                        <button type="submit" class="btn-view" aria-label="View Movie">
                            <i class="fas fa-eye"></i> View
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <!-- Slider Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sliderWrapper = document.querySelector('.slider-wrapper');
            const sliderItems = document.querySelectorAll('.slider-item');
            const nextButton = document.getElementById('next');
            const prevButton = document.getElementById('prev');

            if (sliderItems.length === 0) return; // Prevent errors if no items

            // Fix the number of visible items to 5
            const visibleItems = 5;

            // Each slider-item has a fixed width of ~180px plus margins
            const itemStyle = window.getComputedStyle(sliderItems[0]);
            const itemWidth = sliderItems[0].offsetWidth 
                + parseInt(itemStyle.marginLeft) 
                + parseInt(itemStyle.marginRight);

            // Calculate the maximum scroll position
            const maxPosition = (sliderItems.length - visibleItems) * itemWidth;
            let currentPosition = 0;

            // If we have fewer than or exactly 5 items, hide next/prev buttons
            if (sliderItems.length <= visibleItems) {
                nextButton.disabled = true;
                prevButton.disabled = true;
            }

            function updateSlider() {
                sliderWrapper.style.transform = `translateX(-${currentPosition}px)`;
                // Enable/disable Prev button
                prevButton.disabled = (currentPosition === 0);
                // Enable/disable Next button
                nextButton.disabled = (currentPosition >= maxPosition);
            }

            nextButton.addEventListener('click', () => {
                if (currentPosition < maxPosition) {
                    currentPosition += itemWidth;
                    if (currentPosition > maxPosition) {
                        currentPosition = maxPosition;
                    }
                    updateSlider();
                }
            });

            prevButton.addEventListener('click', () => {
                if (currentPosition > 0) {
                    currentPosition -= itemWidth;
                    if (currentPosition < 0) {
                        currentPosition = 0;
                    }
                    updateSlider();
                }
            });

            // Initialize the slider position
            updateSlider();
        });
    </script>
</body>
</html>
