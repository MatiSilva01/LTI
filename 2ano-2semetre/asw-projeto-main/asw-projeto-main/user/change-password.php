<?php
require_once "../i18n/index.php";
require_once __DIR__ . '/../volunteer/volunteer.php';
require_once __DIR__ . '/../institution/institution.php';

$hash = $_GET["q"];
if (!isset($hash)) {
    header('Location: /');
}

$user = Voluntario::getByLostPasswordHash($hash) ?? Instituicao::getByLostPasswordHash($hash);
if (!isset($user)) {
    header('Location: /');
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>ReFood - FCUL</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/logo_small.png" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="../assets/css/login.css" rel="stylesheet" />
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body id="page-top">
    <!-- Navbar -->
    <?php include '../components/navbar.php' ?>

    <header class="masthead">
        <div class="container">
            <div class="row align-items-center" style="min-height:100vh">
                <!-- d-flex justify-content-center -->
                <div id="first" class="col-md-5 mx-auto">
                    <div class="myform form">
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center">
                                <h2><?= _("Alterar Password") ?></h2>
                            </div>
                        </div>
                        <form name="changePassword" action="submit-password.php" method="post" enctype="multipart/form-data">
                            <input type="text" hidden name="hash" value="<?= $hash ?>"/>
                            <div class="form-group">
                                <label for="password"><?= _("Password") ?></label>
                                <input type="password" name="password" id="password" class="form-control" aria-describedby="passwordInstituicao" minlength="5" required >
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword"><?= _("Repita a Password") ?></label>
                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" aria-describedby="confirmPasswordInstituicao" minlength="5" required>
                            </div>
                            <br>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-block mybtn btn-primary tx-tfm"><?= _("Salvar") ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- FIM EDITAR PERFIL -->
    </header>

    <script>
        $('form[name="changePassword"]').validate({
            rules: {
                passwordInstituicao: {
                    required: true,
                    minlength: 5
                },
                confirmPasswordInstituicao: {
                    required: true,
                    minlength: 5,
                    equalTo: '#passwordInstituicao'
                },
            },

            messages: {
                passwordInstituicao: {
                    required: "<?= _("Por favor insira uma senha") ?>",
                    minlength: "<?= _("A senha tem de ter pelo menos 5 caracteres") ?>"
                },
                confirmPasswordInstituicao: {
                    required: "<?= _("Por favor insira uma senha") ?>",
                    minlength: "<?= _("A senha tem de ter pelo menos 5 caracteres") ?>",
                    equalTo: "<?= _("As senhas devem ser iguais") ?>"
                },
            },

            submitHandler: function (form) {
                form.submit();
            }
        });
    </script>
</body>

</html>