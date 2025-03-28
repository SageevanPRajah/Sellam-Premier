<x-app-layout>
    <div class="py-6">
        <div class="container">
            <h1>Edit Billing</h1>
            @if($errors->any())
                <ul class="error-messages">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <form method="post" action="{{ route('billing.update', ['billing' => $billing->id]) }}">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="booking_id">Booking ID</label>
                    <input type="number" name="booking_id" id="booking_id" value="{{ $billing->booking_id }}" readonly>
                </div>
                
                <div class="form-group">
                    <label for="movie_id">Movie ID</label>
                    <input type="number" name="movie_id" id="movie_id" value="{{ $billing->movie_id }}" readonly>
                </div>
                
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
                    <input type="number" name="total_tickets" id="total_tickets" value="{{ $billing->total_tickets }}" required>
                </div>
                
                <div class="form-group">
                    <label for="full_tickets">Full Tickets</label>
                    <input type="number" name="full_tickets" id="full_tickets" value="{{ $billing->full_tickets }}" required>
                </div>
                
                <div class="form-group">
                    <label for="half_tickets">Half Tickets</label>
                    <input type="number" name="half_tickets" id="half_tickets" value="{{ $billing->half_tickets }}" required>
                </div>
                
                <div class="form-group">
                    <label for="total_price">Total Price</label>
                    <input type="text" name="total_price" id="total_price" value="{{ $billing->total_price }}" required>
                </div>
                
                <div class="form-group">
                    <label for="created_at">Created At</label>
                    <input type="date" name="created_at" id="created_at" value="{{ $billing->created_at->format('Y-m-d') }}" disabled>
                </div>
    
                <div class="form-group">
                    <input type="submit" value="Update Billing">
                </div>
            </form>
        </div>

    </div>

    <style>
        /* Similar styling as the provided example */
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: var(--primary-color);
            padding: 20px 40px;
            border-radius: 15px;
            box-shadow: 3px 3px 9px var(--shadow-dark), -3px -3px 9px var(--shadow-light);
            max-width: 600px;
            width: 100%;
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

        input[type="submit"] {
            background-color: var(--accent-color);
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: darken(var(--accent-color), 10%);
        }
    </style>
</x-app-layout>
