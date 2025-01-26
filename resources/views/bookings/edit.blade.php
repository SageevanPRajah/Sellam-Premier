<x-app-layout>
    <div class="container">
        <h1>Edit Bookings</h1>
    
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
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
        <form action="{{ route('booking.bulkUpdate') }}" method="POST">
            @csrf
            @method('POST')
    
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" placeholder="Phone" class="form-control">
            </div>
    
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Name" class="form-control">
            </div>
    
            <div class="form-group">
                <input type="hidden" name="status" value="0">
            </div>
    
            <table class="table">
                <thead>
                    <tr>
                        <th>Movie Name</th>
                        <th>Seat Type</th>
                        <th>Seat No</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                    <tr>
                        <td>{{ $booking->movie_name }}</td>
                        <td>{{ $booking->seat_type }}</td>
                        <td>{{ $booking->seat_no }}</td>
                        <td>
                            <input type="checkbox" name="booking_ids[]" value="{{ $booking->id }}" >
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</x-app-layout>
