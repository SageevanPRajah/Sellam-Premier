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
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');
            const sliderWrapper = document.querySelector('.slider-wrapper');
            const rows = Array.from(document.querySelectorAll('#movieTableBody tr'));
            let position = 0;

            // Slider Controls
            document.getElementById('prev').addEventListener('click', () => {
                position = Math.min(position + 200, 0);
                sliderWrapper.style.transform = `translateX(${position}px)`;
            });

            document.getElementById('next').addEventListener('click', () => {
                position = Math.max(position - 200, -(sliderWrapper.scrollWidth - sliderWrapper.offsetWidth));
                sliderWrapper.style.transform = `translateX(${position}px)`;
            });

            // Filters
            function filterMovies() {
                const searchQuery = searchInput.value.toLowerCase();
                const statusQuery = statusFilter.value;
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                rows.forEach(row => {
                    const name = row.getAttribute('data-name');
                    const status = row.getAttribute('data-status');
                    const releaseDate = new Date(row.getAttribute('data-release-date'));

                    let matchesSearch = !searchQuery || name.includes(searchQuery);
                    let matchesStatus = statusQuery === 'all' || status === statusQuery;
                    let matchesDate = (!startDate || releaseDate >= startDate) && (!endDate || releaseDate <= endDate);

                    row.style.display = matchesSearch && matchesStatus && matchesDate ? '' : 'none';
                });
            }

            searchInput.addEventListener('input', filterMovies);
            statusFilter.addEventListener('change', filterMovies);
            startDateInput.addEventListener('change', filterMovies);
            endDateInput.addEventListener('change', filterMovies);
        });
    </script>
</x-app-layout>
