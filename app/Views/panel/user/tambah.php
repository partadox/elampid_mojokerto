<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('/user/simpan', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label>Username <code>*</code> </label>
                    <input type="text" class="form-control" id="username" name="username" required>
                    <div class="invalid-feedback errorUser">
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama <code>*</code> </label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                    <div class="invalid-feedback errorNama">
                    </div>
                </div>

                <div class="form-group">
                    <label>Password <code>*</code></label> <br>
                    <code>Password Kombinsasi dari huruf kecil, huruf kapital, angka, simbol dan minimal 8 karakter</code>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback errorPass">
                    </div>
                </div>

                <div class="form-group">
                    <label>Role <code>*</code></label>
                    <select class="form-control" name="role" id="role" required>
                        <option value="" selected disabled> PILIH... </option>
                        <option value="707SP" > USER DINAS </option>
                        <option value="202AC" > USER KECAMATAN </option>
                    </select>
                    <div class="invalid-feedback errorrole">
                    </div>
                </div>


                <div class="form-group" id="divKecamatan" style="display: none;">
                    <label>Kecamatan <code>*</code></label>
                    <select class="form-control" name="kecamatan" id="kecamatan">
                        <option value="" selected disabled> PILIH... </option>
                        <?php foreach ($kecamatan as $key => $data) { ?>
                        <option value="<?= $data['idc'] ?>" > <?= $data['idc'] ?> </option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback errorkecamatan">
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    document.getElementById("role").onchange = function() {
        let selector = document.getElementById('role');
        let value = selector[selector.selectedIndex].value;
        let divkecamatanSelect = document.getElementById("divKecamatan");
        let kecamatanSelect = document.getElementById("kecamatan");
        if (value === "202AC") {
            divkecamatanSelect.style.display = "block";
            kecamatanSelect.setAttribute("required", "required");
        } else {
            divkecamatanSelect.style.display = "none";
            kecamatanSelect.removeAttribute("required");
        }
    };
    $(document).ready(function() {
        $('.formtambah').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    username: $('input#username').val(),
                    nama: $('input#nama').val(),
                    password: $('input#password').val(),
                    role: $('select#role').val(),
                    kecamatan: $('select#kecamatan').val(),
                },
                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpan').attr('disable', 'disable');
                    $('.btnsimpan').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable', 'disable');
                    $('.btnsimpan').html('<i class="fa fa-share-square"></i>  Simpan');
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

                        if (response.error.password) {
                            $('#password').addClass('is-invalid');
                            $('.errorPass').html(response.error.password);
                        } else {
                            $('#password').removeClass('is-invalid');
                            $('.errorPass').html('');
                        }

                        if (response.error.role) {
                            $('#role').addClass('is-invalid');
                            $('.errorrole').html(response.error.role);
                        } else {
                            $('#role').removeClass('is-invalid');
                            $('.errorrole').html('');
                        }

                        if (response.error.kecamatan) {
                            $('#kecamatan').addClass('is-invalid');
                            $('.errorkecamatan').html(response.error.kecamatan);
                        } else {
                            $('#kecamatan').removeClass('is-invalid');
                            $('.errorkecamatan').html('');
                        }

                    } else {

                        if (response.sukses) {
                            Swal.fire({
                            title: "Berhasil!",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#modaltambah').modal('hide');
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