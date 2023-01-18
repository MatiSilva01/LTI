<?php
require_once "../i18n/index.php";
require_once __DIR__ . '/../institution/institution.php';
require_once __DIR__ . '/../volunteer/volunteer.php';
require_once __DIR__ . '/../db/stats.php'
?>
<!--
=========================================================
* * Black Dashboard - v1.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/black-dashboard
* Copyright 2019 Creative Tim (https://www.creative-tim.com)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/x-icon" href="./assets/img/logo_small.png" />
    <title>
        Admin
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="./assets/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
    <link href="/assets/css/lib/bootstrap.min.css" rel="stylesheet" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <script src="./assets/js/lib/chart.min.js"></script>

    <script src="/assets/js/lib/jquery.min.js"></script>
    <script src="/assets/js/lib/bootstrap.min.js"></script>
    <script src="/assets/js/maps.js"></script>
</head>

<body class="">
    <div class="wrapper">
        <div class="sidebar">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="/admin" class="simple-text logo-normal">
                        Admin
                    </a>
                </div>
                <ul class="nav">
                    <li class="active">
                        <a href="/admin">
                            <i class="tim-icons icon-bank"></i>
                            <p>Início</p>
                        </a>
                    </li>
                    <li>
                        <a href="./dashboard.php">
                            <i class="tim-icons icon-bullet-list-67"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="./voluntarios.php">
                            <i class="tim-icons icon-single-02"></i>
                            <p>Voluntários</p>
                        </a>
                    </li>
                    <li>
                        <a href="./instituicoes.php">
                            <i class="tim-icons icon-puzzle-10"></i>
                            <p>Instituições</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle d-inline">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <br />
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
            </nav>
            <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="tim-icons icon-simple-remove"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Navbar -->

            <div class="content">
                <h2 class="card-title text-center">Admin Refood FCUL</h2>

                <div class="row justify-content-center mt-5">
                    <?php
                    $voluntariosStats = Stats::getStatsVoluntarios();
                    $voluntariosStatsCount = array_sum(array_column($voluntariosStats, 'count'));

                    $instituicoes = Stats::getStatsInstituicoes();
                    $instituicoesCount = array_sum(array_column($instituicoes, 'count'));

                    $mensagens = Stats::getStatsMensagens();
                    $mensagensCount = array_sum(array_column($mensagens, 'count'));

                    // $mensagens = Stats::getStatsMensagens();
                    ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Voluntários</h5>
                                        <span class="h2 font-weight-bold mb-0"><?= $voluntariosStatsCount ?></span>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <?php
                                    $last = end($voluntariosStats);
                                    $count = $last['count'];
                                    $before = prev($voluntariosStats);
                                    $countBefore = $before['count'];

                                    $diff = $count - ($countBefore ?? 0);

                                    if ($diff > 0) {
                                        echo "<span class='text-success'><i class='fa fa-arrow-up'></i> " . $diff . "</span>";
                                    } else if ($diff < 0) {
                                        echo "<span class='text-danger'><i class='fa fa-arrow-down'></i> " . $diff . "</span>";
                                    } else {
                                        echo "<span class='text-warning'>" . $diff . "</span>";
                                    }
                                    ?>
                                    <span class="text-nowrap">diferença último mês (<?= $before["created_at_month"] . "-" . $before["created_at_year"] ?>)</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Instituições</h5>
                                        <span class="h2 font-weight-bold mb-0"><?= $instituicoesCount ?></span>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <?php
                                    $last = end($instituicoes);
                                    $count = $last['count'];
                                    $before = prev($instituicoes);
                                    $countBefore = $before['count'];

                                    $diff = $count - ($countBefore ?? 0);

                                    if ($diff > 0) {
                                        echo "<span class='text-success'><i class='fa fa-arrow-up'></i> " . $diff . "</span>";
                                    } else if ($diff < 0) {
                                        echo "<span class='text-danger'><i class='fa fa-arrow-down'></i> " . $diff . "</span>";
                                    } else {
                                        echo "<span class='text-warning'>" . $diff . "</span>";
                                    }
                                    ?>
                                    <span class="text-nowrap">diferença último mês (<?= $before["created_at_month"] . "-" . $before["created_at_year"] ?>)</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Mensagens</h5>
                                        <span class="h2 font-weight-bold mb-0"><?= $mensagensCount ?></span>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <?php
                                    $last = end($mensagens);
                                    $count = $last['count'];
                                    $before = prev($mensagens);
                                    $countBefore = $before['count'];

                                    $diff = $count - ($countBefore ?? 0);

                                    if ($diff > 0) {
                                        echo "<span class='text-success'><i class='fa fa-arrow-up'></i> " . $diff . "</span>";
                                    } else if ($diff < 0) {
                                        echo "<span class='text-danger'><i class='fa fa-arrow-down'></i> " . $diff . "</span>";
                                    } else {
                                        echo "<span class='text-warning'>" . $diff . "</span>";
                                    }
                                    ?>
                                    <span class="text-nowrap">diferença último dia (<?= $before["created_at_day"] . "-" . $before["created_at_month"] . "-" . $before["created_at_year"] ?>)</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-5">
                    <div class="col-xl-4 col-md-6">
                        <canvas id="chartVoluntarios"></canvas>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <canvas id="chartInstituicoes"></canvas>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <canvas id="chartMensagens"></canvas>
                    </div>
                </div>

                <div class="row justify-content-center mt-5 gy-2">
                    <div class="col-xl-5 col-md-6">
                        <h5>Voluntários</h5>
                        <div id="mapVoluntarios" style="width:calc(50vw-0px);height:400px;"></div>
                    </div>
                    <div class="col-xl-5 col-md-6">
                        <h5>Instituições</h5>
                        <div id="mapInstituicoes" style="width:calc(50vw-0px);height:400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <script>
        const ctxVoluntarios = document.getElementById('chartVoluntarios').getContext('2d');
        const chartVoluntarios = new Chart(ctxVoluntarios, {
            type: 'line',
            data: {
                labels: [<?= "'" . implode("', '", array_map(function ($vol) {
                                return $vol['created_at_month'] . '-' . $vol['created_at_year'];
                            }, $voluntariosStats)) . "'" ?>],
                datasets: [{
                    label: 'qtd de voluntários',
                    data: [<?= implode(',', array_column($voluntariosStats, 'count')) ?>],
                    backgroundColor: 'rgba(255, 99, 132, 1)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Voluntários por mês'
                    }
                }
            }
        });

        const ctxInstituicoes = document.getElementById('chartInstituicoes').getContext('2d');
        const chartInstituicoes = new Chart(ctxInstituicoes, {
            type: 'line',
            data: {
                labels: [<?= "'" . implode("', '", array_map(function ($inst) {
                                return $inst['created_at_month'] . '-' . $inst['created_at_year'];
                            }, $instituicoes)) . "'" ?>],
                datasets: [{
                    label: 'qtd instituições',
                    data: [<?= implode(',', array_column($instituicoes, 'count')) ?>],
                    backgroundColor: 'rgba(255, 99, 132, 1)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Instituições por mês'
                    }
                }
            }
        });

        const ctxMensagens = document.getElementById('chartMensagens').getContext('2d');
        const chartMensagens = new Chart(ctxMensagens, {
            type: 'line',
            data: {
                labels: [<?= "'" . implode("', '", array_map(function ($msg) {
                                return $msg['created_at_day'] . '-' . $msg['created_at_month'] . '-' . $msg['created_at_year'];
                            }, $mensagens)) . "'" ?>],
                datasets: [{
                    label: 'qtd mensagens',
                    data: [<?= implode(',', array_column($mensagens, 'count')) ?>],
                    backgroundColor: 'rgba(255, 99, 132, 1)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Mensagens por dia'
                    }
                }
            }
        });
    </script>

    <!-- Maps -->
    <script src="/assets/js/gmaps.js"></script>
    <script type="text/javascript">
        function initMaps() {
            const $mapVoluntarios = document.getElementById('mapVoluntarios');
            const $mapInstituicoes = document.getElementById('mapInstituicoes');

            initialize($mapVoluntarios, [<?php
                                            $vols = iterator_to_array(Voluntario::findAll(['latitude IS NOT NULL', 'longitude IS NOT NULL']));
                                            echo implode(',', array_map(function ($vol) {
                                                return "['$vol->nome', $vol->latitude, $vol->longitude]";
                                            }, $vols));
                                            ?>]);

            initialize($mapInstituicoes, [<?php
                                            $instits = iterator_to_array(Instituicao::findAll(['latitude IS NOT NULL', 'longitude IS NOT NULL']));
                                            echo implode(',', array_map(function ($instit) {
                                                return "['$instit->nome', $instit->latitude, $instit->longitude]";
                                            }, $instits));
                                            ?>])
        }

        loadGmaps()
    </script>
</body>

</html>