@extends('layouts.datatables')

@section('content')
    <div class="container">
        <table class="table table-bordered" id="instructors-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Email</th>
                    <th>Hourly rate</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('scripts')
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            $('#instructors-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route("datatables.instructors.data") !!}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'type', name: 'type' },
                    { data: 'email', name: 'email' },
                    { data: 'hourly_rate', name: 'hourly_rate' },
                    { data: 'action', name: 'action' },
                ]
            });
        });
    </script>
@endpush
