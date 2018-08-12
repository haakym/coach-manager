@extends('layouts.app')

@section('head')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <style>
        #calendar {
            
        }
        .fc-row {
            overflow: hidden;
        }

		.pending {
			background: #6c757d;
			border: #6c757d 1px solid;
		}
		.assigned {
			background: #38c172;
			border: #38c172 1px solid;
		}
        .badge {
            color: white;
        }
        .badge-pending {
			background: #6c757d;
		}
		.badge-assigned {
			background: #38c172;
		}
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div id='calendar'></div>
</div>

<div id="legend">
    <span class="badge badge-pill badge-pending">Pending</span>
    <span class="badge badge-pill badge-assigned">Assigned</span>
</div>

@endsection

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                defaultView: 'month',
                displayEventTime: false,
                height: 550,
                events: {
                    url: 'calendar/data',
                    type: 'GET',
                    data: function() {
                        
                        var date = $('#calendar').fullCalendar('getDate')._d;
                        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
                        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

                        return {
                            start: moment(firstDay).format('YYYY-MM-DD'),
                            end: moment(lastDay).format('YYYY-MM-DD')
                        }
                    },
                    success: function(data) {
                        // console.log(data);
                    },
                    error: function(data) {
                        alert('There was an error while fetching events! Please contact the administrator.');
                    }
                },
                nextDayThreshold: '00:00:00',
                eventRender: function(event, element) {
                    var newLine = '';

                    if (event.start.format('YYYY-MM-DD') === event.end.format('YYYY-MM-DD')) {
                        newLine = '<br> ';
                    }

                    // if (event.cover) {
                    //     element.find('.fc-title').append(newLine + ' (Cover: ' + event.cover + ')'); 
                    // }
                }
            });
        });
    </script>
@endpush
