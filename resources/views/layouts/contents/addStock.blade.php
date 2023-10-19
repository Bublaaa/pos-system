@extends('layouts.ownerview')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Tambah menu baru -->
<form action="{{ route('stock.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Menu Card -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group">
                            <label for="image">Bukti pembelian</label>
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
                    </div>
                    <input type="hidden" name="kind" id="kind" value="pembelian">
                </div>
            </div>
        </div>
        <!-- Ingredient Card -->
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5>Bahan yang dibeli</h5>
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
                        <div class="row">
                            <div class="col col-md">
                                <div class="form-group">
                                    <select name="ingredients[0][name]" class="form-control" id="ingredients[0][name]">
                                        @foreach($ingredientNames as $name)
                                        <option value="{{ $name }}">{{$name}}</option>
                                        @endforeach
                                    </select>
                                    @error('unit')
                                    <span class="ingredients[0][name]" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="number" name="ingredients[0][quantity]"
                                        class="form-control @error('ingredients[0][quantity]') is-invalid @enderror"
                                        id="ingredients[0][quantity]" placeholder="Jumlah Bahan" value=""
                                        inputmode="numeric" min="1" required=true>
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
                    <button class="btn btn-primary" type="submit">Simpan Transaksi</button>
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
                    <select name="ingredients[${ingredientIndex}][name]" class="form-control" id="ingredients[${ingredientIndex}][name]">
                        @foreach($ingredientNames as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('ingredients[${ingredientIndex}][name]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col">
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
            <div class="col">
                <div class="form-group">
                    <select name="ingredients[${ingredientIndex}][unit]" class="form-control" id="ingredients[${ingredientIndex}][unit]">
                        <option value="gram">Gram</option>
                        <option value="ml"> Mililiter</option>
                    </select>
                    @error('unit')
                    <span class="[${ingredientIndex}][unit]" role="alert">
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