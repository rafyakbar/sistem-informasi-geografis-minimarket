@extends('layouts.carbon.app')

@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="card card-body">
                <h3>Perusahaan ({{ $perusahaans->count() }} data)</h3>
                <form action="{{ route('admin.perusahaan.store') }}" method="post">
                    @csrf
                    <textarea class="form-control" placeholder="Pisahkan dengan enter untuk menambahkan banyak perusahaan" rows="4" name="nama"></textarea>
                    <input type="submit" class="btn btn-success" value="Simpan">
                </form>
                <br>
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
                                        <button class="btn btn-success btn-sm" onclick="perEdit('{{ $perusahaan->id }}', $('#nm-{{ $perusahaan->id }}').val())">S</button>
                                        <a href="{{ route('admin.perusahaan.delete', ['id' => encrypt($perusahaan->id)]) }}" class="btn btn-danger btn-sm">H</a>
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

        <div class="col-lg-6">
            <div class="card card-body">
                <h3>Barang ({{ $barangs->total() }} data)</h3>
                <form action="{{ route('admin.barang.store') }}" method="post">
                    @csrf
                    <textarea class="form-control" placeholder="Pisahkan dengan enter untuk menambahkan banyak barang dengan format nama_barang;kategori, contoh : Minyak Sania 2L;Kebutuhan Rumah Tangga" rows="4" name="nama"></textarea>
                    <input type="submit" class="btn btn-success" value="Simpan">
                </form>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <td>No</td>
                            <td>Kategori/Nama/Aksi</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($barangs as $barang)
                            <tr>
                                <td>{{ ($barangs->currentpage() * $barangs->perpage()) + ($loop->iteration) - $barangs->perpage() }}</td>
                                <td>
                                    <form action="{{ route('admin.barang.edit') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $barang->id }}">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <select class="form-control" name="kategori_id">
                                                    <option value="{{ $barang->kategori_id }}">{{ $barang->getKategori(false)->nama }}</option>
                                                    @foreach($kategoris as $kategori)
                                                        @if($barang->kategori_id != $kategori->id)
                                                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-5">
                                                <input type="text" name="nama" class="form-control" value="{{ $barang->nama }}">
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="btn-group">
                                                    <button type="submit" class="btn btn-success btn-sm">S</button>
                                                    <a href="{{ route('admin.barang.delete', ['id' => encrypt($barang->id)]) }}" class="btn btn-danger btn-sm">H</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $barangs->links() }}
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card card-body">
                <h3>Kategori ({{ $kategoris->count() }} data)</h3>
                <form action="{{ route('admin.kategori.store') }}" method="post">
                    @csrf
                    <textarea class="form-control" placeholder="Pisahkan dengan enter untuk menambahkan banyak kategori" rows="4" name="nama"></textarea>
                    <input type="submit" class="btn btn-success" value="Simpan">
                </form>
                <br>
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
                        @foreach($kategoris as $kategori)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><input type="text" class="form-control" id="kt-{{ $kategori->id }}" value="{{ $kategori->nama }}"></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-success btn-sm" onclick="katEdit('{{ $kategori->id }}', $('#kt-{{ $kategori->id }}').val())">S</button>
                                        <a href="{{ route('admin.kategori.delete', ['id' => encrypt($kategori->id)]) }}" class="btn btn-danger btn-sm">H</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <form action="{{ route('admin.kategori.edit') }}" method="post" style="display: none" id="form-kategori-edit">
                @csrf
                <input type="hidden" name="id" id="id-kategori">
                <input type="hidden" name="nama" id="nm-kategori">
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function perEdit(id, nama) {
            event.preventDefault()
            $('#nm-perusahaan').val(nama)
            $('#id-perusahaan').val(id)
            $('#form-perusahaan-edit').submit()
        }

        function katEdit(id, nama) {
            event.preventDefault()
            $('#nm-kategori').val(nama)
            $('#id-kategori').val(id)
            $('#form-kategori-edit').submit()
        }
    </script>
@endpush