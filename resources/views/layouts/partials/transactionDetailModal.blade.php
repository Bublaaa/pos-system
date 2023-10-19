<div class="modal fade" id="menuDetailModal{{ $menu['id'] }}" role="dialog" aria-labelledby="detailModalLabel"
    aria-hidden="false" tabindex="1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('dashboard.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <div class="col">
                        <h5>Tambah ke Transaksi</h5>
                        <h6>Menu: {{$menu['name']}} </h6>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="kind" id="kind" value="penjualan">
                <div class="modal-body">
                    <div class="col">
                        <div class="form-group">
                            <h6>Menu: {{$menu['name']}} </h6>
                            <label for="quantity">Jumlah menu yang dipesan:</label>
                            <input type="number" name="quantity"
                                class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                                placeholder="Jumlah barang" inputmode="numeric" min="1" required=true>
                            @error('quantity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <input type="hidden" name="menu_id" id="menu_id" value="{{ $menu['id'] }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary" type="submit">Yes</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>