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
                            style="max-width: 100px; height: auto;" 
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
                            <button type="submit" class="btn-edit" aria-label="Edit Movie">
                                <img src="icons/icons8-edit-50.png" alt="Edit" style="width: 14px; height: 14px; margin-right: 5px;" />
                                Edit
                            </button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('movie.destroy', ['movie' => $movie]) }}" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn-delete delete-button" aria-label="Delete Movie">
                                <img src="icons/icons8-delete-24.png" alt="Delete" style="width: 17px; height: 17px; margin-right: 5px;" /> Delete
                            </button>
                        </form>
                    </td>
                    <td>
                        <form method="GET" action="{{ route('movie.detail', ['movie' => $movie]) }}">
                            <button type="submit" class="btn-view" aria-label="View Movie">
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
</body>
</html>
