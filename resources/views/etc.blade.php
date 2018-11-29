@extends('layouts.carbon.app')

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-body">
                <h3>Perusahaan</h3>
                <form action="{{ route('admin.perusahaan.store') }}" method="post">
                    @csrf
                    <textarea class="form-control" placeholder="Pisahkan dengan enter untuk menambahkan banyak Perusahaan" rows="4" name="nama"></textarea>
                    <input type="submit" class="btn btn-success" value="Simpan">
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama</td>
                            <td>Aksi</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($perusahaans as $perusahaan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><input type="text" class="form-control" id="nm-{{ $perusahaan->id }}" value="{{ $perusahaan->nama }}"></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-success btn-sm" onclick="perEdit({{ $perusahaan->id }}, $('#nm-{{ $perusahaan->id }}').val())">Simpan</button>
                                        <a href="{{ route('admin.perusahaan.delete', ['id' => $perusahaan->id]) }}" class="btn btn-danger btn-sm">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <form action="{{ route('admin.perusahaan.edit') }}" method="post" style="display: none" id="form-perusahaan-edit">
                @csrf
                <input type="hidden" name="id" id="id-perusahaan">
                <input type="hidden" name="nama" id="nm-perusahaan">
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card card-body">

            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-body">

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function perEdit(id, nama) {
            event.preventDefault();
            $('#nm-perusahaan').val(nama)
            $('#id-perusahaan').val(id)
            $('#form-perusahaan-edit').submit()
        }
    </script>
@endpush