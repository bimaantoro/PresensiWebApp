@extends('layouts.master-admin')
@section('title', 'Data Karyawan')
@section('content')
    <!-- Page body -->
    <div class="page-body">
      <div class="container-xl">
        <div class="row row-cards">
          <div class="card">
            <div class="card-body">

              <div class="col-12 mb-3">
                @if (session()->has('success'))
                  <div class="alert alert-success">
                    {{ session('success') }}
                  </div>
                @endif
                @if (session()->has('error'))
                  <div class="alert alert-danger">
                    {{ session('error') }}
                  </div>
                @endif
              </div>

              <div class="col-12 mb-3">
                <a href="#" class="btn btn-primary" id="btn-add-employee">
                  <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                  Tambah Karyawan
                </a>
              </div>
              <div class="col-12 mb-3">
                <form action="/admin/employees" method="GET">
                  <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" class="form-control" name="fullname" placeholder="Nama Karyawan" value="{{ Request('fullname') }}">
                        </div>
                      </div>
                      {{-- <div class="col-6">
                        <div class="form-group">
                          <select class="form-select" name="kode_dept" id="kode-dept">
                                <option value="">Unit</option>
                          </select>
                        </div>
                      </div> --}}
                      <div class="col-6">
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                            Cari Data
                          </button>
                        </div>
                      </div>
                  </div>
                </form>
              </div>

              <div class="col-12 mb-3">
                <div class="table-responsive">
                  <table class="table table-vcenter table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th class="w-1"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($employee as $std)
                      <tr>
                          <td>{{ $loop->iteration + $employee->firstItem() - 1 }}</td>
                          <td>{{ $std->id_employee }}</td>
                          <td>
                              <div class="d-flex py-1 align-items-center">
                                @if (empty($std->photo))
                                  <img src="{{ asset('assets/img/no-image.png') }}" alt="" class="avatar me-2">
                                @else
                                  <img src="{{ asset('storage/uploads/employee/' . $std->photo) }}" alt="" class="avatar me-2">
                                @endif 
                                <div class="flex-fill">
                                  <div class="font-weight-medium">{{ $std->fullname }}</div>
                                </div>
                              </div>
                          </td>
                          <td>
                              {{ $std->position }}
                          </td>
                          <td>
                            <div class="btn-list flex-nowrap">
                              <a href="/admin/setting/{{ $std->id_employee }}/work-hour" class="btn-success btn btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
                                Setting
                              </a>
                              <a href="#" class="edit btn-primary btn btn-sm" idEmployee="{{ $std->id_employee }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                Edit
                              </a>
                              <form action="/admin/employee/{{ $std->id_employee }}/delete" method="POST">
                                @method('DELETE')
                                @csrf
                                <a class="btn btn-danger btn-sm btn-delete-employee">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z" stroke-width="0" fill="currentColor" /><path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor" /></svg>
                                  Delete
                                </a>
                              </form>
                            </div>
                          </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div> 
              </div>
              {{ $employee->links('vendor.pagination.bootstrap-5') }}
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Add --}}
    <div class="modal modal-blur fade" id="modal-add-employee" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah data Karyawan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/admin/employee/store" id="form-add-employee" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label class="form-label">ID Karyawan</label>
                <input type="text" class="form-control" id="id-employee" name="id_employee">
              </div>
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username">
              </div>
              <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="fullname" id="fullname">
              </div>
              <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="position" name="position">
              </div>
              <div class="mb-3">
                <div class="form-label">Foto</div>
                  <input type="file" name="photo" class="form-control" accept=".png, .jpg, .jpeg" />
              </div>
              <div class="mb-3">
                <button class="btn btn-primary w-100 ms-auto">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                  Simpan
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    {{-- Edit --}}
    <div class="modal modal-blur fade" id="modal-edit-employee" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit data Karyawan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="loaded-edit-form">
          </div>
        </div>
      </div>
    </div>
@endsection

@push('master-admin-script')
    <script>
      $(function() {
        $("#btn-add-employee").click(function() {
          $("#modal-add-employee").modal("show");
        });

        // add
        $("#form-add-employee").submit(function() {
          const idEmployee = $("#id-employee").val();
          const username = $("#username").val();
          const namaLengkap = $("#fullname").val();
          const position = $("#position").val();

          if(idEmployee === "") {
            Swal.fire({
              icon: "warning",
              title: 'Warning!',
              text: "ID Karyawan harus diisi",
              confirmButtonText: "OK"
            }).then((result) => {
              $("#id-karyawan").focus();
            });
            return false;
          } else if(username === "") {
            Swal.fire({
              icon: "warning",
              title: 'Warning!',
              text: "Username harus diisi",
              confirmButtonText: "OK"
            }).then((result) => {
              $("#username").focus();
            });
            return false;
          } else if(namaLengkap === "") {
            Swal.fire({
              icon: "warning",
              title: 'Warning!',
              text: "Nama lengkap harus diisi",
              confirmButtonText: "OK"
            }).then((result) => {
              $("#fullname").focus();
            });
            return false;
          } else if(position === "") {
            Swal.fire({
              icon: "warning",
              title: 'Warning!',
              text: "Jabatan harus diisi",
              confirmButtonText: "OK"
            }).then((result) => {
              $("#position").focus();
            });
            return false;
          }
        });

        // edit
        $(".edit").click(function() {
          const idEmployee = $(this).attr("idEmployee");
          $.ajax({
            type: 'POST',
            url: '/admin/employee/edit',
            data: {
              _token: "{{ csrf_token() }}",
              id: idEmployee,
            },
            success: (response) => {
              $('#loaded-edit-form').html(response);
            }
          });

          $("#modal-edit-employee").modal("show");
        });

        // delete
        $(".btn-delete-employee").click(function(e) {
          const form = $(this).closest('form');
          e.preventDefault();
          Swal.fire({
            title: "Yakin ingin menghapus data ini ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya"
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit();
              Swal.fire({
                title: "Deleted!",
                text: "Data berhasil dihapus!",
                icon: "success"
              });
            }
          });
        });
      });
    </script>
@endpush