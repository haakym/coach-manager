<div class="card" style="margin-top:1em;">
    <div class="card-body">
        <div class="card-title">
            <h3>Assign Instructor</h3>
        </div>
        <form action="{{ route('courses.assign.instructor', $course->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="type">Type*</label>
                <select name="type" class="form-control" v-model="type" @change="loadInstructors()" required>
                    <option value="">Select an instructor type</option>
                    <option value="coach">Coach</option>
                    <option value="volunteer">Volunteer</option>
                </select>
                {!! $errors->first('type', '<div class="invalid-feedback d-block">:message</div>') !!}
            </div>
            <div class="form-group">
                <label for="type">Instructor*</label>
                <select name="instructor_id" class="form-control" v-model="instructor" required>
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