<?= $this->extend('layout/main') ?>
<?= $this->section('isi') ?>

    <style>
        @media (max-width: 767px) {
            /* Styles for mobile devices */
            #lahir-charts {
                width: 100%; /* Full width on mobile */
            }
            #mati-charts {
                width: 100%; /* Full width on mobile */
            }
            #pindah-charts {
                width: 100%; /* Full width on mobile */
            }
            #datang-charts {
                width: 100%; /* Full width on mobile */
            }
        }

        @media (min-width: 768px) {
            /* Styles for desktop devices and above */
            #lahir-charts {
                width: 1100px; /* Set a fixed width for desktop */
            }
            #mati-charts {
                width: 1100px; /* Set a fixed width for desktop */
            }
            #pindah-charts {
                width: 1100px; /* Set a fixed width for desktop */
            }
            #datang-charts {
                width: 1100px; /* Set a fixed width for desktop */
            }
        }
    </style>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card overflow-hidden">
                        <div class="bg-warning bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-success p-3">
                                        <h5 class="text-success">Selamat Datang di Dashboard Sistem e-Lampid <?= ucwords($banner) ?></h5>
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

            <div class="mb-3">
                <form method="POST" action="<?= base_url('/dashboard/filter') ?>">
                    <div class="row">
                        <div class="col-4">
                            <label for="tahun">Data Tahun<code>*</code></label>
                            <select class="form-control" name="tahun" id="tahun" required>
                                <?php foreach ($list_tahun as $key => $data) { ?>
                                <option value="<?= $data['year'] ?>" <?php if ($data['year'] == $tahun) echo "selected"; ?> > <?= $data['year'] ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-success mt-4"><i class="bx bx-search"></i> TAMPIL</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row">

                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-center fw-medium">Data Kelahiran <button type="button" class="btn btn-link waves-effect" data-bs-toggle="tooltip" data-bs-placement="top" title="Berdasarkan Tahun Lahir">
                                        <i class="bx bxs-info-circle"></i>
                                    </button></p>
                                    
                                    <h4 class="mb-0 text-center"><?= $Ylahir ?> / <?= $Tlahir ?></h4>
                                    <p class="text-muted text-center fw-medium">Tahun <?= $tahun ?> / Total</p>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
                                        <span class="avatar-title">
                                            <i class="bx bx-copy-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-center fw-medium">Data Kematian <button type="button" class="btn btn-link waves-effect" data-bs-toggle="tooltip" data-bs-placement="top" title="Berdasarkan Tahun Mati">
                                        <i class="bx bxs-info-circle"></i>
                                    </button></p>
                                    <h4 class="mb-0 text-center"><?= $Ymati ?> / <?= $Tmati ?></h4>
                                    <p class="text-muted text-center fw-medium">Tahun <?= $tahun ?> / Total</p>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
                                        <span class="avatar-title">
                                            <i class="bx bx-copy-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-center fw-medium">Data Pindah <button type="button" class="btn btn-link waves-effect" data-bs-toggle="tooltip" data-bs-placement="top" title="Berdasarkan Tahun Pindah">
                                        <i class="bx bxs-info-circle"></i>
                                    </button></p>
                                    <h4 class="mb-0 text-center"><?= $Ypindah ?> / <?= $Tpindah ?></h4>
                                    <p class="text-muted text-center fw-medium">Tahun <?= $tahun ?> / Total</p>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
                                        <span class="avatar-title">
                                            <i class="bx bx-copy-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-center fw-medium">Data Datang <button type="button" class="btn btn-link waves-effect" data-bs-toggle="tooltip" data-bs-placement="top" title="Berdasarkan Tahun Datang">
                                        <i class="bx bxs-info-circle"></i>
                                    </button></p>
                                    <h4 class="mb-0 text-center"><?= $Ydatang ?> / <?= $Tdatang ?></h4>
                                    <p class="text-muted text-center fw-medium">Tahun <?= $tahun ?> / Total</p>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
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

            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Grafik Data</h4>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#kelahiran1" role="tab" aria-selected="true">
                                    <span class="d-block d-sm-none">Lhr</span>
                                    <span class="d-none d-sm-block">Kelahiran</span> 
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#kematian1" role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none">Mt</i></span>
                                    <span class="d-none d-sm-block">Kematian</span> 
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#pindah1" role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none">Pd</span>
                                    <span class="d-none d-sm-block">Pindah</span>   
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#datang1" role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none">Dt</span>
                                    <span class="d-none d-sm-block">Datang</span>    
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active show" id="kelahiran1" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Data Kelahiran Tahun <?= $tahun ?></h4>
                                        <div id="lahir-charts"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="kematian1" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Data Kematian Tahun <?= $tahun ?></h4>
                                        <div id="mati-charts"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="pindah1" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Data Pindah Tahun <?= $tahun ?></h4>
                                        <div id="pindah-charts"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="datang1" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Data Datang Tahun <?= $tahun ?></h4>
                                        <div id="datang-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <!-- tui charts plugins -->
    <script src="<?= base_url() ?>/public/assets/libs/tui-chart/tui-chart-all.min.js"></script>


    <script>
        // Function to create a TUI Chart
        function createTuiChart(containerId, chartData, chartOptions) {
            var chartContainer = document.getElementById(containerId);
            var chartWidth = chartContainer.offsetWidth;

            chartOptions.chart.width = chartWidth;

            // Create the TUI Chart instance
            var chart = tui.chart.columnChart(chartContainer, chartData, chartOptions);

            // Handle chart resize on window resize
            $(window).resize(function () {
                var newChartWidth = $("#" + containerId).width();
                chart.resize({
                    width: newChartWidth,
                    height: 380
                });
            });

            return chart;
        }

        // Lahir Chart data and options
        var lahirJsonData = <?php echo $lahirChart; ?>;
        var lahirChartData = {
            categories: [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
            ],
            series: lahirJsonData
        };
        var lahirChartOptions = {
            series: {
                stack: {
                    type: 'normal'
                }
            },
            chart: {},
            legend: {
                align: 'top'
            },
            exportMenu: {
                visible: false
            }
        };

        // Mati Chart data and options
        var matiJsonData = <?php echo $matiChart; ?>;
        var matiChartData = {
            categories: [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
            ],
            series: matiJsonData
        };
        var matiChartOptions = {
            series: {
                stack: {
                    type: 'normal'
                }
            },
            chart: {},
            legend: {
                align: 'top'
            },
            exportMenu: {
                visible: false
            }
        };

        // Datang Chart data and options
        var datangJsonData = <?php echo $datangChart; ?>;
        var datangChartData = {
            categories: [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
            ],
            series: datangJsonData
        };
        var datangChartOptions = {
            series: {
                stack: {
                    type: 'normal'
                }
            },
            chart: {},
            legend: {
                align: 'top'
            },
            exportMenu: {
                visible: false
            }
        };

        // Pindah Chart data and options
        var pindahJsonData = <?php echo $pindahChart; ?>;
        var pindahChartData = {
            categories: [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
            ],
            series: pindahJsonData
        };
        var pindahChartOptions = {
            series: {
                stack: {
                    type: 'normal'
                }
            },
            chart: {},
            legend: {
                align: 'top'
            },
            exportMenu: {
                visible: false
            }
        };

        // Create Lahir Chart
        var lahirChart = createTuiChart('lahir-charts', lahirChartData, lahirChartOptions);

        // Create Mati Chart
        var matiChart = createTuiChart('mati-charts', matiChartData, matiChartOptions);
        matiChart.on('load', function () {
            // Set the chart width to 1100 when it's loaded
            matiChart.resize({
                width: 1100,
                height: 380
            });
        });

        // Create Datang Chart
        var datangChart = createTuiChart('datang-charts', datangChartData, datangChartOptions);
        datangChart.on('load', function () {
            // Set the chart width to 1100 when it's loaded
            datangChart.resize({
                width: 1100,
                height: 380
            });
        });

        // Create Pindah Chart
        var pindahChart = createTuiChart('pindah-charts', pindahChartData, pindahChartOptions);
        pindahChart.on('load', function () {
            // Set the chart width to 1100 when it's loaded
            pindahChart.resize({
                width: 1100,
                height: 380
            });
        });
    </script>
<?= $this->endSection('isi') ?>