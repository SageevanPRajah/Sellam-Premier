<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shows</title>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-p6qD4WmF1g4p8qPQ5cM+PEOj8EeA0bg65dwZ2rBt+9v9V/GMq3O36RlhjzQpYYzTCnzqqe/GJZy43k5BSYyxzg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* CSS Variables */
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
            font-family: Arial, sans-serif;
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

        /* Add New Show Button */
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
            /* Invert icon colors for visibility */
        }

        /* Search Bar */
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
            color: var(--text-color);
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
            transition: box-shadow 0.3s;
        }

        .search-bar select:focus,
        .search-bar input[type="text"]:focus,
        .search-bar input[type="date"]:focus {
            box-shadow: 0 0 10px #2196F3;
        }

        .search-bar input[type="text"]::placeholder {
            color: #aaa;
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
            padding: 15px;
            color: var(--text-color);
        }

        th {
            background-color: rgb(35, 36, 36);
            font-weight: bold;
            color: #ffffff;
        }

        /* Buttons (Edit, Delete, View) */
        .action-button {
            width: 100px;
            padding: 10px 0;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 14px;
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
            color: black;
        }

        .btn-edit img,
        .btn-delete img,
        .btn-view img {
            margin-right: 5px;
            filter: brightness(0) invert(1);
        }

        .btn-edit:hover img,
        .btn-delete:hover img,
        .btn-view:hover img {
            filter: brightness(0) invert(0);
        }

        /* Modal Styles */
        .modal {
            display: none;
            /* Hidden by default */
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
            background-color: #fff;
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

        /* Responsive Design */
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
</head>

<body>
    <h1>Billing Details</h1>

    <!-- Success Message -->
    @if (session()->has('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <!-- Billing Table -->
    <table id="billingTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Movie Name</th>
                <th>Seat Type</th>
                <th>Total Tickets</th>
                <th>Full Tickets</th>
                <th>Half Tickets</th>
                <th>Total Price</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($billings as $billing)
                <tr>
                    <td>{{ $billing->id }}</td>
                    <td>{{ $billing->movie_name }}</td>
                    <td>{{ $billing->seat_type }}</td>
                    <td>{{ $billing->total_tickets }}</td>
                    <td>{{ $billing->full_tickets }}</td>
                    <td>{{ $billing->half_tickets }}</td>
                    <td>Rs. {{ number_format($billing->total_price, 2) }}</td>
                    <td>{{ $billing->created_at }}</td>
                    <td>
                        <!-- Action Buttons -->
                        <form method="GET" action="{{ route('billing.detail', $billing->id) }}" style="display:inline;">
                           <button type="submit" class="action-button btn-delete">
                                Detail
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
