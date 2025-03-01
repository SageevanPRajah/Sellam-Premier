<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Print Tickets</title>
    <link href="https://fonts.googleapis.com/css2?family=Meera+Inimai&display=swap" rel="stylesheet">
    <style>
        @page {
            size: 80mm 115mm;
            margin: 0;
        }
        body {
            margin: 0;
            font-family: Cambria, Arial, sans-serif;
            font-size: 12px;
        }
        .ticket {
            width: 80mm;
            overflow: hidden;
            box-sizing: border-box;
            page-break-after: always; /* Ensures each ticket prints separately */
            margin: 0 auto;
            text-align: center;
            padding: 5px;
        }
        .ticket p {
            margin: 2px 0;
            line-height: 1.2;
        }
        .left-align {
            text-align: left !important;
            padding-left: 10px;
        }
        .dashed-line {
            border: 1px dashed #000;
            margin: 5px 0;
        }
        /* Apply Meera Inimai font only for Tamil text */
        .tamil-text {
            font-family: 'Meera Inimai', sans-serif;
        }
        .bold {
            font-weight: bold;
        }
        .ticket img {
            width: 180px;
            height: auto;
            margin-bottom: 0;
        }
        .movie-details {
            font-size: 14px;
        }
        .movie-title {
            font-size: 22px;
            text-transform: uppercase;
            margin: 5px 0;
        }
        .seat-info {
            font-size: 20px;
            margin: 5px 0;
        }
    </style>
</head>
<body onload="window.print();">

    @foreach ($bookings as $booking)
    <div class="ticket">
        <img src="{{ asset('icons/name.png') }}" alt="Logo">
        
        <p class="bold">
            3D DIGITAL CINEMA <br>
            CHENKALADY, BATTICALOA <br>
            TP: 065-2240064
        </p>

        <hr class="dashed-line">

        <p class="left-align">
            <span class="bold">Serial #:</span> {{ $booking->id }} &emsp; <span class="bold"> Issued by:</span> {{ Auth::user()->name }} 
            <br>
            <span class="bold">Date:</span> {{ date('d-M-Y h:i A') }}
        </p>

        <hr class="dashed-line">

        <p class="left-align movie-details">
            <span class="bold">Movie Date:</span> {{ $booking->date }} <br>
            <span class="bold">Movie Time:</span> {{ $booking->time }}
        </p>

        <hr class="dashed-line">

        <p class="movie-title bold">
            {{ $booking->movie_name }} <br>
            {{ $booking->seat_type }}
        </p>

        <hr class="dashed-line">

        <p class="seat-info bold">
            SEAT NO: {{ $booking->seat_no }} &emsp; PAID
        </p>

        <hr class="dashed-line">

        <p class="left-align tamil-text bold">
            அறிவித்தல்: <br>
            வெளியில் இருந்து கொண்டுவரும் உணவுப்பண்டங்கள்,
            குளிர்பானங்கள், மதுபானங்கள் 
            அரங்கினுள் கொண்டு வர முற்றாகத் தடை. <br>
            குறிப்பிட்ட காட்சிக்கு மட்டுமே இந்த டிக்கட் செல்லுபடியாகும். <br>
            புகைத்தல் முற்றாக தடை செய்யப்பட்டுள்ளது.
        </p>

        <hr class="dashed-line">

        <p style="font-size: 10px; margin:0;">
            Developed By: ForcrafTech Solutions (FTS) | 076-2646376
        </p>
    </div>
    @endforeach

    <!-- After printing, redirect to booking creation -->
    <script>
        setTimeout(function() {
            var redirectId = "{{ $bookings->first()->movie_id ?? '' }}";
            window.location.href = "/booking/create/" + redirectId;
        }, 2000);
    </script>

</body>
</html>
