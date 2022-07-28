<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tindakan tidak dikenali</title>

    <!--Popins Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!--CSS-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/master.css">

    <!--JS-->
    <script src="<?= base_url() ?>assets/js/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/alert/sweetalert2.min.js"></script>
    <script src="<?= base_url() ?>assets/js/master.js"></script>

    <script>
        const base_url = "<?= base_url() ?>"
    </script>

</head>
<body>
<style>
    body {
        background-color: white;
    }

    a {
        font-size: 15px !important;
    }
</style>
<!--begin:header landing page-->
<header>
    <div class="py-3 container px-0 d-flex flex-row justify-content-between">
        <div class="d-inline-block d-flex flex-row align-items-center">
            <img class="align-top" src="<?= base_url() ?>assets/media/logo.png" alt="MyPertamina Logo"/>
            <div class="d-inline-block pl-3">
                <h6 class="font-weight-bold mb-1">Web Verifikasi Subsidi Tepat</h6>
                <p class="font-weight-light">Pengguna BBM bersubsidi harus terdaftar di aplikasi MyPertamina<br>
                    untuk bertransaksi BBM subsidi.</p>
            </div>
        </div>
    </div>
</header>
<!--end:header landing page-->

<div class="d-flex flex-column container justify-content-center">
    <img src="<?= base_url() ?>assets/media/oops.png" alt="opps" class="w-50 mx-auto">
    <a class="btn btn-primary btn-lg w-25 mx-auto mt-4 rounded-pill" href="<?= base_url() ?>">Kembali ke halaman verifikasi</a>
</div>
</body>
</html>