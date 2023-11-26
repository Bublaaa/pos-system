<div class="modal fade" id="detailModal{{str_replace(' ', '', $userName)}}" role="dialog"
    aria-labelledby="detailModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog w-auto" role="document" style="max-width:80vw;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Absensi {{$userName}}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: scroll;">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Tanggal</td>
                            <td>Status</td>
                            <td>Bukti absen</td>
                            <td>Lokasi absen</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendancesByMonth as $attendance)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($attendance->created_at)->format('d-M-y  H:i') }}
                            </td>
                            <td
                                style="{{ $attendance->status === "hadir" ? 'color:green;' : ($attendance->status === "terlambat" ? 'color: #FFA500;' : 'color:red;') }}">
                                {{ ucwords($attendance->status) }}</td>
                            <td>
                                @if($attendance->image)
                                <img class="product-img" src="{{ Storage::url($attendance->image) }}"
                                    style="max-width: 200px; max-height: 150px; width: 100%; height: 100%; object-fit: cover;">
                                @else
                                Bukti Absen tidak tersedia
                                @endif
                            </td>
                            <td>
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $attendance->latitude }},{{ $attendance->longitude }}"
                                    target="_blank" type="button" class="btn btn-primary">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Open maps
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>