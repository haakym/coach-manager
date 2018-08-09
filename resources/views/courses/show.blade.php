@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>
                            {{ $course->name }}
                            <span class="badge badge-pill badge-{{ $course->status != 'pending' ? success : 'secondary' }}">
                                {{ ucfirst($course->status) }}
                            </span>
                        </h2>
                    </div>
                    @if($course->description)
                        <p>{{ $course->description }}</p>
                    @endif
                    @if($course->address)
                        <address>
                            <span role="img" aria-label="Address">📍</span> {{ $course->address }}
                        </address>
                    @endif
                    <p>
                        <span role="img" aria-label="Date">📆</span> 
                        {{ $course->date_from->format('F j, Y') }} to 
                        {{ $course->date_to->format('F j, Y') }}
                    </p>
                    <p>Coaches required: {{ $course->coaches_required }}</p>
                    <p>Volunteers required: {{ $course->volunteers_required }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
