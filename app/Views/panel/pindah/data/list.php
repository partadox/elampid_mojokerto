<h4 class="text-center">DATA PINDAH</h4>
<h5 class="text-center"><?= $teks_kecamatan ?> <?= $teks_kelurahan ?></h5>
<h5 class="text-center"><?= $teks_bulan ?> <?= $teks_tahun ?></h5>
<div class="table-responsive mb-3">
  <table id="list" class="table table-striped table-bordered dt-responsive wrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width=2%>NO</th>
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
            buttons: [],
            columnDefs: [{
                targets: -1,
                visible: false
            }],
            dom: "<'row px-2 px-md-4 pt-2'<'col-md-3'l><'col-md-5 text-center py-2'B><'col-md-4'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row px-2 px-md-4 py-3'<'col-md-5'i><'col-md-7'p>>",
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
        table.buttons().container().appendTo('#dataTable_wrapper .col-md-5:eq(0)');

    }

    $(document).ready(function () {
        $('.select2').select2({});
        fetch('<?= $bulan ?>', '<?= $tahun ?>', '<?= $kecamatan ?>', '<?= $kelurahan ?>');
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