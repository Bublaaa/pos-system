@extends('layouts.ownerview')

@section('content')
<div class="wrapper">
    <section class="content">
        <div class="row">
            @foreach ($menus as $menu)
            <div class="col-md-3 col-12 mb-2">
                <div class="card bg-white">
                    <img class="card-img-top" src="https://placehold.co/150x100" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ $menu['name'] }}</h5>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('menu.edit', $menu) }}" class="btn btn-primary mr-2">
                            <i class="fas fa-edit"></i> Menu
                        </a>
                        <button type="button" class="btn btn-danger remove-row" data-toggle="modal"
                            data-target="#deleteModal{{ $menu['id'] }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal{{ $menu['id'] }}" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this menu?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <form action="{{ route('menu.destroy', $menu) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
<script>
@endsection