@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Billing</h1>
    <p>Movie: {{ $show->movie_name }}</p>
    <p>Date: {{ $show->date }}</p>
    <p>Time: {{ $show->time }}</p>

    <!-- Display total selected tickets -->
    <p>Total Selected Tickets: {{ session('selected_seats_count', 0) }}</p>

    @if ($price) <!-- Check if price is available -->
    <table class="table">
        <thead>
            <tr>
                <th>Seat Type</th>
                <th>Full Price</th>
                <th>Half Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $price->seat_type }}</td>
                <td>Rs:{{ number_format($price->full_price, 2) }}</td>
                <td>Rs:{{ number_format($price->half_price, 2) }}</td>
            </tr>
        </tbody>
    </table>
    @else
    <p>No price information available.</p>
    @endif

    <div>
        <h3>Calculate Ticket Price</h3>
        <p>Total Tickets: <span id="total-tickets">{{ session('selected_seats_count', 0) }}</span></p>
        <div>
            <label>Full Tickets:</label>
            <input type="number" id="full-tickets" value="{{ session('selected_seats_count', 0) }}" min="0" max="{{ session('selected_seats_count', 0) }}">
        </div>
        <div>
            <label>Half Tickets:</label>
            <input type="number" id="half-tickets" value="0" min="0" max="{{ session('selected_seats_count', 0) }}">
        </div>
        <p>Total Price: Rs:<span id="total-price">0.00</span></p>
        <button class="button" id="confirm-payment">Confirm Payment</button>
    </div>
</div>

<script>
    const price = @json($price); // Single price object from the server
    const fullTicketsInput = document.getElementById('full-tickets');
    const halfTicketsInput = document.getElementById('half-tickets');
    const totalPriceEl = document.getElementById('total-price');
    const totalTicketsEl = document.getElementById('total-tickets');

    const totalTickets = parseInt({{ session('selected_seats_count', 0) }}); // Total selected seats from session
    let remainingFullTickets = totalTickets; // Initially, all tickets are full tickets

    totalTicketsEl.textContent = totalTickets;

    function calculateTotal() {
        const halfTickets = parseInt(halfTicketsInput.value) || 0;

        if (halfTickets > totalTickets) {
            halfTicketsInput.value = totalTickets;
            remainingFullTickets = 0;
        } else {
            remainingFullTickets = totalTickets - halfTickets;
        }

        fullTicketsInput.value = remainingFullTickets;

        if (price) {
            const fullPrice = parseFloat(price.full_price) || 0;
            const halfPrice = parseFloat(price.half_price) || 0;

            const totalPrice = (remainingFullTickets * fullPrice) + (halfTickets * halfPrice);
            totalPriceEl.textContent = totalPrice.toFixed(2);
        } else {
            console.error("Price object is not available.");
            totalPriceEl.textContent = "0.00";
        }
    }

    // Event listeners for dynamic updates
    halfTicketsInput.addEventListener('input', calculateTotal);
    calculateTotal(); // Initial calculation
</script>
@endsection
