<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php if($modal == 'edit') { ?>
                <?= form_open('/datang/update', ['class' => 'formedit']) ?>
                <?= csrf_field(); ?>
            <?php } ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="id" value="<?= $id ?>" name="id" readonly>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">TGL KEDATANGAN<code>*</code></label>
                    <div class="col-sm-8">
                        <div class="input-group" id="datepicker2">
                            <input type="text" id="tgl_datang" name="tgl_datang" class="form-control" value="<?= $datang['tgl_datang'] ?>"
                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                data-provide="datepicker" data-date-autoclose="true" <?php if($modal == 'info') { ?>disabled<?php } ?> >
                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            <div class="invalid-feedback error_tgl_datang"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">NO KEDATANGAN<code>*</code></label>
                    <div class="col-sm-8">
                        <input class="form-control text-uppercase" type="text" id="no_datang" name="no_datang" value="<?= $datang['no_datang'] ?>" <?php if($modal == 'info') { ?>readonly<?php } ?>>
                        <div class="invalid-feedback error_no_datang"></div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-4 col-form-label">KECAMATAN<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="kecamatan" name="kecamatan" <?php if($modal == 'info') { ?>disabled<?php } ?> >
                            <?php foreach ($kecamatan as $key => $data) { ?>
                                <option value="<?= $data['idc'] ?>" <?php if ($data['idc'] == $datang['kecamatan']) echo "selected"; ?> ><?= $data['idc'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback error_kecamatan"></div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-4 col-form-label">KELURAHAN<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="kelurahan" name="kelurahan" <?php if($modal == 'info') { ?>disabled<?php } ?> >
                            <?php foreach ($kelurahan as $key => $data) { ?>
                                <option value="<?= $data['idl'] ?>" <?php if ($data['idl'] == $datang['kelurahan']) echo "selected"; ?> ><?= $data['idl'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback error_kelurahan"></div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">ALAMAT<code>*</code></label>
                    <div class="col-sm-8">
                        <input class="form-control text-uppercase" type="text" id="alamat" name="alamat" value="<?= $datang['alamat'] ?>" <?php if($modal == 'info') { ?>readonly<?php } ?>>
                        <div class="invalid-feedback error_alamat"></div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">KK<code>*</code></label>
                    <div class="col-sm-8">
                        <input class="form-control text-uppercase" type="text" id="kk" name="kk" value="<?= $datang['kk'] ?>" <?php if($modal == 'info') { ?>readonly<?php } ?> >
                        <div class="invalid-feedback error_kk"></div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">ASAL<code>*</code></label>
                    <div class="col-sm-8">
                        <input class="form-control text-uppercase" type="text" id="asal" name="asal" value="<?= $datang['asal'] ?>" <?php if($modal == 'info') { ?>readonly<?php } ?> >
                        <div class="invalid-feedback error_asal"></div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">NO<code>*</code></label>
                    <div class="col-sm-8">
                        <input class="form-control text-uppercase" type="number" min="0" id="no" name="no" value="<?= $datang['no'] ?>" <?php if($modal == 'info') { ?>readonly<?php } ?> >
                        <div class="invalid-feedback error_no"></div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">NIK<code>*</code></label>
                    <div class="col-sm-8">
                        <input class="form-control text-uppercase" type="text" id="nik" name="nik" value="<?= $datang['nik'] ?>" <?php if($modal == 'info') { ?>readonly<?php } ?>>
                        <div class="invalid-feedback error_nik"></div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">NAMA<code>*</code></label>
                    <div class="col-sm-8">
                        <input class="form-control text-uppercase" type="text" id="nama" name="nama" value="<?= $datang['nama'] ?>" <?php if($modal == 'info') { ?>readonly<?php } ?>>
                        <div class="invalid-feedback error_nama"></div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">SHBKEL<code>*</code></label>
                    <div class="col-sm-8">
                        <input class="form-control text-uppercase" type="text" id="shbkel" name="shbkel" value="<?= $datang['shbkel'] ?>" <?php if($modal == 'info') { ?>readonly<?php } ?>>
                        <div class="invalid-feedback error_shbkel"></div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">JENIS KELAMIN<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="kelamin" name="kelamin" <?php if($modal == 'info') { ?>disabled<?php } ?> >
                            <option value="LAKI-LAKI"  <?php if ($datang['kelamin'] == 'LAKI-LAKI') echo "selected"; ?> >LAKI-LAKI</option>
                            <option value="PEREMPUAN"  <?php if ($datang['kelamin'] == 'PEREMPUAN') echo "selected"; ?> >PEREMPUAN</option>
                        </select>
                        <div class="invalid-feedback error_kelamin"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <?php if($modal == 'edit') { ?>
                    <button type="submit" class="btn btn-success btnsimpan"><i class="bx bx-save"></i> Update</button>
                <?php } ?>
            </div>
            <?php if($modal == 'edit') { ?>
                <?= form_close() ?>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single-edit').select2({
            
        });
        $('.formedit').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
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

                        if (response.error.kecamatan) {
                            $('#kecamatan').addClass('is-invalid');
                            $('.error_kecamatan').html(response.error.kecamatan);
                        } else {
                            $('#kecamatan').removeClass('is-invalid');
                            $('.error_kecamatan').html('');
                        }

                        if (response.error.kelurahan) {
                            $('#kelurahan').addClass('is-invalid');
                            $('.error_kelurahan').html(response.error.kelurahan);
                        } else {
                            $('#kelurahan').removeClass('is-invalid');
                            $('.error_kelurahan').html('');
                        }

                        if (response.error.asal) {
                            $('#asal').addClass('is-invalid');
                            $('.error_asal').html(response.error.asal);
                        } else {
                            $('#asal').removeClass('is-invalid');
                            $('.error_asal').html('');
                        }

                        if (response.error.no) {
                            $('#no').addClass('is-invalid');
                            $('.error_no').html(response.error.no);
                        } else {
                            $('#no').removeClass('is-invalid');
                            $('.error_no').html('');
                        }

                        if (response.error.shbkel) {
                            $('#shbkel').addClass('is-invalid');
                            $('.error_shbkel').html(response.error.shbkel);
                        } else {
                            $('#shbkel').removeClass('is-invalid');
                            $('.error_shbkel').html('');
                        }

                        if (response.error.kk) {
                            $('#kk').addClass('is-invalid');
                            $('.error_kk').html(response.error.kk);
                        } else {
                            $('#kk').removeClass('is-invalid');
                            $('.error_kk').html('');
                        }

                        if (response.error.nik) {
                            $('#nik').addClass('is-invalid');
                            $('.error_nik').html(response.error.nik);
                        } else {
                            $('#nik').removeClass('is-invalid');
                            $('.error_nik').html('');
                        }

                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.error_nama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.error_nama').html('');
                        }

                        if (response.error.tgl_datang) {
                            $('#tgl_datang').addClass('is-invalid');
                            $('.error_tgl_datang').html(response.error.tgl_datang);
                        } else {
                            $('#tgl_datang').removeClass('is-invalid');
                            $('.error_tgl_datang').html('');
                        }

                        if (response.error.no_datang) {
                            $('#no_datang').addClass('is-invalid');
                            $('.error_no_datang').html(response.error.no_datang);
                        } else {
                            $('#no_datang').removeClass('is-invalid');
                            $('.error_no_datang').html('');
                        }

                        if (response.error.kelamin) {
                            $('#kelamin').addClass('is-invalid');
                            $('.error_kelamin').html(response.error.kelamin);
                        } else {
                            $('#kelamin').removeClass('is-invalid');
                            $('.error_kelamin').html('');
                        }

                        if (response.error.alamat) {
                            $('#alamat').addClass('is-invalid');
                            $('.error_alamat').html(response.error.alamat);
                        } else {
                            $('#alamat').removeClass('is-invalid');
                            $('.error_alamat').html('');
                        }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.message,
                            icon: response.icon,
                            allowOutsideClick: false,
                            showConfirmButton: 'OK',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(true);
                            }
                        });
                    }
                }
            });
        })
    });
</script>