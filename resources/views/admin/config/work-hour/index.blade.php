@extends('layouts.master-admin')
@section('title', 'Konfigurasi Jam Kerja')
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
              <a href="#" class="btn btn-primary" id="btn-add-jk">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Tambah Data
              </a>
            </div>

            <div class="col-12 mb-3">
              <div class="table-responsive">
                <table class="table table-vcenter table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode Jam Kerja</th>
                      <th>Nama Jam Kerja</th>
                      <th>Awal Jam Masuk</th>
                      <th>Jam Masuk</th>
                      <th>Akhir Jam Masuk</th>
                      <th>Jam Pulang</th>
                      <th class="w-1">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($workHours as $wh)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $wh->id }}</td>
                            <td>{{ $wh->name }}</td>
                            <td>{{ $wh->start_check_in }}</td>
                            <td>{{ $wh->check_in }}</td>
                            <td>{{ $wh->end_check_in }}</td>
                            <td>{{ $wh->check_out }}</td>
                            <td>
                              <div class="btn-list flex-nowrap">
                                <a href="#" class="edit btn-primary btn btn-sm" id_jam_kerja="{{ $wh->id }}" >
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                  Edit
                                </a>
                                <form action="/admin/config/work-hour/{{ $wh->id }}/delete" method="POST">
                                  @method('DELETE')
                                  @csrf
                                  <a class="btn btn-danger btn-sm btn-delete-jk">
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
          </div>
        </div>
      </div>
    </div>
</div>

{{-- Add --}}
<div class="modal modal-blur fade" id="modal-add-jk" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Jam Kerja</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/admin/config/work-hour/store" id="form-add-jk" method="POST">
          @csrf
          <div class="mb-3">
            <div class="input-icon">
              <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7v-1a2 2 0 0 1 2 -2h2" /><path d="M4 17v1a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v1" /><path d="M16 20h2a2 2 0 0 0 2 -2v-1" /><path d="M5 11h1v2h-1z" /><path d="M10 11l0 2" /><path d="M14 11h1v2h-1z" /><path d="M19 11l0 2" /></svg>
              </span>
              <input type="text" value="" id="id-jk" class="form-control" name="id" placeholder="Kode Jam Kerja">
            </div>
          </div>
          <div class="mb-3">
            <div class="input-icon">
              <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7v-1a2 2 0 0 1 2 -2h2" /><path d="M4 17v1a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v1" /><path d="M16 20h2a2 2 0 0 0 2 -2v-1" /><path d="M5 11h1v2h-1z" /><path d="M10 11l0 2" /><path d="M14 11h1v2h-1z" /><path d="M19 11l0 2" /></svg>
              </span>
              <input type="text" class="form-control" id="name-jk" name="name" placeholder="Nama Jam Kerja">
            </div>            
          </div>
          <div class="mb-3">
            <div class="input-icon">
              <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-hour-7" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 12l-2 3" /><path d="M12 7v5" /></svg>
              </span>
              <input type="text" value="" id="start-check-in" class="form-control" name="start_check_in" placeholder="Awal Jam Masuk">
            </div>
          </div>
          <div class="mb-3">
            <div class="input-icon">
              <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-hour-8" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 12l-3 2" /><path d="M12 7v5" /></svg>
              </span>
              <input type="text" value="" class="form-control" id="check-in" name="check_in" placeholder="Jam Masuk">
            </div>
          </div>
          <div class="mb-3">
            <div class="input-icon">
              <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-hour-9" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 12h-3.5" /><path d="M12 7v5" /></svg>
              </span>
              <input type="text" value="" class="form-control" id="end-check-in" name="end_check_in" placeholder="Akhir Jam Masuk">
            </div>
          </div>
          <div class="mb-3">
            <div class="input-icon">
              <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-hour-5" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 12l2 3" /><path d="M12 7v5" /></svg>
              </span>
              <input type="text" value="" class="form-control" name="check_out" id="check-out" placeholder="Jam Pulang">
            </div>
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
<div class="modal modal-blur fade" id="modal-edit-jk" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit data Jam Kerja</h5>
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
        $("#btn-add-jk").click(function() {
          $("#modal-add-jk").modal("show");
        });

        // add
        $("#form-add-jk").submit(function() {
          const idJamKerja = $("#id-jk").val();
          const namaJamKerja = $("#name-jk").val();
          const startCheckIn = $("#start-check-in").val();
          const checkIn = $("#check-in").val();
          const endCheckIn = $("#end-check-in").val();
          const checkOut = $("#check-out").val();

          if(idJamKerja === "") {
            Swal.fire({
              icon: "warning",
              title: 'Warning!',
              text: "Kode Jam Kerja harus diisi",
              confirmButtonText: "OK"
            }).then((result) => {
              $("#id-jk").focus();
            });
            return false;
          } else if(namaJamKerja === "") {
            Swal.fire({
              icon: "warning",
              title: 'Warning!',
              text: "Nama Jam Kerja harus diisi",
              confirmButtonText: "OK"
            }).then((result) => {
              $("#name-jk").focus();
            });
            return false;
          } else if(startCheckIn === "") {
            Swal.fire({
              icon: "warning",
              title: 'Warning!',
              text: "Awal Jam Masuk harus diisi",
              confirmButtonText: "OK"
            }).then((result) => {
              $("#start-check-in").focus();
            });
            return false;
          } else if(checkIn === "") {
            Swal.fire({
              icon: "warning",
              title: 'Warning!',
              text: "Jam Masuk harus diisi",
              confirmButtonText: "OK"
            }).then((result) => {
              $("#check-in").focus();
            });
            return false;
          } else if(endCheckIn === "") {
            Swal.fire({
              icon: "warning",
              title: 'Warning!',
              text: "Akhir Jam Masuk harus diisi",
              confirmButtonText: "OK"
            }).then((result) => {
              $("#end-check-in").focus();
            }); 
          } else if(checkOut === "") {
            Swal.fire({
              icon: "warning",
              title: 'Warning!',
              text: "Jam Pulang harus diisi",
              confirmButtonText: "OK"
            }).then((result) => {
              $("#check-out").focus();
            }); 
          }
        });

         // edit
        $(".edit").click(function() {
          const idJamKerja = $(this).attr("id_jam_kerja");
          $.ajax({
            type: 'POST',
            url: '/admin/config/work-hour/edit',
            data: {
              _token: "{{ csrf_token() }}",
              id: idJamKerja,
            },
            success: (response) => {
              $('#loaded-edit-form').html(response);
            }
          });
          $("#modal-edit-jk").modal("show");
        });

         // delete
         $(".btn-delete-jk").click(function(e) {
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