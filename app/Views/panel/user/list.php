<table id="listuser" class="table table-striped table-bordered dt-responsive " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Role</th>
            <th>Tindakan</th>
        </tr>
    </thead>


    <tbody>
        <?php $nomor = 0;
        foreach ($list as $data) :
            $nomor++; ?>
            <tr>
                <td><?= $nomor ?></td>
                <td><?= esc($data['nama']) ?></td>
                <td><?= esc($data['username']) ?></td>
                <td>
                    <?php if ($data['role'] == '707SP') { ?>
                        <h6>
                            <span class="badge bg-success">DINAS</span>
                        </h6>
                    <?php } elseif ($data['role'] == '202AC') { ?>
                        <h6>
                            <span class="badge bg-primary">USER KECAMATAN</span>
                        </h6> <strong><?= $data['idcl'] ?></strong>
                    <?php } ?>
                </td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm" onclick="edit('<?= $data['uid'] ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" onclick="pass_change('<?= $data['uid'] ?>')">
                        <i class="fa fa-lock"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $data['uid'] ?>')">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#listuser').DataTable();
    });

    function edit(uid) {
        $.ajax({
            type: "post",
            url: "<?= base_url('/user/formedit') ?>",
            data: {
                uid: uid
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaledit').modal('show');
                }
            }
        });
    }

    function pass_change(uid) {
        $.ajax({
            type: "post",
            url: "<?= base_url('/user/formedit_pass') ?>",
            data: {
                uid: uid
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodalpass').html(response.sukses).show();
                    $('#modaleditpass').modal('show');
                }
            }
        });
    }

    function hapus(uid) {
        Swal.fire({
            title: 'Hapus user?',
            text: `Apakah anda yakin menghapus user?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('/user/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        uid: uid
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: "Data Berhasil Dihapus!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
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
                });
            }
        })
    }

</script>