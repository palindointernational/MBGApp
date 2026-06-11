@include('dashboard.partials.header')
@include('dashboard.partials.navbar')
@include('dashboard.partials.sidebar')
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right" href="{{ route('recipientCreate') }}">
                        Tambah Instansi Penerima
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <di class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Table Data Instansi Penerima</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        {{-- <th>Dapur</th> --}}
                                        <th>Telp</th>
                                        <th>Tipe</th>
                                        <th>Total Porsi</th>
                                        <th>Alamat</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $recipient)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $recipient->name }}</td>
                                            {{-- <td>{{ $recipient->kitchen->name ?? 'N/A' }}</td> --}}
                                            <td>{{ $recipient->phone ?? 'N/A' }}</td>
                                            <td>{{ $recipient->type ?? 'N/A' }}</td>
                                            <td>{{ $recipient->portion ?? 'N/A' }}</td>
                                            <td>{{ Str::limit($recipient->address ?? 'N/A', 30) }}</td>
                                            <td>
                                                <div class="btn-group btn-block">
                                                    <a class="btn btn-sm btn-warning"
                                                        href="{{ route('recipientEdit', $recipient->id) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button url="{{ route('recipientDestroy', $recipient->id) }}"
                                                        type="button" class="btn btn-sm btn-danger delete"
                                                        data-id="{{ $recipient->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </di>
        </div>
    </div>
</div>

@include('dashboard.partials.footer')
