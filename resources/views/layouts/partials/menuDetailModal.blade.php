<div class="modal fade" id="menuDetailModal{{ $menu['id'] }}" role="dialog" aria-labelledby="detailModalLabel"
    aria-hidden="false" tabindex="1">
    <div class="modal-dialog" role="document" style="max-width: 80vw;">
        <div class="modal-content">
            <form action="#" method="POST">
                @csrf
                <div class="modal-header">
                    <h5>Edit menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Menu Card -->
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Detil menu</h5>
                                </div>
                                <div class="card-body">
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
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            placeholder="Name" value="{{ $menu['name'] }}" required=true>
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
                                            <option value="1" {{ $menu['status'] === 1 ? 'selected' : ''}}>Tersedia
                                            </option>
                                            <option value="0" {{ $menu['status'] === 0 ? 'selected' : ''}}>Tidak
                                                Tersedia</option>
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
                        <!-- Ingredient Card -->
                        <div class=" col">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-6">
                                            <h5>Bahan baku</h5>
                                        </div>
                                        <div class="col-6 text-right">
                                            <button name="addIngredient" id="addIngredient" type="button"
                                                class="btn btn-primary">
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
                                        @foreach($ingredients as $ingredient)
                                        <div class="row ingredient-row">
                                            <div class="col col-md">
                                                <div class="form-group">
                                                    <input type="text" name="ingredients[0][name]"
                                                        class="form-control @error('ingredientName') is-invalid @enderror"
                                                        id="ingredients[0][name]" placeholder="Nama Bahan"
                                                        value="{{ old('ingredientName') }}">
                                                    @error('ingredientName')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="number" name="ingredients[0][quantity]"
                                                        class="form-control @error('ingredientQuantity') is-invalid @enderror"
                                                        id="ingredients[0][quantity]" placeholder="Jumlah Bahan"
                                                        value="{{ old('ingredientQuantity') }}" inputmode="numeric"
                                                        min="1">
                                                    @error('ingredientQuantity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <select name="ingredients[0][unit]" class="form-control"
                                                        id="ingredients[0][unit]">
                                                        <option value="gram">Gram</option>
                                                        <option value="ml"> Mililiter</option>
                                                    </select>
                                                    @error('unit')
                                                    <span class="ingredientUnit" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col">
                                                <button type="button" class="btn btn-danger remove-row"
                                                    onclick="removeRow(this)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class=" card-footer">
                                    <button class="btn btn-primary" type="submit">Simpan Menu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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
                            class="form-control @error('ingredientName') is-invalid @enderror"
                            id="ingredients[${ingredientIndex}][name]" placeholder="Nama Bahan"
                            value="{{ old('ingredientName') }}">
                        @error('ingredientName')
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
                            class="form-control @error('ingredientQuantity') is-invalid @enderror"
                            id="ingredients[${ingredientIndex}][quantity]" placeholder="Jumlah Bahan"
                            value="{{ old('ingredientQuantity') }}">
                        @error('ingredientQuantity')
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
                    <span class="ingredientUnit" role="alert">
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