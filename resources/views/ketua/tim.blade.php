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

<!--
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
-->

{{--container--}}
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-2 border-end">
            <div id="side-bar" class="ps-3 pt-3 bg-white overflow-auto" style="width: 180px;">
                <ul class="list-unstyled ps-0">
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                                data-bs-target="#home-collapse" aria-expanded="true">
                            Daftar Tim
                        </button>
                        <div class="collapse" id="dashboard-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a class="link-dark rounded" href="{{ route('ketua.tim') }}" >Daftar Tim</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                                data-bs-target="#home-collapse" aria-expanded="true">
                            Auditor
                        </button>
                        <div class="collapse" id="dashboard-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a class="link-dark rounded" href="{{ route ('ketua.auditor') }}">Auditor</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- list tim -->
        <div class="col-12">
            <div class="card recent-sales overflow-auto">

        

                <div class="card-body">

                <table class="table table-borderless datatable">
                    <thead>
                    <tr class="border-bottom">
                        <th scope="col">Tim</th>
                        <th scope="col">Prodi</th>
                        <th scope="col">Fakultas</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                    </thead>            

                

                    <div class="search-container">
        <div class="new-column">+ New</div>
        <form id="search-form" onsubmit="search(event)">
            <input type="text" id="search-input" placeholder="Search...">
        </form>
        </div>

        <style>
        .search-container {
            display: flex;
            justify-content: space-between; /* Menempatkan elemen di antara tepi kanan dan kiri */
            align-items: center;
            margin-top: 25px;
            margin-bottom: 25px;
            margin-left: 9px;
            margin-right: 15px;
        }

        .new-column {
            background-color: green;
            color: white;
            padding: 4px;
            width: 7%;
            border-radius: 3px;
            /* text: center; */
        }
        </style>



                    <tbody>
                    <tr class="border-bottom">
                        <th scope="row"><a href=>1</a></th>
                        <td>Informatika</td>
                        <td>Teknologi Informasi dan Sains Data</td>
                        <td>Active</td>
                        <td>
                            <a href="/edit" class="btn btn-primary">Edit</a>
                            <a href="/delete" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <tr class="border-bottom">
                        <th scope="row"><a href=>2</a></th>
                        <td>Arsitektur</td>
                        <td>Teknik</td>
                        <td>Active</td>
                        <td>
                            <a href="/edit" class="btn btn-primary">Edit</a>
                            <a href="/delete" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <tr class="border-bottom">
                        <th scope="row"><a href=>3</a></th>
                        <td>Kedokteran</td>
                        <td>Kedokteran</td>
                        <td>Active</td>
                        <td>
                            <a href="/edit" class="btn btn-primary">Edit</a>
                            <a href="/delete" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <tr class="border-bottom">
                        <th scope="row"><a href=>4</a></th>
                        <td>Matematika</td>
                        <td>Matematika dan Ilmu Pengetahuan Alam</td>
                        <td>Active</td>
                        <td>
                            <a href="/edit" class="btn btn-primary">Edit</a>
                            <a href="/delete" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <tr class="border-bottom">
                        <th scope="row"><a href=>5</a></th>
                        <td>Ekonomi</td>
                        <td>Ekonomi dan Bisnis</td>
                        <td>Active</td>
                        <td>
                            <a href="/edit" class="btn btn-primary">Edit</a>
                            <a href="/delete" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <tr class="border-bottom">
                        <th scope="row"><a href=>6</a></th>
                        <td>Agroteknologi</td>
                        <td>Pertanian</td>
                        <td>Active</td>
                        <td>
                            <a href="/edit" class="btn btn-primary">Edit</a>
                            <a href="/delete" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <tr class="border-bottom">
                        <th scope="row"><a href=>7</a></th>
                        <td>Seni Rupa</td>
                        <td>Seni Rupa dan Desain</td>
                        <td>Active</td>
                        <td>
                            <a href="/edit" class="btn btn-primary">Edit</a>
                            <a href="/delete" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <tr class="border-bottom">
                        <th scope="row"><a href=>8</a></th>
                        <td>Sains Data</td>
                        <td>Teknologi Informasi dan Sains Data</td>
                        <td>Active</td>
                        <td>
                            <a href="/edit" class="btn btn-primary">Edit</a>
                            <a href="/delete" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <tr class="border-bottom">
                        <th scope="row"><a href=>9</a></th>
                        <td>Hukum</td>
                        <td>Hukum</td>
                        <td>Active</td>
                        <td>
                            <a href="/edit" class="btn btn-primary">Edit</a>
                            <a href="/delete" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <label for="entries-per-page">Entries per page:</label>
                    <select id="entries-per-page" onchange="changeEntriesPerPage()">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <!-- Tambahkan opsi lain sesuai kebutuhan -->
                    </select>

                </div>

            </div>
            </div><!-- End list tim -->

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
                    DAFTAR STANDART
                </h1>
                <hr>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#tambah-standart-modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                         class="bi bi-card-checklist" viewBox="0 1 16 16">
                        <path
                            d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                        <path
                            d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    <span>Tambah Standart</span>
                </button>
                <div class="card mb-5 mt-2" id="card-standart">
                    <div class="card-body">
                        <table id="table_standart" class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Standart</th>
                                <th>Tahun</th>
                                <th>Jenis Respon</th>
                                <th>Jumlah Pertanyaan</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($standart as $v)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-capitalize">{{ $v->name }}</td>
                                    <td>{{ $v->created_at->format('Y') }}</td>
                                    <td class="text-capitalize">
                                        @if($v->type == 'Likert')
                                        Likert
                                        @else
                                        Sesuai/Tidak Sesuai
                                        @endif
                                    </td>
                                    @if(!$v->questions->count())
                                        <td style="width: 15%">
                                            <span type="button" class="badge rounded-pill bg-danger tips"
                                                  data-bs-toggle="popover" title="Anda masih belum memasukkan pertanyaan
                                                    pada standart ini.">
                                                Kosong
                                            </span>
                                            <a href="/standarts/{{ $v->id }}">
                                                <span type="button" class="badge rounded-pill bg-warning text-dark">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-pencil-square" viewBox="0 1 16 16">
                                                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                      <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                    </svg>
                                                    Isi Data
                                                </span>
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            <span type="button" class="badge rounded-pill bg-success tips" style="width: 25%"
                                                  data-bs-toggle="popover" title="Data telah terisi oleh pertanyaan">
                                                {{ $v->questions->count() }}
                                            </span>
                                        </td>
                                    @endif
                                    <td class="text-center">
                                        <form action="/standarts/{{ $v->id }}" method="post">
                                            @csrf
                                            @method('GET')
                                            <a href="/standarts/{{ $v->id }}/edit"><button type="button" class="btn btn-outline-warning btn-sm">Edit</button></a>
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="deleteFunction()">Hapus</button>
                                        </form>
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
        $('#table_standart').DataTable();
        $('#table_auditee').DataTable();
        $('#table_auditor').DataTable();
        $('#table_news').DataTable();
    });
</script>


@include('layouts.global-script')
</body>

</html>
