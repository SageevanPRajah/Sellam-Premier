<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ isOpen: true }" {{-- Alpine.js state for toggling sidebar --}} x-cloak>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4MNol7QzPxwOWa5t4lRDs9C4vGdAN3E6bOozcKW7v1z4+pbjMZtm2VWwg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!--
                We are NOT including the usual layouts.navigation
                because we want a custom sidebar for this page.
            -->

            <!-- Full page container with the custom background -->
            <div class="min-h-screen flex"
                 style="background-image: url('/icons/sdvs.jpg'); background-repeat: repeat; background-size: auto; background-position: center; min-height: 100vh;"
            >
                <!-- BEGIN: CUSTOM SIDEBAR FOR PLATINUM PAGE -->
                <aside 
                    class="bg-white shadow-md min-h-screen transition-all duration-300"
                    :class="isOpen ? 'w-1/18' : 'w-10'"
                    style="background-color: #f7f9f9;"
                >
                    <ul class="space-y-4 mt-4">
                        <!-- Customize sidebar links as needed -->
                        <li class="mt-5 mx-5">
                            <a href="/booking/create/clone" class="flex items-center text-gray-600 hover:text-gray-900 px-4 py-2">
                                <i class="fas fa-user mr-2"></i>
                                <span x-show="isOpen" x-transition>O</span>
                            </a>
                        </li>
                        <!-- Add or remove sidebar items as you wish -->
                    </ul>
                </aside>
                <!-- END: CUSTOM SIDEBAR -->

            <!-- BEGIN: MAIN CONTENT AREA -->
            <div class="p-6 transition-all duration-300" :class="isOpen ? 'w-17/18' : 'flex-1'"
                style="background-color: #f7f9f9;">
                <main class="w-[1200px] mx-auto">

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
                                <a href="{{ route('booking.goldSeats', $show->id) }}" 
                                   class="button gold-btn {{ Route::is('booking.goldSeats') ? 'active' : '' }}">
                                    Gold
                                </a>
                                <a href="{{ route('booking.platinumSeats', $show->id) }}" 
                                   class="button platinum-btn {{ Route::is('booking.platinumSeats') ? 'active' : '' }}">
                                    Platinum
                                </a>
                                <a href="{{ route('booking.cloneSeats', $show->id) }}" 
                                   class="button silver-btn {{ Route::is('booking.cloneSeats') ? 'active' : '' }}">
                                    Silver
                                </a>
                            </div>
                    
                            <!-- Theater Layout on the right side -->
                            <div class="theater-layout-wrapper">
                                <div id="theater-layout">
                    
                                    <!-- GOLD Section (hidden by default) -->
                                    <div class="seat-type-layout-section" id="gold-layout">
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

            <!-- Now the last 4 lines: push right-side seats further to the right. -->

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
                </main>
            </div>
            <!-- END: MAIN CONTENT AREA -->
        </div>
    </div>

    <!-- JavaScript for seat selection -->
    <script>
        let selectedSeats = [];
        const bookedSeats = @json($bookedSeats); // from the controller

        document.addEventListener('DOMContentLoaded', () => {
            // Mark booked seats
            document.querySelectorAll('.seat').forEach(seat => {
                const seatCode = seat.getAttribute('data-seat-code');
                if (bookedSeats.hasOwnProperty(seatCode)) {
                    if (bookedSeats[seatCode]) {
                        seat.classList.add('booked');
                        seat.disabled = true;
                    } else {
                        seat.classList.add('reserved');
                        seat.disabled = true;
                    }
                }

                // Enable click if not booked/reserved
                if (!seat.classList.contains('booked') && !seat.classList.contains('reserved')) {
                    seat.addEventListener('click', (e) => {
                        e.preventDefault();
                        toggleSeatSelection(seatCode, seat);
                    });
                }
            });
        });

        function toggleSeatSelection(seatCode, seatButton) {
            if (!seatCode) return;
            if (selectedSeats.includes(seatCode)) {
                selectedSeats = selectedSeats.filter(s => s !== seatCode);
                seatButton.classList.remove('selected');
            } else {
                selectedSeats.push(seatCode);
                seatButton.classList.add('selected');
            }
            document.getElementById('selected-seats').value = JSON.stringify(selectedSeats);
        }

        // Optional auto reload every 10 seconds if you want
        setTimeout(function() {
            location.reload();
        }, 10000);
    </script>

    <!-- Custom styles for seats, etc. (copy from your original platinum_seats.blade) -->
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
            flex-wrap: wrap;
            /* Ensures proper wrapping on smaller screens */
            justify-content: left;
            /* Centers the buttons horizontally */
            align-items: left;
            /* Centers vertically */
            gap: 25px;
            /* Adds spacing between buttons */
            margin: 0 auto 20px 100px;
            /* Centers horizontally */
        }

        /* Seat Type Buttons Container */
        .seat-types {
            display: flex;
            flex: 1;
            justify-content: center;
            /* Centers the buttons horizontally */
            align-items: center;
            /* Centers vertically */
            gap: 15px;
            /* Adds spacing between buttons */
            max-width: 500px;
            /* Adjust as needed */
            margin: 0 10px 20px 65px;
            /* Centers horizontally */

        }

       /* Align Silver button left, Gold center, Platinum right */
        .seat-types .gold-btn {
            margin-right: auto;
            /* push left */
        }

        .seat-types .platinum-btn {
            margin: 0 auto;
            /* center */
        }

        .seat-types .silver-btn {
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

        .button.active {
            background-color: #007bff;
            color: white;
            border: 1px solid #0056b3;
        }

        /* etc. */
    </style>
</body>

</html>
