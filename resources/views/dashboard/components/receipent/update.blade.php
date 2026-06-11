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
                            <h3 class="card-title">Lengkapi Informasi Instansi Penerima</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('recipientUpdate', $recipient->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Nama <code>*</code></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Masukkan nama lengkap" autofocus required
                                                value="{{ $recipient->name }}">
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="kitchen_id" name="kitchen_id"
                                            placeholder="Masukkan nama lengkap" autofocus required
                                            value="{{ $recipient->kitchen_id }}">
                                        <span class="text-danger">{{ $errors->first('kitchen_id') }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Nomor Telepon <code>*</code></label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                placeholder="Masukkan Nomor Telepon" inputmode="numeric"
                                                pattern="[0-9]*" minlength="11" maxlength="15" required
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                value="{{ $recipient->phone }}">
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type">Tipe <code>*</code></label>
                                            <select class="form-control" id="type" name="type" required>
                                                <option value="" selected disabled>Pilih Tipe</option>
                                                <option value="Peserta Didik/Pelajar"
                                                    {{ $recipient->type == 'Peserta Didik/Pelajar' ? 'selected' : '' }}>
                                                    Peserta Didik/Pelajar (Sekolah)
                                                </option>
                                                <option value="Kelompok 3B"
                                                    {{ $recipient->type == 'Kelompok 3B' ? 'selected' : '' }}>
                                                    Kelompok 3B (Posyandu)
                                                </option>
                                            </select>
                                            <span class="text-danger">{{ $errors->first('type') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Alamat <code>*</code></label>
                                            <textarea type="text" class="form-control" id="address" name="address" placeholder="Masukkan Alamat" required>{{ $recipient->address }}</textarea>
                                            <span class="text-danger">{{ $errors->first('address') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center mt-4">
                                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </di>
        </div>
    </div>
</div>

@include('dashboard.partials.footer')
