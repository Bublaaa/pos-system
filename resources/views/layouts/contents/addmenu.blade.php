@extends('layouts.ownerview')

@section('content')
<div class="container">
    <h2>Buat Menu Baru</h2>
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
                                    <input type="file" class="custom-file-input" name="image" id="image" required=true>
                                    <label class="custom-file-label" for="image">Choose file</label>
                                    <p style="color:red;">Rekomendasi rasio foto : 200x150</p>
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
                            <!-- Size -->
                            <div class="form-group">
                                <label for="size">Ukuran</label>
                                <div class="row" id="size">
                                    <div class="col-6 col-md-6">
                                        <label for="regular">
                                            <input type="checkbox" id="regular" name="regularSize" value="regular"
                                                checked>
                                            Reguler
                                        </label>
                                        @error('regularSize')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <label for="large">
                                            <input type="checkbox" id="large" value="large" name="largeSize">
                                            Besar
                                        </label>

                                        @error('largeSize')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Variant -->
                            <div class="form-group">
                                <label for="variant">Varian</label>
                                <div class="row" id="variant">
                                    <div class="col-6 col-md-6">
                                        <label for="hot">
                                            <input type="checkbox" id="hot" name="hot" value="hot">
                                            Panas
                                        </label>
                                        @error('hot')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <label for="iced">
                                            <input type="checkbox" id="iced" value="iced" name="iced" required>
                                            Dingin
                                        </label>
                                        @error('iced')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" card-footer">
                        <button class="btn btn-primary" type="submit">Simpan Menu</button>
                    </div>
                </div>
            </div>
            <div class=" col-md-9">
                <!-- Regular size ingredients card-->
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5>Bahan baku ukuran regular</h5>
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
                                <div class="col-4 col-md-4">
                                    <p>Nama</p>
                                </div>
                                <div class="col-4 col-md-3">
                                    <p>Jumlah</p>
                                </div>
                                <div class="col-4 col-md-3">
                                    <p>Satuan</p>
                                </div>
                                <div class="col-2 col-md-2">
                                </div>
                            </div>
                            <div class="row ingredient-row">
                                <div class="col-4 col-md-4">
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
                                <div class="col-4 col-md-3">
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
                                <div class="col-4 col-md-3">
                                    <div class="form-group">
                                        <select name="ingredients[0][unit]" class="form-control"
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
                                <div class="col-1 col-md-2">
                                    <button type="button" class="btn btn-danger remove-row" onclick="removeRow(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" id="regularIceLevel" style="display:none;">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="regularNormalIce">Normal Ice</label>
                                    <input type="number" name="regularNormalIce"
                                        class="form-control @error('regularNormalIce') is-invalid @enderror"
                                        id="regularNormalIce" placeholder="Jumlah Es"
                                        value="{{ old('regularNormalIce') }}" inputmode="numeric" min="1" max="100"
                                        required=true>
                                    @error('regularNormalIce')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="regularLessIce">Less Ice</label>
                                    <input type="number" name="regularLessIce"
                                        class="form-control @error('regularLessIce') is-invalid @enderror"
                                        id="regularLessIce" placeholder="Jumlah Es" value="{{ old('regularLessIce') }}"
                                        inputmode="numeric" min="1" max="100" required=true>
                                    @error('regularLessIce')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Large size ingredients card -->
                <div class="card" id="largeIngredientsCard" style="display:none;">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5>Bahan baku ukuran besar</h5>
                            </div>
                            <div class="col-6 text-right">
                                <button name="addIngredientLarge" id="addIngredientLarge" type="button"
                                    class="btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container" id="largeIngredientContainer">
                            <div class="row">
                                <div class="col-4 col-md-4">
                                    <p>Nama</p>
                                </div>
                                <div class="col-4 col-md-3">
                                    <p>Jumlah</p>
                                </div>
                                <div class="col-4 col-md-3">
                                    <p>Satuan</p>
                                </div>
                                <div class="col-2 col-md-2">
                                </div>
                            </div>
                            <div class="row ingredient-row">
                                <div class="col-4 col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="largeIngredients[0][name]"
                                            class="form-control @error('largeIngredients[0][name]') is-invalid @enderror"
                                            id="largeIngredients[0][name]" placeholder="Nama Bahan"
                                            value="{{ old('largeIngredients[0][name]') }}" required=true>
                                        @error('largeIngredients[0][name]')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4 col-md-3">
                                    <div class="form-group">
                                        <input type="number" name="largeIngredients[0][quantity]"
                                            class="form-control @error('largeIngredients[0][quantity]') is-invalid @enderror"
                                            id="largeIngredients[0][quantity]" placeholder="Jumlah Bahan"
                                            value="{{ old('largeIngredients[0][quantity]') }}" inputmode="numeric"
                                            min="1" required=true>
                                        @error('largeIngredients[0][quantity]')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4 col-md-3">
                                    <div class="form-group">
                                        <select name="largeIngredients[0][unit]" class="form-control"
                                            id="largeIngredients[0][unit]">
                                            <option value="gram">Gram</option>
                                            <option value="ml"> Mililiter</option>
                                        </select>
                                        @error('unit')
                                        <span class="largeIngredients[0][unit]" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-1 col-md-2">
                                    <button type="button" class="btn btn-danger remove-row-large"
                                        onclick="removeRow(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" id="largeIceLevel" style="display:none;">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label for="largeNormalIce">Normal Ice</label>
                                <input type="number" name="largeNormalIce"
                                    class="form-control @error('largeNormalIce') is-invalid @enderror"
                                    id="largeNormalIce" placeholder="Jumlah Es" value="{{ old('largeNormalIce') }}"
                                    inputmode="numeric" min="1" max="1000" required=true>
                                @error('largeNormalIce')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="largeLessIce">Less Ice</label>
                                <input type="number" name="largeLessIce"
                                    class="form-control @error('largeLessIce') is-invalid @enderror" id="largeLessIce"
                                    placeholder="Jumlah Es" value="{{ old('largeLessIce') }}" inputmode="numeric"
                                    min="1" max="100" required=true>
                                @error('largeLessIce')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {

    // Attach an event listener to the "Less Ice" input
    $('#regularLessIce').on('input', function() {
        // Get the values of "Normal Ice" and "Less Ice"
        var normalIceValue = parseInt($('#regularNormalIce').val()) || 0;
        var lessIceValue = parseInt($(this).val()) || 0;

        // Check if "Less Ice" is greater than "Normal Ice"
        if (lessIceValue > normalIceValue) {
            // Display an alert
            alert('Less Ice cannot be more than Normal Ice.');

            // Clear the input value
            $(this).val('');

            // Optionally, you can remove the 'is-invalid' class and clear the error message
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').html('');
        }
    });

    // You may also want to add similar validation on the "Normal Ice" input
    $('#regularNormalIce').on('input', function() {
        var normalIceValue = parseInt($(this).val()) || 0;
        var lessIceValue = parseInt($('#regularLessIce').val()) || 0;

        if (lessIceValue > normalIceValue) {
            // Display an alert
            alert('Less Ice cannot be more than Normal Ice.');

            // Clear the input value
            $('#regularLessIce').val('');

            // Optionally, you can remove the 'is-invalid' class and clear the error message
            $('#regularLessIce').removeClass('is-invalid');
            $('#regularLessIce').next('.invalid-feedback').html('');
        }
    });

    // Large checkbox toggle
    $('#largeIngredientsCard').css('display', $('#large').prop('checked') ? 'block' : 'none');

    $('#large').on('change', function() {
        $('#largeIngredientsCard').css('display', $(this).prop('checked') ? 'block' : 'none');
    });

    $('#regularIceLevel').css('display', $('#iced').prop('checked') ? 'block' : 'none');
    $('#largeIceLevel').css('display', $('#iced').prop('checked') ? 'block' : 'none');

    $('#iced').on('change', function() {
        $('#regularIceLevel').css('display', $(this).prop('checked') ? 'block' : 'none');
        $('#largeIceLevel').css('display', $(this).prop('checked') ? 'block' : 'none');
    });

    // Prevent regular option to be unchecked
    $('#regular').prop('checked', true);

    $('#regular').on('change', function() {
        if (!$(this).prop('checked')) {
            alert('Ukuran reguler tidak bisa diubah.');
            $(this).prop('checked', true);
        }
    });
});

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
    newRow.className = "row py-2";
    newRow.innerHTML = `
<div class="col-4 col-md-4">
    <div class="form-group">
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
</div>
<div class="col-4 col-md-3">
    <div class="form-group">
        <div class="form-group">
            <input type="text" name="ingredients[${ingredientIndex}][quantity]"
                class="form-control @error('ingredients[${ingredientIndex}][quantity]') is-invalid @enderror"
                id="ingredients[${ingredientIndex}][quantity]" placeholder="Jumlah Bahan"
                value="{{ old('ingredients[${ingredientIndex}][quantity]') }}" required=true>
            @error('ingredients[${ingredientIndex}][quantity]')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
<div class="col-4 col-md-3">
    <div class="form-group">
        <select name="ingredients[${ingredientIndex}][unit]" class="form-control"
            id="ingredients[${ingredientIndex}][unit]">
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
<div class="col-12 col-md-2">
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

// Add new row when button clicked - LARGE
var ingredientLargeIndex = 0;
document.getElementById("addIngredientLarge").onclick = function() {
    ++ingredientLargeIndex;

    var newRow = document.createElement("div");
    newRow.className = "row py-2";
    newRow.innerHTML = `
<div class="col-4 col-md-4">
    <div class="form-group">
        <div class="form-group">
            <input type="text" name="largeIngredients[${ingredientLargeIndex}][name]"
                class="form-control @error('largeIngredients[${ingredientLargeIndex}][name]') is-invalid @enderror"
                id="largeIngredients[${ingredientLargeIndex}][name]" placeholder="Nama Bahan"
                value="{{ old('largeIngredients[${ingredientLargeIndex}][name]') }}" required=true>
            @error('largeIngredients[${ingredientLargeIndex}][name]')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
<div class="col-4 col-md-3">
    <div class="form-group">
        <div class="form-group">
            <input type="text" name="largeIngredients[${ingredientLargeIndex}][quantity]"
                class="form-control @error('largeIngredients[${ingredientLargeIndex}][quantity]') is-invalid @enderror"
                id="largeIngredients[${ingredientLargeIndex}][quantity]" placeholder="Jumlah Bahan"
                value="{{ old('largeIngredients[${ingredientLargeIndex}][quantity]') }}" required=true>
            @error('largeIngredients[${ingredientLargeIndex}][quantity]')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
<div class="col-4 col-md-3">
    <div class="form-group">
        <select name="largeIngredients[${ingredientLargeIndex}][unit]" class="form-control"
            id="largeIngredients[${ingredientLargeIndex}][unit]">
            <option value="gram">Gram</option>
            <option value="ml"> Mililiter</option>
        </select>
        @error('unit')
        <span class="largeIngredients[${ingredientLargeIndex}][unit]" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="col-12 col-md-2">
    <button type="button" class="btn btn-danger remove-row-large" onclick="removeRow(this)">
        <i class="fas fa-trash"></i>
    </button>
</div>
`;

    // Append the new row to the container
    document.getElementById("largeIngredientContainer").appendChild(newRow);

    // Attach the onclick event to the remove button in the new row
    newRow.querySelector(".remove-row-large").onclick = function() {
        removeRow(this);
    };
};
</script>
@endsection