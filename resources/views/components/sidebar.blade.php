<!-- Left Sidebar -->
@if (Auth::check() && Auth::user()->position != null)
<nav class="navbar navbar-expand-md shadow-sm">
    <div class="container">
        <div class="row">
            <div class="col py-2">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="container" id="sidebarCollapse">
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-user"></i> Profile
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-cogs"></i> Settings
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
@endif



