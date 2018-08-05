@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ $course->name }}</h2>
                    </div>
                    <p>
                        {{ $course->description }}
                    </p>
                    <address>
                        <span role="img" aria-label="Address">📍</span> {{ $course->address }}
                    </address>
                    </p>
                    <p>
                        <span role="img" aria-label="Date">📆</span> {{ $course->date_from->format('F j, Y') }} to {{ $course->date_to->format('F j, Y') }}
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
