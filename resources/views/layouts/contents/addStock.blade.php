@extends('layouts.ownerView')

@section('content')

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>
</head>
<div class="container">
    <h2>Tambah Stok</h2>
    <!-- Tambah Stok baru -->
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
                                    <input type="file" class="form-control" name="image" id="image" required=true>
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
                            <div class="col-8">
                                <h5>Bahan yang dibeli</h5>
                            </div>
                            <div class="col-4 text-right">
                                <button name="addIngredient" id="addIngredient" type="button" class="btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="ingredientContainer">
                            <div class="row">
                                <div class="col-4 col-md-3">
                                    <p>Nama</p>
                                </div>
                                <div class="col-4 col-md-4">
                                    <p>Jumlah</p>
                                </div>
                                <div class="col-4 col-md-4">
                                    <p>Satuan</p>
                                </div>
                                <div class="col-md-3">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col col-md">
                                    <div class="form-group">
                                        <select name="ingredients[0][name]" class="custom-select"
                                            id="ingredients[0][name]">
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
                                        <select name="ingredients[0][unit]" class="custom-select"
                                            id="ingredients[0][unit]">
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
var ingredientIndex = 0;
document.getElementById("addIngredient").onclick = function() {
    ++ingredientIndex;

    var newRow = document.createElement("div");
    newRow.className = "row";
    newRow.innerHTML = `
            <div class="col">
                <div class="form-group">
                    <select name="ingredients[${ingredientIndex}][name]" class="custom-select" id="ingredients[${ingredientIndex}][name]">
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
                    <select name="ingredients[${ingredientIndex}][unit]" class="custom-select" id="ingredients[${ingredientIndex}][unit]">
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