@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    Users
                    {{-- <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small> --}}
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <br>
                        <div class="row">
                            <div class="col-md-5">
                                <a style="margin-left: 7.5%" title="TAMBAH ROLE" data-toggle="modal" data-target="#tambahUser"
                                    href="#" name="submit" class="btn btn-success waves-effect"><i
                                        class="material-icons">add</i><span>TAMBAH USER</span></a>
                            </div>
                            {{-- <form id="form_validation" method="post" action="">
                            <div class="col-sm-2">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="pilihExport" class="form-control" name="namafile" value="<?php // $getnamafile;
                                        ?>" />
                                        <label class="form-label">Pilih data export</label>
                                    </div>
                                </div>
                            </div>
                            <?php if ($getnamafile == "Karyawan") { ?>
                                <a title="EXPORT DATA KARYAWAN" href="pages/karyawan/cetakkaryawan.php?&act=excel" class="btn btn-primary waves-effect"><i class="material-icons">import_export</i><span>EXPORT DATA</span></a>
                        </form> --}}
                            <div class="col-md-1"></div>
                            <div class="col-md-6">
                                {{-- <h4 style="margin-left: 54%"><b>Jumlah Karyawan : 257<?php // $rowheader->jumlahkaryawan;
                                ?></b></h4> --}}
                            </div>
                            {{-- <?php }else{ ?> --}}
                            {{-- <div class="col-md-12">
                            <h4 style="margin-right: 70%"><b>Jumlah Karyawan : <?php // $rowheader->jumlahkaryawan;
                            ?></b></h4>
                        </div> --}}
                            {{-- <?php } ?> --}}
                        </div>
                        <br>
                        {{-- <div class="header">
                        <h2>
                            KARYAWAN TETAP
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div> --}}
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Nama</th>
                                            <th>Permissions</th>
                                            <th>Aksi</th>
                                            {{-- <th>Salary</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $item)
                                            <tr>
                                                <td> {{ $loop->iteration }} </td>
                                                <td> {{ $item->name }} </td>

                                                <td>
                                                    @foreach ($item->getPermissionNames() as $roles)
                                                        {{ $roles }},
                                                    @endforeach
                                                </td>
                                                <td class="text-center" style="width: 20%">
                                                    <a title="UBAH USER" href="javascript:void(0);"><i
                                                            class="material-icons btn-edit" data-toggle="modal"
                                                            data-target="#editUser{{ $item->id }}"
                                                            aria-hidden="true">edit</i></a>
                                                    <a title="HAPUS USER" data-id="{{ $item->id }}" href="#"
                                                        role="button" class="hapusUsers" data-id=""
                                                        data-toggle="modal"><i class="material-icons"
                                                            aria-hidden="true">delete</i></a>
                                                </td>
                                                {{-- @include('users.modal-edit', ['user' => $item]) --}}
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
        <div class="modal fade" id="tambahUser" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Tambah Data User</h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('users-store') }}">
                            @csrf
                            {{-- <div class="row clearfix"> --}}

                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="name">
                                    <label class="form-label">Nama</label>
                                </div>
                            </div>


                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="email">
                                    <label class="form-label">Email</label>
                                </div>
                            </div>


                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" class="form-control" name="password">
                                    <label class="form-label">Password</label>
                                </div>
                            </div>


                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" class="form-control" name="password_confirmation">
                                    <label class="form-label">Confirm Password</label>
                                </div>
                            </div>


                            <select class=" form-control show-tick" multiple name="permission[]" id="permissionAdd">
                                <option>-- Pilih Permission --</option>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>


                            {{-- </div> --}}

                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-success waves-effect"><i class="material-icons me-3">save</i>SIMPAN</button> --}}
                        <button type="submit" name="submit" class="btn btn-success waves-effect"> <i
                                class="material-icons">save</i><span>SIMPAN</span></button>
                        {{-- <button type="button" name="submit" class="btn btn-success waves-effect"><i class="material-icons">add</i><span>TAMBAH ROLE</span></button> --}}
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"> <i
                                class="material-icons">close</i><span>TUTUP</span></button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        @foreach ($user as $item)
            <div class="modal fade" id="editUser{{ $item->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Edit Data User</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('users-update', $item->id) }}">
                                @csrf
                                {{-- <div class="row clearfix"> --}}

                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" value="{{ $item->name }}"
                                            name="name">
                                        <label class="form-label">Nama</label>
                                    </div>
                                </div>


                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" value="{{ $item->email }}"
                                            name="email">
                                        <label class="form-label">Email</label>
                                    </div>
                                </div>


                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="password" class="form-control" name="password">
                                        <label class="form-label">Password</label>
                                    </div>
                                </div>


                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="password" class="form-control" name="password_confirmation">
                                        <label class="form-label">Confirm Password</label>
                                    </div>
                                </div>


                                <select name="permissions[]" class="form-control show-tick" multiple>
                                    <option>-- Pilih Permission --</option>
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->id }}"
                                            {{ $item->hasPermissionTo($permission->name) ? 'selected' : '' }}>
                                            {{ $permission->name }}</option>
                                    @endforeach
                                </select>


                                {{-- </div> --}}

                        </div>
                        <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-success waves-effect"><i class="material-icons me-3">save</i>SIMPAN</button> --}}
                            <button type="submit" name="submitEdit" class="btn btn-success waves-effect"> <i
                                    class="material-icons">save</i><span>SIMPAN</span></button>
                            {{-- <button type="button" name="submit" class="btn btn-success waves-effect"><i class="material-icons">add</i><span>TAMBAH ROLE</span></button> --}}
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"> <i
                                    class="material-icons">close</i><span>TUTUP</span></button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    </section>
@endsection
@push('custom-scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    <script>
        // $('#permissionAdd').select2({
        //     placeholder: '--Pilih Permission--'
        // });
        // $('#permissions').select2({
        //             placeholder: '--Pilih Permission--'
        //         });
        // $(document).ready(function() {
        $('.hapusUsers').on('click', function() {
            var id = $(this).data('id');
            swal({
                title: "Apakah anda yakin?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "GET",
                        url: "/users-delete/" + id,
                        success: function(response) {
                            swal("Deleted!", "Data telah terhapus.", "success");
                            // session(['success' => 'Berhasil hapus data user']);
                             window.location.href = '{{route("users")}}';
                            // console.log(response);
                        }
                    });
                } else {
                    swal("Cancelled", "", "error");
                }
            });

        });

        // });
    </script>
@endpush
