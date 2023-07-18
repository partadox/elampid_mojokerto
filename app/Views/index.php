<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>e-Lampid - <?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="e-Lampid Dispendukcapil Kota Mojokerto" name="e-Lampid Dispendukcapil Kota Mojokerto" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>/public/assets/images/favicon.png">

    <!-- owl.carousel css -->
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/libs/owl.carousel/assets/owl.carousel.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/libs/owl.carousel/assets/owl.theme.default.min.css">

    <!-- Bootstrap Css -->
    <link href="<?= base_url() ?>/public/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url() ?>/public/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url() ?>/public/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <!-- tui charts Css -->
    <link href="<?= base_url() ?>/public/assets/libs/tui-chart/tui-chart.min.css" rel="stylesheet" type="text/css" />


    <style>
        .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        padding-top: 25px;
        height: 0;
        overflow: hidden;
        }

        .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        }
    </style>

</head>

<body data-bs-spy="scroll" data-bs-target="#topnav-menu" data-bs-offset="60">

        <nav class="navbar navbar-expand-lg navigation fixed-top sticky">
            <div class="container">
                <a class="navbar-logo" href="index.html">
                    <img src="<?= base_url() ?>/public/assets/images/Logo-Dukcapil-Mojokerto.png" alt="" height="65" class="logo logo-dark">
                    <img src="<?= base_url() ?>/public/assets/images/Logo-Dukcapil-Mojokerto.png" alt="" height="65" class="logo logo-light">
                </a>

                <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
              
                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav ms-auto" id="topnav-menu" >
                        <!-- <li class="nav-item">
                            <a class="nav-link active" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#demo">Demo</a>
                        </li> -->

                    </ul>

                    <div class="my-2 ms-lg-2">
                        <a href="<?= base_url() ?>/login" class="btn btn-warning w-xs">Login</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- hero section start -->
        <section class="section hero-section bg-ico-hero" id="home">
            <div class="bg-overlay bg-primary"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="text-white-50">
                            <h1 class="text-white fw-semibold mb-3 hero-title">e-LAMPID DISPENDUKCAPIL KOTA MOJOKERTO <br> <br> "Kami Ada Untuk Anda"</h1>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <img style="object-fit:scale-down;
                        width:250px;
                        height:250px;" src="<?= base_url() ?>/public/assets/images/pejabat/walikota.png" alt="" class="img-fluid"> <br>
                        <a style="color:white; font-size:25px;">Hj. Ika Puspitasari S.E</a>
                    </div>
                    <br>
                    <!-- <div class="col-lg-3">
                        <img style="object-fit:scale-down;
                        width:250px;
                        height:250px;" src="<?= base_url() ?>/public/assets/images/pejabat/wakilwalikota.png" alt="" class="img-fluid"> <br>
                        <a style="color:white; font-size:25px;">Hj. Ika Puspitasari S.E</a>
                    </div> -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- hero section end -->

        <!-- about section start -->
        <section class="section pt-4 bg-white" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <h2 style="color: orange;">e-Lampid</h2>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    
                        <div class="text-muted text-center">
                            <h5>e-LAMPID adalah sebuah aplikasi pelaporan berbasis web, untuk proses LAMPID (Lahir Mati Pindah Datang) pada tingkat kelurahan, kecamatan dan kota. Demi tertib administrasi kependudukan, surat pengantar kelahiran, kematian dan pindah datang pada kelurahan harus menggunakan e-LAMPID.</h5>
                        </div>
                    
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- about section end -->

        <!-- Features start -->
        <section class="section" id="features">
            <div class="container">
                <!-- <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <h4>e-Lampid</h4>
                        </div>
                    </div>
                </div> -->
                <!-- end row -->

                <div class="row align-items-center pt-4">
                    <div class="col-md-6 col-sm-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Data Kelahiran</h4>
                                <p class="card-title-desc">Periode: <?= shortdate_indo($first_month) ?> s.d <?= shortdate_indo($now) ?></p>
                                <div id="lahir-charts" dir="ltr"></div>
                                <h5><strong>Total = <?= $total_lahir ?></strong></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Data Kematian</h4>
                                <p class="card-title-desc">Periode: <?= shortdate_indo($first_month) ?> s.d <?= shortdate_indo($now) ?></p>
                                <div id="mati-charts" dir="ltr"></div>
                                <h5><strong>Total = <?= $total_mati ?></strong></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center pt-4">
                    <div class="col-md-6 col-sm-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Data Pindah</h4>
                                <p class="card-title-desc">Periode: <?= shortdate_indo($first_month) ?> s.d <?= shortdate_indo($now) ?></p>
                                <div id="pindah-charts" dir="ltr"></div>
                                <h5><strong>Total = <?= $total_pindah ?></strong></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Data Datang</h4>
                                <p class="card-title-desc">Periode: <?= shortdate_indo($first_month) ?> s.d <?= shortdate_indo($now) ?></p>
                                <div id="datang-charts" dir="ltr"></div>
                                <h5><strong>Total = <?= $total_datang ?></strong></h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- end row -->

            </div>
            <!-- end container -->
        </section>
        <!-- Features end -->
        

        <!-- Footer start -->
        <footer class="landing-footer">
            <div class="container">

                <!-- <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="mb-4 mb-lg-0">
                            <h5 class="mb-3 footer-list-title">Links</h5>
                            <ul class="list-unstyled footer-list-menu">
                                <li><a href="<?= base_url() ?>/privacy">Privacy Policy</a></li>
                                <li><a href="<?= base_url() ?>/terms-and-conditions">Terms and Conditions</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="mb-4 mb-lg-0">
                            <h5 class="mb-3 footer-list-title">Contact</h5>
                            <div class="blog-post">
                                <a href="mailto: iketuteddy.project@gmail.com" class="post">
                                    <p class="mb-0"><i class="bx bx-mail-send me-1"></i> Email</p>
                                    <div class="badge badge-soft-success font-size-11 mb-3"> iketuteddy.project@gmail.com</div>
                                </a>

                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- end row -->

                <hr class="footer-border my-5">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <img src="<?= base_url() ?>/public/assets/images/Logo-Dukcapil-Mojokerto-Footer.png" alt="" height="50">
                        </div>
    
                        <p class="mb-2"><script>document.write(new Date().getFullYear())</script> © Dinas Kependudukan dan Catatan Sipil Kota Mojokerto.</p>
                    </div>

                </div>
            </div>
            <!-- end container -->
        </footer>
        <!-- Footer end -->

        <!-- JAVASCRIPT -->
        <script src="<?= base_url() ?>/public/assets/libs/jquery/jquery.min.js"></script>
        <script src="<?= base_url() ?>/public/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url() ?>/public/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?= base_url() ?>/public/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?= base_url() ?>/public/assets/libs/node-waves/waves.min.js"></script>

        <script src="<?= base_url() ?>/public/assets/libs/jquery.easing/jquery.easing.min.js"></script>

        <!-- Plugins js-->
        <script src="<?= base_url() ?>/public/assets/libs/jquery-countdown/jquery.countdown.min.js"></script>

        <!-- owl.carousel js -->
        <script src="<?= base_url() ?>/public/assets/libs/owl.carousel/owl.carousel.min.js"></script>

        <!-- ICO landing init -->
        <script src="<?= base_url() ?>/public/assets/js/pages/ico-landing.init.js"></script>

        <script src="<?= base_url() ?>/public/assets/js/app.js"></script>
        <!-- tui charts plugins -->
        <script src="<?= base_url() ?>/public/assets/libs/tui-chart/tui-chart-all.min.js"></script>

        <!-- tui charts plugins -->
        <!-- <script src="<?= base_url() ?>/public/assets/js/pages/tui-charts.init.js"></script> -->

    </body>
    <script>
        // Lahir Chart
        var donutpieChartWidth = $("#lahir-charts").width();
        var container = document.getElementById('lahir-charts');
        var data = {
            categories: ['KECAMATAN'],
            series: <?= $lahir?>
            
        };
        var options = {
            chart: {
                width: donutpieChartWidth,
                height: 380,
                // title: 'Periode',
                format: function(value, chartType, areaType, valuetype, legendName) {
                    if (areaType === 'makingSeriesLabel') { // formatting at series area
                        value = value;
                    }

                    return value;
                }
            },
            series: {
                radiusRange: ['40%', '100%'],
                showLabel: true
            },
            // tooltip: {
            //     suffix: '%'
            // },
            legend: {
                align: 'top'
            },
            exportMenu: {
                visible: false
            },
        };
        var theme = {
            chart: {
                background: {
                    color: '#fff',
                    opacity: 0
                },
            },
            title: {
                color: '#8791af',
            },

            plot: {
                lineColor: 'rgba(166, 176, 207, 0.1)'
            },
            legend: {
                label: {
                    color: '#8791af'
                }
            },
            series: {
                series: {
                    colors: [
                        '#556ee6', '#34c38f', '#f46a6a', '#50a5f1', '#f1b44c'
                    ]
                },
                label: {
                    color: '#fff',
                    fontFamily: 'sans-serif'
                }
            }
        };

        // For apply theme

        tui.chart.registerTheme('myTheme', theme);
        options.theme = 'myTheme';

        var donutChart = tui.chart.pieChart(container, data, options);

        $( window ).resize(function() {
            donutpieChartWidth = $("#lahir-charts").width();
            donutChart.resize({
                width: donutpieChartWidth,
                height: 350
            });
        });

        // Mati Chart
        var donutpieChartWidth = $("#mati-charts").width();
        var container = document.getElementById('mati-charts');
        var data = {
            categories: ['KECAMATAN'],
            series: <?= $mati?>
            
        };
        var options = {
            exportMenu: {
                visible: false
            },
            chart: {
                width: donutpieChartWidth,
                height: 380,
                // title: 'Periode',
                format: function(value, chartType, areaType, valuetype, legendName) {
                    if (areaType === 'makingSeriesLabel') { // formatting at series area
                        value = value;
                    }

                    return value;
                }
            },
            series: {
                radiusRange: ['40%', '100%'],
                showLabel: true
            },
            // tooltip: {
            //     suffix: '%'
            // },
            legend: {
                align: 'top'
            },
        };
        var theme = {
            chart: {
                background: {
                    color: '#fff',
                    opacity: 0
                },
            },
            title: {
                color: '#8791af',
            },

            plot: {
                lineColor: 'rgba(166, 176, 207, 0.1)'
            },
            legend: {
                label: {
                    color: '#8791af'
                }
            },
            series: {
                series: {
                    colors: [
                        '#556ee6', '#34c38f', '#f46a6a', '#50a5f1', '#f1b44c'
                    ]
                },
                label: {
                    color: '#fff',
                    fontFamily: 'sans-serif'
                }
            }
        };

        // For apply theme

        tui.chart.registerTheme('myTheme', theme);
        options.theme = 'myTheme';

        var donutChart = tui.chart.pieChart(container, data, options);

        $( window ).resize(function() {
            donutpieChartWidth = $("#mati-charts").width();
            donutChart.resize({
                width: donutpieChartWidth,
                height: 350
            });
        });

        // Pindah Chart
        var donutpieChartWidth = $("#pindah-charts").width();
        var container = document.getElementById('pindah-charts');
        var data = {
            categories: ['KECAMATAN'],
            series: <?= $pindah?>
            
        };
        var options = {
            exportMenu: {
                visible: false
            },
            chart: {
                width: donutpieChartWidth,
                height: 380,
                // title: 'Periode',
                format: function(value, chartType, areaType, valuetype, legendName) {
                    if (areaType === 'makingSeriesLabel') { // formatting at series area
                        value = value;
                    }

                    return value;
                }
            },
            series: {
                radiusRange: ['40%', '100%'],
                showLabel: true
            },
            // tooltip: {
            //     suffix: '%'
            // },
            legend: {
                align: 'top'
            },
        };
        var theme = {
            chart: {
                background: {
                    color: '#fff',
                    opacity: 0
                },
            },
            title: {
                color: '#8791af',
            },

            plot: {
                lineColor: 'rgba(166, 176, 207, 0.1)'
            },
            legend: {
                label: {
                    color: '#8791af'
                }
            },
            series: {
                series: {
                    colors: [
                        '#556ee6', '#34c38f', '#f46a6a', '#50a5f1', '#f1b44c'
                    ]
                },
                label: {
                    color: '#fff',
                    fontFamily: 'sans-serif'
                }
            }
        };

        // For apply theme

        tui.chart.registerTheme('myTheme', theme);
        options.theme = 'myTheme';

        var donutChart = tui.chart.pieChart(container, data, options);

        $( window ).resize(function() {
            donutpieChartWidth = $("#pindah-charts").width();
            donutChart.resize({
                width: donutpieChartWidth,
                height: 350
            });
        });
    </script>

</html>