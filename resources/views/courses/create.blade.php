@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>
                            Add Course
                        </h2>
                    </div>
                    <form action="/courses" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name*</label>
                            <input type="text"
                                name="name"
                                class="form-control {{ $errors->first('name', 'is-invalid') }}"
                                value="{{ old('name') }}"
                                placeholder="Enter course name"
                                required
                            >
                            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="name">Description</label>
                            <textarea name="description"
                                class="form-control {{ $errors->first('description', 'is-invalid') }}"
                                rows="3"
                                placeholder="Enter course description"
                            >{{ old('description') }}</textarea>
                            {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text"
                                name="address"
                                class="form-control {{ $errors->first('address', 'is-invalid') }}"
                                value="{{ old('address') }}"
                                placeholder="Enter course address"
                            >
                            {!! $errors->first('address', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="date_from">Date from*</label>
                            <input type="text"
                                name="date_from"
                                class="form-control {{ $errors->first('date_from', 'is-invalid') }}"
                                value="{{ old('date_from')}}"
                                placeholder="Use date-picker to enter a date"
                                required
                            >
                            {!! $errors->first('date_from', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="date_to">Date to*</label>
                            <input type="text"
                                name="date_to"
                                class="form-control {{ $errors->first('date_to', 'is-invalid') }}"
                                value="{{ old('date_to')}}"
                                placeholder="Use date-picker to enter a date"
                                required
                            >
                            {!! $errors->first('date_to', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="coaches_required">Coaches required*</label>
                            <input type="number"
                                name="coaches_required"
                                class="form-control {{ $errors->first('coaches_required', 'is-invalid') }}"
                                value="{{ old('coaches_required') }}"
                                placeholder="Enter number of coaches"
                                required
                            >
                            {!! $errors->first('coaches_required', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="volunteers_required">Volunteers required*</label>
                            <input type="number"
                                name="volunteers_required"
                                class="form-control {{ $errors->first('volunteers_required', 'is-invalid') }}"
                                value="{{ old('volunteers_required') }}"
                                placeholder="Enter number of volunteers"
                                required
                            >
                            {!! $errors->first('volunteers_required', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
