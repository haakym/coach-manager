@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex">
                            <div class="p-2">
                                <h2>
                                    {{ $course->name }}
                                    <span class="badge badge-pill badge-{{ $course->status != 'pending' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($course->status) }}
                                    </span>
                                </h2>
                            </div>
                            <div class="ml-auto p-2">
                                <div class='btn-toolbar pull-right'>
                                    <div class='btn-group'>
                                        <a href="{{ route('courses.edit', ['id' => $course->id]) }}"
                                            class="btn btn-primary"
                                        >Edit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @if($course->description)
                                <p>{{ $course->description }}</p>
                            @endif
                            @if($course->address)
                                <address>
                                    <span role="img" aria-label="Address">📍</span> {{ $course->address }}
                                </address>
                            @endif
                            <div>
                                <span role="img" aria-label="Dates">📅</span> 
                                {{ $course->date_from->format('d-m-Y') }} to {{ $course->date_to->format('d-m-Y') }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-sm" style="text-align:center;">
                                <thead>
                                    <tr>
                                        <th colspan="2">Instructors Required</th>
                                    </tr>
                                    <tr>
                                        <th>Coaches</th>
                                        <th>Volunteers</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $course->coaches_required }}</td>
                                        <td>{{ $course->volunteers_required }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            @if($course->instructors()->count())
                                @include('courses/partials/instructors')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if($course->status == 'pending')
                @include('courses/partials/assign-instructor')
            @endif
        </div>
    </div>
</div>
@endsection
