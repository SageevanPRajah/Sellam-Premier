<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Seat Price</title>

    <!-- Font Awesome for icons (if needed) -->
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: var(--primary-color);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 3px 3px 9px var(--shadow-dark), -3px -3px 9px var(--shadow-light);
            width: 100%;
            max-width: 600px; /* Set a max width for responsiveness */
            color: var(--text-color);
            margin: 40px 0;
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
            color: var(--text-color);
        }

        .error-messages {
            color: var(--danger-color);
            list-style-type: none;
            margin-bottom: 15px;
        }

        .error-messages li {
            margin-bottom: 5px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: var(--text-color);
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="file"],
        select,
        input[type="submit"] {
            width: 100%;
            padding: 10px 15px;
            border: none;
            border-radius: 20px;
            background-color: var(--secondary-color);
            color: var(--text-color);
            box-shadow: inset 1px 1px 3px var(--shadow-dark), inset -1px -1px 3px var(--shadow-light);
            font-size: 14px;
            margin-bottom: 15px;
            transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
        }

        input[type="text"]::placeholder,
        input[type="number"]::placeholder,
        input[type="date"]::placeholder,
        input[type="file"]::placeholder,
        select::placeholder {
            color: #aaa;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        input[type="file"]:focus,
        select:focus {
            box-shadow: 0 0 10px var(--info-color);
            outline: none;
            background-color: var(--button-hover-color);
        }

        input[type="submit"] {
            background-color: var(--accent-color);
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            border-radius: 30px;
            box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light);
            transition: box-shadow 0.3s, background-color 0.3s, color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #388E3C; /* Darker shade of accent-color */
            box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .current-poster {
            margin-top: 10px;
            text-align: center;
        }

        .current-poster img {
            max-width: 150px;
            border-radius: 10px;
            box-shadow: 3px 3px 10px var(--shadow-dark), -3px -3px 10px var(--shadow-light);
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--secondary-color);
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: var(--primary-color);
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--accent-color);
        }

        input:focus + .slider {
            box-shadow: 0 0 1px var(--accent-color);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Seat Price</h1>
        <div>
            @if ($errors->any())
                <ul class="error-messages">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <form method="post" action="{{ route('price.update', ['price' => $price]) }}" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="seat_type">Seat Type</label>
                <input type="text" name="seat_type" id="seat_type" placeholder="Enter Seat Type"
                    value="{{ $price->seat_type }}" readonly />
            </div>
            <div class="form-group">
                <label for="seat_logo">Seat Logo</label>
                <input type="file" name="seat_logo" id="seat_logo" accept="image/*" />
                <div class="current-poster">
                    <p>Current Seat Logo:</p>
                    <img src="{{ asset('storage/' . $price->seat_logo) }}" alt="Seat Logo" />
                </div>
            </div>

            <div class="form-group">
                <label for="full_price">Full Price</label>
                <input type="text" name="full_price" id="full_price" placeholder="Enter New Full Price"
                    value="{{ $price->full_price }}" required />
            </div>
            <div class="form-group">
                <label for="half_price">Half Price</label>
                <input type="text" name="half_price" id="half_price" placeholder="Enter New Half Price"
                    value="{{ $price->half_price }}" required />
            </div>

            <div class="form-group">
                <label for="active">Active</label>
                <label class="toggle-switch">
                    <!-- Hidden field to handle unchecked state -->
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" name="active" id="active" value="1" {{ $price->active ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>

            <div class="form-group">
                <input type="submit" value="Update the Seat Price" />
            </div>
        </form>
    </div>
</body>

</html>
