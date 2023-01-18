<?php
require_once "../i18n/index.php";
session_start();

// Force auth
if (!isset($_SESSION["user"])) {
    header("Location: /");
} else {
    require_once __DIR__ . '/../volunteer/volunteer.php';
    $user = unserialize($_SESSION["user"]);

    if (!($user instanceof Voluntario)) {
        header("Location: /user/profile.php");
    }
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once __DIR__ . '/../components/head.php'; ?>
    <link href="/assets/css/login.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/css/lib/select2.min.css">
    <script src="/assets/js/lib/select2.min.js"></script>
</head>

<body id="page-top">
    <!-- Navbar -->
    <?php include '../components/navbar.php' ?>

    <header class="masthead">
        <div class="container">
            <div class="row align-items-center" style="min-height:100vh">
                <!-- d-flex justify-content-center -->
                <div id="first" class="col-md-12 mx-auto">
                    <!-- EDITAR PERFIL -->
                    <div class="content">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="title"><?= _("Editar Perfil") ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <form name="updateVoluntario" action="update.php" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6 pr-md-1">
                                                    <div class="form-group">
                                                        <label for="nomeVoluntario"><?= _("Nome") ?></label>
                                                        <input name="nomeVoluntario" id="nomeVoluntario" type="text" class="form-control" placeholder="<?= _("Insira nome") ?>" value="<?= $user->nome ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pl-md-1">
                                                    <div class="form-group">
                                                        <label for="emailVoluntario"><?= _("Email") ?></label>
                                                        <input name="emailVoluntario" id="emailVoluntario" type="email" class="form-control" placeholder="<?= _("Insira email") ?>" value="<?= $user->email ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pl-md-1">
                                                    <div class="form-group">
                                                        <label for="dataNascimentoVoluntario"><?= _("Data Nascimento") ?></label>
                                                        <input name="dataNascimentoVoluntario" id="dataNascimentoVoluntario" type="date" class="form-control" value="<?= $user->data_nascimento ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pl-md-1">
                                                    <div class="form-group">
                                                        <label for="fotoVoluntario"><?= _("Imagem de Perfil") ?></label>
                                                        <input type="file" class="form-control" id="fotoVoluntario" name="fotoVoluntario" accept="image/jpeg">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 pr-md-1">
                                                    <div class="form-group">
                                                        <label for="telefoneVoluntario"><?= _("Telefone") ?></label>
                                                        <input name="telefoneVoluntario" id="telefoneVoluntario" type="text" class="form-control" placeholder="<?= _("Insira telefone") ?>" value="<?= $user->telefone ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pr-md-1">
                                                    <div class="form-group">
                                                        <label for="generoVoluntario"><?= _("Género") ?></label>
                                                        <select name="generoVoluntario" class="form-control" id="generoVoluntario" aria-describedby="generoVoluntario">
                                                            <option value=""><?= _("Seleccionar Género") ?></option>
                                                            <?php
                                                            foreach ($validGeneros as $gen) {
                                                                echo "<option value='$gen'";


                                                                if ($user->genero == $gen) {
                                                                    echo " selected";
                                                                }

                                                                echo ">" . _($gen) . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 pl-md-1">
                                                    <div class="form-group">
                                                        <label for="cartaoCidadaoVoluntario"><?= _("Cartão Cidadão") ?></label>
                                                        <input name="cartaoCidadaoVoluntario" id="cartaoCidadaoVoluntario" type="number" class="form-control" placeholder="<?= _("Insira cartão cidadão") ?>" value="<?= $user->cartao_cidadao ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pr-md-1">
                                                    <div class="form-group">
                                                        <label for="cartaConducaoVoluntario"><?= _("Carta de Condução") ?></label>
                                                        <input name="cartaConducaoVoluntario" type="number" class="form-control" placeholder="<?= _("Insira carta de condução") ?>" value="<?= $user->carta_conducao ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 px-md-1">
                                                    <div class="form-group">
                                                        <label for="distritoVoluntario" id="distritoVoluntarioLabel"><?= _("Distrito") ?></label>

                                                        <select name="distritoVoluntario" class="form-control" id="distritoVoluntario" aria-describedby="distritoVoluntarioLabel">
                                                            <option value=""><?= _("Seleccionar Distrito") ?></option>

                                                            <?php
                                                            $raw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/assets/js/datasets/distritos-metadata.json');

                                                            $distritos = json_decode($raw)->d;

                                                            foreach ($distritos as $distrito) {
                                                                echo "<option value='$distrito->Designacao'";
                                                                if ($user->distrito == $distrito->Designacao) {
                                                                    echo "selected";
                                                                }

                                                                echo ">$distrito->Designacao</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pr-md-1">
                                                    <div class="form-group">
                                                        <label for="concelhoVoluntario"><?= _("Concelho") ?></label>

                                                        <select name="concelhoVoluntario" class="form-control" id="concelhoVoluntario" aria-describedby="concelhoVoluntarioLabel">
                                                            <option value=""><?= _("Seleccionar Concelho") ?></option>

                                                            <?php
                                                            $raw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/assets/js/datasets/concelhos-metadata.json');

                                                            $concelhos = json_decode($raw)->d;

                                                            foreach ($concelhos as $concelho) {
                                                                echo "<option value='$concelho->designacao'";
                                                                if ($user->concelho == $concelho->designacao) {
                                                                    echo "selected";
                                                                }

                                                                echo ">$concelho->designacao</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 px-md-1">
                                                    <div class="form-group">
                                                        <label for="freguesiaVoluntario"><?= _("Freguesia") ?></label>

                                                        <select name="freguesiaVoluntario" class="form-control" id="freguesiaVoluntario" aria-describedby="freguesiaVoluntarioLabel">
                                                            <option value=""><?= _("Seleccionar Freguesia") ?></option>

                                                            <?php
                                                            $raw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/assets/js/datasets/freguesias-metadata.json');

                                                            $freguesias = json_decode($raw)->d;

                                                            foreach ($freguesias as $freguesia) {
                                                                echo "<option value='$freguesia->freguesia'";
                                                                if ($user->freguesia == $freguesia->freguesia) {
                                                                    echo "selected";
                                                                }

                                                                echo ">$freguesia->distrito > $freguesia->concelho > $freguesia->freguesia</option>";
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

                                                <div class="card-footer">
                                                    <div class="form-group">
                                                        <p class="text-center"><a href="#" id="password"><?= _("Alterar Password") ?></a></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p class="text-center"><a href="#" id="disponibilidade"><?= _("Editar disponibilidade") ?></a></p>
                                                    </div>
                                                    <button type="submit" class="btn btn-fill btn-primary"><?= _("Salvar") ?></button>
                                                </div>
                                        </form>
                                    </div> <!-- Fim do card-body -->
                                </div> <!-- Fim do card -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-user">
                                <div class="card-body">
                                    <p class="card-text">
                                    <div class="author">
                                        <div class="block block-one"></div>
                                        <div class="block block-two"></div>
                                        <div class="block block-three"></div>
                                        <div class="block block-four"></div>

                                        <?php
                                        echo "<img src='data:image/jpeg;base64,$user->foto' style='width:250px;height:250px' class='rounded-circle img-thumbnail avatar' alt='Avatar' loading='lazy' />";
                                        echo "<p class='lead'>{$user->nome}</p>";
                                        ?>
                                    </div>
                                    </p>
                                    <div class="card-description">
                                        <?= _("Voluntário na REFOOD!") ?>
                                    </div>
                                    <p>Instituições para fazer recolha:</p>
                                    <div id="instituicoes" class="card-description">
                                        <?= _("Instituições aceites para recolha:") ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="second" class="col-md-5 mx-auto">
                <div class="myform form">
                    <div class="logo mb-3">
                        <div class="col-md-12 text-center">
                            <h2><?= _("Alterar Password") ?></h2>
                        </div>
                    </div>
                    <form name="changePassword" action="change-password.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="passwordVoluntario"><?= _("Password") ?></label>
                            <input type="password" name="passwordVoluntario" id="passwordVoluntario" class="form-control" aria-describedby="passwordVoluntario">
                        </div>
                        <div class="form-group">
                            <label for="confirmPasswordVoluntario"><?= _("Repita a Password") ?></label>
                            <input type="password" name="confirmPasswordVoluntario" id="confirmPasswordVoluntario" class="form-control" aria-describedby="confirmPasswordVoluntario">
                        </div>
                        <br>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-block mybtn btn-primary tx-tfm"><?= _("Salvar") ?></button>
                        </div>

                        <div class="col-md-12">
                            <div class="login-or">
                                <hr class="hr-or" />
                                <span class="span-or"><?= _("ou") ?></span>
                            </div>
                        </div>



                        <div class="form-group">
                            <p class="text-center">
                                <a href="#" id="editProfile">
                                    <?= _("Alterar perfil") ?>
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <style>
                .mul-select {
                    width: 140px;
                }
            </style>


            <div id="third" class="col-md-5 mx-auto">
                <div class="myform form">
                    <div class="logo mb-3">
                        <div class="col-md-12 text-center">
                            <h2><?= _("Disponibilidade") ?></h2>
                        </div>
                    </div>
                    <form name="availability" id="disponibilidade-form" action="create_disponibilidade.php" method='POST' enctype="multipart/form-data">
                        <table cellspacing="0" rules="all" id="Table1" style="border-collapse: collapse;">
                            <tr>
                                <th>&nbsp;</th>
                                <th style="width:80px"><?= _("Dia da semana") ?></th>
                                <th style="width:120px"><?= _("Inicio da recolha") ?></th>
                                <th style="width:120px"><?= _("Fim da recolha") ?></th>
                            </tr>
                            <tr>
                                <td style="width:120px"><input name="dia[]" value="Segunda" required class="chkView" type="checkbox" /></td>
                                <td style="width:120px"><?= _("Segunda") ?></td>
                                <td style="width:120px">
                                    <select name="inicio[]" class="chkSelectInicio" disabled size="1">
                                        <option value='10'>10</option>
                                        <option value='11'>11</option>
                                        <option value='12'>12</option>
                                        <option value='13'>13</option>
                                        <option value='14'>14</option>
                                        <option value='15'>15</option>
                                        <option value='16'>16</option>
                                        <option value='17'>17</option>
                                        <option value='18'>18</option>
                                        <option value='19'>19</option>
                                        <option value='20'>20</option>
                                        <option value='21'>21</option>
                                        <option value='22'>22</option>
                                    </select>h
                                </td>
                                <td style="width:120px">
                                    <select name="fim[]" class="chkSelectFim" disabled size="1">
                                        <option>10</option>
                                        <option value='10'>10</option>
                                        <option value='11'>11</option>
                                        <option value='12'>12</option>
                                        <option value='13'>13</option>
                                        <option value='14'>14</option>
                                        <option value='15'>15</option>
                                        <option value='16'>16</option>
                                        <option value='17'>17</option>
                                        <option value='18'>18</option>
                                        <option value='19'>19</option>
                                        <option value='20'>20</option>
                                        <option value='21'>21</option>
                                        <option value='22' selected>22</option>
                                    </select>h
                                </td>
                            </tr>
                            <tr>
                                <td><input name="dia[]" value="Terca" class="chkView" required type="checkbox" /></td>
                                <td><?= _("Terça") ?></td>
                                <td>
                                    <select name="inicio[]" class="chkSelectInicio" disabled size="1">
                                        <option value='10'>10</option>
                                        <option value='11'>11</option>
                                        <option value='12'>12</option>
                                        <option value='13'>13</option>
                                        <option value='14'>14</option>
                                        <option value='15'>15</option>
                                        <option value='16'>16</option>
                                        <option value='17'>17</option>
                                        <option value='18'>18</option>
                                        <option value='19'>19</option>
                                        <option value='20'>20</option>
                                        <option value='21'>21</option>
                                        <option value='22'>22</option>
                                    </select>h
                                </td>
                                <td>
                                    <select name="fim[]" class="chkSelectFim" disabled size="1">
                                        <option value='10'>10</option>
                                        <option value='11'>11</option>
                                        <option value='12'>12</option>
                                        <option value='13'>13</option>
                                        <option value='14'>14</option>
                                        <option value='15'>15</option>
                                        <option value='16'>16</option>
                                        <option value='17'>17</option>
                                        <option value='18'>18</option>
                                        <option value='19'>19</option>
                                        <option value='20'>20</option>
                                        <option value='21'>21</option>
                                        <option value='22' selected>22</option>
                                    </select>h
                                </td>
                            </tr>
                            <tr>
                                <td><input name="dia[]" value="Quarta" id="testeClick" required class="chkView" type="checkbox" /></td>
                                <td><?= _("Quarta") ?></td>
                                <td>
                                    <select name="inicio[]" id='SelectH' class="chkSelectInicio" disabled size="1">
                                        <option value='10'>10</option>
                                        <option value='11'>11</option>
                                        <option value='12'>12</option>
                                        <option value='13'>13</option>
                                        <option value='14'>14</option>
                                        <option value='15'>15</option>
                                        <option value='16'>16</option>
                                        <option value='17'>17</option>
                                        <option value='18'>18</option>
                                        <option value='19'>19</option>
                                        <option value='20'>20</option>
                                        <option value='21'>21</option>
                                        <option value='22'>22</option>
                                    </select>h
                                </td>
                                <td>
                                    <select name="fim[]" class="chkSelectFim" disabled size="1">
                                        <option value='10'>10</option>
                                        <option value='11'>11</option>
                                        <option value='12'>12</option>
                                        <option value='13'>13</option>
                                        <option value='14'>14</option>
                                        <option value='15'>15</option>
                                        <option value='16'>16</option>
                                        <option value='17'>17</option>
                                        <option value='18'>18</option>
                                        <option value='19'>19</option>
                                        <option value='20'>20</option>
                                        <option value='21'>21</option>
                                        <option value='22' selected>22</option>
                                    </select>h
                                </td>
                            </tr>
                            <tr>
                                <td><input name="dia[]" value="Quinta" class="chkView" required type="checkbox" /></td>
                                <td><?= _("Quinta") ?></td>
                                <td>
                                    <select name="inicio[]" class="chkSelectInicio" disabled size="1">
                                        <option value='10'>10</option>
                                        <option value='11'>11</option>
                                        <option value='12'>12</option>
                                        <option value='13'>13</option>
                                        <option value='14'>14</option>
                                        <option value='15'>15</option>
                                        <option value='16'>16</option>
                                        <option value='17'>17</option>
                                        <option value='18'>18</option>
                                        <option value='19'>19</option>
                                        <option value='20'>20</option>
                                        <option value='21'>21</option>
                                        <option value='22'>22</option>
                                    </select>h
                                </td>
                                <td>
                                    <select name="fim[]" class="chkSelectFim" required disabled size="1">
                                        <option value='10'>10</option>
                                        <option value='11'>11</option>
                                        <option value='12'>12</option>
                                        <option value='13'>13</option>
                                        <option value='14'>14</option>
                                        <option value='15'>15</option>
                                        <option value='16'>16</option>
                                        <option value='17'>17</option>
                                        <option value='18'>18</option>
                                        <option value='19'>19</option>
                                        <option value='20'>20</option>
                                        <option value='21'>21</option>
                                        <option value='22' selected>22</option>
                                    </select>h
                                </td>
                            </tr>
                            <tr>
                                <td><input name="dia[]" value="Sexta" class="chkView" required type="checkbox" /></td>
                                <td><?= _("Sexta") ?></td>
                                <td>
                                    <select name="inicio[]" class="chkSelectInicio" disabled size="1">
                                        <option value='10'>10</option>
                                        <option value='11'>11</option>
                                        <option value='12'>12</option>
                                        <option value='13'>13</option>
                                        <option value='14'>14</option>
                                        <option value='15'>15</option>
                                        <option value='16'>16</option>
                                        <option value='17'>17</option>
                                        <option value='18'>18</option>
                                        <option value='19'>19</option>
                                        <option value='20'>20</option>
                                        <option value='21'>21</option>
                                        <option value='22'>22</option>
                                    </select>h
                                </td>
                                <td>
                                    <select name="fim[]" class="chkSelectFim" disabled size="1">
                                        <option value='10'>10</option>
                                        <option value='11'>11</option>
                                        <option value='12'>12</option>
                                        <option value='13'>13</option>
                                        <option value='14'>14</option>
                                        <option value='15'>15</option>
                                        <option value='16'>16</option>
                                        <option value='17'>17</option>
                                        <option value='18'>18</option>
                                        <option value='19'>19</option>
                                        <option value='20'>20</option>
                                        <option value='21'>21</option>
                                        <option value='22' selected>22</option>
                                    </select>h
                                </td>
                            </tr>
                        </table>




                        <br>
                        <div class="col-md-12 text-center">
                            <button type="submit" id='salvarDisponibilidade' class="btn btn-block mybtn btn-primary tx-tfm"><?= _("Salvar") ?></button>
                        </div>




                        <div class="col-md-12">
                            <div class="login-or">
                                <hr class="hr-or" />
                                <span class="span-or"><?= _("ou") ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <p class="text-center">
                                <a href="#" id="editProfile">
                                    <?= _("Alterar perfil") ?>
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- FIM EDITAR PERFIL -->
    </header>

    <style>
        input[type=checkbox] {
            transform: scale(1.8);
        }

        .chkView {
            margin-left: 40px;
        }
    </style>
    <?php
    $user = unserialize($_SESSION["user"]);
    $id_voluntario = current($user);
    ?>

    <script>
        function update(nome) {
            const div = $('#instituicoes');
            const html = nome;
            div.html(html);
        }

        function pedidoRecolha() {
            const id_voluntario = <?php echo $id_voluntario; ?>;

            $.ajax({
                type: "GET",
                url: '/volunteer/instituicoesAceites.php',
                data: {
                    id_voluntario,
                },
                success: function(resposta) {
                    var x = "";
                    for (var i = 0; i < resposta['instituicoesAceites'].length; i++) {
                        x += (resposta['instituicoesAceites'][i]['nome']);
                        if (resposta['instituicoesAceites'].length > 1) {
                            if (i != resposta['instituicoesAceites'].length - 1) {
                                x += ' e ';
                            }
                        }

                    };
                    update(x);

                }
            });

        };



        $(document).on('change', '.chkView', function() {
            $(this).closest('tr').find('.chkSelectInicio, .chkSelectFim').prop('disabled', !this.checked);
            $('.chkView').prop('required', false);
        });

        $('#password').click(function() {
            $('#first').fadeOut('fast', function() {
                $('#second').fadeIn('fast');
            });
        });

        $('#editProfile').click(function() {
            $('#second').fadeOut('fast', function() {
                $('#first').fadeIn('fast');

            });
        });

        $('#disponibilidade').click(function() {
            $('#first').fadeOut('fast', function() {
                $('#third').fadeIn('fast');

            });
        });

        $('#editProfile2').click(function() {
            $('#third').fadeOut('fast', function() {
                $('#first').fadeIn('fast');

            });
        });

        $('#editProfile2').click(function() {
            $('#third').fadeOut('fast', function() {
                $('#first').fadeIn('fast');
            });
        });

        $('#disponibilidade').click(function() {
            $('#first').fadeOut('fast', function() {
                $('#third').fadeIn('fast');
            });
        });





        $('form[name="updateVoluntario"]').validate({
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
        pedidoRecolha();
    </script>

</body>

</html>