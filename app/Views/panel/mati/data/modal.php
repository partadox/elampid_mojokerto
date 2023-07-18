<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php if($modal == 'edit') { ?>
                <?= form_open('/mati/update', ['class' => 'formedit']) ?>
                <?= csrf_field(); ?>
            <?php } ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="id" value="<?= $id ?>" name="id" readonly>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">TGL PENGAJUAN<code>*</code></label>
                    <div class="col-sm-8">
                        <div class="input-group" id="datepicker2">
                            <input type="text" id="tgl_aju" name="tgl_aju" class="form-control" value="<?= $mati['tgl_aju'] ?>"
                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                data-provide="datepicker" data-date-autoclose="true" <?php if($modal == 'info') { ?>disabled<?php } ?> >
                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            <div class="invalid-feedback error_tgl_aju"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-4 col-form-label">KECAMATAN<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="kecamatan" name="kecamatan" <?php if($modal == 'info') { ?>disabled<?php } ?> >
                            <?php foreach ($kecamatan as $key => $data) { ?>
                                <option value="<?= $data['idc'] ?>" <?php if ($data['idc'] == $mati['kecamatan']) echo "selected"; ?> ><?= $data['idc'] ?></option>
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
                                <option value="<?= $data['idl'] ?>" <?php if ($data['idl'] == $mati['kelurahan']) echo "selected"; ?> ><?= $data['idl'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback error_kelurahan"></div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">AKTA<code>*</code></label>
                    <div class="col-sm-8">
                        <input class="form-control text-uppercase" type="text" id="akta" name="akta" value="<?= $mati['akta'] ?>" <?php if($modal == 'info') { ?>readonly<?php } ?> >
                        <div class="invalid-feedback error_akta"></div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">NIK<code>*</code></label>
                    <div class="col-sm-8">
                        <input class="form-control text-uppercase" type="text" id="nik" name="nik" value="<?= $mati['nik'] ?>" <?php if($modal == 'info') { ?>readonly<?php } ?>>
                        <div class="invalid-feedback error_nik"></div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">NAMA<code>*</code></label>
                    <div class="col-sm-8">
                        <input class="form-control text-uppercase" type="text" id="nama" name="nama" value="<?= $mati['nama'] ?>" <?php if($modal == 'info') { ?>readonly<?php } ?>>
                        <div class="invalid-feedback error_nama"></div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">TGL MATI<code>*</code></label>
                    <div class="col-sm-8">
                        <div class="input-group" id="datepicker2">
                            <input type="text" id="tgl_mati" name="tgl_mati" class="form-control" value="<?= $mati['tgl_mati'] ?>"
                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                data-provide="datepicker" data-date-autoclose="true" <?php if($modal == 'info') { ?>disabled<?php } ?> >
                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            <div class="invalid-feedback error_tgl_mati"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="" class="col-sm-4 col-form-label">JENIS KELAMIN<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="kelamin" name="kelamin" <?php if($modal == 'info') { ?>disabled<?php } ?> >
                            <option value="LAKI-LAKI"  <?php if ($mati['kelamin'] == 'LAKI-LAKI') echo "selected"; ?> >LAKI-LAKI</option>
                            <option value="PEREMPUAN"  <?php if ($mati['kelamin'] == 'PEREMPUAN') echo "selected"; ?> >PEREMPUAN</option>
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

                        if (response.error.tgl_aju) {
                            $('#tgl_aju').addClass('is-invalid');
                            $('.error_tgl_aju').html(response.error.tgl_aju);
                        } else {
                            $('#tgl_aju').removeClass('is-invalid');
                            $('.error_tgl_aju').html('');
                        }

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

                        if (response.error.akta) {
                            $('#akta').addClass('is-invalid');
                            $('.error_akta').html(response.error.akta);
                        } else {
                            $('#akta').removeClass('is-invalid');
                            $('.error_akta').html('');
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

                        if (response.error.tgl_mati) {
                            $('#tgl_mati').addClass('is-invalid');
                            $('.error_tgl_mati').html(response.error.tgl_mati);
                        } else {
                            $('#tgl_mati').removeClass('is-invalid');
                            $('.error_tgl_mati').html('');
                        }

                        if (response.error.kelamin) {
                            $('#kelamin').addClass('is-invalid');
                            $('.error_kelamin').html(response.error.kelamin);
                        } else {
                            $('#kelamin').removeClass('is-invalid');
                            $('.error_kelamin').html('');
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