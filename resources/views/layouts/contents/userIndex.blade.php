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
    </script>
</head>
<div class="container">
    <h2>Akun Karyawan</h2>
    <div class="row">
        @if($users->count()>0)
        @foreach($users as $user)
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        @if($user->profile_image)
                        <div class="col-md-3">
                            <img id="profileImagePreview" src="{{ asset('storage/'. $user->profile_image) }}"
                                class="rounded-circle mb-3 "
                                style="min-width: 75px;max-width: 76px; max-height: 75px; object-fit: cover;object-position: center center;" />
                        </div>
                        @endif
                        <div class="col-md-6">
                            <h5>{{$user->name}} - {{ucwords($user->position)}}</h5>
                            <p>{{$user->username}}</p>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('user.edit', $user) }}" class="btn btn-primary mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger remove-row" data-toggle="modal"
                                data-target="#deleteModal{{ $user->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Akun</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apa anda yakin ingin menghapus akun karyawan {{$user->name}}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <form action="{{ route('user.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="container">
            <div id="alertContainer" class="alert alert-primary">
                Belum ada akun karyawan yang terdaftar.
                <br>
                <button onclick="window.location.href='{{ route('register') }}'" class="btn btn-primary">
                    Tambah Akun
            </div>
        </div>
        @endif
    </div>
</div>
@endsection