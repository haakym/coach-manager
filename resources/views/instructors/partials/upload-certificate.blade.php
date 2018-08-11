@section('head')
    @parent
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

<div class="card" style="margin-top: 1em;">
    <div class="card-body">
        <div class="card-title">
            <h3>
                Upload Certificate
            </h3>
        </div>
        <form action="/instructors/{{ $instructor->id }}/certificates" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name*</label>
                <input type="text"
                    name="name"
                    class="form-control {{ $errors->first('name', 'is-invalid') }}"
                    value="{{ old('name') }}"
                    placeholder="Enter certificate name"
                    required
                >
                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                <label for="description">Description*</label>
                <input type="text"
                    name="description"
                    class="form-control {{ $errors->first('description', 'is-invalid') }}"
                    value="{{ old('description') }}"
                    placeholder="Enter certificate description"
                    required
                >
                {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                <label for="type">Type*</label>
                <select name="type" class="form-control {{ $errors->first('type', 'is-invalid') }}">
                    <option value="">Select an certificate type</option>
                    <option value="qualification" {{ old('type') == 'qualification' ? 'selected' : '' }}>Qualification</option>
                    <option value="background-check" {{ old('type') == 'background-check' ? 'selected' : '' }}>Background check</option>
                </select>
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry date*</label>
                <input type="text"
                    name="expiry_date"
                    class="form-control {{ $errors->first('expiry_date', 'is-invalid') }}"
                    value="{{ old('expiry_date')}}"
                    placeholder="Use date-picker to enter a date"
                    required
                >
                <small class="form-text text-muted">
                    Must be valid for at least one more month
                </small>
                {!! $errors->first('expiry_date', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                <label for="file">File*</label>
                <input type="file"
                    name="file"
                    class="form-control {{ $errors->first('file', 'is-invalid') }}"
                    placeholder="Select file"
                    required
                >
                {!! $errors->first('file', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</div>

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
    $(function() {
        let expiryDateOld = '{{ old("expiry_date") }}';
        let dateFrom = $('input[name="expiry_date"]').daterangepicker({
            'singleDatePicker': true,
            'opens': 'center',
            'drops': 'up',
            'locale': {
               'format': 'DD-MM-YYYY'
            },
            'startDate': expiryDateOld ? expiryDateOld : moment().add(1, 'month'),
            'minDate': moment().add(1, 'month'),
        }, function(start, end, label) {
            // TODO
            // if dateTo < start, set dateTo = start
        });
    });
    </script>
@endpush