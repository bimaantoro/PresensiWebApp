<form action="/admin/student/{{ $student->id }}/update" method="POST" enctype="multipart/form-data">
  @method('PUT')
  @csrf
  <div class="mb-3">
    <label class="form-label">ID Student</label>
    <input type="text" class="form-control" id="id-student" value="{{ $student->id }}" name="id" readonly>
  </div>
  <div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" class="form-control" id="username" value="{{ $student->username }}" name="username">
  </div>
  <div class="mb-3">
    <label class="form-label">Nama Lengkap</label>
    <input type="text" class="form-control" name="nama_lengkap" value="{{ $student->nama_lengkap }}" id="nama-lengkap">
  </div>
  <div class="mb-3">
    <label class="form-label">Asal Sekolah / Kampus</label>
    <input type="text" class="form-control" id="instansi" value="{{ $student->instansi }}" name="instansi">
  </div>
  <div class="mb-3">
    <div class="form-label">Dari Bulan (Periode PKL / Magang)</div>
    <select class="form-select" name="start_internship" id="start-internship">
      <option disabled selected>-Pilih Bulan-</option>
      <option value="Januari" @selected(old('start_internship', $student->start_internship) == 'Januari')>Januari</option>
      <option value="Februari" @selected(old('start_internship', $student->start_internship) == 'Februari')>Februari</option>
      <option value="Maret" @selected(old('start_internship', $student->start_internship) == 'Maret')>Maret</option>
      <option value="April" @selected(old('start_internship', $student->start_internship) == 'April')>April</option>
      <option value="Mei" @selected(old('start_internship', $student->start_internship) == 'Mei')>Mei</option>
      <option value="Juni" @selected(old('start_internship', $student->start_internship) == 'Juni')>Juni</option>
      <option value="Juli" @selected(old('start_internship', $student->start_internship) == 'Juli')>Juli</option>
      <option value="Agustus" @selected(old('start_internship', $student->start_internship) == 'Agustus')>Agustus</option>
      <option value="September" @selected(old('start_internship', $student->start_internship) == 'September')>September</option>
      <option value="Oktober" @selected(old('start_internship', $student->start_internship) == 'Oktober')>Oktober</option>
      <option value="November" @selected(old('start_internship', $student->start_internship) == 'November')>November</option>
      <option value="Desember" @selected(old('start_internship', $student->start_internship) == 'Desember')>Desember</option>
    </select>
  </div>
  <div class="mb-3">
    <div class="form-label">Sampai Bulan (Periode PKL / Magang)</div>
    <select class="form-select" name="end_internship" id="end-internship">
      <option disabled selected>-Pilih Bulan-</option>
      <option value="Januari" @selected(old('end_internship', $student->end_internship) == 'Januari')>Januari</option>
      <option value="Februari" @selected(old('end_internship', $student->end_internship) == 'Februari')>Februari</option>
      <option value="Maret" @selected(old('end_internship', $student->end_internship) == 'Maret')>Maret</option>
      <option value="April" @selected(old('end_internship', $student->end_internship) == 'April')>April</option>
      <option value="Mei" @selected(old('end_internship', $student->end_internship) == 'Mei')>Mei</option>
      <option value="Juni" @selected(old('end_internship', $student->end_internship) == 'Juni')>Juni</option>
      <option value="Juli" @selected(old('end_internship', $student->end_internship) == 'Juli')>Juli</option>
      <option value="Agustus" @selected(old('end_internship', $student->end_internship) == 'Agustus')>Agustus</option>
      <option value="September" @selected(old('end_internship', $student->end_internship) == 'September')>September</option>
      <option value="Oktober" @selected(old('end_internship', $student->end_internship) == 'Oktober')>Oktober</option>
      <option value="November" @selected(old('end_internship', $student->end_internship) == 'November')>November</option>
      <option value="Desember" @selected(old('end_internship', $student->end_internship) == 'Desember')>Desember</option>
    </select>
  </div>
  <div class="mb-3">
    <div class="form-label">Foto</div>
      <input type="file" name="avatar" class="form-control" accept=".png, .jpg, .jpeg" />
      <input type="hidden" name="old_avatar" value="{{ $student->avatar }}">
  </div>
  <div class="mb-3">
    <button class="btn btn-primary w-100 ms-auto">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
      Simpan
    </button>
  </div>
</form>