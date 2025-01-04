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
            font-family: Arial, sans-serif;
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
            justify-content: center;
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
            transition: background-color 0.3s, color 0.3s;
            margin-left: 1450px;
        }
        .add-link a:hover {
            background-color: rgb(35, 86, 60);
            color: rgb(237, 240, 239);
        }
        .add-link a i {
            margin-right: 5px;
            
        }

        /* Search Bar with Status and Date Range Filter */
        .search-bar {
            width: 80%;
            margin: 20px auto;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px; /* Adds space between elements */
            flex-wrap: wrap; /* Allows wrapping on smaller screens */
        }
        .search-bar .filter-group {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .search-bar input,
        .search-bar select,
        .search-bar input[type="date"] {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .search-bar input:focus,
        .search-bar select:focus,
        .search-bar input[type="date"]:focus {
            outline: none;
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
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
            background-color: rgb(0, 0, 0);
            font-weight: bold;
            text-align: center;
            color: #fff;
        }

        /* Buttons in table */
        .btn-edit {
            background-color: #007BFF;
            padding: 8px 25px;
            border: none;
            color: white;
            border-radius: 7px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-delete {
            background-color: #FF0000;
            padding: 8px 15px;
            border: none;
            color: white;
            border-radius: 7px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-view {
            background-color: rgb(55, 130, 63);
            padding: 8px 25px;
            border: none;
            color: white;
            border-radius: 7px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-edit:hover,
        .btn-delete:hover,
        .btn-view:hover {
            opacity: 0.8;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 13px;
            text-align: center;
            width: 100px;
            font-weight: bold;
            color: black;
        }
        .status-active {
            background-color: rgb(172, 236, 143);
        }
        .status-inactive {
            background-color: rgb(234, 106, 15);
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; 
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.5); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 300px; /* Could be more or less, depending on screen size */
            border-radius: 15px;
            text-align: center;
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-button:hover,
        .close-button:focus {
            color: #000;
            text-decoration: none;
        }

        .modal-actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
        }

        .modal-actions button {
            width: 100px;
        }

        /* Pagination and Rows per Page */
        .pagination-container {
            width: 80%;
            margin: 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .rows-per-page {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .rows-per-page select {
            padding: 6px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .pagination {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .pagination button {
            padding: 6px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .pagination button.active {
            background-color: #007BFF;
            color: #fff;
            border-color: #007BFF;
        }
        .pagination button:hover:not(.active) {
            background-color: #f1f1f1;
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
            .search-bar {
                flex-direction: column;
                align-items: flex-start;
            }
            .search-bar .filter-group {
                width: 100%;
                justify-content: space-between;
            }
            .search-bar input,
            .search-bar select,
            .search-bar input[type="date"] {
                width: 100%;
            }
            .pagination-container {
                flex-direction: column;
                align-items: flex-start;
            }
            .rows-per-page, .pagination {
                width: 100%;
                justify-content: flex-start;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <h1>Ticket Price</h1>

    <div class="add-link">
        <a href="{{route('price.create')}}">Add New Price</a>
    </div>

    @if(session()->has('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <!-- price Table -->
    <table id="movieTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Seat Type</th>
                <th>Seat Logo</th>
                <th>Price Code</th>
                <th>Full Ticket Price</th>
                <th>Half Ticket Price</th>
                <th>Edit</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($prices as $price)
                <tr>
                    <td>{{ $price->id }}</td>
                    <td class="movie-name">{{ $price->seat_type }}</td>
                    <td>
                        <img 
                            src="{{ $price->seat_logo ? asset('storage/' . $price->seat_logo) : asset('images/default-poster.jpg') }}" 
                            alt="SeatLogo" 
                            style="max-width: 100px; height: auto;" 
                        />
                    </td>
                    <td class="movie-name">{{ $price->movie_code }}</td>
                    <td class="movie-name">{{ $price->full_price }}</td>
                    <td class="movie-name">{{ $price->half_price }}</td>
                    
    
                    <td>
                        <form method="GET" action="{{ route('price.edit', ['price' => $price]) }}">
                            <button type="submit" class="btn-edit" aria-label="Edit Movie">
                                <img src="icons/icons8-edit-50.png" alt="Edit" style="width: 14px; height: 14px; margin-right: 5px;" />
                                Edit
                            </button>
                        </form>
                    </td>
                    
                    
                </tr>
            @endforeach
        </tbody>
    </table>

    

    

</body>
</html>
