<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ isOpen: true }"   {{-- Alpine.js state for toggling sidebar --}}
      x-cloak>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
            integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4MNol7QzPxwOWa5t4lRDs9C4vGdAN3E6bOozcKW7v1z4+pbjMZtm2VWwg=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Alpine.js for sidebar toggle -->
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                {{-- <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header> --}}
            @endisset

            <!-- TOP BAR (with user icon on the right) -->
            {{-- <div class="flex items-center justify-end bg-white h-16 px-4 shadow">
                <button class="text-gray-600 hover:text-gray-800 focus:outline-none">
                    <i class="fas fa-user-circle text-2xl"></i>
                </button>
            </div> --}}

            <!-- Page Content -->
            <!-- Sidebar and Main Content -->
            <div class="min-h-screen flex "
            style="background-image: url('/icons/back.jpg'); background-repeat: repeat; background-size: auto; background-position: center; min-height: 100vh;"
            >
            {{-- bg-gray-800 --}}
                <!-- Sidebar -->
                <aside 
                    class="bg-white shadow-md min-h-screen transition-all duration-300"
                    :class="isOpen ? 'w-1/7' : 'w-20'"
                    style="background-color: rgb(0, 0, 0);">
                    
                    <!-- Sidebar Header + Toggle Button -->
                    {{-- <div class="flex items-center justify-between p-4 border-b">
                        <!-- Logo/Text (only show when open) -->
                        <div x-show="isOpen" class="text-lg font-semibold text-gray-800">
                            <img src="{{ asset('/icons/logo.jpg') }}" alt="Logo" class="block h-14 w-auto ml-5">

                        </div>
                        <!-- Toggle Button -->
                        <button
                            @click="isOpen = !isOpen"
                            class="text-gray-600 hover:text-gray-900"
                        >
                            <i class="fas fa-angle-left"
                               :class="{'rotate-180': !isOpen, 'rotate-0': isOpen}"
                               style="transition: transform .2s;"></i>
                        </button>
                    </div> --}}

                    <ul class="space-y-4 mt-4">
                        @if(Auth::user()->usertype === 'admin')
                            <li>
                                <a href="" class="flex items-center text-gray-600 hover:text-gray-900 px-4 py-2">
                                    <i class="fas fa-tachometer-alt mr-2"></i>
                                    <span x-show="isOpen" x-transition>Admin Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="flex items-center text-gray-600 hover:text-gray-900 px-4 py-2">
                                    <i class="fas fa-users mr-2"></i>
                                    <span x-show="isOpen" x-transition>Manage Users</span>
                                </a>
                            </li>
                        @elseif(Auth::user()->usertype === 'super_admin')
                            <li>
                                <a href="" class="flex items-center text-gray-600 hover:text-gray-900 px-4 py-2">
                                    <i class="fas fa-tools mr-2"></i>
                                    <span x-show="isOpen" x-transition>Super Admin Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="flex items-center text-gray-600 hover:text-gray-900 px-4 py-2">
                                    <i class="fas fa-cogs mr-2"></i>
                                    <span x-show="isOpen" x-transition>Settings</span>
                                </a>
                            </li>
                        @else
                            <li class="mt-5 mx-5">
                                <a href="/booking/create" class="flex items-center text-gray-600 hover:text-gray-900 px-4 py-2">
                                    <i class="fas fa-user mr-2"></i>
                                    <span x-show="isOpen" x-transition>Booking</span>
                                </a>
                            </li>
                            <li class="mt-5 mx-5">
                                <a href="/booking/show" class="flex items-center text-gray-600 hover:text-gray-900 px-4 py-2">
                                    <i class="fas fa-user-edit mr-2"></i>
                                    <span x-show="isOpen" x-transition>Pre Book</span>
                                </a>
                            </li>
                            <li class="mt-5 mx-5">
                                <a href="/movie" class="flex items-center text-gray-600 hover:text-gray-900 px-4 py-2">
                                    <i class="fas fa-user-edit mr-2"></i>
                                    <span x-show="isOpen" x-transition>Movie</span>
                                </a>
                            </li>
                            <li class="mt-5 mx-5">
                                <a href="/show" class="flex items-center text-gray-600 hover:text-gray-900 px-4 py-2">
                                    <i class="fas fa-user-edit mr-2"></i>
                                    <span x-show="isOpen" x-transition>Show</span>
                                </a>
                            </li>
                            <li class="mt-5 mx-5">
                                <a href="/price" class="flex items-center text-gray-600 hover:text-gray-900 px-4 py-2">
                                    <i class="fas fa-user-edit mr-2"></i>
                                    <span x-show="isOpen" x-transition>Price</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </aside>

                <!-- Main Content -->
                <div class="p-6 transition-all duration-300 "
                     :class="isOpen ? 'w-6/7' : 'flex-1'"
                     style="background-color: rgb(255, 255, 255);"
                     >
                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>