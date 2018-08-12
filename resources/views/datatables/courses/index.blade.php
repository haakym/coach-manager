@extends('layouts.datatables')

@section('content')
    <div class="container">
        <table class="table table-bordered" id="courses-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Address</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Coaches Required</th>
                    <th>Volunteers Required</th>
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
            $('#courses-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route("datatables.courses.data") !!}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'address', name: 'address' },
                    { data: 'date_from', name: 'date_from' },
                    { data: 'date_to', name: 'date_to' },
                    { data: 'coaches_required', name: 'coaches_required' },
                    { data: 'volunteers_required', name: 'volunteers_required' },
                    { data: 'action', name: 'action' },
                ]
            });
        });
    </script>
@endpush
