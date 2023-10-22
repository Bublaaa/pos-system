@extends('layouts.ownerview')

@section('content')
<table class="table">
    <thead>
        <tr>
            <td>Username</td>
            <td>Nama</td>
            <td>Posisi</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{$user->email}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->position}}</td>
            <td>
                <a href="{{ route('user.edit', $user) }}" class="btn btn-primary mr-2">
                    <i class="fas fa-edit"></i>
                </a>
                <button type="button" class="btn btn-danger remove-row" data-toggle="modal"
                    data-target="#deleteModal{{ $user->id }}">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
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
    </tbody>
</table>
@endsection