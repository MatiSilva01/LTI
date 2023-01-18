<?php
require_once "../i18n/index.php";
session_start();

// Force auth
if (!isset($_SESSION["user"])) {
    header("Location: /");
} else {
    require_once __DIR__ . '/../institution/institution.php';
    $user = unserialize($_SESSION["user"]);

    if (!($user instanceof Instituicao)) {
        header("Location: /user/profile.php");
    }
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once __DIR__ . '/../components/head.php' ?>
    <link href="/assets/css/login.css" rel="stylesheet" />
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
                                    </div> <!-- Fim do card-header -->
                                    <div class="card-body">
                                        <form name="updateInstituicao" action="update.php" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6 pr-md-1">
                                                    <div class="form-group"></div>
                                                    <label for="nomeInstituicao"><?= _("Nome") ?></label>
                                                    <input name="nomeInstituicao" id="nomeInstituicao" type="text" class="form-control" placeholder="<?= _("Insira nome") ?>" value="<?= $user->nome ?>">
                                                </div>
                                                <div class="col-md-6 pl-md-1">
                                                    <div class="form-group">
                                                        <label for="emailInstituicao"><?= _("Email") ?></label>
                                                        <input name="emailInstituicao" id="emailInstituicao" type="email" class="form-control" placeholder="<?= _("Insira email") ?>" value="<?= $user->email ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 pl-md-1">
                                                    <div class="form-group">
                                                        <label for="fotoInstituicao"><?= _("Imagem de Perfil") ?></label>
                                                        <input type="file" class="form-control" id="fotoInstituicao" name="fotoInstituicao" accept="image/jpeg">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pl-md-1">
                                                    <div class="form-group">
                                                        <label for="tipoInstituicao"><?= _("Tipo da instituição") ?></label>
                                                        <select name="tipoInstituicao" class="form-control" id="tipoInstituicao">
                                                            <option value=""><?= _("Seleccionar Tipo") ?></option>
                                                            <?php
                                                            foreach ($validTipos as $tipo) {
                                                                echo "<option value='$tipo'";


                                                                if ($user->tipo == $tipo) {
                                                                    echo " selected";
                                                                }

                                                                echo ">" . _($tipo) . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 pr-md-1">
                                                    <div class="form-group">
                                                        <label for="telefoneInstituicao"><?= _("Telefone do contacto") ?></label>
                                                        <input id="telefoneInstituicao" name="telefoneInstituicao" type="text" class="form-control" placeholder="<?= _("Insira o telefone da instituição") ?>" value="<?= $user->telefone ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pr-md-1">
                                                    <div class="form-group">
                                                        <label for="moradaInstituicao"><?= _("Morada") ?></label>
                                                        <input name="moradaInstituicao" id="moradaInstituicao" type="text" class="form-control" placeholder="<?= _("Insira a morada da instituição") ?>" value="<?= $user->morada ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 pr-md-1">
                                                    <div class="form-group">
                                                        <label><?= _("Nome do contacto") ?></label>
                                                        <input id="nomeContactoInstituicao" name="nomeContactoInstituicao" type="text" class="form-control" placeholder="<?= _("Insira o nome do contacto") ?>" value="<?= $user->contacto ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pr-md-1">
                                                    <div class="form-group"></div>
                                                    <label><?= _("Telefone do contacto") ?></label>
                                                    <input name="telefoneContactoInstituicao" id="telefoneContactoInstituicao" type="text" class="form-control" placeholder="<?= _("Insira o telefone da instituição") ?>" value="<?= $user->telefone_contacto ?>">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 pr-md-1">
                                                    <div class="form-group">
                                                        <label for="distritoInstituicao"><?= _("Distrito") ?></label>

                                                        <select name="distritoInstituicao" class="form-control" id="distritoInstituicao" aria-describedby="distritoVoluntarioLabel">
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

                                                <div class="col-md-6 pr-md-1">
                                                    <div class="form-group">
                                                        <label for="concelhoInstituicao"><?= _("Concelho") ?></label>

                                                        <select name="concelhoInstituicao" class="form-control" id="concelhoInstituicao" aria-describedby="concelhoVoluntarioLabel">
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
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6 pr-md-1">
                                                    <div class="form-group">
                                                        <label for="freguesiaInstituicao"><?= _("Freguesia") ?></label>

                                                        <select name="freguesiaInstituicao" class="form-control" id="freguesiaInstituicao" aria-describedby="freguesiaVoluntarioLabel">
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

                                                <div class="col-md-6 pr-md-1">
                                                    <div class="form-group">
                                                        <label for="descricaoInstituicao"><?= _("Descrição da instituição") ?></label>
                                                        <textarea class="form-control" name="descricaoInstituicao" id="descricaoInstituicao" rows="1"><?= $user->descricao ?></textarea>
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
                                            <br>
                                            <div class="form-group">
                                                <p class="text-center"><a href="#" id="password"><?= _("Alterar Password") ?></a></p>
                                            </div>
                                            <div class="form-group">
                                                <p class="text-center"><a href="#" id="disponibilidade"><?= _("Editar preferências") ?></a></p>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-fill btn-primary"><?= _("Salvar") ?></button>
                                            </div>
                                        </form>
                                    </div> <!-- Fim do card-body -->
                                </div> <!-- Fim do card -->
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

                                            echo "<img src='data:image/jpeg;base64,$user->foto' class='rounded-circle img-thumbnail' alt='Avatar' loading='lazy' />";
                                            echo "<p class='lead'>{$user->nome}</p>";
                                            ?>
                                        </div>
                                        </p>
                                        <div class="card-description">
                                            <?= _("Instituição na REFOOD!") ?>
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
                                <label for="passwordInstituicao"><?= _("Password") ?></label>
                                <input type="password" name="passwordInstituicao" id="passwordInstituicao" class="form-control" aria-describedby="passwordInstituicao">
                            </div>
                            <div class="form-group">
                                <label for="confirmPasswordInstituicao"><?= _("Repita a Password") ?></label>
                                <input type="password" name="confirmPasswordInstituicao" id="confirmPasswordInstituicao" class="form-control" aria-describedby="confirmPasswordInstituicao">
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

                <div id="third" class="col-md-7 mx-auto" style="border-collapse: collapse; margin-top:4em">
                    <div class="myform form">
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center" style="border-collapse: collapse; margin-left:7.5em">
                                <h2><?= _("Disponibilidade da instituição") ?></h2>
                            </div>
                        </div>
                        <form name="availability" id="disponibilidadeDias" action="createDisponibilidade.php" method='POST' enctype="multipart/form-data">
                            <table cellspacing="0" rules="all" id="Table1" style="border-collapse: collapse; margin-left:7.5em">
                                <tr>
                                    <th>&nbsp;</th>
                                    <th style="width:80px"><?= _("Dia da semana") ?></th>
                                    <th style="width:120px"><?= _("Inicio da recolha") ?></th>
                                    <th style="width:120px"><?= _("Fim da recolha") ?></th>
                                </tr>
                                <tr>
                                    <td style="width:120px"><input name="dia" value="Segunda" class="chkViewDias" type="checkbox" required /></td>
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
                                    <td><input name="dia" value="Terca" class="chkViewDias" type="checkbox" required /></td>
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
                                    <td><input name="dia" value="Quarta" id="testeClick" class="chkViewDias" type="checkbox" required /></td>
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
                                    <td><input name="dia" value="Quinta" class="chkViewDias" type="checkbox" required /></td>
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
                                    <td><input name="dia" value="Sexta" class="chkViewDias" type="checkbox" required /></td>
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
                            <div class="col-md-12 text-center" style="border-collapse: collapse; margin-left:7.5em">
                                <h2><?= _("Doacoes") ?></h2>
                            </div>
                            <table cellspacing="0" rules="all" id="TabelaDoacoes" style="border-collapse: collapse; margin-left:3em;">
                                <tr>
                                    <th>&nbsp;</th>
                                    <th style="width:120px"><?= _("Nome das comidas") ?></th>
                                    <th style="width:400px"><?= _("Quantidade expectavel de doacoes (Unidades)") ?></th>
                                </tr>
                                <tr>
                                    <td style="width:120px"><input name="nomes[]" value="Massa" class="chkViewAlimentos" type="checkbox" /></td>
                                    <td style="width:120px"><?= _("Massa") ?></td>
                                    <td>
                                        <input type="number" name="quantidades[]" class="form-control" id="quantidadeExpectavel" aria-describedby="quantidadeExpectavelLabel" disabled required placeholder="<?= _("Insira uma quantidade") ?>">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input name="nomes[]" value="Arroz" class="chkViewAlimentos" type="checkbox" /></td>
                                    <td><?= _("Arroz") ?></td>
                                    <td>
                                        <input type="number" name="quantidades[]" class="form-control" id="quantidadeExpectavel" aria-describedby="quantidadeExpectavelLabel" disabled required placeholder="<?= _("Insira uma quantidade") ?>">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input name="nomes[]" value="Feijao" id="testeClick" class="chkViewAlimentos" type="checkbox" /></td>
                                    <td><?= _("Feijão") ?></td>
                                    <td>
                                        <input type="number" name="quantidades[]" class="form-control" id="quantidadeExpectavel" aria-describedby="quantidadeExpectavelLabel" disabled required placeholder="<?= _("Insira uma quantidade") ?>">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input name="nomes[]" value="Carne" class="chkViewAlimentos" type="checkbox" /></td>
                                    <td><?= _("Carne") ?></td>
                                    <td>
                                        <input type="number" name="quantidades[]" class="form-control" id="quantidadeExpectavel" aria-describedby="quantidadeExpectavelLabel" disabled required placeholder="<?= _("Insira uma quantidade") ?>">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input name="nomes[]" value="Peixe" class="chkViewAlimentos" type="checkbox" /></td>
                                    <td><?= _("Peixe") ?></td>
                                    <td>
                                        <input type="number" name="quantidades[]" class="form-control" id="quantidadeExpectavel" aria-describedby="quantidadeExpectavelLabel" disabled required placeholder="<?= _("Insira uma quantidade") ?>">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input name="nomes[]" value="Fruta" class="chkViewAlimentos" type="checkbox" /></td>
                                    <td><?= _("Fruta") ?></td>
                                    <td>
                                        <input type="number" name="quantidades[]" class="form-control" id="quantidadeExpectavel" aria-describedby="quantidadeExpectavelLabel" disabled required placeholder="<?= _("Insira uma quantidade") ?>">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div class="row">
                                <div class="col-md-6 pl-md-1" style="margin-left:11.5em">
                                    <div class="form-group">
                                        <label for="tipoDoacoes"><?= _("Tipos de Doacoes") ?></label>
                                        <select name="tipoDoacoes" class="form-control" id="tipoDoacoes" required>
                                            <option value=""><?= _("Seleccionar tipos") ?></option>
                                            <?php
                                            foreach ($validTiposDoacoes as $tipo) {
                                                echo "<option value='$tipo'";


                                                if ($user->tipo == $tipo) {
                                                    echo " selected";
                                                }

                                                echo ">" . _($tipo) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- nome da doaçao -->
                            </div>
                            <!-- <div class="row">
                            <div class="col-md-6 pl-md-1" style="margin-left:11.5em">
                                <div class="form-group">
                                    <label for="quantidadeExpectavelLabel"><?= _("Quantidade expectável de doacoes (Unidades)") ?></label>
                                    <input type="number" name="quantidadeExpectavel" class="form-control" id="quantidadeExpectavel" aria-describedby="quantidadeExpectavelLabel" placeholder="<?= _("Insira uma quantidade") ?>">
                                </div>
                            </div>
                        </div> -->
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
                                    <a href="#" id="editProfile2">
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

    <script>
        $(document).on('change', '.chkViewDias', function() {
            $(this).closest('tr').find('.chkSelectInicio, .chkSelectFim, .form-control').prop('disabled', !this.checked);
        });

        $(document).on('change', '.chkViewAlimentos', function() {
            $(this).closest('tr').find('.form-control').prop('disabled', !this.checked);
        });

        if ($('.chkViewDias').is(':checked')) {
            $(".chkViewDias").not(this).prop("disabled", this.checked);
            $(".chkViewDias").not(this).prop("required", false);
        }

        // $('#disponibilidadeDias').submit(function(){
        //     if(!$('#disponibilidadeDias input[type="checkbox"]').is(':checked')){
        //         $(".chkViewDias").not(this).prop("disabled", true);
        //         return false;
        //     }
        // });

        $(".chkViewDias").click(function() {
            $(".chkViewDias").not(this).prop("disabled", this.checked);
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

        $('form[name="updateInstituicao"]').validate({
            rules: {
                nomeInstituicao: {
                    required: true,
                    minlength: 5
                },
                emailInstituicao: {
                    required: true,
                    email: true
                },
                moradaInstituicao: 'required',
                nomeContactoInstituicao: 'required',
                telefoneContactoInstituicao: 'required',
                descricaoInstituicao: 'required',
                tipoInstituicao: 'required',
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
                moradaInstituicao: "<?= _("Por favor insira uma morada") ?>",
                nomeContactoInstituicao: "<?= _("Por favor insira um nome de contacto") ?>",
                telefoneContactoInstituicao: "<?= _("Por favor insira o número de telefone de contacto") ?>",
                descricaoInstituicao: "<?= _("Por favor insira uma descrição") ?>",
                tipoInstituicao: "<?= _("Por favor seleccione um tipo") ?>",
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

            submitHandler: function(form) {
                form.submit();
            }
        });
    </script>
</body>

</html>