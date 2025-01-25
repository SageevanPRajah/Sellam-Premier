<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a New Movie') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
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

                <form method="POST" action="{{ route('movie.store') }}" onsubmit="return convertDuration()" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="name" class="block font-medium text-gray-700">Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            placeholder="Enter Name" 
                            required 
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        />
                    </div>
                    <div class="form-group mb-4">
                        <label for="poster" class="block font-medium text-gray-700">Poster</label>
                        <input 
                            type="file" 
                            name="poster" 
                            id="poster" 
                            accept="image/*" 
                            required 
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        />
                    </div>
                    <div class="form-group mb-4">
                        <label for="trailer_link" class="block font-medium text-gray-700">Trailer Link</label>
                        <input 
                            type="text" 
                            name="trailer_link" 
                            id="trailer_link" 
                            placeholder="Enter Trailer Link" 
                            required 
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        />
                    </div>
                    <div class="form-group mb-4">
                        <label for="duration" class="block font-medium text-gray-700">Duration</label>
                        <div class="flex space-x-4">
                            <input 
                                type="number" 
                                id="hours" 
                                placeholder="Hours" 
                                min="0" 
                                required 
                                class="w-1/2 mt-1 block rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            />
                            <input 
                                type="number" 
                                id="minutes" 
                                placeholder="Minutes" 
                                min="0" 
                                max="59" 
                                required 
                                class="w-1/2 mt-1 block rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            />
                        </div>
                        <input type="hidden" name="duration" id="duration" />
                    </div>
                    <div class="form-group mb-4">
                        <label for="release_date" class="block font-medium text-gray-700">Release Date</label>
                        <input 
                            type="date" 
                            name="release_date" 
                            id="release_date" 
                            required 
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        />
                    </div>
                    <div class="form-group mb-4">
                        <label for="imdb_link" class="block font-medium text-gray-700">IMDB Link</label>
                        <input 
                            type="text" 
                            name="imdb_link" 
                            id="imdb_link" 
                            placeholder="Enter IMDB Link" 
                            required 
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Save Movie
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function convertDuration() {
            // Get the values of hours and minutes
            const hours = parseInt(document.getElementById('hours').value) || 0;
            const minutes = parseInt(document.getElementById('minutes').value) || 0;

            // Validate minutes
            if (minutes > 59) {
                alert("Minutes should be less than 60.");
                return false; // Prevent form submission
            }

            // Convert to total minutes
            const totalMinutes = (hours * 60) + minutes;

            // Set the total minutes in the hidden input field
            document.getElementById('duration').value = totalMinutes;

            return true; // Allow form submission
        }
    </script>
</x-app-layout>
