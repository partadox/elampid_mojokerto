<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>e-Lampid - <?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="e-Lampid Dispendukcapil Kota Mojokerto" name="e-Lampid Dispendukcapil Kota Mojokerto" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url()?>/public/assets/images/favicon.png">


    <!-- Bootstrap Css -->
    <link href="<?= base_url()?>/public/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <!-- Icons Css -->
    <link href="<?= base_url()?>/public/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url()?>/public/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <link href="<?= base_url()?>/public/assets/css/main.css" rel="stylesheet" type="text/css" />
    
    <!-- Custom Css-->
    <link href="<?= base_url()?>/public/assets/css/custom.css" rel="stylesheet" type="text/css" />

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Mask Money JS - Format Input Rupiah JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- Bootstrap-fileinput Krajee Kratik-->
    <!-- <link href="<?= base_url()?>/public/assets/css/fileinput.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet">
    <link href="<?= base_url()?>/public/assets/css/explorer-fa6-theme.css" rel="stylesheet"> -->

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css" integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/2.3.6/buttons.bootstrap4.min.css" integrity="sha512-LVJxdX5sTNFz8G8zJhpf8Sz/6MPnF0KiOTZHKjun7BDq5LEYJv+k1D0uNIaz3Irdu0g7biVfL6a8qkbOBjaWbg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Responsive datatable examples -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs/2.4.1/responsive.bootstrap.min.css" integrity="sha512-lC7CsBqS9byAEsS32hb1hbptYmqxRoPc+kIKOydGHfpUXHywskhQHlIQj69/S5egtqEqsEsFwjc5x5HHx/T14Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Apex Chart -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.js"></script>

    <!-- Date Picker Booststrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- tui charts Css -->
    <link href="<?= base_url() ?>/public/assets/libs/tui-chart/tui-chart.min.css" rel="stylesheet" type="text/css" />

</head>

<body data-sidebar="dark">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="<?= base_url() ?>" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="<?= base_url()?>/public/assets/images/logo-mjkt.png" alt="" height="40">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url()?>/public/assets/images/logo-elampid.png" alt="" height="45">
                            </span>
                        </a>

                        <a href="<?= base_url() ?>" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="<?= base_url()?>/public/assets/images/logo-mjkt.png" alt="" height="40">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url()?>/public/assets/images/logo-elampid.png" alt="" height="45">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="<?= base_url()?>/public/assets/images/user.png"
                                alt="Header Avatar">
                            <span class="d-xl-inline-block ms-1"><?= session('nama') ?></span>
                            <i class="mdi mdi-chevron-down d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <!-- <a class="dropdown-item" href="account"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                                <span key="t-profile">Akun</span></a>
                            <div class="dropdown-divider"></div> -->
                            <a class="dropdown-item text-danger" href="" id=logout><i
                                    class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                                    key="t-logout">Keluar</span></a>
                        </div>
                    </div>

                </div>
            </div>
        </header>
        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title" key="t-menu">Menu</li>

                        <li>
                            <a href="<?= base_url('dashboard') ?>" class="waves-effect">
                                <i class="bx bx-home-circle"></i>
                                <span key="t-dashboards">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-folder"></i>
                                <span key="t-lahir">Data Lahir</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= base_url('lahir') ?>" key="t-lahir">Data</a></li>
                                <?php if (session('role') == '707SP') { ?> 
                                <li><a href="<?= base_url('lahir-laporan') ?>" key="t-laporan-lahir">Laporan</a></li>
                                <li><a href="<?= base_url('lahir-import') ?>" key="t-import-lahir">Import</a></li>
                                <?php } ?>
                                
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-folder"></i>
                                <span key="t-mati">Data Mati</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= base_url('mati') ?>" key="t-mati">Data</a></li>
                                <?php if (session('role') == '707SP') { ?> 
                                <li><a href="<?= base_url('mati-laporan') ?>" key="t-mati-laporan">Laporan</a></li>
                                <li><a href="<?= base_url('mati-import') ?>" key="t-mati-import">Import</a></li>
                                <?php } ?>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-folder"></i>
                                <span key="t-pindah">Data Pindah</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= base_url('pindah') ?>" key="t-pindah">Data</a></li>
                                <?php if (session('role') == '707SP') { ?> 
                                <li><a href="<?= base_url('pindah-laporan') ?>" key="t-pindah-laporan">Laporan</a></li>
                                <li><a href="<?= base_url('pindah-import') ?>" key="t-pindah-import">Import</a></li>
                                <?php } ?>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-folder"></i>
                                <span key="t-datang">Data Datang</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= base_url('datang') ?>" key="t-datang">Data</a></li>
                                <?php if (session('role') == '707SP') { ?> 
                                <li><a href="<?= base_url('datang-laporan') ?>" key="t-datang-laporan">Laporan</a></li>
                                <li><a href="<?= base_url('datang-import') ?>" key="t-datang-import">Import</a></li>
                                <?php } ?>
                            </ul>
                        </li>

                        <!-- <li>
                            <a href="<?= base_url('content') ?>" class="waves-effect">
                                <i class="bx bx-book-content"></i>
                                <span key="t-content">Konten Front Page</span>
                            </a>
                        </li> -->

                        <!-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-map-alt"></i>
                                <span key="t-wilayah">Wilayah</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= base_url('kecamatan') ?>" key="t-kecamatan">Kecamatan</a></li>
                                <li><a href="<?= base_url('kelurahan') ?>" key="t-kelurahan">Kelurahan</a></li>
                            </ul>
                        </li> -->
                        <?php if (session('role') == '707SP') { ?> 
                            <li>
                                <a href="<?= base_url('auth-user') ?>" class="waves-effect">
                                    <i class="bx bx-user-circle"></i>
                                    <span key="t-auth-user">Manajemen User</span>
                                </a>
                            </li>
                        <?php } ?>

                        <!-- <li>
                            <a href="<?= base_url('log') ?>" class="waves-effect">
                                <i class="bx bx-history"></i>
                                <span key="t-log">Log Aktivitas</span>
                            </a>
                        </li> -->
        
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <div class="main-content" id="result">
            <?= $this->renderSection('isi') ?>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <div class="text-center">
                    <script>document.write(new Date().getFullYear())</script> © e-Lampid.
                </div>
            </div>
        </footer>
    </div>
    <!-- END layout-wrapper -->
</body>

<!-- JAVASCRIPT -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js" integrity="sha512-pax4MlgXjHEPfCwcJLQhigY7+N8rt6bVvWLFyUMuxShv170X53TRzGPmPkZmGBhk+jikR8WBM4yl7A9WMHHqvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.7/metisMenu.min.js" integrity="sha512-o36qZrjup13zLM13tqxvZTaXMXs+5i4TL5UWaDCsmbp5qUcijtdCFuW9a/3qnHGfWzFHBAln8ODjf7AnUNebVg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.2.4/simplebar.min.js" integrity="sha512-K//QeDiscFFAs5yljnbZCuoAmzv5KdtVY0W70WLQZ+BFCxi4PotspvxZwpaGJOao2l4oIQhgsHX5tHxyRe+YYw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.6/waves.min.js" integrity="sha512-MzXgHd+o6pUd/tm8ZgPkxya3QUCiHVMQolnY3IZqhsrOWQaBfax600esAw3XbBucYB15hZLOF0sKMHsTPdjLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- App js -->
<script src="<?= base_url()?>/public/assets/js/app.min.js"></script>
<!-- Sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Required datatable js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js" integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Buttons examples -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.3.6/js/dataTables.buttons.min.js" integrity="sha512-hPELv/uqaT+ZbHiKMWXHNV15N6SPTB80TXb9/idOejUqAJZmeLjITlt3Fts8RtCshL/v2kfw7mIKpZnFilDEnA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/2.3.6/buttons.bootstrap4.min.js" integrity="sha512-IXfjiOXWYBQMr7Vkddfu4IB6WFMS2mc+Qb39MuON+hO+L/Jyy3cdpnh1u8UJb5UlP/HWiipq0uaKo2vWbtOXcQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" integrity="sha512-XMVd28F1oH/O71fzwBnV7HucLxVwtxf26XV8P4wPk26EDxuGZ91N8bsOttmnomcCD3CS5ZMRL50H0GgOHvegtg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script src="<?= base_url() ?>public/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>public/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>public/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Responsive examples -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-responsive/2.4.1/dataTables.responsive.min.js" integrity="sha512-9BgeOjT7sU+CPMlXJrq1Shzkx2spfWhhxEnUJ7Ab9b5bSPGCzT8DaT1a/qUfrTBtgJetJwnI81ilCJkXFZRGPA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.4.1/responsive.bootstrap4.min.js" integrity="sha512-EukuhT7pSeYUiLk5NV3uhXWMjGq4la8as5kp+2eZkq7wChPoUew8coepf1urhL8bCjSp/efanT5na06sh3pWlg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- PDFMake for PDF export -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<!-- Date Picker Booststrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $('.datepicker2').datepicker({
        format: 'yyyy-mm-dd',
    });
    //Logout
    $("#logout").on("click", function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Apakah anda yakin ingin keluar?",
        icon: "warning",
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Iya",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
            url: "<?= site_url('logout') ?>",
            type: "post",
            dataType: "json",
            success: function (response) {
            Swal.fire({
                title: "Berhasil!",
                text: "Anda berhasil keluar!",
                icon: "success",
                showConfirmButton: false,
                timer: 1250,
            }).then(function () {
                window.location = response.data.link;
            });
            },
        });
        }
    });
    });
</script>

</html>