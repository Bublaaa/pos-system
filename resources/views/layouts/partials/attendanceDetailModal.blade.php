<div class="modal fade" id="detailModal{{str_replace(' ', '', $userName)}}" role="dialog"
    aria-labelledby="detailModalLabel" aria-hidden="false" tabindex="1">
    <div class=" modal-dialog w-auto" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Attandance Detail {{$userName}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: scroll;">
                <div class=" row">
                    <div class="col">
                        <p>Tanggal</p>
                    </div>
                    <div class="col">
                        <p>Jam</p>
                    </div>
                    <div class="col">
                        <p>Status</p>
                    </div>
                    <div class="col">
                        <p>Bukti absen</p>
                    </div>
                    <div class="col">
                        <p>Lokasi Absen</p>
                    </div>
                </div>
                @foreach($allUserAttendance as $attendance)
                <div class="row">
                    <div class="col" style="text-center">
                        <p>{{ $attendance->created_at->format('d M y')}}</p>
                    </div>
                    <div class="col" style="text-center">
                        <p>{{ $attendance->created_at->format('H:i') }}</p>
                    </div>
                    <div class="col" style="text-center">
                        <p>{{ $attendance->status == 1 ? 'Hadir' : 'Absen' }}</p>
                    </div>
                    <div class="col" style="text-center">
                        <p>{{ $attendance->image }}</p>
                    </div>
                    <div class="col" style="text-center">
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