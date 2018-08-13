@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class='btn-toolbar pull-right'>
                            <div class='btn-group'>
                                <a href="{{ route('instructors.edit', ['id' => $instructor->id]) }}"
                                    class="btn btn-primary"
                                >Edit</a>
                            </div>
                        </div>
                        <h2>
                            {{ $instructor->name }} 
                            <span class="badge badge-pill badge-primary">
                                {{ ucfirst($instructor->type) }}
                            </span>
                        </h2>
                    </div>
                    <p>
                        <span role="img" aria-label="Email">✉</span>
                        <a href="mailto:{{ $instructor->email }}">{{ $instructor->email }}</a>
                    </p>
                    @if($instructor->hourly_rate)
                        <p>Hourly rate: £{{ $instructor->hourly_rate_in_pounds }}</p>
                    @endif
                    @if($instructor->certificates->count())
                        @include('instructors/partials/certificates', ['certificates' => $instructor->certificates])
                    @endif
                </div>
            </div>
            @include('instructors/partials/upload-certificate')
        </div>
    </div>
</div>
@endsection
