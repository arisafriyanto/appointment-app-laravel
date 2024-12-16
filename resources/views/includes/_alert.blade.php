@if (session('error'))
    <div class="position-absolute" style="top: 3rem; right: 1rem;">
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    </div>
@endif

@if (session('success'))
    <div class="position-absolute" style="top: 3rem; right: 1rem;">
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    </div>
@endif
