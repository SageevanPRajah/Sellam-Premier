<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Print Tickets</title>
    <style>
        /* Set the printed page size to 80mm x 150mm */
        @page {
            size: 80mm 150mm;
            margin: 0;
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .ticket {
            width: 80mm;
            height: 150mm;
            overflow: hidden;
            padding: 5mm;
            border: 1px solid #000;
            box-sizing: border-box;
            page-break-after: always; /* Ensures each ticket prints on a separate page */
            margin: 0 auto;         /* Center the ticket container on the page */
            text-align: center;     /* Center-align text inside the ticket */
        }
        .ticket p {
            margin: 2px 0;
            line-height: 1.2;
        }
        .left-align {
            text-align: left !important;
        }
    </style>
</head>
<body onload="window.print();">
    <!-- Loop through each booking and display its details on a ticket -->
    @foreach ($bookings as $booking)
        <div class="ticket">
            <p style="font-size: 10px; margin: 3px;">DEL LANKA ADVANCED TICKETBOOKING</p>
            <!-- Using the asset() helper to load the logo from the public/icons folder -->
            <img src="{{ asset('icons/name.png') }}" alt="Logo" style="width: 170px; height: auto; margin-bottom: 5px;" />
            <p style="margin: 5px 0;">3D Digital Cinema</p>
            <p style="margin: 5px 0;">Chenkalady, Batticaloa</p>
            <p style="margin: 5px 0;">TP: 065-2240064</p>
            <hr style="border: 1px dashed #000; margin:5px;">
            <p class="left-align" style="font-size: 10px; padding-left:20px; margin:0;">
                Serial #: {{ $booking->id }} - - - - - Issued by: {{ Auth::user()->name }}
            </p>
            <p class="left-align" style="font-size: 10px; padding-left:20px; margin:5px;">
                Date: {{ date('d-M-Y h:i A') }}
            </p>
            <hr style="border: 1px dashed #000; margin:0;">
            <p style="font-size: 14px; margin: 5px;"><strong>Movie Date:</strong> {{ $booking->date }}</p>
            <p style="font-size: 14px; margin: 0;"><strong>Movie Time:</strong> {{ $booking->time }}</p>
            <hr style="border: 1px dashed #000; margin:0;">
            <p style="font-size: 22px; margin: 5px; text-transform: uppercase;">
                <strong>{{ $booking->movie_name }}</strong>
            </p>
            <p style="font-size: 26px; margin: 5px; text-transform: uppercase;">
                <strong>{{ $booking->seat_type }}</strong>
            </p>
            <hr style="border: 1px dashed #000;">
            <p style="font-size: 24px; margin: 0;">SEAT NO: <strong>{{ $booking->seat_no }}</strong> .  .  . PAID</p>
            <hr style="border: 1px dashed #000;">
            <p class="left-align" style="font-size: 10px; margin: 0;"><strong>அறிவித்தல்:</strong></p>
            <p class="left-align" style="font-size: 10px; margin: 0;">
                வெளியில் இருந்து கொண்டுவரும்<br/>
                உணவுப்பண்டங்கள் குளிர்பானங்கள் மதுபானங்கள் <br/>
                அரங்கினுள் கொண்டு வர முற்றாகத் தடை.
            </p>
            <p class="left-align" style="font-size: 10px; margin: 0;">
                குறிப்பிட்ட காட்சிக்கு மட்டுமே<br/>
                இந்த டிக்கட் செல்லுபடியாகும்.
            </p>
            <p class="left-align" style="font-size: 10px; margin: 0;">
                புகைத்தல் முற்றாக தடை செய்யப்பட்டுள்ளது.
            </p>
            <hr style="border: 1px dashed #000;">
            <p style="font-size: 10px; margin:0;">
                Software Developed By : ForcrafTech Solutions(FTS)
            </p>
            <p style="font-size: 10px; margin:0;">076-2646376</p>
        </div>
    @endforeach

    <!-- After printing, automatically redirect to the booking creation page -->
    <script>
        window.onafterprint = function(){
            // Replace with the desired ID. For example, if using the movie id of the first booking:
            var redirectId = "{{ $bookings->first()->movie_id ?? '' }}";
            // If using route names, you can also generate a URL:
            // var redirectUrl = "{{ route('booking.selectSeats', ['id' => $bookings->first()->movie_id]) }}";
            window.location.href = "/booking/create/" + redirectId;
        };
    </script>
</body>
</html>
