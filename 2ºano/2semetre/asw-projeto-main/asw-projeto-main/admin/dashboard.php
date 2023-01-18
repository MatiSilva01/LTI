<?php
require_once "../i18n/index.php";
require_once __DIR__ . '/../volunteer/volunteer.php';
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
          <li>
            <a href="/admin">
              <i class="tim-icons icon-bank"></i>
              <p>Início</p>
            </a>
          </li>
          <li class="active">
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
        <h2 class="card-title text-center">Dashboard</h2>

        <div class="col">
          <input id="search" class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Search" onkeyup="refreshVols()" />
        </div>

        <h2>Voluntários</h2>
        <div class="row gutters-sm" id="voluntarios">
          <!-- Voluntarios injetados aqui -->
        </div>

        <h2>Instituições</h2>
        <div class="row gutters-sm" id="instituicoes">
          <!-- Instituicoes injetadas aqui -->
        </div>

      </div>

      <!--   Core JS Files   -->
      <script>
        function updateInstitDiv(instits) {
          const div = $('#instituicoes');

          const html = instits.map(u =>
            `<div class='col-12 col-sm-6 col-md-4 col-xl-3 mb-3'>
                    <div class='card'>
                        <span style="background-color: cornflowerblue;width:100%;height:80px;" lt='Cover' class='card-img-top'></span>
                        <div class='card-body'>
                            <div class="text-center">
                                <img src='data:image/jpeg;base64,${u.foto}' style='width:100px;height:100px;margin-top:-65px' alt='User' class='img-fluid img-thumbnail rounded-circle border-0 mb-3 avatar'>
                                <h3 class='card-title text-body'>${u.nome}</h3>
                            </div>
                            <ul class="list-unstyled ml-1">
                                ${mapInstit(u)}
                            </ul>
                        </div>
                        <div class='card-footer'>
                            <a class='btn btn-secondary has-icon btn-block' href="/admin/matches.php?iid=${u.id}">
                                Matches
                            </a>
                        </div>
                    </div>
                </div>`);

          div.html(html);
        }

        function refreshInstituicoes() {
          const pesquisa = $('#search').val();

          if (!pesquisa) {
            updateInstitDiv([])
          } else {
            $.ajax({
              url: '/admin/api/dashboard.php',
              data: {
                pesquisa
              },
              type: 'get',
              dataType: 'json',
              success: (res) => {
                updateInstitDiv(res.instituicoes);
              }
            })
          }
        }

        function updateVolsDiv(users) {
          const div = $('#voluntarios');

          const html = users.map(u =>
            `<div class='col-12 col-sm-6 col-md-4 col-xl-3 mb-3'>
                    <div class='card'>
                        <span style="background-color: cornflowerblue;width:100%;height:80px;" lt='Cover' class='card-img-top'></span>
                        <div class='card-body'>
                            <div class="text-center">
                                <img src='data:image/jpeg;base64,${u.foto}' style='width:100px;height:100px;margin-top:-65px' alt='User' class='img-fluid img-thumbnail rounded-circle border-0 mb-3 avatar'>
                                <h3 class='card-title text-body'>${u.nome}</h3>
                            </div>
                            <ul class="list-unstyled ml-1">
                                ${mapVol(u)}
                            </ul>
                        </div>
                        <div class='card-footer'>
                            <a class='btn btn-secondary has-icon btn-block' href="/admin/matches.php?vid=${u.id}">
                                Matches
                            </a>
                        </div>
                    </div>
                </div>`);

          div.html(html);
        }

        function refreshVols() {
          const pesquisa = $('#search').val();
          refreshInstituicoes();

          if (!pesquisa) {
            updateVolsDiv([])
          } else {
            $.ajax({
              url: '/admin/api/dashboard.php',
              data: {
                pesquisa
              },
              type: 'get',
              dataType: 'json',
              success: (res) => {
                updateVolsDiv(res.voluntarios)
              }
            })
          }
        }
      </script>
</body>

</html>