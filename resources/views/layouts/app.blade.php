<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <!-- Sidebar and Main Content -->
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            <aside class="w-1/7 bg-white shadow-md min-h-screen">
                {{-- <h3 class="text-lg font-semibold text-gray-800 mb-4">Sidebar</h3> --}}
                <ul class="space-y-4">
                    @if(Auth::user()->usertype === 'admin')
                        <li>
                            <a href="" class="flex items-center text-gray-600 hover:text-gray-900">
                                <i class="fas fa-tachometer-alt mr-2"></i>
                                Admin Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center text-gray-600 hover:text-gray-900">
                                <i class="fas fa-users mr-2"></i>
                                Manage Users
                            </a>
                        </li>
                    @elseif(Auth::user()->usertype === 'super_admin')
                        <li>
                            <a href="" class="flex items-center text-gray-600 hover:text-gray-900">
                                <i class="fas fa-tools mr-2"></i>
                                Super Admin Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center text-gray-600 hover:text-gray-900">
                                <i class="fas fa-cogs mr-2"></i>
                                Settings
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="" class="flex items-center text-gray-600 hover:text-gray-900">
                                <i class="fas fa-user mr-2"></i>
                                User Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center text-gray-600 hover:text-gray-900">
                                <i class="fas fa-user-edit mr-2"></i>
                                Edit Profile
                            </a>
                        </li>
                    @endif
                </ul>
            </aside>

            <!-- Main Content -->
            <div class="w-6/7 p-6">
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
            
        </div>
    </body>
</html>
