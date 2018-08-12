@section('head')
    @parent
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

<div class="card" style="margin-top:1em;">
    <div class="card-body">
        <div class="card-title">
            <h3>Assign Instructor</h3>
        </div>
        <form action="{{ route('courses.assign.instructor', $course->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="type">Type*</label>
                <select name="type" class="form-control {{ $errors->first('type', 'is-invalid') }}" v-model="type" @change="loadInstructors()" required>
                    <option value="">Select an instructor type</option>
                    <option value="coach">Coach</option>
                    <option value="volunteer">Volunteer</option>
                </select>
                {!! $errors->first('type', '<div class="invalid-feedback d-block">:message</div>') !!}
            </div>
            <div class="form-group">
                <label for="type">Instructor*</label>
                <select name="instructor_id" class="form-control {{ $errors->first('instructor_id', 'is-invalid') }}" v-model="instructor" required>
                    <option value="">Select an instructor</option>
                    <option v-for="instructor in instructors" :key="instructor.id" :value="instructor.id">
                        @{{ instructor.name }} @{{ instructor['hourly_rate'] != 0 ? '(£' + instructor['hourly_rate_in_pounds'] + ' p/h)' : '' }}
                    </option>
                </select>
                {!! $errors->first('instructor_id', '<div class="invalid-feedback d-block">:message</div>') !!}
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
                {!! $errors->first('date_from', '<div class="invalid-feedback d-block">:message</div>') !!}
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
                {!! $errors->first('date_to', '<div class="invalid-feedback d-block">:message</div>') !!}
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</div>

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            mounted:function(){
                if (this.type !== '') {
                    this.loadInstructors();
                }
            },
            data: {
                coachList: {!! $coaches !!},
                volunteerList: {!! $volunteers !!},
                type: '{{ old("type") }}',
                instructor: '{{ old("instructor_id") }}',
                instructors: []
            },
            methods: {
                loadInstructors: function () {
                    this.instructors = this[this.type + 'List'];
                }
            }
        });

        $(function() {
            let dateFromOld = '{{ old("date_from") }}';
            let dateToOld = '{{ old("date_to") }}';

            let minDate = '{{ $course->date_from->format("d-m-Y") }}';
            let maxDate = '{{ $course->date_to->format("d-m-Y") }}';

            let dateFrom = $('input[name="date_from"]').daterangepicker({
                'singleDatePicker': true,
                'opens': 'center',
                'drops': 'up',
                'locale': {
                'format': 'DD-MM-YYYY'
                },
                'startDate': dateFromOld ? dateFromOld : minDate,
                'minDate': minDate,
                'maxDate': maxDate,
            }, function(start, end, label) {
                // TODO
                // if dateTo < start, set dateTo = start
            });

            let dateTo = $('input[name="date_to"]').daterangepicker({
                'singleDatePicker': true,
                'opens': 'center',
                'drops': 'up',
                'locale': {
                'format': 'DD-MM-YYYY'
                },
                'startDate': dateFromOld ? dateFromOld : maxDate,
                'minDate': minDate,
                'maxDate': maxDate,
            }, function(start, end, label) {
                // TODO
                // if dateFrom > start, set dateFrom = start
            });
        });
    </script>
@endpush
