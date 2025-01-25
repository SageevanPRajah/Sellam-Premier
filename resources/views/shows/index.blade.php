<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shows') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">

                <h1 class="text-center text-white mb-6">Shows</h1>

                <!-- Success Message -->
                @if(session()->has('success'))
                    <div class="bg-green-500 text-white p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Add New Show Button -->
                <div class="text-right mb-6">
                    <a 
                        href="{{ route('show.create') }}" 
                        class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded inline-flex items-center"
                    >
                        <i class="fa fa-plus mr-2"></i> Add New Show
                    </a>
                </div>

                <!-- Filter Section -->
                <div class="flex flex-wrap gap-4 mb-6">
                    <!-- Show Type Filter -->
                    <div>
                        <label for="movieCodeSelect" class="block text-sm font-medium">Show Type</label>
                        <select id="movieCodeSelect" class="block w-full px-3 py-2 rounded bg-gray-700 text-white">
                            <option value="all">All Show Types</option>
                            <option value="Morning Show">Morning Show</option>
                            <option value="Matinee Show">Matinee Show</option>
                            <option value="Night Show">Night Show</option>
                            <option value="Midnight Show">Midnight Show</option>
                            <option value="Special Show">Special Show</option>
                            <option value="Premiere Show">Premiere Show</option>
                        </select>
                    </div>
                    <!-- Time Filter -->
                    <div>
                        <label for="timeInput" class="block text-sm font-medium">Time</label>
                        <input 
                            id="timeInput" 
                            type="text" 
                            placeholder="e.g. 19:30" 
                            class="block w-full px-3 py-2 rounded bg-gray-700 text-white"
                        >
                    </div>
                    <!-- Date Range Filters -->
                    <div>
                        <label for="startDate" class="block text-sm font-medium">From Date</label>
                        <input 
                            id="startDate" 
                            type="date" 
                            class="block w-full px-3 py-2 rounded bg-gray-700 text-white"
                        >
                    </div>
                    <div>
                        <label for="endDate" class="block text-sm font-medium">To Date</label>
                        <input 
                            id="endDate" 
                            type="date" 
                            class="block w-full px-3 py-2 rounded bg-gray-700 text-white"
                        >
                    </div>
                    <!-- Search Filter -->
                    <div class="flex-1">
                        <label for="searchInput" class="block text-sm font-medium">Search</label>
                        <input 
                            id="searchInput" 
                            type="text" 
                            placeholder="Search by Movie Name" 
                            class="block w-full px-3 py-2 rounded bg-gray-700 text-white"
                        >
                    </div>
                </div>

                <!-- Shows Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-700 text-white rounded">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left">Date</th>
                                <th class="px-4 py-2 text-left">Time</th>
                                <th class="px-4 py-2 text-left">Price Type</th>
                                <th class="px-4 py-2 text-left">Movie Name</th>
                                <th class="px-4 py-2 text-center">Poster</th>
                                <th class="px-4 py-2 text-center">Edit</th>
                                <th class="px-4 py-2 text-center">Delete</th>
                                <th class="px-4 py-2 text-center">View</th>
                            </tr>
                        </thead>
                        <tbody id="showsTableBody">
                            @foreach($shows as $show)
                                <tr 
                                    class="border-b border-gray-600"
                                    data-date="{{ $show->date }}"
                                    data-time="{{ $show->time }}"
                                    data-code="{{ $show->movie_code }}"
                                    data-movie-name="{{ strtolower($show->movie_name) }}"
                                >
                                    <td class="px-4 py-2">{{ $show->id }}</td>
                                    <td class="px-4 py-2">{{ $show->date }}</td>
                                    <td class="px-4 py-2">{{ $show->time }}</td>
                                    <td class="px-4 py-2">{{ $show->movie_code }}</td>
                                    <td class="px-4 py-2">{{ $show->movie_name }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <img 
                                            src="{{ $show->poster ? asset('storage/' . $show->poster) : asset('images/default-poster.jpg') }}" 
                                            alt="Poster" 
                                            class="rounded w-16 h-auto"
                                        />
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <a 
                                            href="{{ route('show.edit', $show) }}" 
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded inline-flex items-center"
                                        >
                                            <i class="fa fa-edit mr-2"></i> Edit
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <form method="POST" action="{{ route('show.destroy', $show) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded inline-flex items-center"
                                                onclick="return confirm('Are you sure you want to delete this show?')"
                                            >
                                                <i class="fa fa-trash mr-2"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <a 
                                            href="{{ route('show.detail', $show) }}" 
                                            class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded inline-flex items-center"
                                        >
                                            <i class="fa fa-eye mr-2"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

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

            </div>
        </div>
    </div>

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
