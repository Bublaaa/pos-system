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
                        <!-- Size -->
                        @if($sizeAvailable->where('menu_id', $menu['id'])->count() > 1)
                        <label for="sizeAvailable">Ukuran</label>
                        <div class="row" id="sizeAvailable">
                            <div class="col-12 col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="size" id="regularOption"
                                        value="Regular" checked>
                                    <label class="form-check-label" for="regularOption">Reguler</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="size" id="largeOption"
                                        value="Large">
                                    <label class="form-check-label" for="largeOption">Besar</label>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- Temprature -->
                        @if($tempratureAvailable->where('menu_id', $menu['id'])->count() > 0)
                        @php
                        $isHotAvailable = false;
                        $isIceAvailable = false;
                        @endphp

                        @foreach($tempratureAvailable->where('menu_id', $menu['id']) as $temperature)
                        @if($temperature->name == "hot")
                        @php
                        $isHotAvailable = true;
                        @endphp
                        @elseif($temperature->name == "normal_ice")
                        @php
                        $isIceAvailable = true;
                        @endphp
                        @endif
                        @endforeach
                        <label for="tempratureAvailable">Suhu</label>
                        <div class="row" id="tempratureAvailable">
                            @if($isHotAvailable)
                            <div class="col-12 col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="temprature" id="hot" value="hot"
                                        checked>
                                    <label class="form-check-label" for="hot">Panas</label>

                                </div>
                            </div>
                            @endif
                            @if($isIceAvailable)
                            <div class="col-12 col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="temprature" id="iced"
                                        value="iced">
                                    <label class="form-check-label" for="iced">Dingin</label>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- Ice Level -->
                        <label for="iceLevels" id="iceLevelLabel">Ice Level</label>
                        <div class="row" id="iceLevels">
                            <div class="col-12 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="iceLevel" id="normal_ice"
                                        value="normal_ice" checked>
                                    <label class="form-check-label" for="normal_ice">Normal Ice</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="iceLevel" id="less_ice"
                                        value="less_ice">
                                    <label class="form-check-label" for="less_ice">Less Ice</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="iceLevel" id="no_ice"
                                        value="no_ice">
                                    <label class="form-check-label" for="no_ice">No Ice</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
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
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary" type="submit">Tambah</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
$(document).ready(function() {
    // Loop through all modals with IDs starting with "menuDetailModal"
    $('[id^="menuDetailModal"]').each(function() {
        // Get the specific elements within this modal
        var modal = $(this);
        var iceLevels = modal.find('#iceLevels');
        var iceLevelLabel = modal.find('#iceLevelLabel');

        // Initial setup for each modal
        toggleIceLevelsDisplay();

        // Event listener for temperature change within each modal
        modal.find('input[name="temprature"]').on('change', function() {
            toggleIceLevelsDisplay();
        });

        // Function to toggle display based on temperature within each modal
        function toggleIceLevelsDisplay() {
            var temperature = modal.find('input[name="temprature"]:checked').val();

            if (temperature === 'iced') {
                iceLevels.css('display', 'block');
                iceLevelLabel.css('display', 'block');
            } else {
                iceLevels.css('display', 'none');
                iceLevelLabel.css('display', 'none');
            }
        }
    });
});
</script>