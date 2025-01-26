<x-app-layout>
    <div class="billing-page-container"
         style="max-width: 800px; margin: 0 auto; padding: 2rem; background-color: #f7f7f7; border-radius: 8px;">

        <!-- Page Title -->
        <h1 style="text-align: center; font-weight: bold; font-size:20px; margin-bottom: 1rem;">
            Billing
        </h1>

        <!-- Success Message -->
        @if(session()->has('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                   style="border-collapse: collapse; table-layout: fixed; width: 100%; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
                <thead style="background-color: #e2e2e2;">
                <tr>
                    <th style="padding: 0.75rem;">Seat Type</th>
                    <th style="padding: 0.75rem;">Full Price</th>
                    <th style="padding: 0.75rem;">Half Price</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="padding: 0.75rem; text-align: center;">{{ $price->seat_type }}</td>
                    <td style="padding: 0.75rem; text-align: center;">Rs:{{ number_format($price->full_price, 2) }}</td>
                    <td style="padding: 0.75rem; text-align: center;">Rs:{{ number_format($price->half_price, 2) }}</td>
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

            <!-- Full Tickets -->
            <div style="margin-bottom: 1rem;">
                <label style="display: inline-block; width: 100px;">Full Tickets:</label>
                <input type="number"
                       id="full-tickets"
                       value="{{ session('selected_seats_count', 0) }}"
                       min="0"
                       max="{{ session('selected_seats_count', 0) }}"
                       style="width: 60px; padding: 0.2rem;">
            </div>

            <!-- Half Tickets -->
            <div style="margin-bottom: 1rem;">
                <label style="display: inline-block; width: 100px;">Half Tickets:</label>
                <input type="number"
                       id="half-tickets"
                       value="0"
                       min="0"
                       max="{{ session('selected_seats_count', 0) }}"
                       style="width: 60px; padding: 0.2rem;">
            </div>

            <!-- Total Price -->
            <p style="margin-top: 1rem; margin-bottom: 20px;">
                <strong>
                    Total Price: Rs:
                    <span id="total-price">0.00</span>
                </strong>
            </p>

            <!-- Payment Button -->
            <form action="{{ route('billing.store') }}" method="POST">
                @csrf
                <input type="hidden" name="booking_id" value="{{ session('created_booking_ids')[0] ?? '' }}">
                <input type="hidden" name="movie_id" value="{{ $show->id }}">
                <input type="hidden" name="movie_name" value="{{ $show->movie_name }}">
                <input type="hidden" name="date" value="{{ $show->date }}">
                <input type="hidden" name="time" value="{{ $show->time }}">
                <input type="hidden" name="seat_type" value="{{ $price->seat_type }}">
                <input type="hidden" name="total_tickets" value="{{ session('selected_seats_count', 0) }}">
                <input type="hidden" id="full-tickets-input" name="full_tickets" value="0">
                <input type="hidden" id="half-tickets-input" name="half_tickets" value="0">
                <input type="hidden" id="total-price-input" name="total_price" value="0">

                <button type="submit" class="button"
                        style="background-color: #da2323; color: #fff; padding: 0.5rem 1rem; border: none; border-radius: 4px;">
                    Confirm Payment
                </button>
            </form>
        </div>

        <!-- Print Tickets Button -->
        <button id="print-button" class="button"
                style="background-color: #2323da; color: #fff; padding: 0.5rem 1rem; border: none; border-radius: 4px;">
            Print Tickets
        </button>

        <!-- Toggle Reprint Section -->
        <button id="toggle-reprint"
                style="background-color: #007bff; color: #fff; padding: 0.5rem 1rem; border: none; border-radius: 4px; margin-top: 1.5rem;">
            Show Reprint Options
        </button>

        <!-- Reprint Options -->
        <div id="reprint-options" style="display: none; margin-top: 1.5rem;">
            @foreach(session('created_booking_ids', []) as $bookingId)
                @php $booking = \App\Models\Booking::find($bookingId); @endphp
                @if($booking)
                    <div class="ticket-preview" style="margin-bottom: 1rem; border: 1px solid #ccc; padding: 1rem;">
                        <p><strong>Movie:</strong> {{ $booking->movie_name }}</p>
                        <p><strong>Seat:</strong> {{ $booking->seat_no }}</p>
                        <button class="reprint-button" data-booking-id="{{ $booking->id }}"
                                style="background-color: #dace23; color: #fff; padding: 0.5rem 1rem; border: none; border-radius: 4px;">
                            Re-Print
                        </button>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Price Calculation Script -->
    <script>
        const price = @json($price);
        const fullTicketsInput = document.getElementById('full-tickets');
        const halfTicketsInput = document.getElementById('half-tickets');
        const totalPriceEl = document.getElementById('total-price');
        const fullTicketsHiddenInput = document.getElementById('full-tickets-input');
        const halfTicketsHiddenInput = document.getElementById('half-tickets-input');
        const totalPriceHiddenInput = document.getElementById('total-price-input');

        function updateHiddenInputs() {
            fullTicketsHiddenInput.value = fullTicketsInput.value;
            halfTicketsHiddenInput.value = halfTicketsInput.value;
            totalPriceHiddenInput.value = parseFloat(totalPriceEl.textContent);
        }

        function calculateTotal() {
            const totalTickets = parseInt({{ session('selected_seats_count', 0) }});
            const halfTickets = parseInt(halfTicketsInput.value) || 0;

            let remainingFullTickets = totalTickets - halfTickets;
            if (remainingFullTickets < 0) {
                remainingFullTickets = 0;
                halfTicketsInput.value = totalTickets;
            }
            fullTicketsInput.value = remainingFullTickets;

            if (price) {
                const fullPrice = parseFloat(price.full_price) || 0;
                const halfPrice = parseFloat(price.half_price) || 0;
                const totalPrice = (remainingFullTickets * fullPrice) + (halfTickets * halfPrice);
                totalPriceEl.textContent = totalPrice.toFixed(2);
            } else {
                console.error('Price object is not available.');
                totalPriceEl.textContent = '0.00';
            }
            updateHiddenInputs();
        }

        // Recalculate on input changes
        fullTicketsInput.addEventListener('input', calculateTotal);
        halfTicketsInput.addEventListener('input', calculateTotal);
        // Initial
        calculateTotal();

         
    </script>

    <!-- QZ Tray Script -->
    <script src="/js/qz-tray.js"></script>
    <script>
        // Setup QZ Tray
        qz.api.setCertificatePromise(function(resolve) {
            resolve(`-----BEGIN CERTIFICATE-----

-----END CERTIFICATE-----`);
        });

        qz.api.setSignaturePromise(function(toSign) {
            return function(resolve, reject) {
                const pk = `-----BEGIN PRIVATE KEY-----

-----END PRIVATE KEY-----`;
                const sig = signData(toSign, pk);
                resolve(sig);
            };
        });

        // Connect to QZ
        async function connectQZ() {
            if (!qz.websocket.isActive()) {
                await qz.websocket.connect();
            }
        }

        // Single or multiple tickets printing
        async function printTicket(ticket) {
            try {
                // Build raw text or ESC/POS data
                const printData = [
                    { type: 'raw', format: 'plain', data: `\nDEL LANKA ADVANCED TICKETBOOKING\n` },
                    { type: 'raw', format: 'plain', data: `Sellam Premier\n` },
                    { type: 'raw', format: 'plain', data: `Movie: ${ticket.movie_name}\n` },
                    { type: 'raw', format: 'plain', data: `Date: ${ticket.date}\nTime: ${ticket.time}\n` },
                    { type: 'raw', format: 'plain', data: `Seat: ${ticket.seat_no}\n` },
                    { type: 'raw', format: 'plain', data: `--------------------------\n` },
                ];

                const config = qz.configs.create('USB_Printer_Name', { copies: 1 });
                await connectQZ();
                await qz.print(config, printData);
                console.log('Ticket printed successfully!');
            } catch (err) {
                console.error('Failed to print ticket:', err);
                alert('Failed to print ticket.');
            }
        }

        // Print newly purchased seats
        document.getElementById('print-button').addEventListener('click', async () => {
            try {
                const bookingIds = '{{ implode(',', session('created_booking_ids', [])) }}';
                if (!bookingIds) {
                    alert('No booking IDs found.');
                    return;
                }

                const response = await fetch(`/generate-tickets/${bookingIds}`);
                const data = await response.json();

                if (response.ok && data.success) {
                    for (const ticket of data.tickets) {
                        await printTicket(ticket);
                    }
                    alert('All tickets printed!');
                } else {
                    alert('Failed to fetch tickets data.');
                }
            } catch (err) {
                console.error('Error fetching tickets:', err);
                alert('Failed to print tickets.');
            }
        });

         // QZ Tray Configurations
         const toggleReprint = document.getElementById('toggle-reprint');
        const reprintOptions = document.getElementById('reprint-options');

        toggleReprint.addEventListener('click', function () {
            reprintOptions.style.display = reprintOptions.style.display === 'none' ? 'block' : 'none';
            toggleReprint.textContent = reprintOptions.style.display === 'block' ? 'Hide Reprint Options' : 'Show Reprint Options';
        });

        // Reprint existing seats
        document.querySelectorAll('.reprint-button').forEach(button => {
            button.addEventListener('click', async function () {
                const bookingId = this.getAttribute('data-booking-id');
                try {
                    const response = await fetch(`/generate-tickets/${bookingIds}`);
                    const data = await response.json();
                    if (response.ok && data.success) {
                        for (const ticket of data.tickets) {
                            await printTicket(ticket);
                        }
                        alert('Reprint done!');
                    } else {
                        alert('Failed to fetch ticket data for reprint.');
                    }
                } catch (err) {
                    console.error('Reprint error:', err);
                    alert('Failed to reprint ticket.');
                }
            });
        });
    </script>
</x-app-layout>
