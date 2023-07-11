<!doctype html>
<html lang="en">
<head>
    <!-- Sisipkan bagian head -->
    @include('layouts.head')

    <!-- Tambahkan script SweetAlert -->
    <script src="sweetalert.js"></script>
</head>
<body id="body-admins">
    <!-- Sisipkan bagian navbar -->
    @include('layouts.navbar')

    <!-- Cek pesan success atau error -->
    @if ($message = Session::get('success'))
        <script>
            $(document).ready(function () {
                Swal.fire({
                    icon: 'success',
                    title: '{{$message}}',
                    timer: 1500,
                })
            });
        </script>
    @elseif ($message = Session::get('error'))
        <script>
            $(document).ready(function () {
                Swal.fire({
                    icon: 'error',
                    title: '{{$message}}',
                    timer: 1500,
                })
            });
        </script>
    @endif

    <!-- Sisipkan script tooltip -->
    <script>
        $(document).ready(function () {
            $('[data-bs-toggle="popover"]').tooltip();
        });
    </script>

    <!-- Bagian konten halaman -->
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col">
                <div class="card p-3 mb-5 border-0">
                    <h2 class="text-center">Profil Saya</h2>
                    <hr>
                    <div class="row">
                        <div class="col-2">
                            <img src="{{ asset('img/blank-profile-picture-973460_1280.png') }}" width="120" height="120" class="rounded float-left mt-2" alt="...">
                            <a href="/auditee/{{ auth()->id() }}/change_password" class="unstyled text-light badge bg-primary">Ganti Password</a>
                            <button type="button" id="edit" class="unstyled text-light badge bg-primary border-0" onClick="edit();">Edit Profil</button>
                            <button type="button" id="batal" class="unstyled text-light badge bg-danger border-0 hide" onClick="batal_edit();">Batal Edit</button>
                            <br>
                        </div>
                        <div class="col">
                            <div class="row g-5 align-items-center">
                                <div class="col-8 mb-3">
                                    <form action="/ketua/{{ auth()->id() }}/profile" method="post">
                                        @csrf
                                        <table class="table table-borderless ">
                                            <tr>
                                                <th scope="row" style="width: 50%">Nama :</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" id="name" name="name" readonly class="form-control p-1 @error('name') is-invalid @enderror" value="{{ auth()->user()->name }}">
                                                    @error('name')
                                                        <div id="name" class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" style="width: 50%">Email :</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="email" id="email" name="email" readonly class="form-control p-1 @error('email') is-invalid @enderror" value="{{ auth()->user()->email }}">
                                                    @error('email')
                                                        <div id="name" class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" style="width: 50%">Fakultas :</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="fakultas" readonly class="form-control p-1 @error('fakultas') is-invalid @enderror" value="{{ auth()->user()->fakultas }}">
                                                    @error('fakultas')
                                                        <div id="name" class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" style="width: 50%">Program Studi :</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" id="prodi" name="prodi" readonly class="form-control p-1 @error('prodi') is-invalid @enderror" value="{{ auth()->user()->prodi }}">
                                                    @error('prodi')
                                                        <div id="prodi" class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                            </tr>
                                        </table>
                                        <hr>
                                        <button type="submit" id="simpan" class="btn btn-success btn-sm hide">Simpan</button>
                                        <a href="{{ route('ketua.dashboard') }}"><button type="button" id="kembali" class="btn btn-secondary btn-sm">Kembali</button></a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function edit() {
                    $("button[id='simpan']").removeClass('hide');
                    $("button[id='kembali']").addClass('hide');
                    $("button[id='edit']").addClass('hide');
                    $("button[id='batal']").removeClass('hide');
                    $("input[name='name']").removeAttr("readonly");
                    $("input[name='email']").removeAttr("readonly");

                    Swal.fire(
                        'Edit',
                        'Anda dalam mode edit',
                        'warning'
                    );
                }

                function batal_edit() {
                    $("button[id='simpan']").addClass('hide');
                    $("button[id='kembali']").removeClass('hide');
                    $("button[id='edit']").removeClass('hide');
                    $("button[id='batal']").addClass('hide');
                    $("input[name='name']").prop("readonly", true);
                    $("input[name='email']").prop("readonly", true);

                    Swal.fire(
                        'Batal Edit',
                        'Keluar Mode Edit',
                        'warning'
                    );
                }
            </script>
        </div>
        @if(auth()->user()->fakultas == null || auth()->user()->prodi == null)
            <div class="alert alert-warning alert-dismissible fade show mt-alerts mt-4" role="alert">
                <strong>Peringatan!</strong> Anda belum mengisi data profil yang diperlukan <a href="{{ route('auditee.profile') }}" class="alert-link">disini</a>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @else
        @endif
    </div>

    <!-- Sisipkan bagian footer -->
    @include('layouts.footer')

    <!-- Skrip untuk mengaktifkan fitur edit dan batal edit -->
    <script>
        function edit() {
            $("button[id='simpan']").removeClass('hide');
            $("button[id='kembali']").addClass('hide');
            $("button[id='edit']").addClass('hide');
            $("button[id='batal']").removeClass('hide');
            $("input[name='name']").removeAttr("readonly");
            $("input[name='email']").removeAttr("readonly");

            Swal.fire(
                'Edit',
                'Anda dalam mode edit',
                'warning'
            );
        };

        function batal_edit() {
            $("button[id='simpan']").addClass('hide');
            $("button[id='kembali']").removeClass('hide');
            $("button[id='edit']").removeClass('hide');
            $("button[id='batal']").addClass('hide');
            $("input[name='name']").prop("readonly", true);
            $("input[name='email']").prop("readonly", true);

            Swal.fire(
                'Batal Edit',
                'Keluar Mode Edit',
                'warning'
            );
        }
    </script>

@include('layouts.global-script')
</body>

</html>
