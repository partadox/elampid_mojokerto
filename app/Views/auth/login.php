<?= $this->extend('layout/main_auth') ?>
<?= $this->section('isi') ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="bg-warning bg-soft">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-secondary p-4">
                                    <h5 class="text-secondary">Selamat Datang di <br> e-Lampid</h5>
                                </div>
                            </div>
                            <div class="col-6 align-self-center" style="margin-left: -20px;">
                                <img width="174px" height="123px" src="<?= base_url()?>/public/assets/images/Logo-Dukcapil-Mojokerto.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="p-2">
                            <?= form_open('dologin', ['class' => 'formlogin']) ?>
                            <?= csrf_field() ?>
                            <form class="form-horizontal">
                                <div class="mb-3">
                                    <label for="user_username" class="form-label">Username <code>*</code></label>
                                    <input type="text" class="form-control" id="user_username" name="user_username" placeholder="Masukan username anda...">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password <code>*</code></label>
                                    <div class="input-group auth-pass-inputgroup">
                                        <input type="password" class="form-control" placeholder="Masukan password anda..." aria-label="Password" aria-describedby="password-addon" name="user_password" autocomplete="false">
                                        <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="g-recaptcha" data-sitekey="<?= $site_key ?>"></div>
                                </div>

                                <div class="mt-3 d-grid">
                                    <button class="btn btn-warning waves-effect waves-light" type="submit" id="login" name="login">Login</button>
                                </div>

                            </form>
                            <?= form_close() ?>
                        </div>

                    </div>
                </div>
                <div class="mt-5 text-center">
                    <p>Kembali ke Halaman Depan e-Lampid? <a href="<?= base_url() ?>" class="fw-medium text-primary"> Kembali ke e-Lampid </a> </p>
                    <div>
                        <p>© <script>
                                document.write(new Date().getFullYear())
                            </script> - Dispendukcapil Kota Mojokerto</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="<?= base_url() ?>/public/assets/js/page/login.js"></script>

<!-- End Page-content -->
<?= $this->endSection('isi') ?>