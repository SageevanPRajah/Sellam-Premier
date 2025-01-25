<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shows') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">

                <h1 class="text-center text-white mb-6">Shows</h1>

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

                <!-- Add New Show Button -->
                <div class="text-right mb-6">
                    <a 
                        href="{{ route('show.create') }}" 
                        class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded inline-flex items-center"
                    >
                        <i class="fa fa-plus mr-2"></i> Add New Show
                    </a>
                </div>

                <!-- Shows Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-700 text-white rounded">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left">Date</th>
                                <th class="px-4 py-2 text-left">Time</th>
                                <th class="px-4 py-2 text-left">Price Type</th>
                                <th class="px-4 py-2 text-left">Movie Name</th>
                                <th class="px-4 py-2 text-center">Poster</th>
                                <th class="px-4 py-2 text-center">Edit</th>
                                <th class="px-4 py-2 text-center">Delete</th>
                                <th class="px-4 py-2 text-center">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shows as $show)
                                <tr class="border-b border-gray-600">
                                    <td class="px-4 py-2">{{ $show->id }}</td>
                                    <td class="px-4 py-2">{{ $show->date }}</td>
                                    <td class="px-4 py-2">{{ $show->time }}</td>
                                    <td class="px-4 py-2">{{ $show->movie_code }}</td>
                                    <td class="px-4 py-2">{{ $show->movie_name }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <img 
                                            src="{{ $show->poster ? asset('storage/' . $show->poster) : asset('images/default-poster.jpg') }}" 
                                            alt="Poster" 
                                            class="rounded w-16 h-auto"
                                        />
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <a 
                                            href="{{ route('show.edit', $show) }}" 
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded inline-flex items-center"
                                        >
                                            <i class="fa fa-edit mr-2"></i> Edit
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <form method="POST" action="{{ route('show.destroy', $show) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded inline-flex items-center"
                                                onclick="return confirm('Are you sure you want to delete this show?')"
                                            >
                                                <i class="fa fa-trash mr-2"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <a 
                                            href="{{ route('show.detail', $show) }}" 
                                            class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded inline-flex items-center"
                                        >
                                            <i class="fa fa-eye mr-2"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $shows->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
