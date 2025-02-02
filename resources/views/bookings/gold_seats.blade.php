<x-app-layout>
    <div class="booking-container">
        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Top Section: Seat Type Buttons & Movie Info -->
        <div class="top-section">


            <!-- Movie Details on the Right -->
            <div class="movie-details">
                <div>
                    <label>Date:</label>
                    <span>{{ $show->date }}</span>
                </div>
                <div>
                    <label>Time:</label>
                    <span>{{ $show->time }}</span>
                </div>
                <div>
                    <label>Movie:</label>
                    <span>{{ $show->movie_name }}</span>
                </div>
            </div>


        </div>

        <!-- Seat Type Selection -->
        <div class="seat-types">
            <a href="{{ url('/booking/create/clone/' . $show->id) }}" class="button silver-btn ">Silver</a>
            <a href="{{ url('/booking/create/gold/' . $show->id) }}" class="button gold-btn">Gold</a>
            <a href="{{ url('/booking/create/platinum/' . $show->id) }}" class="button platinum-btn">Platinum</a>
        </div>

        <!-- Theater Layout on the right side -->
        <div class="theater-layout-wrapper">
            <div id="theater-layout">

                <!-- GOLD Section (hidden by default) -->
                <div class="seat-type-layout-section" id="gold-layout">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="14">SCREEN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SL</td>
                                <td><button class="seat available" data-seat-code="G-SL-1">SL1</button></td>
                                <td><button class="seat available" data-seat-code="G-SL-2">SL2</button></td>
                                <td><button class="seat available" data-seat-code="G-SL-3">SL3</button></td>
                                <td><button class="seat available" data-seat-code="G-SL-4">SL4</button></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-SR-5">SR5</button></td>
                                <td><button class="seat available" data-seat-code="G-SR-6">SR6</button></td>
                                <td><button class="seat available" data-seat-code="G-SR-7">SR7</button></td>
                                <td><button class="seat available" data-seat-code="G-SR-8">SR8</button></td>
                                <td><button class="seat available" data-seat-code="G-SR-9">SR9</button></td>
                                <td><button class="seat available" data-seat-code="G-SR-10">SR10</button></td>
                                <td>SR</td>
                            </tr>
                            <tr>
                                <td>RL</td>
                                <td><button class="seat available" data-seat-code="G-RL-1">RL1</button></td>
                                <td><button class="seat available" data-seat-code="G-RL-2">RL2</button></td>
                                <td><button class="seat available" data-seat-code="G-RL-3">RL3</button></td>
                                <td><button class="seat available" data-seat-code="G-RL-4">RL4</button></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-RR-5">RR5</button></td>
                                <td><button class="seat available" data-seat-code="G-RR-6">RR6</button></td>
                                <td><button class="seat available" data-seat-code="G-RR-7">RR7</button></td>
                                <td><button class="seat available" data-seat-code="G-RR-8">RR8</button></td>
                                <td><button class="seat available" data-seat-code="G-RR-9">RR9</button></td>
                                <td><button class="seat available" data-seat-code="G-RR-10">RR10</button></td>
                                <td>RR</td>
                            </tr>
                            <tr>
                                <td>QL</td>
                                <td><button class="seat available" data-seat-code="G-QL-1">QL1</button></td>
                                <td><button class="seat available" data-seat-code="G-QL-2">QL2</button></td>
                                <td><button class="seat available" data-seat-code="G-QL-3">QL3</button></td>
                                <td><button class="seat available" data-seat-code="G-QL-4">QL4</button></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-QR-5">QR5</button></td>
                                <td><button class="seat available" data-seat-code="G-QR-6">QR6</button></td>
                                <td><button class="seat available" data-seat-code="G-QR-7">QR7</button></td>
                                <td><button class="seat available" data-seat-code="G-QR-8">QR8</button></td>
                                <td><button class="seat available" data-seat-code="G-QR-9">QR9</button></td>
                                <td><button class="seat available" data-seat-code="G-QR-10">QR10</button></td>
                                <td>QR</td>
                            </tr>
                            <tr>
                                <td>PL</td>
                                <td><button class="seat available" data-seat-code="G-PL-1">PL1</button></td>
                                <td><button class="seat available" data-seat-code="G-PL-2">PL2</button></td>
                                <td><button class="seat available" data-seat-code="G-PL-3">PL3</button></td>
                                <td><button class="seat available" data-seat-code="G-PL-4">PL4</button></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-PR-5">PR5</button></td>
                                <td><button class="seat available" data-seat-code="G-PR-6">PR6</button></td>
                                <td><button class="seat available" data-seat-code="G-PR-7">PR7</button></td>
                                <td><button class="seat available" data-seat-code="G-PR-8">PR8</button></td>
                                <td><button class="seat available" data-seat-code="G-PR-9">PR9</button></td>
                                <td><button class="seat available" data-seat-code="G-PR-10">PR10</button></td>
                                <td>PR</td>
                            </tr>
                            <tr>
                                <td>OL</td>
                                <td><button class="seat available" data-seat-code="G-OL-1">OL1</button></td>
                                <td><button class="seat available" data-seat-code="G-OL-2">OL2</button></td>
                                <td><button class="seat available" data-seat-code="G-OL-3">OL3</button></td>
                                <td><button class="seat available" data-seat-code="G-OL-4">OL4</button></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-OR-5">OR5</button></td>
                                <td><button class="seat available" data-seat-code="G-OR-6">OR6</button></td>
                                <td><button class="seat available" data-seat-code="G-OR-7">OR7</button></td>
                                <td><button class="seat available" data-seat-code="G-OR-8">OR8</button></td>
                                <td><button class="seat available" data-seat-code="G-OR-9">OR9</button></td>
                                <td><button class="seat available" data-seat-code="G-OR-10">OR10</button></td>
                                <td>OR</td>
                            </tr>
                            <tr>
                                <td>NL</td>
                                <td><button class="seat available" data-seat-code="G-NL-1">NL1</button></td>
                                <td><button class="seat available" data-seat-code="G-NL-2">NL2</button></td>
                                <td><button class="seat available" data-seat-code="G-NL-3">NL3</button></td>
                                <td><button class="seat available" data-seat-code="G-NL-4">NL4</button></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-NR-5">NR5</button></td>
                                <td><button class="seat available" data-seat-code="G-NR-6">NR6</button></td>
                                <td><button class="seat available" data-seat-code="G-NR-7">NR7</button></td>
                                <td><button class="seat available" data-seat-code="G-NR-8">NR8</button></td>
                                <td><button class="seat available" data-seat-code="G-NR-9">NR9</button></td>
                                <td><button class="seat available" data-seat-code="G-NR-10">NR10</button></td>
                                <td>NR</td>
                            </tr>
                            <tr>
                                <td>ML</td>
                                <td><button class="seat available" data-seat-code="G-ML-1">ML1</button></td>
                                <td><button class="seat available" data-seat-code="G-ML-2">ML2</button></td>
                                <td><button class="seat available" data-seat-code="G-ML-3">ML3</button></td>
                                <td><button class="seat available" data-seat-code="G-ML-4">ML4</button></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-MR-5">MR5</button></td>
                                <td><button class="seat available" data-seat-code="G-MR-6">MR6</button></td>
                                <td><button class="seat available" data-seat-code="G-MR-7">MR7</button></td>
                                <td><button class="seat available" data-seat-code="G-MR-8">MR8</button></td>
                                <td><button class="seat available" data-seat-code="G-MR-9">MR9</button></td>
                                <td><button class="seat available" data-seat-code="G-MR-10">MR10</button></td>
                                <td>MR</td>
                            </tr>
                            <tr>
                                <td>LL</td>
                                <td><button class="seat available" data-seat-code="G-LL-1">LL1</button></td>
                                <td><button class="seat available" data-seat-code="G-LL-2">LL2</button></td>
                                <td><button class="seat available" data-seat-code="G-LL-3">LL3</button></td>
                                <td><button class="seat available" data-seat-code="G-LL-4">LL4</button></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-LR-5">LR5</button></td>
                                <td><button class="seat available" data-seat-code="G-LR-6">LR6</button></td>
                                <td><button class="seat available" data-seat-code="G-LR-7">LR7</button></td>
                                <td><button class="seat available" data-seat-code="G-LR-8">LR8</button></td>
                                <td><button class="seat available" data-seat-code="G-LR-9">LR9</button></td>
                                <td><button class="seat available" data-seat-code="G-LR-10">LR10</button></td>
                                <td>LR</td>
                            </tr>
                            <tr>
                                <td>KL</td>
                                <td><button class="seat available" data-seat-code="G-KL-1">KL1</button></td>
                                <td><button class="seat available" data-seat-code="G-KL-2">KL2</button></td>
                                <td><button class="seat available" data-seat-code="G-KL-3">KL3</button></td>
                                <td><button class="seat available" data-seat-code="G-KL-4">KL4</button></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-KR-5">KR5</button></td>
                                <td><button class="seat available" data-seat-code="G-KR-6">KR6</button></td>
                                <td><button class="seat available" data-seat-code="G-KR-7">KR7</button></td>
                                <td><button class="seat available" data-seat-code="G-KR-8">KR8</button></td>
                                <td><button class="seat available" data-seat-code="G-KR-9">KR9</button></td>
                                <td><button class="seat available" data-seat-code="G-KR-10">KR10</button></td>
                                <td>KR</td>
                            </tr>
                            <tr>
                                <td>JL</td>
                                <td><button class="seat available" data-seat-code="G-JL-1">JL1</button></td>
                                <td><button class="seat available" data-seat-code="G-JL-2">JL2</button></td>
                                <td><button class="seat available" data-seat-code="G-JL-3">JL3</button></td>
                                <td><button class="seat available" data-seat-code="G-JL-4">JL4</button></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-JR-5">JR5</button></td>
                                <td><button class="seat available" data-seat-code="G-JR-6">JR6</button></td>
                                <td><button class="seat available" data-seat-code="G-JR-7">JR7</button></td>
                                <td><button class="seat available" data-seat-code="G-JR-8">JR8</button></td>
                                <td><button class="seat available" data-seat-code="G-JR-9">JR9</button></td>
                                <td><button class="seat available" data-seat-code="G-JR-10">JR10</button></td>
                                <td>JR</td>
                            </tr>
                            <tr>
                                <td>IL</td>
                                <td><button class="seat available" data-seat-code="G-IL-1">IL1</button></td>
                                <td><button class="seat available" data-seat-code="G-IL-2">IL2</button></td>
                                <td><button class="seat available" data-seat-code="G-IL-3">IL3</button></td>
                                <td><button class="seat available" data-seat-code="G-IL-4">IL4</button></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-IR-5">IR5</button></td>
                                <td><button class="seat available" data-seat-code="G-IR-6">IR6</button></td>
                                <td><button class="seat available" data-seat-code="G-IR-7">IR7</button></td>
                                <td><button class="seat available" data-seat-code="G-IR-8">IR8</button></td>
                                <td><button class="seat available" data-seat-code="G-IR-9">IR9</button></td>
                                <td><button class="seat available" data-seat-code="G-IR-10">IR10</button></td>
                                <td>IR</td>
                            </tr>
                            <tr>
                                <td>HL</td>
                                <td><button class="seat available" data-seat-code="G-HL-1">HL1</button></td>
                                <td><button class="seat available" data-seat-code="G-HL-2">HL2</button></td>
                                <td><button class="seat available" data-seat-code="G-HL-3">HL3</button></td>
                                <td><button class="seat available" data-seat-code="G-HL-4">HL4</button></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-HR-5">HR5</button></td>
                                <td><button class="seat available" data-seat-code="G-HR-6">HR6</button></td>
                                <td><button class="seat available" data-seat-code="G-HR-7">HR7</button></td>
                                <td><button class="seat available" data-seat-code="G-HR-8">HR8</button></td>
                                <td><button class="seat available" data-seat-code="G-HR-9">HR9</button></td>
                                <td><button class="seat available" data-seat-code="G-HR-10">HR10</button></td>
                                <td>HR</td>
                            </tr>
                            <tr>
                                <td>GL</td>
                                <td><button class="seat available" data-seat-code="G-GL-1">GL1</button></td>
                                <td><button class="seat available" data-seat-code="G-GL-2">GL2</button></td>
                                <td><button class="seat available" data-seat-code="G-GL-3">GL3</button></td>
                                <td><button class="seat available" data-seat-code="G-GL-4">GL4</button></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-GR-5">GR5</button></td>
                                <td><button class="seat available" data-seat-code="G-GR-6">GR6</button></td>
                                <td><button class="seat available" data-seat-code="G-GR-7">GR7</button></td>
                                <td><button class="seat available" data-seat-code="G-GR-8">GR8</button></td>
                                <td><button class="seat available" data-seat-code="G-GR-9">GR9</button></td>
                                <td><button class="seat available" data-seat-code="G-GR-10">GR10</button></td>
                                <td>GR</td>
                            </tr>
                            <tr>
                                <td>FL</td>
                                <td><button class="seat available" data-seat-code="G-FL-1">FL1</button></td>
                                <td><button class="seat available" data-seat-code="G-FL-2">FL2</button></td>
                                <td><button class="seat available" data-seat-code="G-FL-3">FL3</button></td>
                                <td><button class="seat available" data-seat-code="G-FL-4">FL4</button></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-FR-5">FR5</button></td>
                                <td><button class="seat available" data-seat-code="G-FR-6">FR6</button></td>
                                <td><button class="seat available" data-seat-code="G-FR-7">FR7</button></td>
                                <td><button class="seat available" data-seat-code="G-FR-8">FR8</button></td>
                                <td><button class="seat available" data-seat-code="G-FR-9">FR9</button></td>
                                <td><button class="seat available" data-seat-code="G-FR-10">FR10</button></td>
                                <td>FR</td>
                            </tr>
                            <tr>
                                <td>EL</td>
                                <td><button class="seat available" data-seat-code="G-EL-1">EL1</button></td>
                                <td><button class="seat available" data-seat-code="G-EL-2">EL2</button></td>
                                <td><button class="seat available" data-seat-code="G-EL-3">EL3</button></td>
                                <td><button class="seat available" data-seat-code="G-EL-4">EL4</button></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-ER-5">ER5</button></td>
                                <td><button class="seat available" data-seat-code="G-ER-6">ER6</button></td>
                                <td><button class="seat available" data-seat-code="G-ER-7">ER7</button></td>
                                <td><button class="seat available" data-seat-code="G-ER-8">ER8</button></td>
                                <td><button class="seat available" data-seat-code="G-ER-9">ER9</button></td>
                                <td><button class="seat available" data-seat-code="G-ER-10">ER10</button></td>
                                <td>ER</td>
                            </tr>
                            <tr>
                                <td>DL</td>
                                <td><button class="seat available" data-seat-code="G-DL-1">DL1</button></td>
                                <td><button class="seat available" data-seat-code="G-DL-2">DL2</button></td>
                                <td><button class="seat available" data-seat-code="G-DL-3">DL3</button></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-DR-4">DR4</button></td>
                                <td><button class="seat available" data-seat-code="G-DR-5">DR5</button></td>
                                <td><button class="seat available" data-seat-code="G-DR-6">DR6</button></td>
                                <td><button class="seat available" data-seat-code="G-DR-7">DR7</button></td>
                                <td><button class="seat available" data-seat-code="G-DR-8">DR8</button></td>
                                <td>DR</td>
                            </tr>
                            <tr>
                                <td>CL</td>
                                <td><button class="seat available" data-seat-code="G-CL-1">CL1</button></td>
                                <td><button class="seat available" data-seat-code="G-CL-2">CL2</button></td>
                                <td><button class="seat available" data-seat-code="G-CL-3">CL3</button></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-CR-4">CR4</button></td>
                                <td><button class="seat available" data-seat-code="G-CR-5">CR5</button></td>
                                <td><button class="seat available" data-seat-code="G-CR-6">CR6</button></td>
                                <td><button class="seat available" data-seat-code="G-CR-7">CR7</button></td>
                                <td><button class="seat available" data-seat-code="G-CR-8">CR8</button></td>
                                <td>CR</td>
                            </tr>
                            <tr>
                                <td>BL</td>
                                <td><button class="seat available" data-seat-code="G-BL-1">BL1</button></td>
                                <td><button class="seat available" data-seat-code="G-BL-2">BL2</button></td>
                                <td><button class="seat available" data-seat-code="G-BL-3">BL3</button></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-BR-4">BR4</button></td>
                                <td><button class="seat available" data-seat-code="G-BR-5">BR5</button></td>
                                <td><button class="seat available" data-seat-code="G-BR-6">BR6</button></td>
                                <td><button class="seat available" data-seat-code="G-BR-7">BR7</button></td>
                                <td><button class="seat available" data-seat-code="G-BR-8">BR8</button></td>
                                <td>BR</td>
                            </tr>
                            <tr>
                                <td>AL</td>
                                <td><button class="seat available" data-seat-code="G-AL-1">AL1</button></td>
                                <td><button class="seat available" data-seat-code="G-AL-2">AL2</button></td>
                                <td><button class="seat available" data-seat-code="G-AL-3">AL3</button></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><button class="seat available" data-seat-code="G-AR-4">AR4</button></td>
                                <td><button class="seat available" data-seat-code="G-AR-5">AR5</button></td>
                                <td><button class="seat available" data-seat-code="G-AR-6">AR6</button></td>
                                <td><button class="seat available" data-seat-code="G-AR-7">AR7</button></td>
                                <td><button class="seat available" data-seat-code="G-AR-8">AR8</button></td>
                                <td>AR</td>
                            </tr>

                        </tbody>
                    </table>
                </div>



                <!-- PLATINUM Section (hidden by default) -->

            </div>
        </div>

        <!-- Booking Form & Buttons -->
        <form action="{{ route('booking.store') }}" method="POST" class="booking-form">
            @csrf
            @method('post')

            <input type="hidden" id="selected-seats" name="selected_seats">
            <!-- Hidden fields (still needed by your logic) -->
            <input type="hidden" id="selected-date" name="selected_date" value="{{ $show->date }}">
            <input type="hidden" id="time" name="time" value="{{ $show->time }}">
            <input type="hidden" id="selected-movie-id" name="movie_id" value="{{ $show->id }}">
            <input type="hidden" id="selected-movie-name" name="movie_name" value="{{ $show->movie_name }}">
            <!-- Default seat type set to Silver -->
            <input type="hidden" id="selected-seat-type" name="seat_type" value="Silver">

            {{-- <div class="form-buttons">
                        <button type="submit" name="reserve_seats" class="button reserve-btn">Reserve Seats</button>
                        <button type="submit" name="confirm_booking" id="confirm-booking" class="button confirm-btn">Confirm Booking</button>
                    </div> --}}
        </form>
    </div>

    <script>
        let selectedSeats = []; // Array to hold selected seats.
        // Use booked seats passed from the backend
        const bookedSeats = @json($bookedSeats); // This array is injected from the backend

        document.addEventListener('DOMContentLoaded', () => {
            // Mark booked seats dynamically
            document.querySelectorAll('.seat').forEach(seat => {
                const seatCode = seat.getAttribute('data-seat-code');

                if (bookedSeats.hasOwnProperty(seatCode)) {
                    // If seat is fully booked or reserved (from backend data)
                    if (bookedSeats[seatCode]) {
                        // If true => booked
                        seat.classList.add('booked');
                        seat.disabled = true;
                    } else {
                        // If false => reserved
                        seat.classList.add('reserved');
                        seat.disabled = true;
                    }
                }

                // Only add click event if seat is neither booked nor reserved
                if (!seat.classList.contains('booked') && !seat.classList.contains('reserved')) {
                    seat.addEventListener('click', (e) => {
                        e.preventDefault();
                        toggleSeatSelection(seatCode, seat);
                    });
                }
            });

            // Event listeners for seat type selection
            document.querySelectorAll('#seat-types button').forEach(button => {
                button.addEventListener('click', () => {
                    const seatType = button.dataset.type;

                    // Hide all seat layouts
                    document.querySelectorAll('.seat-type-layout-section').forEach(section => {
                        section.style.display = 'none';
                    });

                    // Show the chosen seat layout
                    document.getElementById(seatType.toLowerCase() + '-layout').style.display =
                        'block';

                    // Update hidden input
                    document.getElementById('selected-seat-type').value = seatType;
                });
            });
        });

        function toggleSeatSelection(seatCode, seatButton) {
            if (!seatCode) return;

            if (selectedSeats.includes(seatCode)) {
                // Remove seat from selected
                selectedSeats = selectedSeats.filter(s => s !== seatCode);
                seatButton.classList.remove('selected');
            } else {
                // Add seat to selected
                selectedSeats.push(seatCode);
                seatButton.classList.add('selected');
            }

            // Update hidden input with current selection
            document.getElementById('selected-seats').value = JSON.stringify(selectedSeats);
        }

        setTimeout(function() {
            location.reload();
        }, 10000); // Reloads the page every 10 seconds
    </script>

    <style>
        /* Make the page take full screen (reset default body margin/padding) */
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        /* Container to fill the viewport */
        .booking-container {
            width: 100%;
            min-height: 100vh;
            /* Occupy full vertical space */
            background-color: #ffffff;
            padding: 20px;
            box-sizing: border-box;
            /* Ensure padding doesn't add to total width */
        }

        /* Top Section: Buttons & Movie Info */
        .top-section {
            display: flex;
            flex-wrap: wrap;/* Ensures proper wrapping on smaller screens */
            justify-content: left;/* Centers the buttons horizontally */
            align-items: left;/* Centers vertically */
            gap: 25px;/* Adds spacing between buttons */
            margin: 0 auto 20px 100px;/* Centers horizontally */
        }

        /* Seat Type Buttons Container */
        .seat-types {
            display: flex;
            flex: 1;
            justify-content: center;/* Centers the buttons horizontally */
            align-items: center;/* Centers vertically */
            gap: 15px;/* Adds spacing between buttons */
            max-width: 500px;/* Adjust as needed */
            margin: 0 10px 20px 65px;/* Centers horizontally */

        }

        /* Align Silver button left, Gold center, Platinum right */
        .seat-types .silver-btn {
            margin-right: auto;
            /* push left */
        }

        .seat-types .gold-btn {
            margin: 0 auto;
            /* center */
        }

        .seat-types .platinum-btn {
            margin-left: auto;
            /* push right */
        }

        /* Ensure Movie Details are aligned in one line */
        .movie-details {
            display: flex;
            gap: 20px;
            /* Adds spacing between Date, Time, and Movie */
            align-items: center;
        }

        .movie-details div {
            margin: 0;
            /* Remove extra margin to keep everything in one line */
        }

        .movie-details label {
            font-weight: bold;
            margin-right: 5px;
            /* Adds spacing between label and value */
        }

        /* Theater layout container – align to the right */
        .theater-layout-wrapper {
            display: flex;
            justify-content: left;
            margin-bottom: 20px;
        }

        /* Table styling */
        table {
            margin: 10px auto;
            border-collapse: collapse;
            width: 40%;
        }

        th,
        td {
            border: 0px solid black;
            padding: 5px;
            text-align: center;
            width: 30px;
            height: 30px;
        }

        table thead th {
            border-top: 5px solid black;
        }

        .seat-type-layout-section table {
            margin: 0 auto;
            border-collapse: collapse;
        }

        .seat-type-layout-section th {
            text-align: center;
            font-weight: bold;
        }

        /* Seat styles */
        .seat {
            width: 40px;
            height: 30px;
            margin: 0;
            font-size: 10px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }

        .seat:hover {
            background-color: #ddd;
        }

        .seat.selected {
            background-color: #007bff;
            color: white;
            border: 1px solid #0056b3;
        }

        .seat.booked {
            background-color: #e81414;
            cursor: not-allowed;
        }

        .seat.reserved {
            background-color: #ffc107;
            cursor: not-allowed;
        }

        /* Form Buttons at the bottom */
        .form-buttons {
            text-align: right;
            margin-top: 20px;
        }

        .form-buttons .button {
            margin-left: 10px;
        }

        /* Success & Error Messages */
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .error-messages {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }

        /* Basic button style */
        .button {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            background-color: #444;
            color: #fff;
            cursor: pointer;
        }

        .button:hover {
            background-color: #333;
        }
    </style>
</x-app-layout>