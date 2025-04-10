<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Movie') }}
        </h2>
    </x-slot>

    <h1><b> Movie </b></h1>

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
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movies as $movie)
                <tr 
                    data-status="{{ $movie->active ? 'active' : 'inactive' }}" 
                    data-release="{{ \Carbon\Carbon::parse($movie->release_date)->format('Y-m-d') }}"
                >
                    <td>{{ $movie->id }}</td>
                    <td class="movie-name">{{ $movie->name }}</td>
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
                                <img src="icons/icons8-delete-24.png" alt="Delete" style="width: 17px; height: 17px; margin-right: 5px;" />
                                Delete
                            </button>
                        </form>
                    </td>
                    <td>
                        <form method="GET" action="{{ route('movie.detail', ['movie' => $movie]) }}">
                            <button type="submit" class="action-button btn-view" aria-label="View Movie">
                                <img src="icons/icons8-eye-32.png" alt="View" style="width: 17px; height: 17px; margin-right: 5px;" /> 
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
        <div class="rows-per-page">
            <label for="rowsPerPage">Rows per page:</label>
            <select id="rowsPerPage" aria-label="Select number of rows per page">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="15">15</option>
            </select>
        </div>
        <div class="pagination" id="pagination"></div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close-button" aria-label="Close Modal">&times;</span>
            <p>Are you sure you want to delete this movie?</p>
            <div>
                <img src="icons/icons8-delete (1).gif" alt="Delete" style="width: 25px; height: 25px; margin-right: 5px;" />
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
            font-size: 20px;
        }

        .success-message {
            text-align: center;
            color: var(--success-color);
            margin-bottom: 10px;
        }

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
            transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
            cursor: pointer;
            font-weight: bold;
            margin-left: 57%;
        }
        .add-link a:hover {
            background-color: #333;
            color: #fff;
        }
        .add-link a img {
            margin-right: 10px;
            filter: brightness(0) invert(1);
        }

        /* Search Bar with Status and Date Range Filter */
        .search-bar {
            width: 80%;
            margin: 20px auto;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
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
            font-size: 14px;
            outline: none;
            transition: box-shadow 0.3s;
        }
        .search-bar input::placeholder {
            color: #aaa;
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
        .search-bar label {
            font-size: 14px;
            color: black;
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

        /* Buttons */
        .action-button {
            width: 100px;
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
        }
        .btn-edit {
            background-color: rgb(81, 88, 94);
        }
        .btn-delete {
            background-color: #343a40;
        }
        .btn-view {
            background-color: #495057;
        }
        .btn-edit:hover,
        .btn-delete:hover,
        .btn-view:hover {
            color: black;
        }
        .btn-edit:hover img,
        .btn-delete:hover img,
        .btn-view:hover img {
            filter: brightness(0) invert(0);
        }
        .btn-edit img,
        .btn-delete img,
        .btn-view img {
            margin-right: 5px;
            filter: brightness(0) invert(1);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
        }
        .modal-content {
            background-color: #ffffff;
            margin: 10% auto;
            padding: 20px;
            border: none;
            width: 300px;
            border-radius: 20px;
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
            transition: box-shadow 0.3s, background-color 0.3s;
        }
        #confirmDelete {
            background-color: #FF5555;
        }
        #cancelDelete {
            background-color: #6c757d;
        }
        #confirmDelete:hover,
        #cancelDelete:hover {
        }

        /* Pagination & Rows per Page */
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
        @media (max-width: 768px) {
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

    <!-- Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            /* =================== Filtering + Pagination =================== */
            const searchInput       = document.getElementById('searchInput');
            const statusFilter      = document.getElementById('statusFilter');
            const startDateInput    = document.getElementById('startDate');
            const endDateInput      = document.getElementById('endDate');
            const table             = document.getElementById('movieTable');
            const tbody             = table.querySelector('tbody');
            const rows              = Array.from(tbody.querySelectorAll('tr'));

            const rowsPerPageSelect = document.getElementById('rowsPerPage');
            const paginationDiv     = document.getElementById('pagination');
            let currentPage         = 1;
            let rowsPerPage         = parseInt(rowsPerPageSelect.value);

            function filterMovies() {
                const searchTerm     = searchInput.value.trim().toLowerCase();
                const selectedStatus = statusFilter.value;
                const startDate      = startDateInput.value;
                const endDate        = endDateInput.value;

                return rows.filter(row => {
                    const nameCell    = row.querySelector('.movie-name');
                    const nameText    = nameCell.textContent.trim().toLowerCase();
                    const status      = row.getAttribute('data-status');
                    const releaseDate = row.getAttribute('data-release');

                    // Search filter
                    const matchesSearch = nameText.includes(searchTerm);

                    // Status filter
                    let matchesStatus = false;
                    if (selectedStatus === 'all') {
                        matchesStatus = true;
                    } else if (selectedStatus === 'active' && status === 'active') {
                        matchesStatus = true;
                    } else if (selectedStatus === 'inactive' && status === 'inactive') {
                        matchesStatus = true;
                    }

                    // Date range (YYYY-MM-DD string compare)
                    let matchesDate = true;
                    if (startDate && releaseDate < startDate) {
                        matchesDate = false;
                    }
                    if (endDate && releaseDate > endDate) {
                        matchesDate = false;
                    }

                    return matchesSearch && matchesStatus && matchesDate;
                });
            }

            function paginateRows(filteredRows) {
                const totalPages = Math.ceil(filteredRows.length / rowsPerPage) || 1;
                if (currentPage > totalPages) currentPage = totalPages;
                if (currentPage < 1) currentPage = 1;

                const startIndex = (currentPage - 1) * rowsPerPage;
                const endIndex   = startIndex + rowsPerPage;

                rows.forEach(row => (row.style.display = 'none'));
                filteredRows.slice(startIndex, endIndex).forEach(row => (row.style.display = ''));

                updatePaginationControls(totalPages);
            }

            function updatePaginationControls(totalPages) {
                paginationDiv.innerHTML = '';
                if (totalPages <= 1) return;

                // Prev
                const prevBtn = document.createElement('button');
                prevBtn.textContent = 'Prev';
                prevBtn.disabled = (currentPage === 1);
                prevBtn.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        applyFiltersAndPagination();
                    }
                });
                paginationDiv.appendChild(prevBtn);

                let startPage = Math.max(1, currentPage - 2);
                let endPage   = Math.min(totalPages, currentPage + 2);

                if (currentPage <= 3) {
                    endPage = Math.min(5, totalPages);
                }
                if (currentPage >= totalPages - 2) {
                    startPage = Math.max(1, totalPages - 4);
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.textContent = i;
                    if (i === currentPage) pageBtn.classList.add('active');
                    pageBtn.addEventListener('click', () => {
                        currentPage = i;
                        applyFiltersAndPagination();
                    });
                    paginationDiv.appendChild(pageBtn);
                }

                // Next
                const nextBtn = document.createElement('button');
                nextBtn.textContent = 'Next';
                nextBtn.disabled = (currentPage === totalPages);
                nextBtn.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        applyFiltersAndPagination();
                    }
                });
                paginationDiv.appendChild(nextBtn);
            }

            function applyFiltersAndPagination() {
                const filteredRows = filterMovies();
                paginateRows(filteredRows);
            }

            // Filter event listeners
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
            rowsPerPageSelect.addEventListener('change', () => {
                rowsPerPage = parseInt(rowsPerPageSelect.value);
                currentPage = 1;
                applyFiltersAndPagination();
            });

            // Initial load
            applyFiltersAndPagination();

            /* =================== Delete Confirmation Modal =================== */
            const deleteModal         = document.getElementById('deleteModal');
            const closeButton         = document.querySelector('.close-button');
            const cancelDeleteButton  = document.getElementById('cancelDelete');
            const confirmDeleteButton = document.getElementById('confirmDelete');
            let formToSubmit          = null;

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
                    e.preventDefault();
                    const form = button.closest('form');
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
