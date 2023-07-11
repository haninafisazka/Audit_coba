<!doctype html>
<html lang="en">
@include('layouts.head')

<body id="body-admins">
@include('layouts.navbar')

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

<script>
    $(document).ready(function () {
        $('[data-bs-toggle="popover"]').tooltip();
    });

    function deleteFunction() {
        event.preventDefault(); // prevent form submit
        var form = event.target.form; // storing the form

        swal.fire({
            icon: "warning",
            title: "Hapus Data?",
            text: "Data yang telah terhapus tidak dapat dikembalikan",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Hapus data",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();

            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swal.fire(
                    'Dibatalkan',
                    'Hapus data dibatalkan, data tidak terhapus.',
                    'error'
                )
            }
        })

        // function(isConfirm){
        //     if (isConfirm) {
        //         form.submit();          // submitting the form when user press yes
        //     } else {
        //         Swal.fire(
        //             'The Internet?',
        //             'That thing is still around?',
        //             'question'
        //         );
        //     }
        // });
    }
</script>

<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-2 border-end">
            <div id="side-bar" class="ps-3 pt-3 bg-white overflow-auto" style="width: 180px;">
                <ul class="list-unstyled ps-0">
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                                data-bs-target="#home-collapse" aria-expanded="true">
                            <span>Home</span>
                        </button>
                        <div class="collapse" id="home-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li ><a href="{{route('auditor.dashboard')}}" class="link-dark rounded">Beranda</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{--                    <li class="mb-1">--}}
                    {{--                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"--}}
                    {{--                                data-bs-target="#account-collapse" aria-expanded="false">--}}
                    {{--                            <span>Penilaian</span>--}}
                    {{--                        </button>--}}
                    {{--                        <div class="collapse" id="account-collapse">--}}
                    {{--                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">--}}
                    {{--                                <li><a href="#" class="link-dark rounded">Penilaian</a></li>--}}
                    {{--                                <li><a href="#" class="link-dark rounded">Penilaian</a></li>--}}
                    {{--                            </ul>--}}
                    {{--                        </div>--}}
                    {{--                    </li>--}}





                    



                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                                data-bs-target="#profile-collapse" aria-expanded="false">
                            <span>Evaluasi</span>
                        </button>
                        <div class="collapse show" id="profile-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li class="fw-bold"><a href="{{ route('auditor.tindakan') }}" class="link-dark rounded">Evaluasi</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col">
            <h2 class="text-center">Hasil Evaluasi</h2>
            <hr>
            <div class="card p-3">
                <form method="POST" action="/auditor/change_password">
                    @csrf
                    <div class="form-group row mb-3">
                        <label for="password" class="col-md-0 col-form-label text-md-right">Kondisi Awal : </label>

                        <div class="col-12">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" aria-describedby="description" id="description" rows="3" >{{ old('description') }}</textarea>
                            @error('description')
                                <div id="description" class="invalid-feedback">
                                    Deskripsi wajib diisi
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="password" class="col-md-0 col-form-label text-md-right">Dasar Evaluasi :</label>

                        <div class="col-12">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" aria-describedby="description" id="description" rows="3" >{{ old('description') }}</textarea>
                            @error('description')
                                <div id="description" class="invalid-feedback">
                                    Deskripsi wajib diisi
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="password" class="col-md-0 col-form-label text-md-right">Penyebab : </label>

                        <div class="col-12">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" aria-describedby="description" id="description" rows="3" >{{ old('description') }}</textarea>
                            @error('description')
                                <div id="description" class="invalid-feedback">
                                    Deskripsi wajib diisi
                                </div>
                            @enderror
                        </div>
                    </div>

 

                    <div class="form-group row mb-3">
                        <label for="password" class="col-md-0 col-form-label text-md-right">Akibat : </label>

                        <div class="col-12">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" aria-describedby="description" id="description" rows="3" >{{ old('description') }}</textarea>
                            @error('description')
                                <div id="description" class="invalid-feedback">
                                    Deskripsi wajib diisi
                                </div>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group row mb-3">
                        <label for="password" class="col-md-0 col-form-label text-md-right">Rekomendasi Follow-Up : </label>

                        <div class="col-12">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" aria-describedby="description" id="description" rows="3" >{{ old('description') }}</textarea>
                            @error('description')
                                <div id="description" class="invalid-feedback">
                                    Deskripsi wajib diisi
                                </div>
                            @enderror
                        </div>
                    </div>

            
            </div>
            <div class="row pt-3 mb-4">
                        <div class="col-auto pe-0">
                            <button type="submit" class="btn btn-success" onclick="simpanFunction()">Simpan</button>
                        </div>
                        <div class="col-auto">
                            <a type="button" onclick="batalFunction()" href="{{route('auditee.dashboard')}}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div> 
            </div>     
    </div>
</div>

    

@include('layouts.footer')

<script>

    $(document).ready(function () {
        $('#table_standart').DataTable();
    });
</script>

@include('layouts.global-script')
</body>

</html>
