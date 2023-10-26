<?= $this->extend('layout/main') ?>
<?= $this->section('isi') ?>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card overflow-hidden">
                        <div class="bg-warning bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-success text-cemter p-3">
                                        <h1 class="text-success">Selamat Datang di Sistem e-Lampid <?= ucwords($banner) ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-xl-8">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">-</p>
                                            <h4 class="mb-0">-</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-warning align-self-center">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4 card-title">
                                Data Kelahiran
                            </div>
                            <div class="text-center">
                                <div class="mb-4"><i class="bx bx-file text-warning display-4"></i></div>
                                <h3><?= $Ylahir ?> / <?= $Tlahir ?></h3>
                                <h5>Tahun <?= date('Y') ?> / Total</h5>
                                <p><i>(by tanggal input)</i></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4 card-title">
                                Data Kematian
                            </div>
                            <div class="text-center">
                                <div class="mb-4"><i class="bx bx-file text-warning display-4"></i></div>
                                <h3><?= $Ymati ?> / <?= $Tmati ?></h3>
                                <h5>Tahun <?= date('Y') ?> / Total</h5>
                                <p><i>(by tanggal input)</i></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4 card-title">
                                Data Pindah
                            </div>
                            <div class="text-center">
                                <div class="mb-4"><i class="bx bx-file text-warning display-4"></i></div>
                                <h3><?= $Ypindah ?> / <?= $Tpindah ?></h3>
                                <h5>Tahun <?= date('Y') ?> / Total</h5>
                                <p><i>(by tanggal input)</i></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4 card-title">
                                Data Datang
                            </div>
                            <div class="text-center">
                                <div class="mb-4"><i class="bx bx-file text-warning display-4"></i></div>
                                <h3><?= $Ydatang ?> / <?= $Tdatang ?></h3>
                                <h5>Tahun <?= date('Y') ?> / Total</h5>
                                <p><i>(by tanggal input)</i></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
<?= $this->endSection('isi') ?>