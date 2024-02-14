<form action="/admin/employee/{{ $employee->id_employee }}/update" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="mb-3">
      <label class="form-label">ID Karyawan</label>
      <input type="text" class="form-control" id="id-employee" value="{{ $employee->id_employee }}" name="id_employee" readonly disabled>
    </div>
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" class="form-control" id="username" value="{{ $employee->username }}" name="username">
    </div>
    <div class="mb-3">
      <label class="form-label">Nama Lengkap</label>
      <input type="text" class="form-control" name="fullname" value="{{ $employee->fullname }}" id="fullname">
    </div>
    <div class="mb-3">
      <label class="form-label">Jabatan</label>
      <input type="text" class="form-control" id="position" value="{{ $employee->position }}" name="position">
    </div>
    <div class="mb-3">
      <div class="form-label">Foto</div>
        <input type="file" name="photo" class="form-control" accept=".png, .jpg, .jpeg" />
        <input type="hidden" name="old_photo" value="{{ $employee->photo }}">
    </div>
    <div class="mb-3">
      <button class="btn btn-primary w-100 ms-auto">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
        Perbarui Data
      </button>
    </div>
  </form>