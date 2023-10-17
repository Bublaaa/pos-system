<div class="modal fade" id="detailModal{{str_replace(' ', '', $userName)}}" role="dialog"
    aria-labelledby="detailModalLabel" aria-hidden="false" tabindex="1">
    <div class=" modal-dialog" role="document" style="max-width: 80vw; max-height: 10vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Attandance Detail {{$userName}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto;">
                <div class="row">
                    <div class="col-4 col-md-1">
                        <p>Tanggal</p>
                    </div>
                    <div class="col-2 col-md-1">
                        <p>Jam</p>
                    </div>
                    <div class="col-3 col-md">
                        <p>Status</p>
                    </div>
                    <div class="col-3 col-md">
                        <p>Bukti absen</p>
                    </div>
                    <div class="col-3 col-md-2">
                        <p>Lokasi Absen</p>
                    </div>
                </div>
                @foreach($allUserAttendance as $attendance)
                <div class="row">
                    <div class="col-4 col-md-1" style="text-center">
                        <p>{{ $attendance->created_at->format('d M y')}}</p>
                    </div>
                    <div class="col-4 col-md-1" style="text-center">
                        <p>{{ $attendance->created_at->format('H:i') }}</p>
                    </div>
                    <div class="col-4 col-md-1" style="text-center">
                        <p>{{ $attendance->status == 1 ? 'Hadir' : 'Tidak Hadir' }}</p>
                    </div>
                    <div class="col-4 col-md" style="text-center">
                        <p>{{ $attendance->image }}</p>
                    </div>
                    <div class="col-4 col-md-2" style="text-center">
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $attendance->latitude }},{{ $attendance->longitude }}"
                            target="_blank" type="button">
                            <i class="fas fa-map-marker-alt"></i>
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