@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>
                            Edit Instructor
                        </h2>
                    </div>
                    <form action="/instructors/{{ $instructor->id }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Name*</label>
                            <input type="text"
                                name="name"
                                class="form-control {{ $errors->first('name', 'is-invalid') }}"
                                value="{{ old('name') ? old('name') : $instructor->name }}"
                                placeholder="Enter instructor name"
                                required
                            >
                            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="name">Email*</label>
                            <input type="email"
                                name="email"
                                class="form-control {{ $errors->first('email', 'is-invalid') }}"
                                value="{{ old('email') ? old('email') : $instructor->email }}"
                                placeholder="Enter instructor email"
                                required
                            >
                            {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="type">Type*</label>
                            <select name="type" class="form-control {{ $errors->first('type', 'is-invalid') }}" v-model="instructor_type">
                                <option value="">Select an instructor type</option>
                                <option value="coach">Coach</option>
                                <option value="volunteer">Volunteer</option>
                            </select>
                        </div>
                        <div class="form-group" v-if="instructor_type == 'coach'" v-cloak>
                            <label for="name">Hourly rate*</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">&pound;</div>
                                </div>
                                <input type="number"
                                    name="hourly_rate" 
                                    class="form-control {{ $errors->first('hourly_rate', 'is-invalid') }}" 
                                    value="{{ old('hourly_rate') ? old('hourly_rate') : $instructor->hourly_rate_in_pounds }}"
                                    placeholder="Enter instructor hourly rate in pounds"
                                    min="1" step="any"
                                >
                            </div>
                            {!! $errors->first('hourly_rate', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                instructor_type: '{{ old("type") ? old("type") : $instructor->type }}'
            }
        });
    </script>
@endpush
