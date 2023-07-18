<?= $this->extend('layout/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-3">DATA DATANG KOTA MOJOKERTO</h4>
                        <form method="POST" action="<?= base_url('/datang/filter') ?>">
                          <div class="row mb-3">
                            <div class="col">
                              <label for="bulan">BULAN DATANG<code>*</code></label>
                              <select class="form-control" name="bulan" id="bulan" >
                                    <option value="all" <?php if ($bulan == 'all') echo "selected"; ?> > SEMUA </option>
                                  <?php foreach ($list_bulan as $data) { ?>
                                    <option value="<?= $data['month_number'] ?>" <?php if ($data['month_number'] == $bulan) echo "selected"; ?> > <?= strtoupper($data['month_name']) ?> </option>
                                  <?php } ?>
                              </select>
                            </div>
                            <div class="col">
                              <label for="tahun">TAHUN DATANG<code>*</code></label>
                              <select class="form-control" name="tahun" id="tahun">
                                  <option value="all" <?php if ($tahun == 'all') echo "selected"; ?> > SEMUA </option>
                                  <?php foreach ($list_tahun as $key => $data) { ?>
                                  <option value="<?= $data['year'] ?>" <?php if ($data['year'] == $tahun) echo "selected"; ?> > <?= $data['year'] ?> </option>
                                  <?php } ?>
                              </select>
                            </div>
                            <div class="col">
                              <label for="kecamatan">KECAMATAN<code>*</code></label>
                              <select class="form-control" name="kecamatan" id="kecamatan">
                                  <option value="all" <?php if ($kecamatan == 'all') echo "selected"; ?> > SEMUA </option>
                                  <?php foreach ($list_kecamatan as $key => $data) { ?>
                                  <option value="<?= $data['idc'] ?>" <?php if ($data['idc'] == $kecamatan) echo "selected"; ?> > <?= $data['idc'] ?> </option>
                                  <?php } ?>
                              </select>
                            </div>
                            <div class="col" id="divKelurahan" style="display: none;">
                              <label for="kelurahan">KELURAHAN<code>*</code></label>
                              <select class="form-control" name="kelurahan" id="kelurahan">
                                <option value="all" <?php if ($kelurahan == 'all') echo "selected"; ?> > SEMUA </option>
                                  <?php foreach ($list_kelurahan as $key => $data) { ?>
                                  <option class="<?= $data['kec'] ?>" value="<?= $data['idl'] ?>" <?php if ($data['idl'] == $kelurahan) echo "selected"; ?> > <?= $data['idl'] ?> </option>
                                  <?php } ?>
                              </select>
                            </div>
                            <div class="col">
                              <button type="submit" class="btn btn-success mt-4"><i class="bx bx-search"></i> TAMPIL</button>
                            </div>
                          </div>
                        </form>
                        <div class="viewdata"></div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<div class="viewmodal"></div>

<script>
  document.getElementById("kecamatan").onchange = function() {
    let selector = document.getElementById('kecamatan');
    let value = selector[selector.selectedIndex].value;
    let divkelurahanSelect = document.getElementById("divKelurahan");
    let kelurahanSelect = document.getElementById("kelurahan");
    kelurahanSelect.selectedIndex = 0; // Reset the selected value

    let nodeList = kelurahanSelect.querySelectorAll("option");

    if (value === "all") {
      divkelurahanSelect.style.display = "none";
    } else {
      divkelurahanSelect.style.display = "block";

      nodeList.forEach(function(option) {
        if (option.classList.contains(value)) {
          option.style.display = "block";
        } else {
          option.style.display = "none";
        }
      });
    }
  };
</script>

<?php if($modul == 'Filter') { ?>
  <script>
    function list(bulan, tahun, kecamatan, kelurahan) {
        $.ajax({
            url: "<?= base_url('/datang/list') ?>",
            type: "POST", // or GET, depending on what your server expects
            data: {
              bulan: bulan,
              tahun: tahun,
              kecamatan: kecamatan,
              kelurahan: kelurahan
            },
            dataType: "json",
            success: function(response) {
                $('.viewdata').html(response.data);
            }
        });
    }

    $(document).ready(function() {
        list('<?= $bulan ?>', '<?= $tahun ?>', '<?= $kecamatan ?>', '<?= $kelurahan ?>');
        // $('.select2').select2({
        //     minimumResultsForSearch: Infinity
        // });
    });
  </script>
<?php } ?>


<?= $this->endSection('isi') ?>