<form action="/admin/employee/{{ $employee->id_employee }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="row">
      <div class="col-lg-12">
        <div class="mb-3">
          <label class="form-label">ID Karyawan</label>
          <input type="text" class="form-control" name="id_employee" value="{{ old('id_employee', $employee->id_employee) }}" disabled>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" class="form-control" name="username" value="{{ old('username', $employee->username) }}">
        </div>
      </div>
      <div class="col-lg-12">
        <div class="mb-3">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control" name="fullname" value="{{ old('fullname', $employee->fullname) }}">
        </div>
      </div>
      <div class="col-lg-12">
        <div class="mb-3">
          <label class="form-label">Jabatan</label>
          <input type="text" class="form-control" name="position" value="{{ old('position', $employee->position) }}">
        </div>
      </div>
      {{-- <div class="col-lg-12">
        <div class="mb-3">
          <div class="form-label">Jenis kelamin</div>
          <select class="form-select" name="gender" id="gender">
            <option value="l" @selected(old('gender', $employee->gender) == 'l')>Laki-Laki</option>
            <option value="p" @selected(old('gender', $employee->gender) == 'p')>Perempuan</option>
          </select>
        </div>
      </div> --}}
      <div class="col-lg-12">
        <div class="mb-3">
          <div class="form-label">Foto</div>
            <input type="file" name="photo" class="form-control" accept=".png, .jpg, .jpeg" />
            <input type="hidden" name="old_photo" value="{{ $employee->photo }}">
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