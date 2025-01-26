<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Movie') }}
        </h2>
    </x-slot>

    {{-- <div class="py-6"> --}}
        <h1>Movie</h1>

    @if(session()->has('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif


<!-- Error Messages -->
@if($errors->any())
    <div class="error-messages">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

    <!-- Slider Controls Container -->
    <div class="slider-controls">
        <!-- Prev Button -->
        <button id="prev" class="slider-control-btn" aria-label="Previous">
            <!-- Custom SVG for the 'Previous' icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="18" height="18" fill="currentColor">
                <path d="M16 4l-8 8 8 8z" />
            </svg>
        </button>

        <!-- Slider Container -->
        <div class="slider-container">
            <!-- Slider Wrapper -->
            <div class="slider-wrapper">
                @foreach($movies as $movie)
                    <div class="slider-item">
                        <img src="{{ $movie->poster ? asset('storage/' . $movie->poster) : asset('images/default-poster.jpg') }}" alt="Poster">
                        <a href="{{ route('movie.inspect', ['movie' => $movie]) }}">More...</a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Next Button -->
        <button id="next" class="slider-control-btn" aria-label="Next">
            <!-- Custom SVG for the 'Next' icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="18" height="18" fill="currentColor">
                <path d="M8 4l8 8-8 8z" />
            </svg>
        </button>
    </div>

    <!-- Add New Movie Button -->
    <div class="add-link">
        <a href="{{ route('movie.create') }}">
            <img src="icons/icons8-add-24.png" alt="Add" style="width: 19px; height: 19px; margin-bottom: -3px;" /> Add New Movie
        </a>
    </div>

    <!-- Search Bar with Status and Date Range Filter -->
    <div class="search-bar">
        <!-- Search by Name -->
        <div class="filter-group">
            <input type="text" id="searchInput" placeholder="Search by name..." aria-label="Search Movies by Name">
        </div>
        <!-- Status Filter -->
        <div class="filter-group">
            <select id="statusFilter" aria-label="Filter Movies by Status">
                <option value="all">All Statuses</option>
                <option value="active">Active</option>
                <option value="inactive">Not Active</option>
            </select>
        </div>
        <!-- Date Range Filter -->
        <div class="filter-group">
            <label for="startDate">From:</label>
            <input type="date" id="startDate" aria-label="Filter Movies From Date">
            <label for="endDate">To:</label>
            <input type="date" id="endDate" aria-label="Filter Movies To Date">
        </div>
    </div>

    <!-- Movie Table -->
    <table id="movieTable">
        <thead>
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
        </thead>
        <tbody>
            @foreach($movies as $movie)
                <tr data-status="{{ $movie->active ? 'active' : 'inactive' }}">
                    <td>{{ $movie->id }}</td>
                    <td class="movie-name">{{ $movie->name }}</td>
                    <td>
                        <img 
                            src="{{ $movie->poster ? asset('storage/' . $movie->poster) : asset('images/default-poster.jpg') }}" 
                            alt="Poster" 
                            style="max-width: 100px; height: auto; border-radius: 10px;" 
                        />
                    </td>
                    <td>
                        <a href="{{ $movie->trailer_link }}" target="_blank">Watch Trailer</a>
                    </td>
                    <td>{{ $movie->duration }} minutes</td>
                    <td>{{ \Carbon\Carbon::parse($movie->release_date)->format('F d, Y') }}</td>
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
                            <button type="submit" class="action-button btn-edit" aria-label="Edit Movie">
                                <img src="icons/icons8-edit-50.png" alt="Edit" style="width: 14px; height: 14px; margin-right: 5px;" />
                                Edit
                            </button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('movie.destroy', ['movie' => $movie]) }}" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="action-button btn-delete delete-button" aria-label="Delete Movie">
                                <img src="icons/icons8-delete-24.png" alt="Delete" style="width: 17px; height: 17px; margin-right: 5px;" /> Delete
                            </button>
                        </form>
                    </td>
                    <td>
                        <form method="GET" action="{{ route('movie.detail', ['movie' => $movie]) }}">
                            <button type="submit" class="action-button btn-view" aria-label="View Movie">
                                <img src="icons/icons8-eye-32.png" alt="View" style="width: 17px; height: 17px; margin-right: 5px;" /> View
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination and Rows per Page -->
    <div class="pagination-container">
        <!-- Rows Per Page -->
        <div class="rows-per-page">
            <label for="rowsPerPage">Rows per page:</label>
            <select id="rowsPerPage" aria-label="Select number of rows per page">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="15">15</option>
            </select>
        </div>
        <!-- Pagination Controls -->
        <div class="pagination" id="pagination">
            <!-- Pagination buttons will be dynamically generated -->
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close-button" aria-label="Close Modal">&times;</span>
            <p>Are you sure you want to delete this movie?</p>
            <div><img src="icons/icons8-delete (1).gif" alt="Delete" style="width: 25px; height: 25px; margin-right: 5px;" /></div>
            <div class="modal-actions">
                <button id="confirmDelete" class="btn-delete">Confirm</button>
                <button id="cancelDelete" class="btn-view">Cancel</button>
            </div>
        </div>
    </div>

        
    </div>


    <!-- Style for this script -->
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
            background-color:rgb(40, 43, 46);
            color: var(--text-color);
            font-size:12px;
        }

        h1 {
            margin: 20px 0;
            text-align: center;
            color: var(--text-color);
        }

        /* Success Message */
        .success-message {
            text-align: center; 
            color: var(--success-color); 
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
            width: 100%;
            overflow: hidden;   /* Hides overflow for slider effect */
            border: 1px solid var(--border-color);
            border-radius: 15px;
            background-color: var(--primary-color);
            box-shadow: inset 5px 5px 15px var(--shadow-dark), inset -5px -5px 15px var(--shadow-light);
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
            flex: 1 1 auto;
            width: 180px;
            margin: 10px 5px; /* gap between items */
            text-align: center;
            background-color: var(--primary-color);
            border-radius: 15px;
            box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light);
            padding: 10px;
            height: 220px;
        }

        .slider-item img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            border-radius: 10px;
        }

        .slider-item a {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #2196F3;
            font-weight: bold;
        }

        .slider-item a:hover {
            text-decoration: underline;
        }

        /* Slider Control Buttons (Neumorphic Gray and Black) */
        .slider-control-btn {
            background-color: var(--button-color);
            border-radius: 50%;
            /* box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light); */
            color: var(--text-color);
            border: none;
            width: 50px;
            height: 50px;
            cursor: pointer;
            font-size: 16px;
            transition: box-shadow 0.3s, background-color 0.3s;
            margin: 0 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slider-control-btn:hover {
            box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
        }

        .slider-control-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Add New Movie Button (Neumorphic Gray and Black) */
        .add-link {
            text-align: center;
            margin: 20px 0;
        }

        .add-link a {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            background-color: var(--primary-color);
            color: var(--text-color);
            text-decoration: none;
            border-radius: 30px;
            /* box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light); */
            transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
            cursor: pointer;
            font-weight: bold;
            margin-left:57%;
        }

        .add-link a:hover {
            /* box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light); */
            background-color: #333;
            color: #fff;
        }

        .add-link a img {
            margin-right: 10px;
            filter: brightness(0) invert(1); /* Invert icon colors for visibility */
        }

        /* Search Bar with Status and Date Range Filter */
        .search-bar {
            width: 80%;
            margin: 20px auto;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 15px; /* Adds space between elements */
            flex-wrap: wrap; /* Allows wrapping on smaller screens */
        }

        .search-bar .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-bar input,
        .search-bar select,
        .search-bar input[type="date"] {
            padding: 8px 12px;
            border: none;
            border-radius: 20px;
            background-color: rgb(53, 53, 53); 
            color: var(--text-color);
            /* box-shadow: inset 5px 5px 15px var(--shadow-dark), inset -5px -5px 15px var(--shadow-light); */
            font-size: 14px;
            outline: none;
            transition: box-shadow 0.3s;
        }

        .search-bar input::placeholder {
            color: #aaa;
        }

        a:-webkit-any-link {
            color: gray;
        }

        .search-bar input:focus,
        .search-bar select:focus,
        .search-bar input[type="date"]:focus {
            box-shadow: 0 0 10px #2196F3;
        }

        .search-bar select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23e0e0e0' d='M6 8.4L2.4 4.8l1.2-1.2L6 6l2.4-2.4 1.2 1.2z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
            cursor: pointer;
            padding-right: 30px;
        }

        /* Table */
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 80%;
            font-size: 16px;
            text-align: center;
            background-color:rgb(41, 43, 44);
            box-shadow: 0 0 10px var(--shadow-dark);
            border-radius: 15px;
            overflow: hidden;
        }

        th, td {
            padding: 10px;
            color: var(--text-color);
        }

        th {
            background-color: rgb(35, 36, 36);
            font-weight: bold;
            text-align: center;
            color: #ffffff;
        }

        /* Status Badge */
        .status-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color:rgb(37, 39, 39);
            padding: 5px 10px;
            border-radius: 20px;
            text-align: center;
            color: #ffffff;
            position: relative;
        }

        .status-badge::before {
            content: '';
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .status-active::before {
            background-color:rgb(6, 248, 14);
        }

        .status-inactive::before {
            background-color:rgb(255, 0, 0);
        }

        /* Buttons in table (Neumorphic Gray and Black) */
        .action-button {
            width: 100px;
            /* height: 40px; */
            padding: 7px 0;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light);
            transition: box-shadow 0.3s, background-color 0.3s;
            color: #ffffff;
            margin: 0 auto; /* Center the button within the cell */
        }

        .btn-edit {
            background-color:rgb(81, 88, 94); /* Gray */
        }

        .btn-delete {
            background-color: #343a40; /* Dark Gray */
        }

        .btn-view {
            background-color: #495057; /* Medium Gray */
        }

        .btn-edit:hover,
        .btn-delete:hover,
        .btn-view:hover {
            /* box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light); */
            color: black;
            
        }

        .btn-edit:hover img,
        .btn-delete:hover img,
        .btn-view:hover img {
        filter: brightness(0) invert(0); /* Remove inversion to make the image black */
        }
        /* .btn-edit img, .btn-delete img, .btn-view img:hover {
        color: black;
        } */

        .btn-edit img,
        .btn-delete img,
        .btn-view img {
            margin-right: 5px;
            filter: brightness(0) invert(1); /* Invert icon colors for visibility */
        }

        /* Modal Styles (Neumorphic Gray and Black) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; 
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.7); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto; /* 10% from top and centered */
            padding: 20px;
            border: none;
            width: 300px; /* Could be more or less, depending on screen size */
            border-radius: 20px;
            /* box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light); */
            text-align: center;
            color: rgb(41, 43, 44);
        }

        .close-button {
            color: #ffffff;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-button:hover,
        .close-button:focus {
            color: #FF5555;
            text-decoration: none;
        }

        .modal-actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
        }

        .modal-actions button {
            width: 100px;
            padding: 10px 0;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 14px;
            color: #ffffff;
            /* box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light); */
            transition: box-shadow 0.3s, background-color 0.3s;
        }

        #confirmDelete {
            background-color: #FF5555; /* Danger */
        }

        #cancelDelete {
            background-color: #6c757d; /* Gray */
        }

        #confirmDelete:hover,
        #cancelDelete:hover {
            /* box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light); */
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
            padding: 8px 12px;
            border: none;
            border-radius: 20px;
            background-color: var(--secondary-color);
            color: var(--text-color);
            box-shadow: inset 5px 5px 15px var(--shadow-dark), inset -5px -5px 15px var(--shadow-light);
            font-size: 16px;
            outline: none;
            transition: box-shadow 0.3s;
        }

        .rows-per-page select:focus {
            box-shadow: 0 0 10px #2196F3;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pagination button {
            padding: 8px 12px;
            border: none;
            border-radius: 20px;
            background-color: var(--secondary-color);
            color: var(--text-color);
            /* box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light); */
            cursor: pointer;
            transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
        }

        .pagination button.active {
            background-color: #2196F3;
            color: #ffffff;
            box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
        }

        .pagination button:hover:not(.active) {
            box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
            background-color: #555555;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .slider-container {
                width: 100%;
            }
            .slider-item {
                width: 120px;
            }
            table {
                font-size: 14px;
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

    <!-- Slider and Search Functionality Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Slider Functionality
            const sliderWrapper = document.querySelector('.slider-wrapper');
            const sliderItems = document.querySelectorAll('.slider-item');
            const nextButton = document.getElementById('next');
            const prevButton = document.getElementById('prev');

            if (sliderItems.length === 0) return; // Prevent errors if no items

            // Define the number of visible items
            const visibleItems = 5;

            // Calculate the width of each slider item including margins
            const itemStyle = window.getComputedStyle(sliderItems[0]);
            const itemWidth = sliderItems[0].offsetWidth 
                + parseInt(itemStyle.marginLeft) 
                + parseInt(itemStyle.marginRight);

            // Calculate the maximum scroll position
            const maxPosition = (sliderItems.length - visibleItems) * itemWidth;
            let currentPosition = 0;

            // Hide next/prev buttons if not needed
            if (sliderItems.length <= visibleItems) {
                nextButton.disabled = true;
                prevButton.disabled = true;
                nextButton.style.display = 'none';
                prevButton.style.display = 'none';
            }

            function updateSlider() {
                sliderWrapper.style.transform = translateX(-${currentPosition}px);
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

            // Search and Status and Date Range Filter Functionality
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');
            const table = document.getElementById('movieTable');
            const tbody = table.getElementsByTagName('tbody')[0];
            const rows = Array.from(tbody.getElementsByTagName('tr'));

            // Pagination Elements
            const rowsPerPageSelect = document.getElementById('rowsPerPage');
            const paginationContainer = document.getElementById('pagination');

            let currentPage = 1;
            let rowsPerPage = parseInt(rowsPerPageSelect.value);

            // Function to filter movies based on search, status, and date range
            function filterMovies() {
                const searchTerm = searchInput.value.trim().toLowerCase();
                const selectedStatus = statusFilter.value;
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;

                // Filter rows based on criteria
                const filteredRows = rows.filter(row => {
                    const nameCell = row.querySelector('.movie-name');
                    const releaseDateCell = row.cells[5]; // 6th column: Release Date

                    const nameText = nameCell.textContent.trim().toLowerCase();

                    // Retrieve status from data attribute
                    const status = row.getAttribute('data-status');

                    // Retrieve and parse release date
                    const releaseDateText = releaseDateCell.textContent.trim();
                    const releaseDate = new Date(releaseDateText);

                    // Check search term
                    const matchesSearch = nameText.includes(searchTerm);

                    // Check status
                    let matchesStatus = false;
                    if (selectedStatus === 'all') {
                        matchesStatus = true;
                    } else if (selectedStatus === 'active' && status === 'active') {
                        matchesStatus = true;
                    } else if (selectedStatus === 'inactive' && status === 'inactive') {
                        matchesStatus = true;
                    }

                    // Check date range
                    let matchesDate = true;
                    if (startDate) {
                        const start = new Date(startDate);
                        if (releaseDate < start) {
                            matchesDate = false;
                        }
                    }
                    if (endDate) {
                        const end = new Date(endDate);
                        if (releaseDate > end) {
                            matchesDate = false;
                        }
                    }

                    return matchesSearch && matchesStatus && matchesDate;
                });

                return filteredRows;
            }

            // Function to paginate rows
            function paginateRows(filteredRows) {
                // Calculate total pages
                const totalPages = Math.ceil(filteredRows.length / rowsPerPage) || 1;

                // Adjust currentPage if out of bounds
                if (currentPage > totalPages) {
                    currentPage = totalPages;
                }
                if (currentPage < 1) {
                    currentPage = 1;
                }

                // Determine start and end indices
                const startIndex = (currentPage - 1) * rowsPerPage;
                const endIndex = startIndex + rowsPerPage;

                // Hide all rows
                rows.forEach(row => {
                    row.style.display = 'none';
                });

                // Show filtered and paginated rows
                filteredRows.slice(startIndex, endIndex).forEach(row => {
                    row.style.display = '';
                });

                // Update pagination controls
                updatePaginationControls(totalPages);
            }

            // Function to update pagination controls
            function updatePaginationControls(totalPages) {
                // Clear existing pagination buttons
                paginationContainer.innerHTML = '';

                if (totalPages <= 1) return; // No need for pagination

                // Previous Button
                const prevBtn = document.createElement('button');
                prevBtn.textContent = 'Prev';
                prevBtn.disabled = currentPage === 1;
                prevBtn.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        applyFiltersAndPagination();
                    }
                });
                paginationContainer.appendChild(prevBtn);

                // Page Number Buttons (show up to 5 pages for simplicity)
                let startPage = Math.max(1, currentPage - 2);
                let endPage = Math.min(totalPages, currentPage + 2);

                if (currentPage <= 3) {
                    endPage = Math.min(5, totalPages);
                }
                if (currentPage >= totalPages - 2) {
                    startPage = Math.max(1, totalPages - 4);
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.textContent = i;
                    if (i === currentPage) {
                        pageBtn.classList.add('active');
                    }
                    pageBtn.addEventListener('click', () => {
                        currentPage = i;
                        applyFiltersAndPagination();
                    });
                    paginationContainer.appendChild(pageBtn);
                }

                // Next Button
                const nextBtn = document.createElement('button');
                nextBtn.textContent = 'Next';
                nextBtn.disabled = currentPage === totalPages;
                nextBtn.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        applyFiltersAndPagination();
                    }
                });
                paginationContainer.appendChild(nextBtn);
            }

            // Function to apply filters and pagination
            function applyFiltersAndPagination() {
                const filteredRows = filterMovies();
                paginateRows(filteredRows);
            }

            // Event listeners for filters
            searchInput.addEventListener('input', () => {
                currentPage = 1;
                applyFiltersAndPagination();
            });
            statusFilter.addEventListener('change', () => {
                currentPage = 1;
                applyFiltersAndPagination();
            });
            startDateInput.addEventListener('change', () => {
                currentPage = 1;
                applyFiltersAndPagination();
            });
            endDateInput.addEventListener('change', () => {
                currentPage = 1;
                applyFiltersAndPagination();
            });

            // Event listener for rows per page
            rowsPerPageSelect.addEventListener('change', () => {
                rowsPerPage = parseInt(rowsPerPageSelect.value);
                currentPage = 1;
                applyFiltersAndPagination();
            });

            // Initial load
            applyFiltersAndPagination();

            // Modal Elements
            const deleteModal = document.getElementById('deleteModal');
            const closeButton = document.querySelector('.close-button');
            const cancelDeleteButton = document.getElementById('cancelDelete');
            const confirmDeleteButton = document.getElementById('confirmDelete');

            let formToSubmit = null; // To keep track of which form to submit

            // Function to open the modal
            function openModal(form) {
                deleteModal.style.display = 'block';
                formToSubmit = form;
            }

            // Function to close the modal
            function closeModal() {
                deleteModal.style.display = 'none';
                formToSubmit = null;
                confirmDeleteButton.disabled = false; // Re-enable the button if it was disabled
            }

            // Event listener for delete buttons
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    const form = e.target.closest('form');
                    openModal(form);
                });
            });

            // Event listener for confirm delete
            confirmDeleteButton.addEventListener('click', () => {
                if (formToSubmit) {
                    // Optionally disable the confirm button to prevent multiple clicks
                    confirmDeleteButton.disabled = true;
                    formToSubmit.submit();
                }
            });

            // Event listener for cancel delete
            cancelDeleteButton.addEventListener('click', () => {
                closeModal();
            });

            // Event listener for close button (X)
            closeButton.addEventListener('click', () => {
                closeModal();
            });

            // Close modal when clicking outside the modal content
            window.addEventListener('click', (event) => {
                if (event.target == deleteModal) {
                    closeModal();
                }
            });
        });
    </script>
</x-app-layout>
