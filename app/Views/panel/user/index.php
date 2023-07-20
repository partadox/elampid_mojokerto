<?= $this->extend('layout/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title mb-3">MANAJEMEN USER E-LAMPID</div>
                        <button type="button" class="btn btn-primary tambahuser mb-3"><i class=" fa fa-plus-circle"></i> Tambah User</button>
                        <div class="viewdata"></div>
                        <div class="viewmodal"> </div>
                        <div class="viewmodalpass"></div>
                    </div>
                </div>
            </div>
        </div>
        
    </div> <!-- container-fluid -->
</div>

<script>
    function listuser() {
        $.ajax({
            url: "<?= base_url('/user/getdata') ?>",
            dataType: "json",
            success: function(response) {
                $('.viewdata').html(response.data);
            }
        });
    }

    $(document).ready(function() {
        listuser();
        $('.tambahuser').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('/user/formtambah') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaltambah').modal('show');
                }
            });
        });
    });
</script>
<?= $this->endSection('isi') ?>