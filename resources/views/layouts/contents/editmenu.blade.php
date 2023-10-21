@extends('layouts.ownerview')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Tambah menu baru -->
<div class="row">
    <!-- Menu Card -->
    <div class="col-md-3">
        <form action="{{ route('menu.update', $menu) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    <h5>Edit menu</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($menu->image)
                        <img class="product-img" src="{{ Storage::url($menu->image) }}"
                            style="width: 100%; height: 100%; object-fit: fill;">
                        @else
                        <p>Foto menu tidak tersedia</p>
                        @endif
                        <div class="form-group">
                            <label for="image">Ganti foto menu</label>
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
                                id="name" placeholder="Name" value="{{ $menu->name }}" required=true>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror"
                                id="status">
                                <option value="1" {{ $menu->status === 1 ? 'selected' : ''}}>Tersedia</option>
                                <option value="0" {{ $menu->status === 0 ? 'selected' : ''}}>Tidak Tersedia</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class=" card-footer">
                    <button class="btn btn-primary" type="submit">Simpan Menu</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Ingredient Card -->
    <div class=" col-md-9">
        <form action="{{ route('ingredient.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5>Edit bahan</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button name="addIngredient" id="addIngredient" type="button" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container" id="ingredientContainer">
                        <div class="row">
                            <div class="col-3">
                                <p>Nama</p>
                            </div>
                            <div class="col-4">
                                <p>Jumlah</p>
                            </div>
                            <div class="col-4">
                                <p>Satuan</p>
                            </div>
                            <div class="col-3">
                            </div>
                        </div>
                        @foreach($ingredients as $index => $ingredient)
                        <div class="row">
                            <div class="col col-md">
                                <div class="form-group">
                                    <input type="text" name="ingredients[{{$index}}][name]"
                                        class="form-control @error('ingredients[{{$index}}][name]') is-invalid @enderror"
                                        id="ingredients[{{$index}}][name]" placeholder="Nama Bahan"
                                        value="{{ $ingredient->name }}">
                                    @error('ingredients[{{$index}}][name]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="number" name="ingredients[{{$index}}][quantity]"
                                        class="form-control @error('ingredients[{{$index}}][quantity]') is-invalid @enderror"
                                        id="ingredients[{{$index}}][quantity]" placeholder="Jumlah Bahan"
                                        value="{{ $ingredient->quantity }}" inputmode="numeric" min="1">
                                    @error('ingredients[{{$index}}][quantity]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <select name="ingredients[{{$index}}][unit]" class="form-control"
                                        id="ingredients[{{$index}}][unit]">
                                        <option value="gram" {{ $ingredient->unit == "gram" ? 'selected' : '' }}>Gram
                                        </option>
                                        <option value="ml" {{ $ingredient->unit == "ml" ? 'selected' : '' }}>
                                            Mililiter
                                        </option>
                                    </select>
                                    @error('ingredients[{{$index}}][unit]')
                                    <span class="ingredients[{{$index}}][unit]" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-danger remove-row" onclick="removeRow(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class=" card-footer">
                    <button class="btn btn-primary" type="submit">Simpan Bahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Prevent the last remaining row from deleted & delete selected row
function removeRow(button) {
    var row = button.closest(".row");
    if (row.parentElement.children.length > 2) {
        row.remove();
    } else {
        alert("You can't delete the last row.");
    }
}

// Add new row when button clicked
var ingredientIndex = "{{$ingredients->count()-1}}";

document.getElementById("addIngredient").onclick = function() {
    console.log(ingredientIndex.type);

    ++ingredientIndex;

    var newRow = document.createElement("div");
    newRow.className = "row";
    newRow.innerHTML = `
            <div class="col">
                <div class="form-group">
                    <input type="text" name="ingredients[${ingredientIndex}][name]"
                        class="form-control @error('ingredients[${ingredientIndex}][name]') is-invalid @enderror"
                        id="ingredients[${ingredientIndex}][name]" placeholder="Nama Bahan"
                        value="{{ old('ingredients[${ingredientIndex}][name]') }}" required=true>
                    @error('ingredients[${ingredientIndex}][name]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <input type="number" name="ingredients[${ingredientIndex}][quantity]"
                        class="form-control @error('ingredients[${ingredientIndex}][quantity]') is-invalid @enderror"
                        id="ingredients[${ingredientIndex}][quantity]" placeholder="Jumlah Bahan"
                        value="" inputmode="numeric" min="1" required=true>
                    @error('ingredients[${ingredientIndex}][quantity]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <select name="ingredients[${ingredientIndex}][unit]" class="form-control" id="ingredients[${ingredientIndex}][unit]">
                        <option value="gram">Gram</option>
                        <option value="ml"> Mililiter</option>
                    </select>
                    @error('unit')
                    <span class="ingredients[${ingredientIndex}][unit]" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col">
                <button type="button" class="btn btn-danger remove-row" onclick="removeRow(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;

    // Append the new row to the container
    document.getElementById("ingredientContainer").appendChild(newRow);

    // Attach the onclick event to the remove button in the new row
    newRow.querySelector(".remove-row").onclick = function() {
        removeRow(this);
    };
};
</script>
@endsection