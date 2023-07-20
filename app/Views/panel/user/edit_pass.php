<!-- Modal -->
<div class="modal fade" id="modaleditpass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('user/update_pass', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="uid" value="<?= $uid ?>" name="uid" readonly>
                <div class="form-group">
                    <label>Password <code>*</code></label> <br>
                    <code>Password Kombinsasi dari huruf kecil, huruf kapital, angka, simbol dan minimal 8 karakter</code>
                    <input type="password" class="form-control" id="password" name="password">
                    <div class="invalid-feedback errorPass">
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnupdate"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.formedit').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    uid: $('input#uid').val(),
                    password: $('input#password').val(),
                },
                dataType: "json",
                beforeSend: function() {
                    $('.btnupdate').attr('disable', 'disable');
                    $('.btnupdate').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnupdate').removeAttr('disable', 'disable');
                    $('.btnupdate').html('<i class="fa fa-share-square"></i>  Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        
                        if (response.error.password) {
                            $('#password').addClass('is-invalid');
                            $('.errorPass').html(response.error.password);
                        } else {
                            $('#password').removeClass('is-invalid');
                            $('.errorPass').html('');
                        }

                    } else {
                        
                        if (response.sukses) {
                            Swal.fire({
                            title: "Berhasil!",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#modaleditpass').modal('hide');
                        listuser();
                        }

                        if (response.eror) {
                            Swal.fire({
                                title: "Error",
                                text: response.eror.code,
                                icon: "error",
                                showConfirmButton: false,
                                timer: 1250
                            }).then(function() {
                                window.location = response.eror.link;
                            });
                        }
                    }
                }
            });
        })
    });
</script>