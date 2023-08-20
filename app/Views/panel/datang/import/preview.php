<?= $this->extend('layout/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <form id="save_form" action="<?= base_url('/datang-import/save') ?>" method="post">
                        <h4 class="card-title mb-3">IMPORT PREVIEW DATA DATANG KOTA MOJOKERTO</h4>
                        <div class="row mb-3">
                          <div class="col-sm-6">
                            <div class="card border border-warning mt-3">
                              <div class="card-header bg-transparent border-warning">
                                  <h5 class="my-0 text-warning"><i class="mdi mdi-information me-3"></i>CATATAN</h5>
                              </div>
                              <div class="card-body">
                                  <ul>
                                    <li>Ini merupakan halaman preview data dari hasil import file excel anda. Pastikan bahwa data sesuai dengan format yang telah ditentukan!</li>
                                    <li>Anda dapat mengedit data dengan cara klik di kolom yang datanya ingin anda edit.</li>
                                    <li>Anda dapat menghapus data dengan cara klik tombol berwarna merah dengan icon <i class="bx bx-trash" style="color: red;"></i> </li>
                                    <li><strong>Tombol Merah <i style="color: red;">"Batal"</i></strong> berfungsi untuk membatalkan import data dan kembali ke halaman pilih file excel.</li>
                                    <li><strong>Tombol Hijau <i style="color: green;">"Simpan"</i></strong> berfungsi untuk menyimpan data hasil preview ini ke database e-lampid.</li>
                                  </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="table-responsive">
                            <table id="preview_table" class="table table-striped table-bordered dt-responsive wrap w-100">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>TGL DATANG</th>
                                        <th>NO DATANG</th>
                                        <th>KECAMATAN</th>
                                        <th>KELURAHAN</th>
                                        <th>ALAMAT</th>
                                        <th>KK</th>
                                        <th>ASAL</th>
                                        <th>NO</th>
                                        <th>NIK</th>
                                        <th>NAMA</th>
                                        <th>SHBKEL</th>
                                        <th>JENIS KELAMIN</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($preview_data as $index => $row): ?>
                                    <tr data-row-id="<?= $index ?>">
                                        <td><?= $row[0] ?></td>
                                        <td contenteditable="true"><?= $row[1] ?></td>
                                        <td contenteditable="true"><?= $row[2] ?></td>
                                        <td contenteditable="true"><?= $row[3] ?></td>
                                        <td contenteditable="true"><?= $row[4] ?></td>
                                        <td contenteditable="true"><?= $row[5] ?></td>
                                        <td contenteditable="true"><?= $row[6] ?></td>
                                        <td contenteditable="true"><?= $row[7] ?></td>
                                        <td contenteditable="true"><?= $row[8] ?></td>
                                        <td contenteditable="true"><?= $row[9] ?></td>
                                        <td contenteditable="true"><?= $row[10] ?></td>
                                        <td contenteditable="true"><?= $row[11] ?></td>
                                        <td contenteditable="true"><?= $row[12] ?></td>
                                        <td>
                                            <button class="btn btn-outline-danger delete-btn mb-2"><i class="bx bx-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex flex-row-reverse">
                            <div class="p-2">
                                
                                    <input type="hidden" name="data" id="data_input">
                                    <button class="btn btn-success" type="submit"><i class="bx bx-save"></i> Save</button>
                                
                            </div>
                            <div class="p-2">
                                <a class="btn btn-danger" href="<?= base_url('/datang-import') ?>"> <i class="bx bx-x"></i> Batal</a>
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
<script>
$(document).ready(function() {
    $('#preview_table').DataTable({
        aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
        ],
        iDisplayLength: -1,
        paging: false
    });

    // Handle delete button click event
    $(document).on('click', '.delete-btn', function() {
        // Get the row and perform the necessary actions
        var row = $(this).closest('tr');
        var rowData = row.find('td');

        // Example: Remove the row from the table
        row.remove();
    });

    $('#save_form').on('submit', function(e) {
        e.preventDefault();

        // Get the table data
        var tableData = [];
        $('#preview_table tbody tr').each(function() {
            var rowData = {};
            $(this).find('td').each(function(index, element) {
                var columnName = 'column_' + index;
                rowData[columnName] = $(this).text().trim();
            });
            tableData.push(rowData);
        });

        // Prepare the form data
        var formData = new FormData();
        formData.append('data', JSON.stringify(tableData));

        // Submit the form via AJAX
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success == true) {
                    // Show SweetAlert 2 with the success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: response.message,
                        allowOutsideClick: false,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = response.redirect;
                        }
                    });
                } 
                if(response.success == false) {
                    // Show SweetAlert 2 with the error message
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: response.message,
                        allowOutsideClick: false,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = response.redirect;
                        }
                    });
                }
            },
            error: function(response) {
                // Show SweetAlert 2 with the error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi Error Dalam Proses Simpan Data.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/datang-import';
                        }
                });
            }
        });
    });
});
</script>

<?= $this->endSection('isi') ?>