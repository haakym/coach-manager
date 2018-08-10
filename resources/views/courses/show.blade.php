@extends('layouts.app')

@section('head')
    @parent
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

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

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
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
