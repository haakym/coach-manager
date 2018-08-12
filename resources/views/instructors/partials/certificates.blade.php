<h3>Certificates</h3>
<table class="table table-bordered table-sm">
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
                <td>{{ $certificate->type }}</td>
                <td>{{ $certificate->name }}</td>
                <td>{{ $certificate->description }}</td>
                <td
                    @if($certificate->has_expired)
                        class="table-danger"
                    @endif
                >
                    {{ $certificate->expiry_date ? $certificate->expiry_date->format('d-m-Y') : 'N/A' }}</td>
                <td>
                    <a href="{{ route('certificates.download', ['certificate' => $certificate->id]) }}">
                        Download
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
