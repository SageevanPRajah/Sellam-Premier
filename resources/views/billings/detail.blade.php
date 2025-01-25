<x-app-layout>
    <div class="container">
        <h1>Edit Billing</h1>

        @if($errors->any())
            <ul class="error-messages">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <!-- Display billing details -->
        <form method="post" action="">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="movie_name">Movie Name</label>
                <input type="text" name="movie_name" id="movie_name" value="{{ $billing->movie_name }}" readonly>
            </div>
            
            <div class="form-group">
                <label for="seat_type">Seat Type</label>
                <input type="text" name="seat_type" id="seat_type" value="{{ $billing->seat_type }}" readonly>
            </div>
            
            <div class="form-group">
                <label for="total_tickets">Total Tickets</label>
                <input type="number" name="total_tickets" id="total_tickets" value="{{ $billing->total_tickets }}" readonly>
            </div>
            
            <div class="form-group">
                <label for="full_tickets">Full Tickets</label>
                <input type="number" name="full_tickets" id="full_tickets" value="{{ $billing->full_tickets }}" readonly>
            </div>
            
            <div class="form-group">
                <label for="half_tickets">Half Tickets</label>
                <input type="number" name="half_tickets" id="half_tickets" value="{{ $billing->half_tickets }}" readonly>
            </div>
            
            <div class="form-group">
                <label for="total_price">Total Price</label>
                <input type="text" name="total_price" id="total_price" value="{{ $billing->total_price }}" readonly>
            </div>
            
            <div class="form-group">
                <label for="created_at">Created At</label>
                <input type="date" name="created_at" id="created_at" value="{{ $billing->created_at->format('Y-m-d') }}" disabled>
            </div>
        </form>

        <!-- Edit Button -->
        <form method="GET" action="{{ route('billing.edit', $billing->id) }}" style="display:inline;">
            <button type="submit" class="action-button btn-edit">
                Edit
            </button>
        </form>

        <!-- Delete Button -->
        <form method="POST" action="{{ route('billing.destroy', $billing->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="action-button btn-delete">
                Delete
            </button>
        </form>
    </div>

    <style>
        :root {
            --background-color: #121212;
            --primary-color: #1e1e1e;
            --secondary-color: #2e2e2e;
            --text-color: #e0e0e0;
            --accent-color: #4CAF50;
            --danger-color: #FF5555;
            --shadow-light: #2b2b2b;
            --shadow-dark: #0c0c0c;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .container {
            background-color: var(--primary-color);
            padding: 20px 40px;
            border-radius: 15px;
            box-shadow: 3px 3px 9px var(--shadow-dark), -3px -3px 9px var(--shadow-light);
            max-width: 600px;
            width: 100%;
            margin: 20px auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .error-messages {
            color: var(--danger-color);
            list-style-type: none;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: var(--secondary-color);
            color: var(--text-color);
        }

        .action-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .btn-edit {
            background-color: var(--accent-color);
            color: white;
        }

        .btn-delete {
            background-color: var(--danger-color);
            color: white;
        }

        .action-button:hover {
            opacity: 0.9;
        }
    </style>
</x-app-layout>
