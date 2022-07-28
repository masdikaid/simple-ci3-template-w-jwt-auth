
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/auth/login-page.css">
<script src="{base_url}assets/js/jquery/jquery.validate.min.js"></script>

<!--begin:container-->
<div class="container login-container">
    <div class="container bg-white p-3 col-4 mx-auto mt-5 rounded shadow-sm">
        <div id="header-login"></div>
        <img src="<?= base_url(); ?>assets/media/logo.png" alt="logo" class="mx-auto rounded d-block mt-5">
        <h5 class="font-weight-bold text-center mt-3">Selamat Datang</h5>
        <p class="font-weight-normal text-center">Silahkan masukan email dan password anda</p>
        <form class="pt-2 px-4 mt-5" id="login-form">

            <div class="form-group mb-4">
                <input type="email" class="form-control" name="email" id="email" placeholder="Masukan email anda" required>
                <label for="email">Email</label>
            </div>

            <div class="form-group mb-4">
                <input class="form-control" type="password" name="password" id="password" placeholder="Masukan password anda" required>
                <label for="password">Password</label>
            </div>

            <div class="form-group pt-4 mb-4">
                <button id="submit-login" class="btn btn-primary btn-block d-flex justify-content-center text-white" type="submit"><span class="w-auto">Masuk</span></button>
                <p id="login-status" class="mt-2 font-weight-light text-danger d-none text-center">Silahkan masukan email dan password anda</p>
            </div>

        </form>
    </div>
</div>
<!--end:container-->

<script src="{base_url}assets/js/pages/auth/login-page.js"></script>
