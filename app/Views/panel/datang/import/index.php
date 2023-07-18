<?= $this->extend('layout/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">IMPORT DATA DATANG KOTA MOJOKERTO</h4>
                        <form action="<?= base_url('datang-import/import') ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                              <div class="col-sm-6 mb-2">
                                <input class="form-control" type="file" name="excel_file" accept=".xls,.xlsx" required>
                              </div>
                              <div class="col-sm-4 mb-2">
                                <button class="btn btn-success" type="submit"> <i class="bx bx-import"></i> Import</button>
                              </div>
                            </div>
                        </form>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="card border border-danger mt-3">
                              <div class="card-header bg-transparent border-danger">
                                  <h5 class="my-0 text-danger"><i class="mdi mdi-alert-outline me-3"></i>CATATAN (HARAP DIBACA!)</h5>
                              </div>
                              <div class="card-body">
                                  <ul>
                                    <li>Untuk melakukan import data harap gunakan template excel yang disediakan, <u><strong><a href="public/assets/template/Datang-Template-Import.xlsx" style="color: green;"><i class="fa fa-file-excel"></i> Download Template</a></strong></u></li>
                                    <li>Format penulisan seperti yang terdapat pada contoh excel.</li>
                                    <li>Penulisan menggunakan huruf kapital seluruhnya.</li>
                                    <li>Penulisan format tanggal menggunakan format YYYY-MM-DD (Cth: 2000-01-31).</li>
                                    <li>Tidak bisa menggunakan formula, jika kolom berisi formula maka yang akan terbaca adalah formulanya.</li>
                                    <li>Tipe kolom diharapkan menggunakan tipe "Text".</li>
                                    <li>Jenis kelamin: LAKI-LAKI atau PEREMPUAN.</li>
                                    <li>Setelah memilih file yang akan diimport kemudian klik tombol import, setelah itu anda akan menuju halaman data preview untuk mengecek data yang akan anda import.</li>
                                  </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->


<?= $this->endSection('isi') ?>