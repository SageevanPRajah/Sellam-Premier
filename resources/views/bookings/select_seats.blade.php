<x-app-layout>
    <div class="booking-container">
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

        <div class="seat-form-container">
        <!-- Seat Type Selection -->
        <div id="seat-types" class="seat-types">
            <button class="button gold-btn" data-type="Gold">Gold</button>
            <button class="button platinum-btn" data-type="Platinum">Platinum</button>
            <button class="button silver-btn" data-type="Silver">Silver</button>
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
                    <input type="hidden" id="selected-seat-type" name="seat_type" value="Gold">

                    <div class="form-buttons">
                        <button type="submit" name="reserve_seats" class="button reserve-btn">Reserve Seats</button>
                        <button type="submit" name="confirm_booking" id="confirm-booking" class="button confirm-btn">Confirm Booking</button>
                    </div>
                </form>
        </div>

        <!-- Theater Layout on the right side -->
        <div class="theater-layout-wrapper">
            <div id="theater-layout">

                <!-- GOLD Section (hidden by default) -->
                <div class="seat-type-layout-section" id="gold-layout" style="display: block;">
                    <table>
                    <thead>
                        <tr>
                            <th colspan="14">Gold Class</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- 1) SL row (6 seats left, 4 seats right) -->
                        <tr>
                            <td>SL</td>
                            <td><button class="seat available" data-seat-code="G-SL-6">SL6</button></td>
                            <td><button class="seat available" data-seat-code="G-SL-5">SL5</button></td>
                            <td><button class="seat available" data-seat-code="G-SL-4">SL4</button></td>
                            <td><button class="seat available" data-seat-code="G-SL-3">SL3</button></td>
                            <td><button class="seat available" data-seat-code="G-SL-2">SL2</button></td>
                            <td><button class="seat available" data-seat-code="G-SL-1">SL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-SR-1">SR1</button></td>
                            <td><button class="seat available" data-seat-code="G-SR-2">SR2</button></td>
                            <td><button class="seat available" data-seat-code="G-SR-3">SR3</button></td>
                            <td><button class="seat available" data-seat-code="G-SR-4">SR4</button></td>
                            <td>SR</td>
                        </tr>
            
                        <!-- 2) RL row -->
                        <tr>
                            <td>RL</td>
                            <td><button class="seat available" data-seat-code="G-RL-6">RL6</button></td>
                            <td><button class="seat available" data-seat-code="G-RL-5">RL5</button></td>
                            <td><button class="seat available" data-seat-code="G-RL-4">RL4</button></td>
                            <td><button class="seat available" data-seat-code="G-RL-3">RL3</button></td>
                            <td><button class="seat available" data-seat-code="G-RL-2">RL2</button></td>
                            <td><button class="seat available" data-seat-code="G-RL-1">RL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-RR-1">RR1</button></td>
                            <td><button class="seat available" data-seat-code="G-RR-2">RR2</button></td>
                            <td><button class="seat available" data-seat-code="G-RR-3">RR3</button></td>
                            <td><button class="seat available" data-seat-code="G-RR-4">RR4</button></td>
                            <td>RR</td>
                        </tr>
            
                        <!-- 3) QL row -->
                        <tr>
                            <td>QL</td>
                            <td><button class="seat available" data-seat-code="G-QL-6">QL6</button></td>
                            <td><button class="seat available" data-seat-code="G-QL-5">QL5</button></td>
                            <td><button class="seat available" data-seat-code="G-QL-4">QL4</button></td>
                            <td><button class="seat available" data-seat-code="G-QL-3">QL3</button></td>
                            <td><button class="seat available" data-seat-code="G-QL-2">QL2</button></td>
                            <td><button class="seat available" data-seat-code="G-QL-1">QL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-QR-1">QR1</button></td>
                            <td><button class="seat available" data-seat-code="G-QR-2">QR2</button></td>
                            <td><button class="seat available" data-seat-code="G-QR-3">QR3</button></td>
                            <td><button class="seat available" data-seat-code="G-QR-4">QR4</button></td>
                            <td>QR</td>
                        </tr>
            
                        <!-- 4) PL row -->
                        <tr>
                            <td>PL</td>
                            <td><button class="seat available" data-seat-code="G-PL-6">PL6</button></td>
                            <td><button class="seat available" data-seat-code="G-PL-5">PL5</button></td>
                            <td><button class="seat available" data-seat-code="G-PL-4">PL4</button></td>
                            <td><button class="seat available" data-seat-code="G-PL-3">PL3</button></td>
                            <td><button class="seat available" data-seat-code="G-PL-2">PL2</button></td>
                            <td><button class="seat available" data-seat-code="G-PL-1">PL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-PR-1">PR1</button></td>
                            <td><button class="seat available" data-seat-code="G-PR-2">PR2</button></td>
                            <td><button class="seat available" data-seat-code="G-PR-3">PR3</button></td>
                            <td><button class="seat available" data-seat-code="G-PR-4">PR4</button></td>
                            <td>PR</td>
                        </tr>
            
                        <!-- 5) OL row -->
                        <tr>
                            <td>OL</td>
                            <td><button class="seat available" data-seat-code="G-OL-6">OL6</button></td>
                            <td><button class="seat available" data-seat-code="G-OL-5">OL5</button></td>
                            <td><button class="seat available" data-seat-code="G-OL-4">OL4</button></td>
                            <td><button class="seat available" data-seat-code="G-OL-3">OL3</button></td>
                            <td><button class="seat available" data-seat-code="G-OL-2">OL2</button></td>
                            <td><button class="seat available" data-seat-code="G-OL-1">OL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-OR-1">OR1</button></td>
                            <td><button class="seat available" data-seat-code="G-OR-2">OR2</button></td>
                            <td><button class="seat available" data-seat-code="G-OR-3">OR3</button></td>
                            <td><button class="seat available" data-seat-code="G-OR-4">OR4</button></td>
                            <td>OR</td>
                        </tr>
            
                        <!-- 6) NL row -->
                        <tr>
                            <td>NL</td>
                            <td><button class="seat available" data-seat-code="G-NL-6">NL6</button></td>
                            <td><button class="seat available" data-seat-code="G-NL-5">NL5</button></td>
                            <td><button class="seat available" data-seat-code="G-NL-4">NL4</button></td>
                            <td><button class="seat available" data-seat-code="G-NL-3">NL3</button></td>
                            <td><button class="seat available" data-seat-code="G-NL-2">NL2</button></td>
                            <td><button class="seat available" data-seat-code="G-NL-1">NL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-NR-1">NR1</button></td>
                            <td><button class="seat available" data-seat-code="G-NR-2">NR2</button></td>
                            <td><button class="seat available" data-seat-code="G-NR-3">NR3</button></td>
                            <td><button class="seat available" data-seat-code="G-NR-4">NR4</button></td>
                            <td>NR</td>
                        </tr>
            
                        <!-- 7) ML row -->
                        <tr>
                            <td>ML</td>
                            <td><button class="seat available" data-seat-code="G-ML-6">ML6</button></td>
                            <td><button class="seat available" data-seat-code="G-ML-5">ML5</button></td>
                            <td><button class="seat available" data-seat-code="G-ML-4">ML4</button></td>
                            <td><button class="seat available" data-seat-code="G-ML-3">ML3</button></td>
                            <td><button class="seat available" data-seat-code="G-ML-2">ML2</button></td>
                            <td><button class="seat available" data-seat-code="G-ML-1">ML1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-MR-1">MR1</button></td>
                            <td><button class="seat available" data-seat-code="G-MR-2">MR2</button></td>
                            <td><button class="seat available" data-seat-code="G-MR-3">MR3</button></td>
                            <td><button class="seat available" data-seat-code="G-MR-4">MR4</button></td>
                            <td>MR</td>
                        </tr>
            
                        <!-- 8) LL row -->
                        <tr>
                            <td>LL</td>
                            <td><button class="seat available" data-seat-code="G-LL-6">LL6</button></td>
                            <td><button class="seat available" data-seat-code="G-LL-5">LL5</button></td>
                            <td><button class="seat available" data-seat-code="G-LL-4">LL4</button></td>
                            <td><button class="seat available" data-seat-code="G-LL-3">LL3</button></td>
                            <td><button class="seat available" data-seat-code="G-LL-2">LL2</button></td>
                            <td><button class="seat available" data-seat-code="G-LL-1">LL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-LR-1">LR1</button></td>
                            <td><button class="seat available" data-seat-code="G-LR-2">LR2</button></td>
                            <td><button class="seat available" data-seat-code="G-LR-3">LR3</button></td>
                            <td><button class="seat available" data-seat-code="G-LR-4">LR4</button></td>
                            <td>LR</td>
                        </tr>
            
                        <!-- 9) KL row -->
                        <tr>
                            <td>KL</td>
                            <td><button class="seat available" data-seat-code="G-KL-6">KL6</button></td>
                            <td><button class="seat available" data-seat-code="G-KL-5">KL5</button></td>
                            <td><button class="seat available" data-seat-code="G-KL-4">KL4</button></td>
                            <td><button class="seat available" data-seat-code="G-KL-3">KL3</button></td>
                            <td><button class="seat available" data-seat-code="G-KL-2">KL2</button></td>
                            <td><button class="seat available" data-seat-code="G-KL-1">KL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-KR-1">KR1</button></td>
                            <td><button class="seat available" data-seat-code="G-KR-2">KR2</button></td>
                            <td><button class="seat available" data-seat-code="G-KR-3">KR3</button></td>
                            <td><button class="seat available" data-seat-code="G-KR-4">KR4</button></td>
                            <td>KR</td>
                        </tr>
            
                        <!-- 10) JL row -->
                        <tr>
                            <td>JL</td>
                            <td><button class="seat available" data-seat-code="G-JL-6">JL6</button></td>
                            <td><button class="seat available" data-seat-code="G-JL-5">JL5</button></td>
                            <td><button class="seat available" data-seat-code="G-JL-4">JL4</button></td>
                            <td><button class="seat available" data-seat-code="G-JL-3">JL3</button></td>
                            <td><button class="seat available" data-seat-code="G-JL-2">JL2</button></td>
                            <td><button class="seat available" data-seat-code="G-JL-1">JL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-JR-1">JR1</button></td>
                            <td><button class="seat available" data-seat-code="G-JR-2">JR2</button></td>
                            <td><button class="seat available" data-seat-code="G-JR-3">JR3</button></td>
                            <td><button class="seat available" data-seat-code="G-JR-4">JR4</button></td>
                            <td>JR</td>
                        </tr>
            
                        <!-- 11) IL row -->
                        <tr>
                            <td>IL</td>
                            <td><button class="seat available" data-seat-code="G-IL-6">IL6</button></td>
                            <td><button class="seat available" data-seat-code="G-IL-5">IL5</button></td>
                            <td><button class="seat available" data-seat-code="G-IL-4">IL4</button></td>
                            <td><button class="seat available" data-seat-code="G-IL-3">IL3</button></td>
                            <td><button class="seat available" data-seat-code="G-IL-2">IL2</button></td>
                            <td><button class="seat available" data-seat-code="G-IL-1">IL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-IR-1">IR1</button></td>
                            <td><button class="seat available" data-seat-code="G-IR-2">IR2</button></td>
                            <td><button class="seat available" data-seat-code="G-IR-3">IR3</button></td>
                            <td><button class="seat available" data-seat-code="G-IR-4">IR4</button></td>
                            <td>IR</td>
                        </tr>
            
                        <!-- 12) HL row -->
                        <tr>
                            <td>HL</td>
                            <td><button class="seat available" data-seat-code="G-HL-6">HL6</button></td>
                            <td><button class="seat available" data-seat-code="G-HL-5">HL5</button></td>
                            <td><button class="seat available" data-seat-code="G-HL-4">HL4</button></td>
                            <td><button class="seat available" data-seat-code="G-HL-3">HL3</button></td>
                            <td><button class="seat available" data-seat-code="G-HL-2">HL2</button></td>
                            <td><button class="seat available" data-seat-code="G-HL-1">HL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-HR-1">HR1</button></td>
                            <td><button class="seat available" data-seat-code="G-HR-2">HR2</button></td>
                            <td><button class="seat available" data-seat-code="G-HR-3">HR3</button></td>
                            <td><button class="seat available" data-seat-code="G-HR-4">HR4</button></td>
                            <td>HR</td>
                        </tr>
            
                        <!-- 13) GL row -->
                        <tr>
                            <td>GL</td>
                            <td><button class="seat available" data-seat-code="G-GL-6">GL6</button></td>
                            <td><button class="seat available" data-seat-code="G-GL-5">GL5</button></td>
                            <td><button class="seat available" data-seat-code="G-GL-4">GL4</button></td>
                            <td><button class="seat available" data-seat-code="G-GL-3">GL3</button></td>
                            <td><button class="seat available" data-seat-code="G-GL-2">GL2</button></td>
                            <td><button class="seat available" data-seat-code="G-GL-1">GL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-GR-1">GR1</button></td>
                            <td><button class="seat available" data-seat-code="G-GR-2">GR2</button></td>
                            <td><button class="seat available" data-seat-code="G-GR-3">GR3</button></td>
                            <td><button class="seat available" data-seat-code="G-GR-4">GR4</button></td>
                            <td>GR</td>
                        </tr>
            
                        <!-- 14) FL row -->
                        <tr>
                            <td>FL</td>
                            <td><button class="seat available" data-seat-code="G-FL-6">FL6</button></td>
                            <td><button class="seat available" data-seat-code="G-FL-5">FL5</button></td>
                            <td><button class="seat available" data-seat-code="G-FL-4">FL4</button></td>
                            <td><button class="seat available" data-seat-code="G-FL-3">FL3</button></td>
                            <td><button class="seat available" data-seat-code="G-FL-2">FL2</button></td>
                            <td><button class="seat available" data-seat-code="G-FL-1">FL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-FR-1">FR1</button></td>
                            <td><button class="seat available" data-seat-code="G-FR-2">FR2</button></td>
                            <td><button class="seat available" data-seat-code="G-FR-3">FR3</button></td>
                            <td><button class="seat available" data-seat-code="G-FR-4">FR4</button></td>
                            <td>FR</td>
                        </tr>
            
                        <!-- 15) EL row -->
                        <tr>
                            <td>EL</td>
                            <td><button class="seat available" data-seat-code="G-EL-6">EL6</button></td>
                            <td><button class="seat available" data-seat-code="G-EL-5">EL5</button></td>
                            <td><button class="seat available" data-seat-code="G-EL-4">EL4</button></td>
                            <td><button class="seat available" data-seat-code="G-EL-3">EL3</button></td>
                            <td><button class="seat available" data-seat-code="G-EL-2">EL2</button></td>
                            <td><button class="seat available" data-seat-code="G-EL-1">EL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-ER-1">ER1</button></td>
                            <td><button class="seat available" data-seat-code="G-ER-2">ER2</button></td>
                            <td><button class="seat available" data-seat-code="G-ER-3">ER3</button></td>
                            <td><button class="seat available" data-seat-code="G-ER-4">ER4</button></td>
                            <td>ER</td>
                        </tr>
            
                        <!-- 16) DL row (5 seats left, 3 seats far-right) -->
                        <tr>
                            <td>DL</td>
                            <td><button class="seat available" data-seat-code="G-DL-5">DL5</button></td>
                            <td><button class="seat available" data-seat-code="G-DL-4">DL4</button></td>
                            <td><button class="seat available" data-seat-code="G-DL-3">DL3</button></td>
                            <td><button class="seat available" data-seat-code="G-DL-2">DL2</button></td>
                            <td><button class="seat available" data-seat-code="G-DL-1">DL1</button></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-DR-1">DR1</button></td>
                            <td><button class="seat available" data-seat-code="G-DR-2">DR2</button></td>
                            <td><button class="seat available" data-seat-code="G-DR-3">DR3</button></td>
                            <td>DR</td>
                        </tr>
            
                        <!-- 17) CL row -->
                        <tr>
                            <td>CL</td>
                            <td><button class="seat available" data-seat-code="G-CL-5">CL5</button></td>
                            <td><button class="seat available" data-seat-code="G-CL-4">CL4</button></td>
                            <td><button class="seat available" data-seat-code="G-CL-3">CL3</button></td>
                            <td><button class="seat available" data-seat-code="G-CL-2">CL2</button></td>
                            <td><button class="seat available" data-seat-code="G-CL-1">CL1</button></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-CR-1">CR1</button></td>
                            <td><button class="seat available" data-seat-code="G-CR-2">CR2</button></td>
                            <td><button class="seat available" data-seat-code="G-CR-3">CR3</button></td>
                            <td>CR</td>
                        </tr>
            
                        <!-- 18) BL row -->
                        <tr>
                            <td>BL</td>
                            <td><button class="seat available" data-seat-code="G-BL-5">BL5</button></td>
                            <td><button class="seat available" data-seat-code="G-BL-4">BL4</button></td>
                            <td><button class="seat available" data-seat-code="G-BL-3">BL3</button></td>
                            <td><button class="seat available" data-seat-code="G-BL-2">BL2</button></td>
                            <td><button class="seat available" data-seat-code="G-BL-1">BL1</button></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-BR-1">BR1</button></td>
                            <td><button class="seat available" data-seat-code="G-BR-2">BR2</button></td>
                            <td><button class="seat available" data-seat-code="G-BR-3">BR3</button></td>
                            <td>BR</td>
                        </tr>
            
                        <!-- 19) AL row -->
                        <tr>
                            <td>AL</td>
                            <td><button class="seat available" data-seat-code="G-AL-5">AL5</button></td>
                            <td><button class="seat available" data-seat-code="G-AL-4">AL4</button></td>
                            <td><button class="seat available" data-seat-code="G-AL-3">AL3</button></td>
                            <td><button class="seat available" data-seat-code="G-AL-2">AL2</button></td>
                            <td><button class="seat available" data-seat-code="G-AL-1">AL1</button></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="G-AR-1">AR1</button></td>
                            <td><button class="seat available" data-seat-code="G-AR-2">AR2</button></td>
                            <td><button class="seat available" data-seat-code="G-AR-3">AR3</button></td>
                            <td>AR</td>
                        </tr>
                    </tbody>
                </table>
                </div>

                <!-- SILVER Section (visible by default) -->
                <div class="seat-type-layout-section" id="silver-layout" style="display: none;">
                    <table>
                    <thead>
                        <tr>
                            <th colspan="14">Silver Class</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- 1) EL row -->
                        <tr>
                            <td>EL</td>
                            <td><button class="seat available" data-seat-code="S-EL-6">EL6</button></td>
                            <td><button class="seat available" data-seat-code="S-EL-5">EL5</button></td>
                            <td><button class="seat available" data-seat-code="S-EL-4">EL4</button></td>
                            <td><button class="seat available" data-seat-code="S-EL-3">EL3</button></td>
                            <td><button class="seat available" data-seat-code="S-EL-2">EL2</button></td>
                            <td><button class="seat available" data-seat-code="S-EL-1">EL1</button></td>
                            <!-- Blank columns to shift right seats farther right -->
                            <td></td>
                            <td></td>
                            <!-- Right side -->
                            <td><button class="seat available" data-seat-code="S-ER-1">ER1</button></td>
                            <td><button class="seat available" data-seat-code="S-ER-2">ER2</button></td>
                            <td><button class="seat available" data-seat-code="S-ER-3">ER3</button></td>
                            <td><button class="seat available" data-seat-code="S-ER-4">ER4</button></td>
                            <td>ER</td>
                        </tr>
            
                        <!-- 2) DL row -->
                        <tr>
                            <td>DL</td>
                            <td><button class="seat available" data-seat-code="S-DL-6">DL6</button></td>
                            <td><button class="seat available" data-seat-code="S-DL-5">DL5</button></td>
                            <td><button class="seat available" data-seat-code="S-DL-4">DL4</button></td>
                            <td><button class="seat available" data-seat-code="S-DL-3">DL3</button></td>
                            <td><button class="seat available" data-seat-code="S-DL-2">DL2</button></td>
                            <td><button class="seat available" data-seat-code="S-DL-1">DL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="S-DR-1">DR1</button></td>
                            <td><button class="seat available" data-seat-code="S-DR-2">DR2</button></td>
                            <td><button class="seat available" data-seat-code="S-DR-3">DR3</button></td>
                            <td><button class="seat available" data-seat-code="S-DR-4">DR4</button></td>
                            <td>DR</td>
                        </tr>
            
                        <!-- 3) CL row -->
                        <tr>
                            <td>CL</td>
                            <td><button class="seat available" data-seat-code="S-CL-6">CL6</button></td>
                            <td><button class="seat available" data-seat-code="S-CL-5">CL5</button></td>
                            <td><button class="seat available" data-seat-code="S-CL-4">CL4</button></td>
                            <td><button class="seat available" data-seat-code="S-CL-3">CL3</button></td>
                            <td><button class="seat available" data-seat-code="S-CL-2">CL2</button></td>
                            <td><button class="seat available" data-seat-code="S-CL-1">CL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="S-CR-1">CR1</button></td>
                            <td><button class="seat available" data-seat-code="S-CR-2">CR2</button></td>
                            <td><button class="seat available" data-seat-code="S-CR-3">CR3</button></td>
                            <td><button class="seat available" data-seat-code="S-CR-4">CR4</button></td>
                            <td>CR</td>
                        </tr>
            
                        <!-- 4) BL row -->
                        <tr>
                            <td>BL</td>
                            <td><button class="seat available" data-seat-code="S-BL-6">BL6</button></td>
                            <td><button class="seat available" data-seat-code="S-BL-5">BL5</button></td>
                            <td><button class="seat available" data-seat-code="S-BL-4">BL4</button></td>
                            <td><button class="seat available" data-seat-code="S-BL-3">BL3</button></td>
                            <td><button class="seat available" data-seat-code="S-BL-2">BL2</button></td>
                            <td><button class="seat available" data-seat-code="S-BL-1">BL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="S-BR-1">BR1</button></td>
                            <td><button class="seat available" data-seat-code="S-BR-2">BR2</button></td>
                            <td><button class="seat available" data-seat-code="S-BR-3">BR3</button></td>
                            <td><button class="seat available" data-seat-code="S-BR-4">BR4</button></td>
                            <td>BR</td>
                        </tr>
            
                        <!-- 5) AL row -->
                        <tr>
                            <td>AL</td>
                            <td><button class="seat available" data-seat-code="S-AL-6">AL6</button></td>
                            <td><button class="seat available" data-seat-code="S-AL-5">AL5</button></td>
                            <td><button class="seat available" data-seat-code="S-AL-4">AL4</button></td>
                            <td><button class="seat available" data-seat-code="S-AL-3">AL3</button></td>
                            <td><button class="seat available" data-seat-code="S-AL-2">AL2</button></td>
                            <td><button class="seat available" data-seat-code="S-AL-1">AL1</button></td>
                            <td></td>
                            <td></td>
                            <td><button class="seat available" data-seat-code="S-AR-1">AR1</button></td>
                            <td><button class="seat available" data-seat-code="S-AR-2">AR2</button></td>
                            <td><button class="seat available" data-seat-code="S-AR-3">AR3</button></td>
                            <td><button class="seat available" data-seat-code="S-AR-4">AR4</button></td>
                            <td>AR</td>
                        </tr>
                    </tbody>
                </table>
                </div>

                <!-- PLATINUM Section (hidden by default) -->
                <div class="seat-type-layout-section" id="platinum-layout" style="display: none;">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="14">Platinum Class</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td><td ></td><td ></td><td ></td><td ></td><td ></td>
                                <td><button class="seat available" data-seat-code="P-X-19">X19</button></td>
                                <td><button class="seat available" data-seat-code="P-X-18">X18</button></td>
                                <td><button class="seat available" data-seat-code="P-X-17">X17</button></td>
                                <td><button class="seat available" data-seat-code="P-X-16">X16</button></td>
                                <td><button class="seat available" data-seat-code="P-X-15">X15</button></td>
                                <td></td><td ></td><td ></td>
                            </tr>
                            <tr>
                                <td></td><td ></td><td ></td><td ></td><td ></td><td ></td>
                                <td><button class="seat available" data-seat-code="P-X-14">X14</button></td>
                                <td><button class="seat available" data-seat-code="P-X-13">X13</button></td>
                                <td><button class="seat available" data-seat-code="P-X-12">X12</button></td>
                                <td><button class="seat available" data-seat-code="P-X-11">X11</button></td>
                                <td><button class="seat available" data-seat-code="P-X-10">X10</button></td>
                                <td></td><td ></td><td ></td>
                            </tr>
                            <tr>
                                <td></td><td ></td><td ></td><td ></td><td ></td><td></td>
                                <td><button class="seat available" data-seat-code="P-X-9">X9</button></td>
                                <td><button class="seat available" data-seat-code="P-X-8">X8</button></td>
                                <td><button class="seat available" data-seat-code="P-X-7">X7</button></td>
                                <td><button class="seat available" data-seat-code="P-X-6">X6</button></td>
                                <td><button class="seat available" data-seat-code="P-X-5">X5</button></td>
                                <td ></td><td ></td><td ></td>
                            </tr>
                            <tr>
                                <td></td><td ></td><td ></td><td ></td><td ></td><td></td>
                                <td><button class="seat available" data-seat-code="P-X-4">X4</button></td>
                                <td><button class="seat available" data-seat-code="P-X-3">X3</button></td>
                                <td><button class="seat available" data-seat-code="P-X-2">X2</button></td>
                                <td><button class="seat available" data-seat-code="P-X-1">X1</button></td>
                                <td></td><td ></td><td ></td><td ></td>
                            </tr>
                            <!-- ( Additional Platinum rows if needed ) -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

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
            
            // Check for seat_type in the URL query parameters
            const urlParams = new URLSearchParams(window.location.search);
            const seatTypeParam = urlParams.get('seat_type');
            if (seatTypeParam) {
                // Update the hidden input to match the passed seat type
                document.getElementById('selected-seat-type').value = seatTypeParam;
                
                // Optionally, mark the corresponding button as selected
                document.querySelectorAll('#seat-types button').forEach(button => {
                    if (button.dataset.type === seatTypeParam) {
                        button.classList.add('selected');
                    } else {
                        button.classList.remove('selected');
                    }
                });
                
                // Hide all seat layout sections
                document.querySelectorAll('.seat-type-layout-section').forEach(section => {
                    section.style.display = 'none';
                });
                // Show the section corresponding to the passed seat type (convert to lowercase)
                const layoutToShow = document.getElementById(seatTypeParam.toLowerCase() + '-layout');
                if (layoutToShow) {
                    layoutToShow.style.display = 'block';
                }

            }

            // ---------------------
            //  ADDED CODE HERE:
            // ---------------------
            document.querySelectorAll('#seat-types button').forEach(button => {
            button.addEventListener('click', () => {
                const newSeatType = button.dataset.type;

                // ------------------------------------------------------------
                // Update Popup Window - nazeemthebeta@gmail.com
                // ------------------------------------------------------------
                const showId = "{{ $show->id }}";
                const seatPopup = window.open('', 'SeatPopup'); // Reuse existing popup

                let popupUrl = '';

                if (newSeatType.toLowerCase() === 'silver') {
                    popupUrl = `/booking/create/clone/${showId}`;
                } else {
                    popupUrl = `/booking/create/${newSeatType.toLowerCase()}/${showId}`;
                }

                if (seatPopup && !seatPopup.closed) {
                    seatPopup.location.href = popupUrl;
                } else {
                    console.warn('Popup not found or already closed.');
                }

                // -------------------------------------------------------------
                
                const currentSeatType = document.getElementById('selected-seat-type').value;
                
                // If switching seat types and there are seats selected from the previous type,
                // automatically deselect them.
                if (newSeatType !== currentSeatType && selectedSeats.length > 0) {
                    // Loop through all selected seats and remove the selected class
                    selectedSeats.forEach(seatCode => {
                        const seatElem = document.querySelector(`[data-seat-code="${seatCode}"]`);
                        if (seatElem) {
                            seatElem.classList.remove('selected');
                        }
                    });
                    // Clear the selected seats array and update the hidden input field
                    selectedSeats = [];
                    document.getElementById('selected-seats').value = JSON.stringify(selectedSeats);
                }
                
                // Update the hidden input with the new seat type
                document.getElementById('selected-seat-type').value = newSeatType;
        
                // Hide all seat layout sections
                document.querySelectorAll('.seat-type-layout-section').forEach(section => {
                    section.style.display = 'none';
                });
        
                // Show the layout corresponding to the new seat type (convert to lowercase for matching ID)
                const layout = document.getElementById(newSeatType.toLowerCase() + '-layout');
                if (layout) {
                    layout.style.display = 'block';
                }
        
                // Update the styling of the seat type buttons to reflect the current selection
                document.querySelectorAll('#seat-types button').forEach(btn => {
                    btn.classList.toggle('selected', btn.dataset.type === newSeatType);
                });
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
    </script>

    <style>
        /* Make the page take full screen (reset default body margin/padding) */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        /* Container to fill the viewport */
        .booking-container {
            width: 100%;
            min-height: 100vh; /* Occupy full vertical space */
            background-color: #ffffff;
            padding: 20px;
            box-sizing: border-box; /* Ensure padding doesn't add to total width */
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
        
        /* Seat Type Selection and Booking Form Layout */
        .seat-form-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            max-width: 1200px; /* Adjust width as needed */
            margin: 0 auto 20px auto; /* Centering */
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
        .seat-types .gold-btn {
            margin-right: auto; /* push left */
        }
        .seat-types .platinum-btn {
            margin: 0 auto;     /* center */
        }
        .seat-types .silver-btn {
            margin-left: auto;  /* push right */
        }

        /* Movie details on the right */
        /* Ensure Movie Details are aligned in one line */
        .movie-details {
            display: flex;
            gap: 30px; /* Adds spacing between Date, Time, and Movie */
            align-items: center;
        }
        .movie-details div {
            margin: 5px 0;
        }
        .movie-details label {
            font-weight: bold;
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
        th, td {
            border: 0px solid black;
            padding: 5px;
            text-align: center;
            width: 30px;
            height: 30px;
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

        .booking-form {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
    
            align-items: center;
            margin-right: 220px;
        }
        /* Form Buttons at the bottom */
        .form-buttons {
            text-align: right;
            margin-top: 20px;
            margin-bottom: 40px;
            margin-right: -50px;
        }
        .form-buttons .button {
            margin-left: 10px;
            background-color: #007FFF;
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
