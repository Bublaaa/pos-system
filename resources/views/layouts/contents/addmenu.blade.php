@extends('layouts.ownerview')

@section('content')
<!-- Tambah menu baru -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Menu Baru</h3>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="image">Foto menu</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image" id="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Nama menu</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="name" placeholder="Name" value="{{ old('name') }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                            <option value="1" {{ old('status') === 1 ? 'selected' : ''}}>Tersedia</option>
                            <option value="0" {{ old('status') === 0 ? 'selected' : ''}}>Tidak Tersedia</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="row" id="ingredient-container">
                        <!-- Dynamically added rows will go here -->
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label>Bahan baku</label>
                        </div>
                        <div class="col-4">
                            <label>Jumlah</label>
                        </div>
                        <div class="col-4">
                            <label>Satuan</label>
                        </div>
                    </div>

                    @foreach ($ingredients as $ingredient)
                    <div class="row">
                        <div class="col-4">
                            <p>{{$ingredient['name']}}</p>
                        </div>
                        <div class="col-4">
                            <p>{{$ingredient['quantity']}}</p>
                        </div>
                        <div class="col-3">
                            <p>{{$ingredient['unit']}}</p>
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn btn-danger">-</button>
                        </div>
                    </div>
                    @endforeach
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" name="ingredientName"
                                        class="form-control @error('ingredientName') is-invalid @enderror"
                                        id="ingredientName" placeholder="Nama Bahan"
                                        value="{{ old('ingredientName') }}">
                                    @error('ingredientName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" name="ingredientQuantity"
                                        class="form-control @error('ingredientQuantity') is-invalid @enderror"
                                        id="ingredientQuantity" placeholder="Jumlah Bahan"
                                        value="{{ old('ingredientQuantity') }}">
                                    @error('ingredientQuantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <select name="ingredientUnit" class="form-control" id="ingredientUnit">
                                    <option value="gram" {{ $ingredient['unit'] === 'gram' ? 'selected' : '' }}>Gram
                                    </option>
                                    <option value="ml" {{ $ingredient['unit'] === 'ml' ? 'selected' : '' }}>Mililiter
                                    </option>
                                </select>
                                @error('unit')
                                <span class="ingredientUnit" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('owner.add.ingredient') }}" class="btn btn-primary">Add Ingredient</a>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" type="submit">Create</button>
    </div>
</div>
<script>
// function addIngredient() {}
</script>
@endsection