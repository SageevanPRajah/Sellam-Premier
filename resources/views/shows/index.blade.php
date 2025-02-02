<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shows') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <h1> <b> Shows </b> </h1>

        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Add New Show Button -->
        <div class="add-link">
            <a href="{{ route('show.create') }}">
                <img src="icons/icons8-add-24.png" alt="Add"
                    style="width: 19px; height: 19px; margin-bottom: -3px;" />
                Add New Show
            </a>
        </div>

        <!-- Search Bar with Filters -->
        <div class="search-bar">
            <!-- movie_code Filter (Dropdown) -->
            <div class="filter-group">
                <label for="movieCodeSelect">Show Type</label>
                <select id="movieCodeSelect" aria-label="Select Show Type">
                    <option value="all">All Show Types</option>
                    <option value="Morning Show">Morning Show</option>
                    <option value="Matinee Show">Matinee Show</option>
                    <option value="Night Show">Night Show</option>
                    <option value="Midnight Show">Midnight Show</option>
                    <option value="Special Show">Special Show</option>
                    <option value="Premiere Show">Premiere Show</option>
                </select>
            </div>

            <!-- Filter by Time -->
            <div class="filter-group">
                <label for="timeInput">Time</label>
                <input type="text" id="timeInput" placeholder="e.g. 19:30" aria-label="Filter by Time">
            </div>

            <!-- Date Range Filter -->
            <div class="filter-group">
                <label for="startDate">From Date</label>
                <input type="date" id="startDate" aria-label="Filter Shows From Date">
            </div>
            <div class="filter-group">
                <label for="endDate">To Date</label>
                <input type="date" id="endDate" aria-label="Filter Shows To Date">
            </div>

            <!-- General Search -->
            <div class="filter-group">
                <label for="searchInput">Search</label>
                <input type="text" id="searchInput" placeholder="Search by Movie Name" aria-label="Search Shows">
            </div>
        </div>

        <!-- Shows Table -->
        <table id="showTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Price Type</th>
                    <th>Movie Name</th>
                    <th>Poster</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shows as $show)
                    <!--
                     Store filterable attributes in data- attributes so the JS can read them:
                     - data-date for the show date
                     - data-time for the show time
                     - data-code for the movie_code (e.g. 'Morning Show', 'Matinee Show', etc.)
                     - data-movie-name for the movie name
                -->
                    <tr data-date="{{ $show->date }}" data-time="{{ $show->time }}"
                        data-code="{{ $show->movie_code }}" data-movie-name="{{ strtolower($show->movie_name) }}">
                        <td>{{ $show->id }}</td>
                        <td>{{ $show->date }}</td>
                        <td>{{ $show->time }}</td>
                        <td>{{ $show->movie_code }}</td>
                        <td>{{ $show->movie_name }}</td>
                        <td>
                            <img src="{{ $show->poster ? asset('storage/' . $show->poster) : asset('images/default-poster.jpg') }}"
                                alt="Poster" style="max-width: 100px; height: auto; border-radius: 10px;" />
                        </td>
                        <td>
                            <form method="GET" action="{{ route('show.edit', ['show' => $show]) }}">
                                <button type="submit" class="action-button btn-edit">
                                    <img src="icons/icons8-edit-50.png" alt="Edit"
                                        style="width: 14px; height: 14px; margin-right: 5px;" />
                                    Edit
                                </button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('show.destroy', ['show' => $show]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="action-button btn-delete delete-button">
                                    <img src="icons/icons8-delete-24.png" alt="Delete"
                                        style="width: 17px; height: 17px; margin-right: 5px;" />
                                    Delete
                                </button>
                            </form>
                        </td>
                        <td>
                            <form method="GET" action="{{ route('show.detail', ['show' => $show]) }}">
                                <button type="submit" class="action-button btn-view">
                                    <img src="icons/icons8-eye-32.png" alt="View"
                                        style="width: 17px; height: 17px; margin-right: 5px;" />
                                    View
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
                <select id="rowsPerPage">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="15">15</option>
                </select>
            </div>
            <!-- Pagination Controls -->
            <div class="pagination" id="pagination">
                <!-- Dynamically generated buttons -->
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <span class="close-button" aria-label="Close Modal">&times;</span>
                <p>Are you sure you want to delete this show?</p>
                <div>
                    <img src="icons/icons8-delete (1).gif" alt="Delete"
                        style="width: 25px; height: 25px; margin-right: 5px;" />
                </div>
                <div class="modal-actions">
                    <button id="confirmDelete" class="btn-delete">Confirm</button>
                    <button id="cancelDelete" class="btn-view">Cancel</button>
                </div>
            </div>
        </div>

        <!-- Styles -->
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
                background-color: rgb(40, 43, 46);
                color: var(--text-color);
                font-size: 12px;
            }

            h1 {
                margin: 20px 0;
                text-align: center;
                color: black;
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
                overflow: hidden;
                /* Hides overflow for slider effect */
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
                margin: 10px 5px;
                /* gap between items */
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
                margin-left: 57%;
            }

            .add-link a:hover {
                /* box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light); */
                background-color: #333;
                color: #fff;
            }

            .add-link a img {
                margin-right: 10px;
                filter: brightness(0) invert(1);
                /* Invert icon colors for visibility */
            }

            /* Search Bar with Status and Date Range Filter */
            .search-bar {
                width: 80%;
                margin: 20px auto;
                display: flex;
                justify-content: flex-end;
                align-items: center;
                gap: 15px;
                /* Adds space between elements */
                flex-wrap: wrap;
                /* Allows wrapping on smaller screens */
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
                background-color: rgb(41, 43, 44);
                box-shadow: 0 0 10px var(--shadow-dark);
                border-radius: 15px;
                overflow: hidden;
            }

            th,
            td {
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
                background-color: rgb(37, 39, 39);
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
                background-color: rgb(6, 248, 14);
            }

            .status-inactive::before {
                background-color: rgb(255, 0, 0);
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
                margin: 0 auto;
                /* Center the button within the cell */
            }

            .btn-edit {
                background-color: rgb(81, 88, 94);
                /* Gray */
            }

            .btn-delete {
                background-color: #343a40;
                /* Dark Gray */
            }

            .btn-view {
                background-color: #495057;
                /* Medium Gray */
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
                filter: brightness(0) invert(0);
                /* Remove inversion to make the image black */
            }

            /* .btn-edit img, .btn-delete img, .btn-view img:hover {
        color: black;
        } */

            .btn-edit img,
            .btn-delete img,
            .btn-view img {
                margin-right: 5px;
                filter: brightness(0) invert(1);
                /* Invert icon colors for visibility */
            }

            /* Modal Styles (Neumorphic Gray and Black) */
            .modal {
                display: none;
                /* Hidden by default */
                position: fixed;
                z-index: 1000;
                /* Sit on top */
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                /* Enable scroll if needed */
                background-color: rgba(0, 0, 0, 0.7);
                /* Black w/ opacity */
            }

            .modal-content {
                background-color: #fff;
                margin: 10% auto;
                /* 10% from top and centered */
                padding: 20px;
                border: none;
                width: 300px;
                /* Could be more or less, depending on screen size */
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
                background-color: #FF5555;
                /* Danger */
            }

            #cancelDelete {
                background-color: #6c757d;
                /* Gray */
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

            .search-bar label {
                font-size: 14px;
                color: black;
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

                .rows-per-page,
                .pagination {
                    width: 100%;
                    justify-content: flex-start;
                    margin-bottom: 10px;
                }
            }
        </style>

        <!-- JS for Filtering, Pagination, and Modal -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Grab references
                const movieCodeSelect = document.getElementById('movieCodeSelect');
                const timeInput = document.getElementById('timeInput');
                const startDateInput = document.getElementById('startDate');
                const endDateInput = document.getElementById('endDate');
                const searchInput = document.getElementById('searchInput'); // New Search Input

                const table = document.getElementById('showTable');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.getElementsByTagName('tr'));

                // Pagination elements
                const rowsPerPageSelect = document.getElementById('rowsPerPage');
                const paginationContainer = document.getElementById('pagination');
                let currentPage = 1;
                let rowsPerPage = parseInt(rowsPerPageSelect.value);

                // ----------------------------
                // Filtering Function
                // ----------------------------
                function filterShows() {
                    const selectedShowType = movieCodeSelect.value; // "all" or "Morning Show", etc.
                    const timeValue = timeInput.value.trim().toLowerCase();
                    const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
                    const endDate = endDateInput.value ? new Date(endDateInput.value) : null;
                    const searchValue = searchInput.value.trim().toLowerCase(); // Get Search Input

                    return rows.filter(row => {
                        // data attributes
                        const rowMovieCode = row.getAttribute('data-code') || '';
                        const rowTime = (row.getAttribute('data-time') || '').toLowerCase();
                        const rowDate = new Date(row.getAttribute('data-date'));
                        const rowMovieName = row.getAttribute('data-movie-name') || '';

                        // Filter by show type
                        let matchesShowType = true;
                        if (selectedShowType !== 'all') {
                            // Compare exact match (case-sensitive or insensitive as needed)
                            if (rowMovieCode !== selectedShowType) {
                                matchesShowType = false;
                            }
                        }

                        // Filter by time (contains)
                        const matchesTime = rowTime.includes(timeValue);

                        // Filter by date range
                        let matchesDate = true;
                        if (startDate && rowDate < startDate) {
                            matchesDate = false;
                        }
                        if (endDate && rowDate > endDate) {
                            matchesDate = false;
                        }

                        // Filter by search input (movie name contains search value)
                        let matchesSearch = true;
                        if (searchValue !== '') {
                            matchesSearch = rowMovieName.toLowerCase().includes(searchValue);
                        }

                        return matchesShowType && matchesTime && matchesDate && matchesSearch;
                    });
                }

                // ----------------------------
                // Pagination Functions
                // ----------------------------
                function paginateRows(filteredRows) {
                    const totalPages = Math.ceil(filteredRows.length / rowsPerPage) || 1;

                    // Ensure current page is within bounds
                    if (currentPage > totalPages) currentPage = totalPages;
                    if (currentPage < 1) currentPage = 1;

                    const startIndex = (currentPage - 1) * rowsPerPage;
                    const endIndex = startIndex + rowsPerPage;

                    // Hide all rows
                    rows.forEach(row => {
                        row.style.display = 'none';
                    });

                    // Show the relevant slice of rows
                    filteredRows.slice(startIndex, endIndex).forEach(row => {
                        row.style.display = '';
                    });

                    updatePaginationControls(totalPages);
                }

                function updatePaginationControls(totalPages) {
                    // Clear existing
                    paginationContainer.innerHTML = '';

                    if (totalPages <= 1) return; // No need for pagination

                    // Prev Button
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

                    // Page Buttons (show a window of 5 pages)
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

                // ----------------------------
                // Main "apply" function
                // ----------------------------
                function applyFiltersAndPagination() {
                    const filtered = filterShows();
                    paginateRows(filtered);
                }

                // Event Listeners
                movieCodeSelect.addEventListener('change', () => {
                    currentPage = 1;
                    applyFiltersAndPagination();
                });
                timeInput.addEventListener('input', () => {
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
                searchInput.addEventListener('input', () => { // Listen to Search Input
                    currentPage = 1;
                    applyFiltersAndPagination();
                });

                rowsPerPageSelect.addEventListener('change', () => {
                    rowsPerPage = parseInt(rowsPerPageSelect.value);
                    currentPage = 1;
                    applyFiltersAndPagination();
                });

                // Initial load
                applyFiltersAndPagination();

                // ----------------------------
                // Delete Confirmation Modal
                // ----------------------------
                const deleteModal = document.getElementById('deleteModal');
                const closeButton = deleteModal.querySelector('.close-button');
                const cancelDeleteButton = document.getElementById('cancelDelete');
                const confirmDeleteButton = document.getElementById('confirmDelete');
                let formToSubmit = null;

                function openModal(form) {
                    deleteModal.style.display = 'block';
                    formToSubmit = form;
                }

                function closeModal() {
                    deleteModal.style.display = 'none';
                    formToSubmit = null;
                    confirmDeleteButton.disabled = false;
                }

                const deleteButtons = document.querySelectorAll('.delete-button');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', (e) => {
                        const form = e.target.closest('form');
                        openModal(form);
                    });
                });

                confirmDeleteButton.addEventListener('click', () => {
                    if (formToSubmit) {
                        confirmDeleteButton.disabled = true;
                        formToSubmit.submit();
                    }
                });

                cancelDeleteButton.addEventListener('click', () => {
                    closeModal();
                });

                closeButton.addEventListener('click', () => {
                    closeModal();
                });

                window.addEventListener('click', (event) => {
                    if (event.target === deleteModal) {
                        closeModal();
                    }
                });
            });
        </script>
</x-app-layout>