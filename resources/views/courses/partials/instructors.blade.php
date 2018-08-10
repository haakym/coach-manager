<table class="table table-bordered table-sm" style="text-align:center;">
    <thead>
        <tr>
            <th colspan="4">Instructors Assigned</th>
        </tr>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>From</th>
            <th>To</th>
        </tr>
    </thead>
    <tbody>
        @if($course->instructors()->count())
            @foreach($course->instructors as $instructor)
                <tr>
                    <td>{{ $instructor->name }}</td>
                    <td>{{ $instructor->type }}</td>
                    <td>{{ $instructor->pivot->date_from->format('d-m-Y') }}</td>
                    <td>{{ $instructor->pivot->date_to->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>