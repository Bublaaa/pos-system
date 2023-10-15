<div class="modal fade" id="detailModal{{str_replace(' ', '', $userName)}}" role="dialog"
    aria-labelledby="detailModalLabel" aria-hidden="false" tabindex="1">
    <div class=" modal-dialog" role="document" style="max-width: 90vw; max-height: 90vh; overflow-y: auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Attandance Detail {{$userName}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3">
                        <p>Tanggal</p>
                    </div>
                    <div class="col-3">
                        <p>Jam</p>
                    </div>
                    <div class="col-3">
                        <p>Bukti absen</p>
                    </div>
                    <div class="col-3">
                        <p>Lokasi Absen</p>
                    </div>
                </div>
                @foreach($userAttendances as $attendance)
                <div class="row">
                    <div class="col-3">
                        <p>{{ $attendance->created_at->format('d-M-Y')}}</p>
                    </div>
                    <div class="col-3">
                        <p>{{ $attendance->created_at->format('H:i') }}</p>
                    </div>
                    <div class="col-3">
                        <p>{{ $attendance->image }}</p>
                    </div>
                    <div class="col-3">
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $attendance->latitude }},{{ $attendance->longitude }}"
                            target="_blank">
                            Cek Lokasi
                        </a>
                    </div>
                </div>
                @endforeach
                <!-- <h5 class="modal-title" id="myModalLabel">{{ $userAttendances }}'s Attendance Details</h5> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>