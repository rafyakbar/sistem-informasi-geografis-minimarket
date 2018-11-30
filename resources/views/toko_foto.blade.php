<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Bootstrap & carbon -->
    <link rel="stylesheet" href="{{ asset('vendor/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carbon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="header-fixed">
            <div class="card card-body">
                <div class="alert alert-info">
                    Toko nomor {{ $no }}
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.toko.foto.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $toko->id }}" name="toko_id">
                    <label>Tambah foto</label>
                    <br>
                    <input type="file" class="form-control" name="dir[]" multiple accept="image/*">
                    <br>
                    <button class="btn btn-success" type="submit">Simpan</button>
                </form>
                <div class="row">
                    @foreach($toko->getFoto(false) as $foto)
                        <div class="col-lg-4">
                            <img src="{{ asset($foto->dir) }}" class="img-fluid" alt="Responsive image">
                            <a class="btn btn-danger btn-sm btn-block text-white" href="{{ route('admin.toko.foto.delete', ['id' => encrypt($foto->id)]) }}">Hapus</a>
                        </div>
                    @endforeach
                </div>
            </div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/carbon.js') }}"></script>
</body>
</html>
