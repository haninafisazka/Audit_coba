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


    $(document).ready(function () {
        @if (count($errors) > 0)
        $('#modalPendahuluan').modal('show');
        @endif
    });
</script>

<!-- Modal -->
{{-- <div class="modal fade" id="modalPendahuluan" tabindex="-1" aria-labelledby="modalPendahuluan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize" id="modalPendahuluan">Isi data pendahuluan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/auditee/{{ auth()->id() }}/dataPendahuluan" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="kepala_prodi" class="col-sm-5 col-form-label">Kepala Prodi</label>
                        <div class="col-1"> :</div>
                        <div class="col-sm-6">
                            <input type="text" name="kepala_prodi" class="form-control @error('kepala_prodi') is-invalid @enderror" id="kepala_prodi">
                            @error('kepala_prodi')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-5 col-form-label">Nama Pengisi</label>
                        <div class="col-1"> :</div>
                        <div class="col-sm-6">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="dosen_aktif" class="col-sm-5 col-form-label">Jumlah Dosen Aktif</label>
                        <div class="col-1"> :</div>
                        <div class="col-sm-6">
                            <input type="number" name="dosen_aktif" class="form-control @error('dosen_aktif') is-invalid @enderror" id="dosen_aktif">
                            @error('dosen_aktif')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="mahasiswa_aktif" class="col-sm-5 col-form-label">Jumlah Mahasiswa Aktif</label>
                        <div class="col-1"> :</div>
                        <div class="col-sm-6">
                            <input type="number" name="mahasiswa_aktif" class="form-control @error('mahasiswa_aktif') is-invalid @enderror" id="mahasiswa_aktif">
                            @error('mahasiswa_aktif')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="total_penelitian" class="col-sm-5 col-form-label">Jumlah Penelitian Dosen</label>
                        <div class="col-1"> :</div>
                        <div class="col-sm-6">
                            <input type="number" name="total_penelitian" class="form-control @error('total_penelitian') is-invalid @enderror" id="total_penelitian">
                            @error('total_penelitian')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="total_pengabdian" class="col-sm-5 col-form-label">Jumlah Pengabdian Dosen</label>
                        <div class="col-1"> :</div>
                        <div class="col-sm-6">
                            <input type="number" name="total_pengabdian" class="form-control @error('total_pengabdian') is-invalid @enderror" id="total_pengabdian">
                            @error('total_pengabdian')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jumlah_kerjasama" class="col-sm-5 col-form-label">Jumlah Kerja Sama</label>
                        <div class="col-1"> :</div>
                        <div class="col-sm-6">
                            <input type="number" name="jumlah_kerjasama" class="form-control @error('jumlah_kerjasama') is-invalid @enderror" id="jumlah_kerjasama">
                            @error('jumlah_kerjasama')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div> --}}

{{--container--}}
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-2 border-end">
            <div id="side-bar" class="ps-3 pt-3 bg-white overflow-auto" style="width: 180px;">
                <ul class="list-unstyled ps-0">
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                                data-bs-target="#home-collapse" aria-expanded="true">
                                Upload File
                        </button>
                        <div class="collapse show" id="home-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li class="fw-bold"><a href="{{route('auditee.dashboard')}}" class="link-dark rounded">Upload</a>
                                </li>
                                {{-- <li><a href="{{route('auditee.grade')}}" class="link-dark rounded">Lihat hasil</a>
                                </li> --}}
                            </ul>
                        </div>
                    </li>

                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                                data-bs-target="#account-collapse" aria-expanded="false">
                            Feedback
                        </button>
                        <div class="collapse show" id="account-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="{{ route('auditee.feedbackTemuan') }}" class="link-dark rounded">Feedback Temuan</a></li>
                                <li><a href="{{ route('auditee.feedbackTindakLanjut') }}" class="link-dark rounded">Tindak Lanjut Temuan</a></li>
                            </ul>
                        </div>
                    </li>

        
                </ul>
            </div>
        </div>
        <div class="col">
       <div class="col">
            <h2 class="text-center">Feedback Hasil Temuan</h2>
            <hr>
            <div class="card mb-3 p-2">
                <div class="tab-pane fade show active" id="format_soal" role="tabpanel" aria-labelledby="format_soal-tab">
                    <div class="card-body">
                        <div class="table-container">

                        <div class="col-auto mb-3">Komentar/Klarifikasi:</div>
                                    <div class="col-12 mb-3">
                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" aria-describedby="description" id="description" rows="3" >{{ old('description') }}</textarea>
                                            @error('description')
                                                <div id="description" class="invalid-feedback">
                                                    Deskripsi wajib diisi
                                                </div>
                                            @enderror
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @if(auth()->user()->fakultas == null || auth()->user()->prodi == null)
        <div class="alert alert-warning alert-dismissible fade show mt-alerts mt-4" role="alert">
            <strong>Peringatan!</strong> Anda belum mengisi data profil yang diperlukan <a href="{{ route('auditee.profile') }}" class="alert-link">disini</a>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @else
    @endif --}}
</div>

@include('layouts.footer')

<script>

    // function responseFunction() {
    //     event.preventDefault(); // prevent form submit

    //     Swal.fire({
    //         icon: 'error',
    //         title: 'Aksi Dilarang',
    //         text: 'Anda Belum mengisikan Data Pendahuluan / Data profil yang diperlukan',
    //     })

    // }

    $(document).ready(function () {
        $('#table_standart').DataTable();
    });
</script>

@include('layouts.global-script')
</body>

</html>
