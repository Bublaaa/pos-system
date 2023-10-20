@extends('layouts.ownerview')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Tambah menu baru -->
<form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Menu Card -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5>Detil menu</h5>
                </div>
                <div class="card-body">
                    <div class="row">
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
                                id="name" placeholder="Name" value="{{ old('name') }}" required=true>
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
                </div>
            </div>
        </div>
        <!-- Ingredient Card -->
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5>Bahan baku</h5>
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
                        <div class="row ingredient-row">
                            <div class="col col-md">
                                <div class="form-group">
                                    <input type="text" name="ingredients[0][name]"
                                        class="form-control @error('ingredients[0][name]') is-invalid @enderror"
                                        id="ingredients[0][name]" placeholder="Nama Bahan"
                                        value="{{ old('ingredients[0][name]') }}" required=true>
                                    @error('ingredients[0][name]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="number" name="ingredients[0][quantity]"
                                        class="form-control @error('ingredients[0][quantity]') is-invalid @enderror"
                                        id="ingredients[0][quantity]" placeholder="Jumlah Bahan"
                                        value="{{ old('ingredients[0][quantity]') }}" inputmode="numeric" min="1"
                                        required=true>
                                    @error('ingredients[0][quantity]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <select name="ingredients[0][unit]" class="form-control" id="ingredients[0][unit]">
                                        <option value="gram">Gram</option>
                                        <option value="ml"> Mililiter</option>
                                    </select>
                                    @error('unit')
                                    <span class="ingredients[0][unit]" role="alert">
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
                    </div>
                </div>
                <div class=" card-footer">
                    <button class="btn btn-primary" type="submit">Simpan Menu</button>
                </div>
            </div>
        </div>
    </div>
</form>

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
var ingredientIndex = 0;
document.getElementById("addIngredient").onclick = function() {
    ++ingredientIndex;

    var newRow = document.createElement("div");
    newRow.className = "row";
    newRow.innerHTML = `
            <div class="col">
                <div class="form-group">
                    <div class="form-group">
                        <input type="text" name="ingredients[${ingredientIndex}][name]"
                            class="form-control @error('ingredients[${ingredientIndex}][name]') is-invalid @enderror"
                            id="ingredients[${ingredientIndex}][name]" placeholder="Nama Bahan"
                            value="{{ old('ingredients[${ingredientIndex}][name]') }}">
                        @error('ingredients[${ingredientIndex}][name]')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <div class="form-group">
                        <input type="text" name="ingredients[${ingredientIndex}][quantity]"
                            class="form-control @error('ingredients[${ingredientIndex}][quantity]') is-invalid @enderror"
                            id="ingredients[${ingredientIndex}][quantity]" placeholder="Jumlah Bahan"
                            value="{{ old('ingredients[${ingredientIndex}][quantity]') }}">
                        @error('ingredients[${ingredientIndex}][quantity]')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
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