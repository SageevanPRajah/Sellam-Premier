<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Show') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
                <div class="container">
                    <h1 class="text-center text-white mb-6">Edit Show</h1>

                    <!-- Success Message -->
                    @if(session()->has('success'))
                        <div class="bg-green-500 text-white p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="bg-red-500 text-white p-4 rounded mb-4">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form to edit an existing Show -->
                    <form method="POST" action="{{ route('show.update', ['show' => $show]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Show Date -->
                        <div class="mb-4">
                            <label for="date" class="block text-white font-bold mb-2">Date</label>
                            <input 
                                type="date" 
                                name="date" 
                                id="date" 
                                class="w-full px-4 py-2 rounded bg-gray-700 text-white" 
                                value="{{ old('date', $show->date) }}" 
                                required 
                            />
                        </div>

                        <!-- Show Time -->
                        <div class="mb-4">
                            <label for="time" class="block text-white font-bold mb-2">Time</label>
                            <select 
                                name="time" 
                                id="time" 
                                class="w-full px-4 py-2 rounded bg-gray-700 text-white" 
                                required
                            >
                                @php
                                    $start = strtotime('00:00'); // Start time (12:00 AM)
                                    $end = strtotime('23:59'); // End time (11:59 PM)
                                    while ($start <= $end) {
                                        $time = date('g:i A', $start); // Format time as "6:00 AM"
                                        $selected = $time === $show->time ? 'selected' : '';
                                        echo "<option value=\"$time\" $selected>$time</option>";
                                        $start = strtotime('+30 minutes', $start); // Increment by 30 minutes
                                    }
                                @endphp
                            </select>
                        </div>

                        <!-- Show Type (movie_code) -->
                        <div class="mb-4">
                            <label for="movie_code" class="block text-white font-bold mb-2">Price Type</label>
                            <select 
                                name="movie_code" 
                                id="movie_code" 
                                class="w-full px-4 py-2 rounded bg-gray-700 text-white" 
                                required
                            >
                                <option value="">-- Select Show Type --</option>
                                <option value="Price 1" {{ $show->movie_code === 'Price 1' ? 'selected' : '' }}>Price 1</option>
                                <option value="Price 2" {{ $show->movie_code === 'Price 2' ? 'selected' : '' }}>Price 2</option>
                                <option value="Price 3" {{ $show->movie_code === 'Price 3' ? 'selected' : '' }}>Price 3</option>
                            </select>
                        </div>

                        <!-- Movie Name -->
                        <div class="mb-4">
                            <label for="movie_name" class="block text-white font-bold mb-2">Movie Name</label>
                            <input 
                                type="text" 
                                name="movie_name" 
                                id="movie_name" 
                                class="w-full px-4 py-2 rounded bg-gray-700 text-white" 
                                value="{{ old('movie_name', $show->movie_name) }}" 
                                readonly 
                            />
                        </div>

                        <!-- Poster Field + Current Poster Preview -->
                        <div class="mb-4">
                            <label for="poster" class="block text-white font-bold mb-2">Show Poster</label>
                            @if($show->poster)
                                <div class="mt-2 text-center">
                                    <p class="text-white">Current Poster:</p>
                                    <img 
                                        src="{{ asset('storage/' . $show->poster) }}" 
                                        alt="Current Show Poster" 
                                        class="mx-auto rounded shadow-md" 
                                        style="max-width: 150px;"
                                    />
                                </div>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button 
                                type="submit" 
                                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded"
                            >
                                Update the Show
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
