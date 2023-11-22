<h4 class="text-center">DATA PINDAH</h4>
<h5 class="text-center"><?= $teks_kecamatan ?> <?= $teks_kelurahan ?></h5>
<h5 class="text-center"><?= $teks_bulan ?> <?= $teks_tahun ?></h5>
<?= form_open('pindah/deleteSelect', ['class' => 'formhapus']) ?>
    <div class="table-responsive mb-3">
        <?php if (session('role') == '707SP') { ?> 
            <div>
                <button type="submit" class="btn btn-sm btn-danger mb-3"><i class="fa fa-trash"></i> Hapus yang Dipilih </button>
            </div>
        <?php } ?>
        <table id="list" class="table table-striped table-bordered dt-responsive wrap w-100 ">
            <thead>
                <tr class="table-secondary">
                    <th width=2%><input type="checkbox" id="pilihSemua">NO</th>
                    <th width=15%>NIK</th>
                    <th width=15%>NAMA</th>
                    <th width=15%>ALAMAT</th>
                    <th width=15%>TGL PINDAH</th>
                    <th width=9%>KEC.</th>
                    <th width=9%>KEL.</th>
                    <th width=8%></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
<?= form_close() ?>

<script>
    function fetch(bulan, tahun, kecamatan, kelurahan) {
        var table = $('#list').DataTable({
            "processing": true,
            "serverside": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('/pindah/fetch') ?>",
                "type": "POST",
                "data": {
                    bulan: bulan,
                    tahun: tahun,
                    kecamatan: kecamatan,
                    kelurahan: kelurahan
                },
                'dataSrc': function (json) {
                    if (json.userLevel == 1) {
                        $('#btn-dels').show();
                    } else {
                        $('#btn-dels').hide();
                    }
                    return json.data;
                }
            },
            "columnDefs": [{
                    "targets": 0,
                    "orderable": false,
                },
                {
                    "targets": -1,
                    "orderable": false,
                },
            ],
            buttons: [{
                    extend: 'excelHtml5',
                    title: 'Data Export',
                    text: 'Export Excel',
                    className: 'btn-export-excel'
                }],
            columnDefs: [{
                targets: -1,
                visible: false
            }],
            dom: "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
               "<'row'<'col-sm-12'tr>>" +
               "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            lengthMenu: [
                [25, 50, 75, 100, -1],
                [25, 50, 75, 100, "All"]
            ],
            columnDefs: [{
                targets: -1,
                orderable: false,
                searchable: false
            }],
        });
        table.buttons().container().appendTo($('.col-sm-12.col-md-4').eq(0));

    }

    $(document).ready(function () {
        $('.select2').select2({});
        fetch('<?= $bulan ?>', '<?= $tahun ?>', '<?= $kecamatan ?>', '<?= $kelurahan ?>');

        $('#pilihSemua').click(function(e) {
            if ($(this).is(':checked')) {
                $('.pilihPindah').prop('checked', true);
            } else {
                $('.pilihPindah').prop('checked', false);
            }
        });

        $('.formhapus').submit(function(e) {
            e.preventDefault();
            let jmldata = $('.pilihPindah:checked');
            if (jmldata.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops!',
                    text: 'Silahkan pilih data!',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else {
                Swal.fire({
                    title: 'Hapus data',
                    text: `Apakah anda yakin ingin menghapus sebanyak ${jmldata.length} data?`,
                    icon: 'warning',
                    showCancelButton: true,
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.success,
                                        showConfirmButton: true,
                                        allowOutsideClick: false
                                    }).then(function () {
                                        window.location.reload();
                                    });
                                } else if (response.error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: response.error,
                                        showConfirmButton: true,
                                        allowOutsideClick: false
                                    });
                                }
                            }
                        });
                    }
                })
            }
        });
    });

    function info(id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/pindah/modal') ?>",
            data: {
                id : id,
                modal: 'info'
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modal').modal('show');
                }
            }
        });
    }

    <?php if(session('role') == '707SP' || session('role') == '101DL') { ?>

    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/pindah/modal') ?>",
            data: {
                id : id,
                modal: 'edit'
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modal').modal('show');
                }
            }
        });
    }

    function hapus(id, nama) {
        Swal.fire({
            title: `Hapus Data ${nama}`,
            text: 'Yakin mengahpus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('/pindah/delete') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        id : id
                    },
                    success: function(response) {
                        if (response.success == true) {
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
            }
        })
    }

    <?php } ?>
</script>