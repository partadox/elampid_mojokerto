<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('/user/update', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="uid" value="<?= $uid ?>" name="uid" readonly>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= $username ?>">
                    <div class="invalid-feedback errorUser">
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama ?>">
                    <div class="invalid-feedback errorNama">
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
                    username: $('input#username').val(),
                    nama: $('input#nama').val(),
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
                        if (response.error.username) {
                            $('#username').addClass('is-invalid');
                            $('.errorUser').html(response.error.username);
                        } else {
                            $('#username').removeClass('is-invalid');
                            $('.errorUser').html('');
                        }

                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errorNama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errorNama').html('');
                        }

                        if (response.error.role) {
                            $('#role').addClass('is-invalid');
                            $('.errorrole').html(response.error.role);
                        } else {
                            $('#role').removeClass('is-invalid');
                            $('.errorrole').html('');
                        }

                    } else {
                        if (response.sukses) {
                            Swal.fire({
                            title: "Berhasil!",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#modaledit').modal('hide');
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