@extends('layouts.master-admin')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                Data Pegawai
              </h2>
            </div>
          </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
      <div class="container-xl">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
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
                </div>
                <div class="row">
                  <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                      <form action="{{ route('employee-admin') }}" method="GET">
                        <div class="row">
                          <div class="col-8">
                            <div class="form-group">
                              <input type="text" class="form-control" name="fullname" placeholder="Nama Karyawan" value="{{ request()->fullname }}">
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-group">
                              <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                Search
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                      <a href="#" class="btn btn-primary d-none d-sm-inline-block" id="btn-add-employee">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        Tambah Pegawai
                      </a>
                    </div>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-12">
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
                        @foreach ($employee as $e)
                        <tr>
                            <td>{{ $loop->iteration + $employee->firstItem() - 1 }}</td>
                            <td>{{ $e->id_employee }}</td>
                            <td>
                                <div class="d-flex py-1 align-items-center">
                                  @if (empty($e->photo))
                                    <img src="{{ asset('assets/img/no-image.png') }}" alt="" class="avatar me-2">
                                  @else
                                    <img src="{{ asset('storage/uploads/employee/' . $e->photo) }}" alt="" class="avatar me-2">
                                  @endif
                                  <div class="flex-fill">
                                    <div class="font-weight-medium">{{ $e->fullname }}</div>
                                  </div>
                                </div>
                            </td>
                            <td class="text-secondary">
                                {{ $e->position }}
                            </td>
                            <td>
                              <div class="btn-list flex-nowrap">
                                <a href="#" class="edit btn-primary btn btn-sm" idEmployee="{{ $e->id_employee }}" >
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                  Edit
                                </a>
                                <form action="/admin/employee/{{ $e->id_employee }}/delete" method="POST">
                                  @method('DELETE')
                                  @csrf
                                  <button class="btn btn-danger btn-sm btn-delete-employee">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z" stroke-width="0" fill="currentColor" /><path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor" /></svg>
                                    Delete
                                  </button>
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
    </div>

    {{-- Add --}}
    <div class="modal modal-blur fade" id="modal-add-employee" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah data Pegawai</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label class="form-label">ID Pegawai</label>
                    <input type="text" class="form-control" name="id_employee">
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username">
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="fullname">
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" class="form-control" name="position">
                  </div>
                </div>
                {{-- <div class="col-lg-12">
                  <div class="mb-3">
                    <div class="form-label">Jenis kelamin</div>
                    <select class="form-select" name="gender" id="gender">
                      <option value="l" selected>Laki-Laki</option>
                      <option value="p">Perempuan</option>
                    </select>
                  </div>
                </div> --}}
                <div class="col-lg-12">
                  <div class="mb-3">
                    <div class="form-label">Foto</div>
                      <input type="file" name="photo" class="form-control" accept=".png, .jpg, .jpeg" />
                  </div>
                </div>
                <div class="col-lg-12">
                  <button class="btn btn-primary w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                    Simpan
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    {{-- Edit --}}
    <div class="modal modal-blur fade" id="modal-edit-employee" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit data Pegawai</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="edit-employee-form">
          </div>
        </div>
      </div>
    </div>
@endsection
@push('modal-employee-script')
    <script>
      $(function() {
        $("#btn-add-employee").click(function() {
          $("#modal-add-employee").modal("show");
        });

        $(".edit").click(function() {
          const idEmployee = $(this).attr("idEmployee");
          $.ajax({
            type: 'POST',
            url: '/admin/employee/edit',
            data: {
              _token: "{{ csrf_token() }}",
              idEmployee: idEmployee,
            },
            success: (response) => {
              $('#edit-employee-form').html(response);
            }
          });

          $("#modal-edit-employee").modal("show");
        });

        $(".btn-delete-employee").click(function(e) {
          const form = $(this).closest('form');
          e.preventDefault();
          Swal.fire({
            title: "Apakah Anda yakin ingin menghapus data karyawan?",
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
                text: "Data berhasil dihapus.",
                icon: "success"
              });
            }
          });
        });
      });
    </script>
@endpush