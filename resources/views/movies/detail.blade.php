<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Movie') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-xl sm:rounded-lg p-6 text-white">
                <div class="poster text-center mb-6">
                    <img 
                        src="{{ asset('storage/' . $movie->poster) }}" 
                        alt="Movie Poster" 
                        class="w-96 mx-auto rounded-lg"
                    />
                </div>

                <!-- Success Message -->
                @if(session()->has('success'))
                    <div class="success-message text-green-500 text-center mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="error-messages text-red-500 mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="movie-details text-center">
                    <h1 class="text-2xl font-bold mb-2">{{ $movie->name }} ({{ date('Y', strtotime($movie->release_date)) }})</h1>
                    
                    <!-- Release Date -->
                    <div class="release-date text-gray-400 text-sm mb-4">
                        Release Date: {{ date('F d, Y', strtotime($movie->release_date)) }}
                    </div>

                    <!-- Trailer and IMDB Links -->
                    <div class="form-group flex justify-center space-x-4 mb-4">
                        <a 
                            href="{{ $movie->trailer_link }}" 
                            target="_blank" 
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium"
                        >
                            Trailer Link
                        </a>
                        <a 
                            href="{{ $movie->imdb_link }}" 
                            target="_blank" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium"
                        >
                            IMDB Link
                        </a>
                    </div>

                    <!-- Synopsis -->
                    <div class="synopsis text-left bg-gray-800 p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-bold mb-2">Synopsis:</h3>
                        <p class="text-sm leading-relaxed">{{ $movie->synopsis }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
