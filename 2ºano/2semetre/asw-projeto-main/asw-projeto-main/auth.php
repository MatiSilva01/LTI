<?php
// Redirect to profile if authenticated
session_start();

require_once __DIR__ . '/volunteer/volunteer.php';
require_once __DIR__ . '/institution/institution.php';

if (isset($_SESSION['user'])) {
    header("Location: /user/profile.php");
}

require_once "i18n/index.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once __DIR__ . '/components/head.php'; ?>
    <link href="assets/css/login.css" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navbar -->
    <?php include 'components/navbar.php' ?>

    <header class="masthead">
        <div class="container">
            <div class="row align-items-center" style="min-height:100vh">
                <div id="first" class="col-md-5 mx-auto">
                    <div class="myform form">
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center">
                                <h2><?= _("Iniciar Sessão") ?></h2>
                            </div>
                        </div>
                        <form action="user/login.php" method="post" name="login">
                            <div class="form-group">
                                <label for="usernameEmailInputLogin"><?= _("Username ou Email") ?></label>
                                <input type="text" name="usernameEmailLogin" class="form-control" id="usernameEmailLogin" aria-describedby="usernameEmailInputLogin" placeholder="<?= _("Insira o username/email") ?>">

                                <?php

                                if ($_REQUEST['err']) {
                                    echo "<label id='usernameEmailLogin-error' class='error' for='usernameEmailLogin'>" . _($_REQUEST['err']) . "</label>";
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="passwordInputLogin"><?= _("Password") ?></label>
                                <input type="password" name="passwordLogin" class="form-control" id="passwordLogin" aria-describedby="passwordInputLogin" placeholder="<?= _("Insira a Password") ?>">
                            </div>
                            <div class="form-group">
                                <p class="text-center"><?= _("Ao iniciar sessão está a aceitar os nossos") . " <a href='https://youtu.be/-A3TrJmDasY' target='__blank'>" . _("Termos de Uso") . "</a>" ?></p>
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-block mybtn btn-primary tx-tfm"><?= _("Iniciar Sessão") ?></button>
                            </div>
                        </form>


                        <div class="col-md-12">
                            <div class="login-or">
                                <hr class="hr-or" />
                                <span class="span-or"><?= _("ou") ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <p class="text-center"><?= _("Ainda não tem conta?") . " <a href='#' id='signup'>" . _("Registe-se") . "</a>" ?></p>
                            <p class="text-center"><?= _("Esqueceu a sua senha?") . " <a href='#' id='lostPassword'>" . _("Recupere") . "</a>" ?></p>
                        </div>
                    </div>
                </div>
                <div id="second" class="col-md-12 mx-auto">
                    <div class="myform form" style="width:100%">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="voluntario-tab" data-bs-toggle="tab" data-bs-target="#voluntario" type="button" role="tab" aria-controls="home" aria-selected="true">
                                    <?= _("Registar Voluntário") ?>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="instituicao-tab" data-bs-toggle="tab" data-bs-target="#instituicao" type="button" role="tab" aria-controls="contact" aria-selected="false">
                                    <?= _("Registar Instituição") ?>
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="voluntario" role="tabpanel" aria-labelledby="voluntario-tab">
                                <form action="volunteer/create.php" method="post" name="registerVoluntario" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nomeVoluntarioLabel"><?= _("Nome") ?></label>
                                                <input type="text" name="nomeVoluntario" class="form-control" id="nomeVoluntario" aria-describedby="nomeVoluntarioLabel" placeholder="<?= _("Insira nome") ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="emailVoluntarioLabel"><?= _("Email") ?></label>
                                                <input type="email" name="emailVoluntario" class="form-control" id="emailVoluntario" aria-describedby="emailVoluntarioLabel" placeholder="<?= _("Insira email") ?>">
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="passwordVoluntarioLabel"><?= _("Password") ?></label>
                                                        <input type="password" name="passwordVoluntario" id="passwordVoluntario" class="form-control" aria-describedby="passwordVoluntarioLabel">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="confirmPasswordInputSignup"><?= _("Repita a Password") ?></label>
                                                        <input type="password" name="confirmPasswordVoluntario" id="confirmPasswordVoluntario" class="form-control" aria-describedby="confirmPasswordVoluntarioLabel">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="dataNascimentoVoluntarioLabel"><?= _("Data Nascimento") ?></label>
                                                        <input type="date" name="dataNascimentoVoluntario" class="form-control" id="dataNascimentoVoluntarioLabel" aria-describedby="dataNascimentoVoluntarioLabel" placeholder="<?= _("Insira data nascimento") ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="generoVoluntarioLabel"><?= _("Género") ?></label>

                                                        <select name="generoVoluntario" class="form-control" id="generoVoluntario" aria-describedby="generoVoluntarioLabel">
                                                            <option value=""><?= _("Seleccionar Género") ?></option>
                                                            <option value="Masculino"><?= _("Masculino") ?></option>
                                                            <option value="Feminino"><?= _("Feminino") ?></option>
                                                            <option value="Outro"><?= _("Outro") ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fotoVoluntario"><?= _("Imagem de Perfil") ?></label>
                                                        <input type="file" class="form-control" id="fotoVoluntario" name="fotoVoluntario" accept="image/jpeg">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="telefoneVoluntarioLabel"><?= _("Telefone") ?></label>
                                                        <input type="number" name="telefoneVoluntario" class="form-control" id="telefoneVoluntario" aria-describedby="telefoneVoluntarioLabel" placeholder="<?= _("Insira telefone") ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cartaoCidadaoVoluntarioLabel"><?= _("Cartão Cidadão") ?></label>
                                                        <input type="number" name="cartaoCidadaoVoluntario" class="form-control" id="cartaoCidadaoVoluntarioLabel" aria-describedby="cartaoCidadaoVoluntarioLabel" placeholder="<?= _("Insira cartão cidadão") ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cartaConducaoVoluntarioLabel"><?= _("Carta de Condução") ?></label>
                                                        <input type="number" name="cartaConducaoVoluntario" class="form-control" id="cartaConducaoVoluntarioLabel" aria-describedby="cartaConducaoVoluntarioLabel" placeholder="<?= _("Insira carta de condução") ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">

                                            <!-- <div class="row"> -->
                                            <!-- <div class="col-md-6"> -->
                                            <div class="form-group">
                                                <label for="distritoVoluntarioLabel"><?= _("Distrito") ?></label>

                                                <select name="distritoVoluntario" class="form-control" id="distritoVoluntario" aria-describedby="distritoVoluntarioLabel">
                                                    <option value=""><?= _("Seleccionar Distrito") ?></option>

                                                    <?php
                                                    $raw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/assets/js/datasets/distritos-metadata.json');

                                                    $distritos = json_decode($raw)->d;

                                                    foreach ($distritos as $distrito) {
                                                        echo "<option value='$distrito->Designacao'>$distrito->Designacao</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- </div>
                                                <div class="col-md-6"> -->
                                            <div class="form-group">
                                                <label for="concelhoVoluntarioLabel"><?= _("Concelho") ?></label>

                                                <select name="concelhoVoluntario" class="form-control" id="concelhoVoluntario" aria-describedby="concelhoVoluntarioLabel">
                                                    <option value=""><?= _("Seleccionar Concelho") ?></option>

                                                    <?php
                                                    $raw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/assets/js/datasets/concelhos-metadata.json');

                                                    $concelhos = json_decode($raw)->d;

                                                    foreach ($concelhos as $concelho) {
                                                        echo "<option value='$concelho->designacao'>$concelho->designacao</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- </div> -->
                                            <!-- </div> -->
                                            <div class="form-group">
                                                <label for="freguesiaVoluntario"><?= _("Freguesia") ?></label>

                                                <select name="freguesiaVoluntario" class="form-control" id="freguesiaVoluntario" aria-describedby="freguesiaVoluntarioLabel">
                                                    <option value=""><?= _("Seleccionar Freguesia") ?></option>

                                                    <?php
                                                    $raw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/assets/js/datasets/freguesias-metadata.json');

                                                    $freguesias = json_decode($raw)->d;

                                                    foreach ($freguesias as $freguesia) {
                                                        echo "<option value='$freguesia->freguesia'> $freguesia->distrito > $freguesia->concelho > $freguesia->freguesia</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 pl-md-1">
                                                <div class="form-group">
                                                    <label for="latitudeVoluntario"><?= _("Latitude") ?></label>
                                                    <input name="latitudeVoluntario" id="latitudeVoluntario" type="number" class="form-control" placeholder="<?= _("Insira latitude") ?>" value="<?= $user->latitude ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pr-md-1">
                                                <div class="form-group">
                                                    <label for="longitudeVoluntario"><?= _("Longitude") ?></label>
                                                    <input name="longitudeVoluntario" type="number" class="form-control" placeholder="<?= _("Insira longitude") ?>" value="<?= $user->longitude ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 text-center mt-2 mb-3">
                                            <button type="submit" class="btn btn-block mybtn btn-primary tx-tfm"><?= _("Registar") ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="instituicao" role="tabpanel" aria-labelledby="instituicao-tab">
                                <form action="institution/create.php" method="post" name="registerInstituicao" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nomeInstituicaoLabel"><?= _("Nome") ?></label>
                                                <input type="text" name="nomeInstituicao" class="form-control" id="nomeInstituicao" aria-describedby="nomeInstituicaoLabel" placeholder="<?= _("Insira o nome da instituição") ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="emailInstituicaoLabel"><?= _("Email") ?></label>
                                                <input type="email" name="emailInstituicao" class="form-control" id="emailInstituicao" aria-describedby="emailInstituicaoLabel" placeholder="<?= _("Insira o email da instituição") ?>">
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="passwordInstituicaoLabel"><?= _("Password") ?></label>
                                                        <input type="password" name="passwordInstituicao" id="passwordInstituicaoLabel" class="form-control" aria-describedby="passwordInstituicaoLabel">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="confirmPasswordInputSignup"><?= _("Repita a Password") ?></label>
                                                        <input type="password" name="confirmPasswordInstituicao" id="confirmPasswordInstituicao" class="form-control" aria-describedby="confirmPasswordInstituicaoLabel">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="moradaInstituicaoLabel"><?= _("Morada") ?></label>
                                                        <input type="text" name="moradaInstituicao" class="form-control" id="moradaInstituicaoLabel" aria-describedby="moradaInstituicaoLabel" placeholder="<?= _("Insira a morada da instituição") ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nomeContactoInstituicaoLabel"><?= _("Nome do contacto") ?></label>
                                                        <input type="text" name="nomeContactoInstituicao" class="form-control" id="nomeContactoInstituicao" aria-describedby="nomeContactoInstituicaoLabel" placeholder="<?= _("Insira o nome da pessoa a consultar") ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="telefoneInstituicaoLabel"><?= _("Telefone") ?></label>
                                                        <input type="number" name="telefoneInstituicao" class="form-control" id="telefoneInstituicaoLabel" aria-describedby="telefoneInstituicaoLabel" placeholder="<?= _("Insira o telefone da instituição") ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="telefoneContactoInstituicaoLabel"><?= _("Telefone do contacto") ?></label>
                                                        <input type="number" name="telefoneContactoInstituicao" class="form-control" id="telefoneContactoInstituicao" aria-describedby="telefoneContactoInstituicaoLabel" placeholder="<?= _("Insira telefone da pessoa a consultar") ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="descricaoInstituicaoLabel"><?= _("Descrição da instituição") ?></label>
                                                        <textarea class="form-control" name="descricaoInstituicao" id="descricaoInstituicao" rows="3" placeholder="<?= _("Breve descrição da instituição") ?>"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="tipoInstituicao"><?= _("Tipo da instituição") ?></label>
                                                        <select name="tipoInstituicao" class="form-control" id="tipoInstituicao">
                                                            <option value=""><?= _("Seleccionar Tipo") ?></option>
                                                            <?php
                                                            foreach ($validTipos as $tipo) {
                                                                echo "<option value='$tipo'>" . _($tipo) . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 pl-md-1">
                                                    <div class="form-group">
                                                        <label for="latitudeInstituicao"><?= _("Latitude") ?></label>
                                                        <input name="latitudeInstituicao" id="latitudeInstituicao" type="number" class="form-control" placeholder="<?= _("Insira latitude") ?>" value="<?= $user->latitude ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pr-md-1">
                                                    <div class="form-group">
                                                        <label for="longitudeInstituicao"><?= _("Longitude") ?></label>
                                                        <input name="longitudeInstituicao" type="number" class="form-control" placeholder="<?= _("Insira longitude") ?>" value="<?= $user->longitude ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">

                                            <!-- <div class="row"> -->
                                            <!-- <div class="col-md-6"> -->
                                            <div class="form-group">
                                                <label for="distritoInstituicaoLabel"><?= _("Distrito") ?></label>

                                                <select name="distritoInstituicao" class="form-control" id="distritoInstituicao" aria-describedby="distritoInstituicaoLabel">
                                                    <option value=""><?= _("Seleccionar Distrito") ?></option>

                                                    <?php
                                                    foreach ($distritos as $distrito) {
                                                        echo "<option value='$distrito->Designacao'>$distrito->Designacao</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- </div>
                                                <div class="col-md-6"> -->
                                            <div class="form-group">
                                                <label for="concelhoInstituicaoLabel"><?= _("Concelho") ?></label>

                                                <select name="concelhoInstituicao" class="form-control" id="concelhoInstituicao" aria-describedby="concelhoInstituicaoLabel">
                                                    <option value=""><?= _("Seleccionar Concelho") ?></option>

                                                    <?php
                                                    foreach ($concelhos as $concelho) {
                                                        echo "<option value='$concelho->designacao'>$concelho->designacao</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- </div> -->
                                            <!-- </div> -->
                                            <div class="form-group">
                                                <label for="freguesiaInstituicaoLabel"><?= _("Freguesia") ?></label>

                                                <select name="freguesiaInstituicao" class="form-control" id="freguesiaInstituicao" aria-describedby="freguesiaInstituicaoLabel">
                                                    <option value=""><?= _("Seleccionar Freguesia") ?></option>

                                                    <?php
                                                    foreach ($freguesias as $freguesia) {
                                                        echo "<option value='$freguesia->freguesia'> $freguesia->distrito > $freguesia->concelho > $freguesia->freguesia</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-auto mr-3">
                                                <div class="form-group">
                                                    <label for="fotoInstituicao"><?= _("Foto da instituição") ?></label>
                                                    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                                                    <input type="file" class="form-control" name="fotoInstituicao" id="fotoInstituicao" rows="3" placeholder="<?= _("Upload da foto da instituição") ?>"></input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 text-center mt-2 mb-3">
                                        <button type="submit" class="btn btn-block mybtn btn-primary tx-tfm"><?= _("Registar") ?></button>
                                    </div>
                            </div>
                            </form>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <p class="text-center signin"><a href="#"><?= _("Já tem uma conta?") ?></a></p>
                        </div>
                    </div>
                </div>

                <div id="third" class="col-md-4 mx-auto">
                    <div class="myform form">
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center">
                                <h2><?= _("Recuperar Senha") ?></h2>
                            </div>
                        </div>
                        <form action="user/recover-password.php" method="post" name="recover">
                            <div class="form-group">
                                <label for="usernameEmailRecover"><?= _("Username ou Email") ?></label>
                                <input type="text" name="usernameEmailRecover" class="form-control" id="usernameEmailRecover" aria-describedby="usernameEmailInputLogin" placeholder="<?= _("Insira o username/email") ?>">
                            </div>

                            <div class="col-md-12 mt-3 text-center">
                                <button type="submit" class="btn btn-block mybtn btn-primary tx-tfm"><?= _("Recuperar") ?></button>
                            </div>


                            <div class="form-group">
                                <p class="text-center signin"><a href="#"><?= _("Já tem uma conta?") ?></a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </header>

    <script>
        $('#signup').click(function() {
            $('#first').fadeOut('fast', function() {
                $('#second').fadeIn('fast');
            });
        });

        $('.signin').click(function() {
            $('#second').fadeOut('fast', function() {
                $('#third').fadeOut('fast', function() {
                    $('#first').fadeIn('fast');
                });
            });
        });

        $('#lostPassword').click(function() {
            $('#first').fadeOut('fast', function() {
                $('#third').fadeIn('fast');
            });
        });

        $('form[name="login"]').validate({
            rules: {
                usernameEmailLogin: {
                    required: true,
                },
                passwordLogin: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                usernameEmailLogin: '<?= _("Por favor insira um email ou nome de utilizador") ?>',
                passwordLogin: {
                    required: '<?= _("Por favor insira uma senha") ?>',
                    minlength: '<?= _("A senha tem de ter pelo menos 5 caracteres") ?>'
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        $('form[name="recover"]').validate({
            rules: {
                usernameEmailRecover: {
                    required: true,
                },
            },
            messages: {
                usernameEmailRecover: '<?= _("Por favor insira um email ou nome de utilizador") ?>',
            },
            submitHandler: function(form) {
                form.submit();
            }
        })

        $('form[name="registerVoluntario"]').validate({
            rules: {
                nomeVoluntario: {
                    required: true,
                    minlength: 5
                },
                emailVoluntario: {
                    required: true,
                    email: true
                },
                passwordVoluntario: {
                    required: true,
                    minlength: 5
                },
                confirmPasswordVoluntario: {
                    required: true,
                    minlength: 5,
                    equalTo: '#passwordVoluntario'
                },
                dataNascimentoVoluntario: {
                    required: true,
                    dateISO: true
                },
                generoVoluntario: 'required',
                fotoVoluntario: 'required',
                telefoneVoluntario: 'required',
                cartaoCidadaoVoluntario: 'required',
                cartaConducaoVoluntario: 'required',
                distritoVoluntario: 'required',
                concelhoVoluntario: 'required',
                freguesiaVoluntario: 'required',
                latitudeVoluntario: 'required',
                longitudeVoluntario: 'required',
            },

            messages: {
                nomeVoluntario: {
                    required: "<?= _("Por favor insira um nome de utilizador") ?>",
                    minlength: "<?= _("O nome tem de ter pelo menos 5 caracteres") ?>"
                },
                emailVoluntario: {
                    required: "<?= _("Por favor insira um email") ?>",
                    email: "<?= _("Por favor insira um email válido") ?>"
                },
                passwordVoluntario: {
                    required: "<?= _("Por favor insira uma senha") ?>",
                    minlength: "<?= _("A senha tem de ter pelo menos 5 caracteres") ?>"
                },
                confirmPasswordVoluntario: {
                    required: "<?= _("Por favor insira uma senha") ?>",
                    minlength: "<?= _("A senha tem de ter pelo menos 5 caracteres") ?>",
                    equalTo: "<?= _("As senhas devem ser iguais") ?>"
                },
                dataNascimentoVoluntario: {
                    required: "<?= _("Por favor insira uma data de nascimento") ?>",
                    dateISO: "<?= _("Deve ser uma data válida") ?>"
                },
                generoVoluntario: "<?= _("Por favor seleccione um género") ?>",
                fotoVoluntario: "<?= _("Por favor adicione uma imagem") ?>",
                telefoneVoluntario: "<?= _("Por favor insira um número de telefone") ?>",
                cartaoCidadaoVoluntario: "<?= _("Por favor insira o número de cartão de cidadão") ?>",
                cartaConducaoVoluntario: "<?= _("Por favor insira o número de carta de condução") ?>",
                distritoVoluntario: "<?= _("Por favor seleccione um distrito") ?>",
                concelhoVoluntario: "<?= _("Por favor seleccione um concelho") ?>",
                freguesiaVoluntario: "<?= _("Por favor seleccione um freguesia") ?>",
                latitudeVoluntario: "<?= _("Por favor insira a latitude") ?>",
                longitudeVoluntario: "<?= _("Por favor insira a longitude") ?>",
            },

            submitHandler: function(form) {
                form.submit();
            }
        });

        $('form[name="registerInstituicao"]').validate({
            rules: {
                nomeInstituicao: {
                    required: true,
                    minlength: 5
                },
                emailInstituicao: {
                    required: true,
                    email: true
                },
                passwordInstituicao: {
                    required: true,
                    minlength: 5
                },
                confirmPasswordInstituicao: {
                    required: true,
                    minlength: 5,
                    equalTo: '#passwordVoluntario'
                },
                moradaInstituicao: 'required',
                nomeContactoInstituicao: 'required',
                telefoneContactoInstituicao: 'required',
                descricaoInstituicao: 'required',
                tipoInstituicao: 'required',
                fotoInstituicao: 'required',
                telefoneInstituicao: 'required',
                distritoInstituicao: 'required',
                concelhoInstituicao: 'required',
                freguesiaInstituicao: 'required',
                latitudeInstituicao: 'required',
                longitudeInstituicao: 'required',
            },

            messages: {
                nomeInstituicao: {
                    required: "<?= _("Por favor insira um nome de utilizador") ?>",
                    minlength: "<?= _("O nome tem de ter pelo menos 5 caracteres") ?>"
                },
                emailInstituicao: {
                    required: "<?= _("Por favor insira um email") ?>",
                    email: "<?= _("Por favor insira um email válido") ?>",
                },
                passwordInstituicao: {
                    required: "<?= _("Por favor insira uma senha") ?>",
                    minlength: "<?= _("A senha tem de ter pelo menos 5 caracteres") ?>"
                },
                confirmPasswordInstituicao: {
                    required: "<?= _("Por favor insira uma senha") ?>",
                    minlength: "<?= _("A senha tem de ter pelo menos 5 caracteres") ?>",
                    equalTo: "<?= _("As senhas devem ser iguais") ?>"
                },
                moradaInstituicao: "<?= _("Por favor insira uma morada") ?>",
                nomeContactoInstituicao: "<?= _("Por favor insira um nome de contacto") ?>",
                telefoneContactoInstituicao: "<?= _("Por favor insira o número de telefone de contacto") ?>",
                descricaoInstituicao: "<?= _("Por favor insira uma descrição") ?>",
                tipoInstituicao: "<?= _("Por favor seleccione um tipo") ?>",
                generoVoluntario: "<?= _("Por favor seleccione um género") ?>",
                fotoInstituicao: "<?= _("Por favor adicione uma imagem") ?>",
                telefoneInstituicao: "<?= _("Por favor insira um número de telefone") ?>",
                distritoInstituicao: "<?= _("Por favor seleccione um distrito") ?>",
                concelhoInstituicao: "<?= _("Por favor seleccione um concelho") ?>",
                freguesiaInstituicao: "<?= _("Por favor seleccione um freguesia") ?>",
                latitudeInstituicao: "<?= _("Por favor insira a latitude") ?>",
                longitudeInstituicao: "<?= _("Por favor insira a longitude") ?>",
            },

            submitHandler: function(form) {
                form.submit();
            }
        });
    </script>
</body>

</html>