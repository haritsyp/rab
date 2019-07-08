<div class="form-group row">
  <label for="colFormLabel" class="col-sm-2 col-form-label">Nama Proyek</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" placeholder="Ex: La Diva Grenhill" name="nama_proyek" value="{{ $proyek->nama_proyek ?? '' }}">
  </div>
</div>
<div class="form-group row">
  <label for="colFormLabel" class="col-sm-2 col-form-label">Biaya Proyek</label>
  <div class="col-sm-10">
    <input type="number" class="form-control" placeholder="Ex: 500000000" name="biaya_proyek" value="{{ $proyek->biaya_proyek ?? '' }}">
  </div>
</div>
<div class="form-group row">
  <label for="colFormLabel" class="col-sm-2 col-form-label">Lama</label>
  <div class="col-sm-10">
    <input type="text" class="form-control"  placeholder="Ex: 50 Hari" name="lama" value="{{ $proyek->lama ?? '' }}">
  </div>
</div>
<div class="form-group row">
  <label for="colFormLabel" class="col-sm-2 col-form-label"></label>
  <div class="col-sm-10">
    <input type="submit" class="btn btn-primary" value="Simpan">
  </div>
</div>