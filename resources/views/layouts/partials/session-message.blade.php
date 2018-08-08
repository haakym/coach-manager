@if(session()->has('message'))
    <div class="container">
        <div class="alert alert-{{ session('status', 'info') }}" role="alert">
            {{ session('message') }}
        </div>
    </div>
@endif