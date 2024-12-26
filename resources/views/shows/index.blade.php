<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Table</title>

    <!-- Font Awesome for icons -->
    <link 
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-p6qD4WmF1g4p8qPQ5cM+PEOj8EeA0bg65dwZ2rBt+9v9V/GMq3O36RlhjzQpYYzTCnzqqe/GJZy43k5BSYyxzg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />

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
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: Arial, sans-serif;
        }

        h1 {
            margin: 20px 0;
            text-align: center;
            color: var(--text-color);
        }

        /* Container */
        .container {
            width: 90%;
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Success Message */
        .success-message {
            text-align: center; 
            color: var(--success-color); 
            margin-bottom: 20px;
            font-size: 18px;
        }

        /* Add New Show Button */
        .add-link {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .add-link a {
            display: inline-flex;
            align-items: center;
            padding: 12px 20px;
            background-color: var(--primary-color);
            color: var(--text-color);
            text-decoration: none;
            border-radius: 30px;
            /* box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light); */
            transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
            cursor: pointer;
            font-weight: bold;
        }

        .add-link a:hover {
            /* box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light); */
            background-color: var(--button-hover-color);
            color: #fff;
        }

        .add-link a img {
            margin-right: 10px;
            filter: brightness(0) invert(1); /* Invert icon colors for visibility */
            width: 20px;
            height: 20px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color:rgb(41, 43, 44);
            box-shadow: 0 0 10px var(--shadow-dark);
            border-radius: 15px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: rgb(35, 36, 36);
            color: #ffffff;
            font-weight: bold;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: var(--secondary-color);
        }

        /* Images in Table */
        td img {
            max-width: 100px;
            height: auto;
            border-radius: 10px;
            /* box-shadow: 3px 3px 10px var(--shadow-dark), -3px -3px 10px var(--shadow-light); */
        }

        /* Action Buttons */
        .action-button {
            padding: 8px 12px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light);
            transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
        }

        .btn-edit {
            background-color: rgb(81, 88, 94); /* Info Color */
            margin-right: 5px;
        }

        .btn-delete {
            background-color: #343a40; /* Danger Color */
            margin-right: 5px;
        }

        .btn-view {
            background-color: #495057; /* Success Color */
        }

        .action-button:hover {
            box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
            background-color: var(--button-hover-color);
            color: #000;
        }

        .action-button img {
            margin-right: 5px;
            filter: brightness(0) invert(1); /* Invert icon colors for visibility */
            width: 16px;
            height: 16px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                width: 100%;
                font-size: 14px;
            }

            th, td {
                padding: 10px;
            }

            .add-link {
                justify-content: center;
            }

            .add-link a {
                padding: 10px 16px;
                font-size: 14px;
            }

            .action-button {
                padding: 6px 10px;
                font-size: 12px;
            }

            .action-button img {
                width: 14px;
                height: 14px;
            }
        }
    </style>
</head>
<body>
    <h1>Show Table</h1>
    <div class="container">
        <!-- Success Message -->
        @if(session()->has('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add New Show Button -->
        <div class="add-link">
            <a href="{{ route('show.create') }}">
                <img src="icons/icons8-add-24.png" alt="Add" /> Add New Show
            </a>
        </div>

        <!-- Show Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th> 
                    <th>Date</th> 
                    <th>Time</th>
                    <th>Movie Code</th> 
                    <th>Movie Name</th> 
                    <th>Movie Poster</th>  
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shows as $show)
                    <tr>
                        <td>{{ $show->id }}</td> 
                        <td>{{ \Carbon\Carbon::parse($show->date)->format('F d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($show->time)->format('h:i A') }}</td>
                        <td>{{ $show->movie_code }}</td>
                        <td>{{ $show->movie_name }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $show->movie_poster) }}" alt="Poster" />
                        </td>
                        <td>
                            <form method="GET" action="{{ route('show.edit', ['show' => $show]) }}">
                                <button type="submit" class="action-button btn-edit" aria-label="Edit Show">
                                    <img src="icons/icons8-edit-50.png" alt="Edit" /> Edit
                                </button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('show.destroy', ['show' => $show]) }}" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="action-button btn-delete delete-button" aria-label="Delete Show">
                                    <img src="icons/icons8-delete-24.png" alt="Delete" /> Delete
                                </button>
                            </form>
                        </td>
                        <td>
                            <form method="GET" action="{{ route('show.detail', ['show' => $show]) }}">
                                <button type="submit" class="action-button btn-view" aria-label="View Show">
                                    <img src="icons/icons8-eye-32.png" alt="View" /> View
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal" style="display: none;">
        <div class="modal-content" style="
            background-color: var(--primary-color);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light);
            color: var(--text-color);
            text-align: center;
        ">
            <span class="close-button" style="
                color: #ffffff;
                float: right;
                font-size: 24px;
                font-weight: bold;
                cursor: pointer;
            ">&times;</span>
            <p>Are you sure you want to delete this show?</p>
            <div style="margin: 20px 0;">
                <img src="icons/icons8-delete (1).gif" alt="Delete" style="width: 30px; height: 30px;" />
            </div>
            <div class="modal-actions" style="display: flex; justify-content: center; gap: 20px;">
                <button id="confirmDelete" class="action-button btn-delete" style="width: 100px;">Confirm</button>
                <button id="cancelDelete" class="action-button btn-view" style="width: 100px;">Cancel</button>
            </div>
        </div>
    </div>

    <!-- JavaScript for Delete Confirmation Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Modal Elements
            const deleteModal = document.getElementById('deleteModal');
            const closeButton = deleteModal.querySelector('.close-button');
            const cancelDeleteButton = document.getElementById('cancelDelete');
            const confirmDeleteButton = document.getElementById('confirmDelete');
            let formToSubmit = null;

            // Function to open the modal
            function openModal(form) {
                deleteModal.style.display = 'block';
                formToSubmit = form;
            }

            // Function to close the modal
            function closeModal() {
                deleteModal.style.display = 'none';
                formToSubmit = null;
                confirmDeleteButton.disabled = false;
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
