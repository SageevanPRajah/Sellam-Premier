<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Movie') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-xl sm:rounded-lg p-6 text-white">
                <h1 class="text-2xl font-bold text-center mb-6">Edit Movie</h1>

                <!-- Success Message -->
                @if(session()->has('success'))
                    <div class="bg-green-500 text-center text-white p-2 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('movie.update', ['movie' => $movie]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="w-full rounded-lg border-gray-700 bg-gray-800 text-white p-3" 
                            value="{{ $movie->name }}" 
                            required 
                        />
                    </div>

                    <!-- Poster -->
                    <div class="mb-4">
                        <label for="poster" class="block text-sm font-medium text-gray-300 mb-1">Poster</label>
                        <input 
                            type="file" 
                            name="poster" 
                            id="poster" 
                            class="block w-full text-sm text-gray-300 bg-gray-800 rounded-lg border-gray-700" 
                            accept="image/*" 
                        />
                        <div class="mt-3">
                            <p class="text-sm text-gray-400">Current Poster:</p>
                            <img 
                                src="{{ asset('storage/' . $movie->poster) }}" 
                                alt="Poster" 
                                class="w-32 rounded-lg mt-2"
                            />
                        </div>
                    </div>

                    <!-- Trailer Link -->
                    <div class="mb-4">
                        <label for="trailer_link" class="block text-sm font-medium text-gray-300 mb-1">Trailer Link</label>
                        <input 
                            type="text" 
                            name="trailer_link" 
                            id="trailer_link" 
                            class="w-full rounded-lg border-gray-700 bg-gray-800 text-white p-3" 
                            value="{{ $movie->trailer_link }}" 
                            required 
                        />
                    </div>

                    <!-- Duration -->
                    <div class="mb-4">
                        <label for="duration" class="block text-sm font-medium text-gray-300 mb-1">Duration (in minutes)</label>
                        <input 
                            type="number" 
                            name="duration" 
                            id="duration" 
                            class="w-full rounded-lg border-gray-700 bg-gray-800 text-white p-3" 
                            value="{{ $movie->duration }}" 
                            required 
                        />
                    </div>

                    <!-- Release Date -->
                    <div class="mb-4">
                        <label for="release_date" class="block text-sm font-medium text-gray-300 mb-1">Release Date</label>
                        <input 
                            type="date" 
                            name="release_date" 
                            id="release_date" 
                            class="w-full rounded-lg border-gray-700 bg-gray-800 text-white p-3" 
                            value="{{ $movie->release_date }}" 
                            required 
                        />
                    </div>

                    <!-- IMDB Link -->
                    <div class="mb-4">
                        <label for="imdb_link" class="block text-sm font-medium text-gray-300 mb-1">IMDB Link</label>
                        <input 
                            type="text" 
                            name="imdb_link" 
                            id="imdb_link" 
                            class="w-full rounded-lg border-gray-700 bg-gray-800 text-white p-3" 
                            value="{{ $movie->imdb_link }}" 
                            required 
                        />
                    </div>

                    <!-- Active Toggle -->
                    <div class="mb-4">
                        <label for="active" class="block text-sm font-medium text-gray-300 mb-1">Active</label>
                        <input type="hidden" name="active" value="0">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="active" 
                                id="active" 
                                value="1" 
                                {{ $movie->active ? 'checked' : '' }} 
                                class="form-checkbox h-5 w-5 text-green-600"
                            />
                            <span class="ml-2 text-sm text-gray-300">Set as active</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button 
                            type="submit" 
                            class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-lg"
                        >
                            Update Movie
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
