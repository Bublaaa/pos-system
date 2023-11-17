@extends('layouts.ownerView')

@section('content')
<!-- Tambah menu baru -->
<div class="row">
    <div class="col-md-3">
        <!-- Menu Card -->
        <form action="{{ route('menu.update', $menu) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    <h5>Edit menu</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Menu Image -->
                        @if($menu->image)
                        <img class="product-img" src="{{ Storage::url($menu->image) }}"
                            style="width: 100%; height: 100%; object-fit: fill;">
                        @else
                        <p>Foto menu tidak tersedia</p>
                        @endif
                        <div class="form-group">
                            <label for="image">Ganti foto menu</label>
                            <div class="custom-file">
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- Menu Name -->
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
                        <!-- Menu Status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="custom-select @error('status') is-invalid @enderror"
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
                        <!-- Menu Size -->
                        <div class="form-group">
                            <label for="size">Ukuran</label>
                            <div class="row" id="size">
                                <div class="col-6 col-md-6">
                                    <label for="regular">
                                        <input type="checkbox" id="regular" name="regularSize" value="regular" checked>
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
                                        <input type="checkbox" id="large" value="large" name="largeSize"
                                            {{ $largeIngredients->count() > 0 ? 'checked' : '' }}>
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
                        <!-- Menu Temprature Variant -->
                        <div class="form-group">
                            <label for="variant">Varian</label>
                            <div class="row" id="variant">
                                <div class="col-6 col-md-6">
                                    <label for="hot">
                                        <input type="checkbox" id="hot" name="hot" value="hot"
                                            {{ $isHotAvailable == true ? 'checked' : '' }}>
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
                                        <input type="checkbox" id="iced" value="iced" name="iced"
                                            {{ $isIcedAvailable == true ? 'checked' : '' }}>
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
                <!-- Submit Button -->
                <div class=" card-footer">
                    <button class="btn btn-primary" type="submit">Simpan Menu</button>
                </div>
            </div>
        </form>
    </div>
    <div class=" col-md-9">
        <!-- Regular Ingredient Card -->
        <form action="{{ route('ingredient.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5>Edit bahan ukuran reguler</h5>
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
                        <!-- Regular Ingredient Field -->
                        @foreach($ingredients as $index => $ingredient)
                        <div class="row">
                            <div class="col-4 col-md-4">
                                <!-- Regular Ingredient Name -->
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
                            <div class="col-4 col-md-3">
                                <!-- Regular Ingredient Quantity -->
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
                            <div class="col-4 col-md-3">
                                <!-- Regular Ingredient Unit -->
                                <div class="form-group">
                                    <select name="ingredients[{{$index}}][unit]" class="custom-select"
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
                            <!-- Remove Regular Ingredient Row -->
                            <div class="col-12 col-md-2">
                                <button type="button" class="btn btn-danger remove-row" onclick="removeRow(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="container">
                        <!-- Regular Ice Level -->
                        <div class="row" id="regularIceLevel" style="display:none;">
                            <!-- Normal ice quantity -->
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="regularNormalIce">Normal Ice</label>
                                    <input type="number" name="regularNormalIce"
                                        class="form-control @error('regularNormalIce') is-invalid @enderror"
                                        id="regularNormalIce" placeholder="Jumlah Es"
                                        value="{{ $regularIceLevel->count() < 2 ? old('lessIceQuantity') : $regularIceLevel->where('name','normal_ice')[0]->quantity}}"
                                        inputmode="numeric" min="1" max="100" required=true>
                                    @error('regularNormalIce')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- less ice quantity -->
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="regularLessIce">Less Ice</label>
                                    <input type="number" name="regularLessIce"
                                        class="form-control @error('regularLessIce') is-invalid @enderror"
                                        id="regularLessIce" placeholder="Jumlah Es"
                                        value="{{ $regularIceLevel->count() < 2 ? old('lessIceQuantity') : $regularIceLevel->where('name','less_ice')[1]->quantity}}"
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
                <!-- Regular ingredient submit button -->
                <div class=" card-footer">
                    <button class="btn btn-primary" type="submit">Simpan Bahan</button>
                </div>
            </div>
        </form>
        <!-- Large Ingredient Card -->
        <form action="{{ route('ingredient.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card" id="largeIngredientsCard" style="display:none;">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5>Edit bahan ukuran besar</h5>
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
                            <div class="col-12 col-md-2">
                            </div>
                        </div>
                        @if($largeIngredients->count() == 0)
                        <div class="row">
                            <div class="col-4 col-md-4">
                                <div class="form-group">
                                    <input type="text" name="largeIngredients[0][name]"
                                        class="form-control @error('largeIngredients[0][name]') is-invalid @enderror"
                                        id="largeIngredients[0][name]" placeholder="Nama Bahan"
                                        value="{{ old('name') }}">
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
                                        value="{{ old('quantity') }}" inputmode="numeric" min="1">
                                    @error('largeIngredients[0][quantity]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 col-md-3">
                                <div class="form-group">
                                    <select name="largeIngredients[0[unit]" class="custom-select"
                                        id="largeIngredients[0][unit]">
                                        <option value="gram" {{ $ingredient->unit == "gram" ? 'selected' : '' }}>Gram
                                        </option>
                                        <option value="ml" {{ $ingredient->unit == "ml" ? 'selected' : '' }}>
                                            Mililiter
                                        </option>
                                    </select>
                                    @error('largeIngredients[0][unit]')
                                    <span class="ingredients[0][unit]" role="alert">
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
                        </div>
                        @endif
                        @foreach($largeIngredients as $index => $ingredient)
                        <div class="row">
                            <div class="col-4 col-md-4">
                                <div class="form-group">
                                    <input type="text" name="largeIngredients[{{$index}}][name]"
                                        class="form-control @error('largeIngredients[{{$index}}][name]') is-invalid @enderror"
                                        id="largeIngredients[{{$index}}][name]" placeholder="Nama Bahan"
                                        value="{{ $ingredient->name }}">
                                    @error('largeIngredients[{{$index}}][name]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 col-md-3">
                                <div class="form-group">
                                    <input type="number" name="largeIngredients[{{$index}}][quantity]"
                                        class="form-control @error('largeIngredients[{{$index}}][quantity]') is-invalid @enderror"
                                        id="largeIngredients[{{$index}}][quantity]" placeholder="Jumlah Bahan"
                                        value="{{ $ingredient->quantity }}" inputmode="numeric" min="1">
                                    @error('largeIngredients[{{$index}}][quantity]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 col-md-3">
                                <div class="form-group">
                                    <select name="largeIngredients[{{$index}}][unit]" class="custom-select"
                                        id="largeIngredients[{{$index}}][unit]">
                                        <option value="gram" {{ $ingredient->unit == "gram" ? 'selected' : '' }}>Gram
                                        </option>
                                        <option value="ml" {{ $ingredient->unit == "ml" ? 'selected' : '' }}>
                                            Mililiter
                                        </option>
                                    </select>
                                    @error('largeIngredients[{{$index}}][unit]')
                                    <span class="ingredients[{{$index}}][unit]" role="alert">
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
                        </div>
                        @endforeach
                    </div>
                    <div class="container">
                        <div class="row" id="largeIceLevel" style="display:none;">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="largeNormalIce">Normal Ice</label>
                                    <input type="number" name="largeNormalIce"
                                        class="form-control @error('largeNormalIce') is-invalid @enderror"
                                        id="largeNormalIce" placeholder="Jumlah Es"
                                        value="{{ $largeIceLevel->count() < 2 ? old('lessIceQuantity') : $largeIceLevel->where('name','normal_ice')[0]->quantity}}"
                                        inputmode="numeric" min="1" max="100" required=true>
                                    @error('largeNormalIce')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="largeLessIce">Less Ice</label>
                                    <input type="number" name="largeLessIce"
                                        class="form-control @error('largeLessIce') is-invalid @enderror"
                                        id="largeLessIce" placeholder="Jumlah Es"
                                        value="{{ $largeIceLevel->count() < 2 ? old('lessIceQuantity') : $largeIceLevel->where('name','less_ice')[1]->quantity}}"
                                        inputmode="numeric" min="1" max="100" required=true>
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
                <div class=" card-footer">
                    <button class="btn btn-primary" type="submit">Simpan Bahan</button>
                </div>
            </div>
        </form>
    </div>
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

    $('#regularIceLevel').css('display', $('#iced').prop('checked') ? 'flex' : 'none');
    $('#largeIceLevel').css('display', $('#iced').prop('checked') ? 'flex' : 'none');

    $('#iced').on('change', function() {
        $('#regularIceLevel').css('display', $(this).prop('checked') ? 'flex' : 'none');
        $('#largeIceLevel').css('display', $(this).prop('checked') ? 'flex' : 'none');
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
var ingredientIndex = "{{$ingredients->count()-1}}";
var ingredientLargeIndex = "{{$largeIngredients->count() > 0 ? $largeIngredients->count()-1 : 0}}";

document.getElementById("addIngredient").onclick = function() {
    ++ingredientIndex;

    var newRow = document.createElement("div");
    newRow.className = "row";
    newRow.innerHTML = `
                <div class="col-4 col-md-4">
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
                <div class="col-4 col-md-3">
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
                <div class="col-4 col-md-3">
                    <div class="form-group">
                        <select name="ingredients[${ingredientIndex}][unit]" class="custom-select" id="ingredients[${ingredientIndex}][unit]">
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
document.getElementById("addIngredientLarge").onclick = function() {
    ++ingredientLargeIndex;

    var newRow = document.createElement("div");
    newRow.className = "row py-2";
    newRow.innerHTML = `
        <div class="col-4 col-md-4">
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
        <div class="col-4 col-md-3">
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
        <div class="col-4 col-md-3">
            <div class="form-group">
                <select name="largeIngredients[${ingredientLargeIndex}][unit]" class="custom-select"
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