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


{{--modal--}}
<form action="{{route('tambahStandart')}}" method="post">
    @csrf
    <div class="modal fade" id="tambah-standart-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
         tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Masukkan Nama Standart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input name="name" class="form-control form-control" type="text" id="keteranganHelp"
                           placeholder="Contoh : Standart Kompetensi" aria-label="keteranganHelp" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-target="#next"
                            data-bs-toggle="modal" data-bs-dismiss="modal">Lanjut
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="next" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
         tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">Pilih Jenis standart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-evenly">
                        <button name="type" type="submit" class="btn btn-outline-success btn-lg"
                                value="Likert">Skala Likert
                        </button>
                        <button name="type" type="submit" class="btn btn-outline-primary btn-lg"
                                value="Ya/Tidak">Sesuai / Tidak Sesuai
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<div class="container-fluid">
    <div class="row pt-3">
        <div class="col">
            <div id="side-bar" class="ps-3 pt-3 bg-white overflow-auto" style="width: 180px;">
                <ul class="list-unstyled ps-0">
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                                data-bs-target="#home-collapse" aria-expanded="true">
                            Set Up
                        </button>
                        <div class="collapse  show" id="home-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="{{route('admin.dashboard')}}" class="link-dark rounded">Periode Audit</a>
                                </li>
                                <li class="fw-bold"><a href="{{route('daftarUnit')}}" class="link-dark rounded">Unit Audit</a>
                                </li>
                            </ul>
                            
                        </div>
                    </li>
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                                data-bs-target="#dashboard-collapse" aria-expanded="false">
                            Auditee
                        </button>
                        <div class="collapse" id="dashboard-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="{{route('admin.dashboardAuditee')}}" class="link-dark rounded">Data</a>
                                </li>
                                <li><a href="{{route('pageTambahAuditee')}}" class="link-dark rounded">Tambah
                                        Auditee</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                                data-bs-target="#orders-collapse" aria-expanded="false">
                            Auditor
                        </button>
                        <div class="collapse" id="orders-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="{{route('admin.dashboardAuditor')}}" class="link-dark rounded">Data</a>
                                </li>
                                <li><a href="{{route('pageTambahAuditor')}}" class="link-dark rounded">Tambah
                                        Auditor</a></li>
                            </ul>
                        </div>
                    </li>
{{--                    <li class="border-top my-3"></li>--}}
{{--                    <li class="mb-1">--}}
{{--                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"--}}
{{--                                data-bs-target="#account-collapse" aria-expanded="false">--}}
{{--                            Pengumuman--}}
{{--                        </button>--}}
{{--                        <div class="collapse" id="account-collapse">--}}
{{--                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">--}}
{{--                                <li><a href="#" class="link-dark rounded">Data</a></li>--}}
{{--                                <li><a href="#" class="link-dark rounded">Tambah Pengumuman</a></li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </li>--}}
                </ul>
            </div>
        </div>
        <div class="col-10 border-start">
            <div class="container-fluid">
                <h1 class="fw-bold mt-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                         class="bi bi-card-list" viewBox="0 1 16 16">
                        <path
                            d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                        <path
                            d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                    </svg>
                    UNIT AUDIT
                </h1>
                <hr>
                <a href="{{route('pageTambahUnit')}}">
                    <button type="button" class="btn btn-outline-secondary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                             class="bi bi-person-plus-fill" viewBox="0 1 16 16">
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            <path fill-rule="evenodd"
                                  d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        <span>Tambah Unit</span>
                    </button>
                </a>
                <div class="card mb-5 mt-2" id="card-periode">
                    <div class="card-body">
                        <table id="table_periode" class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Periode Audit</th>
                                <th>Standar Ruang Lingkup</th>
                                <th>Nama Unit</th>
                                <th>Tanggal Audit</th>
                                <th>Ketua Tim</th>
                                <th>NIP Ketua Tim</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($unitAudit as $v)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$v->id_periode_audit}}</td>
                                    <td>{{$v->id_standar_ruang_lingkup}}</td>
                                    <td>{{$v->nama_unit}}</td>
                                    <td>{{$v->tanggal_audit}}</td>
                                    <td>{{$v->ketua_tim}}</td>
                                    <td>{{$v->nip_ketua_tim}}</td>
                                    <td class="text-center list-inline">
                                        <div class="d-inline-flex bd-highlight">
                                        <form id="form" class="delete-form" action="{{ route('destroy',$v->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="deleteFunction()">Hapus</button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('layouts.footer')

<script>

    $(document).ready(function () {
        $('#table_periode').DataTable();
        $('#table_auditee').DataTable();
        $('#table_auditor').DataTable();
        $('#table_news').DataTable();
    });
</script>


@include('layouts.global-script')
</body>

</html>
