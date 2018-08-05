<h3>Certificates</h3>
<table class="table">
    <thead>
        <tr>
            <th>Type</th>
            <th>Name</th>
            <th>Description</th>
            <th>Expiry Date</th>
            <th>Download</th>
        </tr>
    </thead>
    <tbody>
        @foreach($certificates as $certificate)
            <tr>
                <th>{{ $certificate->type }}</th>
                <th>{{ $certificate->name }}</th>
                <th>{{ $certificate->description }}</th>
                <th>
                    {{ $certificate->expiry_date ? $certificate->expiry_date->format('d-m-Y') : 'N/A' }}</th>
                <th>
                    <a href="#">Download</a>
                </th>
            </tr>
        @endforeach
    </tbody>
</table>