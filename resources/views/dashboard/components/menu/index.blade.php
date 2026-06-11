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
                    <a class="btn btn-primary float-right" href="{{ route('menuCreate') }}">
                        Tambah Menu
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
                            <h3 class="card-title">Table Data Menu</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Dapur</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Portion</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $menu)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($menu->image)
                                                    <img src="{{ asset('storage/menu/' . $menu->image) }}"
                                                        alt="{{ $menu->title }}" width="60">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td>{{ $menu->kitchen->name ?? 'N/A' }}</td>
                                            <td>{{ $menu->title }}</td>
                                            <td>{{ Carbon\Carbon::parse($menu->date)->format('d M Y') }}</td>
                                            <td>{{ number_format($menu->portion, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($menu->status == 'Draft')
                                                    <span class="badge badge-warning"><i class="fas fa-clock"></i>
                                                        Draft</span>
                                                @elseif ($menu->status == 'Cooking')
                                                    <span class="badge badge-secondary"><i class="fas fa-fire"></i>
                                                        Cooking</span>
                                                @elseif ($menu->status == 'Packing')
                                                    <span class="badge badge-info"><i class="fas fa-box"></i>
                                                        Packing</span>
                                                @elseif ($menu->status == 'Delivered')
                                                    <span class="badge badge-primary"><i class="fas fa-truck"></i>
                                                        Delivered</span>
                                                @elseif ($menu->status == 'Distributed')
                                                    <span class="badge badge-success"><i
                                                            class="fas fa-check-circle"></i>
                                                        Distributed</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-block">
                                                    @if ($menu->status == 'Draft' || $menu->status == 'Cooking' || $menu->status == 'Packing')
                                                        <button type="button" class="btn btn-sm btn-info"
                                                            data-toggle="modal"
                                                            data-target="#modal-default{{ $menu->id }}">
                                                            Status
                                                        </button>
                                                    @endif
                                                    <div class="modal fade" id="modal-default{{ $menu->id }}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Update Status</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('menuStatusUpdate', $menu->slug) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="form-group mb-3">
                                                                            <label for="status">Status</label>
                                                                            <select class="form-control" id="status"
                                                                                name="status">
                                                                                <option value="Draft"
                                                                                    {{ $menu->status == 'Draft' ? 'selected' : '' }}>
                                                                                    Draft</option>
                                                                                <option value="Cooking"
                                                                                    {{ $menu->status == 'Cooking' ? 'selected' : '' }}>
                                                                                    Cooking</option>
                                                                                <option value="Packing"
                                                                                    {{ $menu->status == 'Packing' ? 'selected' : '' }}>
                                                                                    Packing</option>
                                                                                <option value="Delivered"
                                                                                    {{ $menu->status == 'Delivered' ? 'selected' : '' }}>
                                                                                    Delivered</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Tutup</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a class="btn btn-sm btn-warning"
                                                        href="{{ route('menuEdit', $menu->slug) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button url="{{ route('menuDestroy', $menu->slug) }}"
                                                        type="button" class="btn btn-sm btn-danger delete"
                                                        data-id="{{ $menu->id }}">
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
