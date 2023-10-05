<!-- Left Sidebar -->
@if (Auth::check() && Auth::user()->position != null)
<div class="container-fluid bg-white" style="height: 100vh; vertical-align:top; width:100%;">
    <div class="row">
        <div class="col-md-3 py-4">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>
        <div class=" list-group-flush ml-3 pr-3">
            <a href="#" class="list-group-item list-group-item-action p-2 bg-white">
                <i class="fas fa-home p-2"></i> Dashboard
            </a>
            <a href="#" class="list-group-item list-group-item-action p-2 bg-white">
                <i class="fas fa-user p-2"></i> Profile
            </a>
            <a href="#" class="list-group-item list-group-item-action p-2 bg-white">
                <i class="fas fa-cogs p-2"></i> Settings
            </a>
        </div>
    </div>
</div>
@endif