<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Movie') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-xl sm:rounded-lg p-6 text-white">
                <h1 class="text-2xl font-bold text-center mb-6">Movies</h1>

                @if(session()->has('success'))
                    <div class="bg-green-500 text-center text-white p-2 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Slider Controls Container -->
                <div class="slider-controls flex items-center justify-between mb-6">
                    <!-- Prev Button -->
                    <button id="prev" class="slider-control-btn bg-gray-700 hover:bg-gray-600 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="18" height="18" fill="currentColor">
                            <path d="M16 4l-8 8 8 8z" />
                        </svg>
                    </button>

                    <!-- Slider Container -->
                    <div class="slider-container overflow-hidden rounded-lg">
                        <div class="slider-wrapper flex">
                            @foreach($movies as $movie)
                                <div class="slider-item w-48 mx-2 text-center bg-gray-800 rounded-lg p-2">
                                    <img 
                                        src="{{ $movie->poster ? asset('storage/' . $movie->poster) : asset('images/default-poster.jpg') }}" 
                                        alt="Poster" 
                                        class="w-full h-32 object-cover rounded-lg"
                                    >
                                    <a href="{{ route('movie.inspect', ['movie' => $movie]) }}" class="text-blue-400 underline mt-2 block">
                                        More...
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Next Button -->
                    <button id="next" class="slider-control-btn bg-gray-700 hover:bg-gray-600 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="18" height="18" fill="currentColor">
                            <path d="M8 4l8 8-8 8z" />
                        </svg>
                    </button>
                </div>

                <!-- Add New Movie Button -->
                <div class="text-right mb-4">
                    <a href="{{ route('movie.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-lg">
                        <img src="icons/icons8-add-24.png" alt="Add" class="inline-block mr-2" style="width: 19px; height: 19px;" /> Add New Movie
                    </a>
                </div>

                <!-- Search Bar with Status and Date Range Filter -->
                <div class="search-bar flex flex-wrap gap-4 items-center mb-6">
                    <!-- Search by Name -->
                    <div class="filter-group">
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Search by name..." 
                            class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400" 
                            aria-label="Search Movies by Name"
                        >
                    </div>
                    <!-- Status Filter -->
                    <div class="filter-group">
                        <select 
                            id="statusFilter" 
                            class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white" 
                            aria-label="Filter Movies by Status"
                        >
                            <option value="all">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="inactive">Not Active</option>
                        </select>
                    </div>
                    <!-- Date Range Filter -->
                    <div class="filter-group flex gap-2 items-center">
                        <label for="startDate" class="text-white">From:</label>
                        <input 
                            type="date" 
                            id="startDate" 
                            class="px-4 py-2 rounded-lg bg-gray-700 text-white" 
                            aria-label="Filter Movies From Date"
                        >
                        <label for="endDate" class="text-white">To:</label>
                        <input 
                            type="date" 
                            id="endDate" 
                            class="px-4 py-2 rounded-lg bg-gray-700 text-white" 
                            aria-label="Filter Movies To Date"
                        >
                    </div>
                </div>

                <!-- Movie Table -->
                <table class="w-full bg-gray-800 rounded-lg text-center">
                    <thead class="bg-gray-700 text-gray-200">
                        <tr>
                            <th class="p-3">ID</th>
                            <th class="p-3">Name</th>
                            <th class="p-3">Poster</th>
                            <th class="p-3">Trailer Link</th>
                            <th class="p-3">Duration</th>
                            <th class="p-3">Release Date</th>
                            <th class="p-3">IMDB Link</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Edit</th>
                            <th class="p-3">Delete</th>
                            <th class="p-3">View</th>
                        </tr>
                    </thead>
                    <tbody id="movieTableBody">
                        @foreach($movies as $movie)
                            <tr 
                                data-status="{{ $movie->active ? 'active' : 'inactive' }}" 
                                data-name="{{ strtolower($movie->name) }}" 
                                data-release-date="{{ $movie->release_date }}"
                            >
                                <td>{{ $movie->id }}</td>
                                <td>{{ $movie->name }}</td>
                                <td>
                                    <img 
                                        src="{{ $movie->poster ? asset('storage/' . $movie->poster) : asset('images/default-poster.jpg') }}" 
                                        alt="Poster" 
                                        class="w-16 h-auto rounded-md" 
                                    />
                                </td>
                                <td>
                                    <a href="{{ $movie->trailer_link }}" class="text-blue-400 underline" target="_blank">Watch Trailer</a>
                                </td>
                                <td>{{ $movie->duration }} minutes</td>
                                <td>{{ \Carbon\Carbon::parse($movie->release_date)->format('F d, Y') }}</td>
                                <td>
                                    <a href="{{ $movie->imdb_link }}" class="text-blue-400 underline" target="_blank">IMDB Link</a>
                                </td>
                                <td>
                                    @if($movie->active)
                                        <span class="bg-green-500 px-3 py-1 rounded-full text-white">Active</span>
                                    @else
                                        <span class="bg-red-500 px-3 py-1 rounded-full text-white">Not Active</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('movie.edit', ['movie' => $movie]) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-4 rounded-lg">
                                        Edit
                                    </a>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('movie.destroy', ['movie' => $movie]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="bg-red-500 hover:bg-red-600 text-white py-1 px-4 rounded-lg delete-button">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('movie.detail', ['movie' => $movie]) }}" class="bg-gray-600 hover:bg-gray-700 text-white py-1 px-4 rounded-lg">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination and Rows per Page -->
    <div class="pagination-container">
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
