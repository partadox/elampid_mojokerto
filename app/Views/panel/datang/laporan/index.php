<?= $this->extend('layout/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-3">LAPORAN DATA DATANG KOTA MOJOKERTO</h4>
                        <form method="POST" action="<?= base_url('/datang-laporan/export') ?>">
                          <div class="row mb-3">
                            <div class="col">
                              <label for="tahun">TAHUN<code>*</code></label>
                              <select class="form-control" name="tahun" id="tahun" required>
                                  <option value="" selected> PILIH TAHUN... </option>
                                  <?php foreach ($list_tahun as $key => $data) { ?>
                                    <option value="<?= $data['year'] ?>"> <?= $data['year'] ?> </option>
                                  <?php } ?>
                              </select>
                            </div>
                            <div class="col">
                              <label for="tahun">JENIS FILE LAPORAN<code>*</code></label>
                              <select class="form-control" name="extension" id="extension" required>
                                  <option value="" selected> PILIH JENIS FILE... </option>
                                  <option value="xlsx"> EXCEL</option>
                                  <option value="pdf"> PDF </option>
                              </select>
                            </div>
                            <div class="col">
                              <button type="submit" class="btn btn-success mt-4"><i class="bx bx-download"></i> DOWNLOAD</button>
                            </div>
                          </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<?= $this->endSection('isi') ?>