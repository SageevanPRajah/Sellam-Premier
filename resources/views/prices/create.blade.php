<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        /* Reset some default styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center;    /* Center vertically */
            height: 100vh;          /* Full viewport height */
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px; /* Set a max width for responsiveness */
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
            color: #343a40;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #495057;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="file"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
            margin-bottom: 15px; /* Add space between inputs */
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        input[type="file"]:focus {
            border-color: #80bdff;
            outline: none;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        ul {
            color: #dc3545;
            list-style-type: none;
            padding: 0;
            margin: 0 0 15px;
        }

        ul li {
            margin-bottom: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .row {
            display: flex;
            gap: 10px;
        }

        .row input {
            flex: 1;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <h1>Ticket Price Create</h1>
        <div>
            @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
            @endif
        </div>
        <div class="form-container">
        <form method="post" action="{{route('price.store')}}" enctype="multipart/form-data" >
        @csrf
        @method('post')    
            <div>
                <label for="seat_type">Seat Type</label>
                <select name="seat_type" id="seat_type">
                    <option value="" disabled selected>Select seat type</option>
                    <option value="Silver">Silver</option>
                    <option value="Gold">Gold</option>
                    <option value="Platinum">Platinum</option>
                </select>
            </div>
            <div class="form-group">
                <label for="seat_logo">Seat Logo</label>
                <input type="file" name="seat_logo" id="seat_logo" accept="image/*" required />
            </div>
            <div>
                <label>Full Price</label>
                <input type="text" name="full_price" placeholder="Enter full_price" />
            </div>
            <div>
                <label>Half Price</label>
                <input type="text" name="half_price" placeholder="Enter half_price" />
            </div>
            <div>
                <input type="submit" value="Save a new Seat Price"/>
            </div>
        </form>
        </div>
        </div>
    </div>

</body>
</html>