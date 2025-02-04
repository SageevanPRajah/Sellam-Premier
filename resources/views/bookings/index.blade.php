<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Details') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <h1>Booking details</h1>

        <!-- Success Message -->
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

        <!-- Search Bar / Filters -->
        <div class="search-bar">
            <!-- Filter by "Show Type" (example) -->
            <div class="filter-group">
                <label for="movieCodeSelect">Show Type</label>
                <select id="movieCodeSelect" aria-label="Select Show Type">
                    <option value="">All Types</option>
                    <option value="Price 1">Price 1</option>
                    <option value="Price 2">Price 2</option>
                    <option value="Price 3">Price 3</option>
                </select>
            </div>

            <!-- Filter by Time -->
            <div class="filter-group">
                <label for="timeInput">Time</label>
                <input 
                  type="text" 
                  id="timeInput" 
                  placeholder="e.g. 19:30" 
                  aria-label="Filter by Time"
                />
            </div>

            <!-- Date Range -->
            <div class="filter-group">
                <label for="startDate">From Date</label>
                <input 
                  type="date" 
                  id="startDate" 
                  aria-label="Filter Shows From Date"
                />
            </div>
            <div class="filter-group">
                <label for="endDate">To Date</label>
                <input 
                  type="date" 
                  id="endDate" 
                  aria-label="Filter Shows To Date"
                />
            </div>

            <!-- General Search (by movie name, or customer name, etc.) -->
            <div class="filter-group">
                <label for="searchInput">Search</label>
                <input 
                  type="text" 
                  id="searchInput" 
                  placeholder="Search by Movie Name" 
                  aria-label="Search Bookings"
                />
            </div>
        </div>

        <!-- Bookings Table -->
        <table id="showTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Show Id</th>
                    <th>Movie Name</th>
                    <th>Seat Type</th>
                    <th>Seat Number</th>
                    <th>Seat Code</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr 
                        data-showtype="{{ strtolower($booking->price_type ?? '') }}"
                        data-time="{{ $booking->time }}"
                        data-date="{{ $booking->date }}"
                        data-name="{{ strtolower($booking->movie_name.' '.$booking->name) }}"
                        data-status="{{ strtolower($booking->status) }}"
                    >
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->date }}</td>
                        <td>{{ $booking->time }}</td>
                        <td>{{ $booking->movie_id }}</td>
                        <td>{{ $booking->movie_name }}</td>
                        <td>{{ $booking->seat_type }}</td>
                        <td>{{ $booking->seat_no }}</td>
                        <td>{{ $booking->seat_code }}</td>
                        <td>{{ $booking->name }}</td>
                        <td>{{ $booking->phone }}</td>
                        <td>{{ $booking->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination and Rows-per-page -->
        <div class="pagination-container">
            <div class="rows-per-page">
                <label for="rowsPerPage">Rows per page:</label>
                <select id="rowsPerPage" aria-label="Select number of rows per page">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="15">15</option>
                </select>
            </div>
            <div class="pagination" id="pagination">
                <!-- JS will inject pagination buttons here -->
            </div>
        </div>
    </div>


    <!-- Example Styling (adjust as you like) -->
    <style>
        :root {
            --background-color: #121212;
            --primary-color: #1e1e1e;
            --secondary-color: #2e2e2e;
            --text-color: #e0e0e0;
            --accent-color: #4CAF50;
            --button-color: #2e2e2e;
            --border-color: #555;
            --success-color: #4CAF50;
            --danger-color: #FF5555;
            --info-color: #2196F3;
            --muted-color: #777;
            --shadow-light: #2b2b2b;
            --shadow-dark: #0c0c0c;
        }

        body {
            background-color: rgb(40, 43, 46);
            color: black;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
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

        .error-messages li {
            color: #ffdddd;
        }

        .add-link {
            text-align: center;
            margin: 20px 0;
        }
        .add-link a {
            display: inline-flex;
            align-items: center;
            padding: 12px 20px;
            background-color: var(--primary-color);
            color: var(--text-color);
            text-decoration: none;
            border-radius: 30px;
            transition: background-color 0.3s, color 0.3s;
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
            flex-direction: column;
            gap: 5px;
        }
        .search-bar label {
            font-size: 14px;
        }
        .search-bar select,
        .search-bar input[type="text"],
        .search-bar input[type="date"] {
            padding: 10px 15px;
            border: none;
            border-radius: 20px;
            background-color: rgb(53, 53, 53);
            color: var(--text-color);
            font-size: 16px;
            outline: none;
        }
        .search-bar select:focus,
        .search-bar input[type="text"]:focus,
        .search-bar input[type="date"]:focus {
            box-shadow: 0 0 10px #2196F3;
        }
        .search-bar input[type="text"]::placeholder {
            color: #aaa;
        }

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
            padding: 15px;
            color: var(--text-color);
        }
        th {
            background-color: rgb(35, 36, 36);
            font-weight: bold;
        }

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
            font-size: 16px;
            outline: none;
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
            transition: 0.3s;
        }
        .pagination button.active {
            background-color: #2196F3;
            color: #fff;
            /* box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light); */
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
            }
            .search-bar select,
            .search-bar input[type="text"],
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

    <!-- Script for Filtering & Pagination -->
    <script>
      document.addEventListener('DOMContentLoaded', () => {
          // Filters
          const movieCodeSelect = document.getElementById('movieCodeSelect');
          const timeInput       = document.getElementById('timeInput');
          const startDateInput  = document.getElementById('startDate');
          const endDateInput    = document.getElementById('endDate');
          const searchInput     = document.getElementById('searchInput');

          // Table rows
          const table = document.getElementById('showTable');
          const tbody = table.querySelector('tbody');
          const rows  = Array.from(tbody.querySelectorAll('tr'));

          // Pagination
          const rowsPerPageSelect = document.getElementById('rowsPerPage');
          const paginationContainer = document.getElementById('pagination');

          let currentPage  = 1;
          let rowsPerPage  = parseInt(rowsPerPageSelect.value);

          // 1) Filtering logic
          function filterBookings() {
              const showTypeVal  = movieCodeSelect.value.toLowerCase().trim();
              const timeVal      = timeInput.value.trim().toLowerCase();
              const startDateVal = startDateInput.value;
              const endDateVal   = endDateInput.value;
              const searchVal    = searchInput.value.toLowerCase().trim();

              return rows.filter(row => {
                  const rowShowType = row.getAttribute('data-showtype') || '';
                  const rowTime     = row.getAttribute('data-time') || '';
                  const rowDate     = row.getAttribute('data-date') || '';
                  const rowName     = row.getAttribute('data-name') || '';
                  const rowStatus   = row.getAttribute('data-status') || '';

                  // Check Show Type
                  let matchShowType = true;
                  if (showTypeVal && !rowShowType.includes(showTypeVal)) {
                      matchShowType = false;
                  }

                  // Check Time
                  let matchTime = true;
                  if (timeVal && !rowTime.toLowerCase().includes(timeVal)) {
                      matchTime = false;
                  }

                  // Check Date Range
                  let matchDate = true;
                  if (startDateVal && rowDate < startDateVal) {
                      matchDate = false;
                  }
                  if (endDateVal && rowDate > endDateVal) {
                      matchDate = false;
                  }

                  // Check Search (movie name + user name, etc.)
                  let matchSearch = true;
                  if (searchVal && !rowName.includes(searchVal)) {
                      matchSearch = false;
                  }

                  // If all conditions match, keep the row
                  return matchShowType && matchTime && matchDate && matchSearch;
              });
          }

          // 2) Pagination logic
          function paginateRows(filteredRows) {
              const totalPages = Math.ceil(filteredRows.length / rowsPerPage) || 1;
              if (currentPage > totalPages) currentPage = totalPages;
              if (currentPage < 1) currentPage = 1;

              const startIndex = (currentPage - 1) * rowsPerPage;
              const endIndex   = startIndex + rowsPerPage;

              // Hide all rows, then show only the slice for this page
              rows.forEach(row => (row.style.display = 'none'));
              filteredRows.slice(startIndex, endIndex).forEach(row => (row.style.display = ''));

              // Update pagination buttons
              updatePaginationControls(totalPages);
          }

          // 3) Create pagination buttons
          function updatePaginationControls(totalPages) {
              paginationContainer.innerHTML = '';

              // No pagination needed if there's only one page
              if (totalPages <= 1) return;

              // Prev Button
              const prevBtn = document.createElement('button');
              prevBtn.textContent = 'Prev';
              prevBtn.disabled = (currentPage === 1);
              prevBtn.addEventListener('click', () => {
                  if (currentPage > 1) {
                      currentPage--;
                      applyFiltersAndPagination();
                  }
              });
              paginationContainer.appendChild(prevBtn);

              // Numeric page buttons
              let startPage = Math.max(1, currentPage - 2);
              let endPage   = Math.min(totalPages, currentPage + 2);

              // Adjust if near first or last pages
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
              nextBtn.disabled = (currentPage === totalPages);
              nextBtn.addEventListener('click', () => {
                  if (currentPage < totalPages) {
                      currentPage++;
                      applyFiltersAndPagination();
                  }
              });
              paginationContainer.appendChild(nextBtn);
          }

          // 4) Master function to handle filter + pagination
          function applyFiltersAndPagination() {
              const filtered = filterBookings();
              paginateRows(filtered);
          }

          // 5) Event listeners
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
          searchInput.addEventListener('input', () => {
              currentPage = 1;
              applyFiltersAndPagination();
          });

          rowsPerPageSelect.addEventListener('change', () => {
              rowsPerPage = parseInt(rowsPerPageSelect.value);
              currentPage = 1;
              applyFiltersAndPagination();
          });

          // 6) Initialize
          applyFiltersAndPagination();
      });
    </script>
</x-app-layout>
