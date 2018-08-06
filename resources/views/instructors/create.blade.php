@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>
                            Add Instructor
                        </h2>
                    </div>
                    <form action="/instructors" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name*</label>
                            <input type="text" name="name" class="form-control {{ $errors->first('name', 'is-invalid') }}" placeholder="Enter instructor name" {{--required--}}>
                            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="name">Email*</label>
                            <input type="email" name="email" class="form-control {{ $errors->first('email', 'is-invalid') }}" placeholder="Enter instructor email">
                            {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="type">Type*</label>
                            <select class="form-control">
                                <option value="">Select an instructor type</option>
                                <option value="coach">Coach</option>
                                <option value="volunteer">Volunteer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Hourly rate*</label>
                            <input type="text" name="hourly_rate" class="form-control {{ $errors->first('hourly_rate', 'is-invalid') }}" placeholder="Enter instructor hourly rate">
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
