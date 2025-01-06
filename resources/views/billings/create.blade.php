@extends('layouts.app')

@section('content')
    <div class="billing-page-container"
         style="max-width: 800px; margin: 0 auto; padding: 2rem; background-color: #f7f7f7; border-radius: 8px;">

        <!-- Page Title -->
        <h1 style="text-align: center; font-weight: bold;font-size:20px; margin-bottom: 1rem;">
            Billing
        </h1>

        <!-- Movie Information & Poster -->
        <div style="display: flex; gap: 1rem; background-color: #ffffff; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            
            <!-- Poster Column (30%) -->
            <div style="flex: 0 0 30%; text-align: center;">
                <img src="{{ $show->poster ? asset('storage/' . $show->poster) : asset('images/default-poster.jpg') }}"
                     alt="Poster"
                     style="max-width: 100%; height: auto; border-radius: 10px;">
            </div>
            
            <!-- Movie Info Column (70%) -->
            <div style="flex: 1; margin-top: 4rem; margin-left: 2rem;">
                <p><strong>Movie:</strong> {{ $show->movie_name }}</p>
                <p><strong>Date:</strong> {{ $show->date }}</p>
                <p><strong>Time:</strong> {{ $show->time }}</p>
                <p><strong>Total Selected Tickets:</strong> {{ session('selected_seats_count', 0) }}</p>
            </div>
        </div>

        <!-- Price Information -->
        @if ($price)
        <table class="table"
        style="border-collapse: collapse;
               table-layout: fixed;
               width: 100%;
               background-color: #ffffff;
               border-radius: 8px;
               overflow: hidden;">
     <thead style="background-color: #e2e2e2;">
         <tr>
             <th style="padding: 0.75rem; border: 0px solid #ccc; ">Seat Type</th>
             <th style="padding: 0.75rem; border: 0px solid #ccc; ">Full Price</th>
             <th style="padding: 0.75rem; border: 0px solid #ccc; ">Half Price</th>
         </tr>
     </thead>
     <tbody>
         <tr>
             <td style="padding: 0.75rem; border: 0px solid #ccc; text-align: center;">
                 {{ $price->seat_type }}
             </td>
             <td style="padding: 0.75rem; border: 0px solid #ccc; text-align: center;">
                 Rs:{{ number_format($price->full_price, 2) }}
             </td>
             <td style="padding: 0.75rem; border: 0px solid #ccc; text-align: center;">
                 Rs:{{ number_format($price->half_price, 2) }}
             </td>
         </tr>
     </tbody>
 </table>
 
        @else
            <div style="background-color: #ffffff; padding: 1rem; border-radius: 8px; margin-top: 1rem;">
                <p>No price information available.</p>
            </div>
        @endif

        <!-- Ticket Price Calculation -->
        <div style="background-color: #ffffff; padding: 1rem; border-radius: 8px; margin-top: 1.5rem;">
            <h3 style="margin-bottom: 10px;">Calculate Ticket Price</h3>
            <p style="margin-bottom: 10px;">
                Total Tickets:
                <span id="total-tickets">{{ session('selected_seats_count', 0) }}</span>
            </p>

            <div style="margin-bottom: 1rem;">
                <label style="display: inline-block; width: 100px;">Full Tickets:</label>
                <input type="number"
                       id="full-tickets"
                       value="{{ session('selected_seats_count', 0) }}"
                       min="0"
                       max="{{ session('selected_seats_count', 0) }}"
                       style="width: 60px; padding: 0.2rem;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: inline-block; width: 100px;">Half Tickets:</label>
                <input type="number"
                       id="half-tickets"
                       value="0"
                       min="0"
                       max="{{ session('selected_seats_count', 0) }}"
                       style="width: 60px; padding: 0.2rem;">
            </div>

            <p style="margin-top: 1rem; margin-bottom: 20px;">
                <strong>
                    Total Price: Rs:
                    <span id="total-price">0.00</span>
                </strong>
            </p>

            <!-- Payment Button -->
            <button class="button"
                    id="confirm-payment"
                    style="background-color: #da2323; color: #fff; padding: 0.5rem 1rem; border: none; border-radius: 4px;">
                Confirm Payment
            </button>
        </div>
    </div>

    <script>
        const price = @json($price);
        const fullTicketsInput = document.getElementById('full-tickets');
        const halfTicketsInput = document.getElementById('half-tickets');
        const totalPriceEl = document.getElementById('total-price');
        const totalTicketsEl = document.getElementById('total-tickets');

        // Retrieve total selected seats from session
        const totalTickets = parseInt({{ session('selected_seats_count', 0) }});
        let remainingFullTickets = totalTickets;

        totalTicketsEl.textContent = totalTickets;

        function calculateTotal() {
            const halfTickets = parseInt(halfTicketsInput.value) || 0;

            // Ensure we don't exceed total tickets
            if (halfTickets > totalTickets) {
                halfTicketsInput.value = totalTickets;
                remainingFullTickets = 0;
            } else {
                remainingFullTickets = totalTickets - halfTickets;
            }

            // Reflect the full tickets count in the fullTicketsInput
            fullTicketsInput.value = remainingFullTickets;

            if (price) {
                // Calculate total price
                const fullPrice = parseFloat(price.full_price) || 0;
                const halfPrice = parseFloat(price.half_price) || 0;
                const totalPrice = (remainingFullTickets * fullPrice) + (halfTickets * halfPrice);
                totalPriceEl.textContent = totalPrice.toFixed(2);
            } else {
                console.error("Price object is not available.");
                totalPriceEl.textContent = "0.00";
            }
        }

        // Update price whenever half tickets change
        halfTicketsInput.addEventListener('input', calculateTotal);

        // Initial calculation
        calculateTotal();
    </script>
@endsection
