<?php
require_once __DIR__ . '/../institution/disponibilidadeDoacao.php';
require_once __DIR__ . '/../i18n/index.php';
?>
<!--
    Código da cor do logo: #0c4ca2
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once __DIR__ . '/../components/head.php'; ?>
  <script src="/assets/js/maps.js"></script>
</head>

<body id="page-top">
  <!-- Navigation-->
  <?php include '../components/navbar.php' ?>

  <!-- Masthead-->
  <header class="masthead3">
  </header>
  <section class="signup-section" id="signup">
    <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
      <div class="d-flex justify-content-center">
        <div class="text-center">

          <h1 class="mx-auto my-0 text-uppercase" style="color: White"><?= _("Voluntários") ?>:</h1><br /><br />

          <div class="content">
            <div class="row mb-3">
              <div class="row mb-3">
                <div class="col-4">
                  <input id="nameSearch" class="form-control mr-sm-2" type="search" placeholder="<?= _("Pesquisar") ?>" aria-label="Search" onkeyup="refreshVols()">

                </div>
                <div class="col-4">
                  <select id="distrito" class='form-select' onchange="refreshVols()">
                    <option value=""><?= _("Distrito") ?></option>

                    <?php
                    $raw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/assets/js/datasets/distritos-metadata.json');

                    $distritos = json_decode($raw)->d;

                    foreach ($distritos as $distrito) {
                      echo "<option value='$distrito->Designacao'>$distrito->Designacao</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="col-4">
                  <select id="concelho" class='form-select' onchange="refreshVols()">
                    <option value=""><?= _("Concelho") ?></option>

                    <?php
                    $raw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/assets/js/datasets/concelhos-metadata.json');

                    $concelhos = json_decode($raw)->d;

                    foreach ($concelhos as $concelho) {
                      echo "<option value='$concelho->designacao'>$concelho->designacao</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

            </div>




            <div class="row gutters-sm" id="voluntarios">
              <!-- Voluntarios injetadas aqui -->
            </div>
            <h1 class="mx-auto my-0 text-uppercase" style="color: White"><?= _("Pedidos de recolha por aceitar") ?>:</h1><br /><br />

            <div class="row gutters-sm" id="pedidos">
              <!-- voluntarios recolha injetadas aqui -->
            </div>

            <div class="row justify-content-center">
              <div class="col-11">
                <div id="mapVoluntarios" style="width:calc(50vw-0px);height:400px;"></div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <!--<element onclick="aceitaRecolha(7)" class="btn btn-primary">AQUI1</element>-->

  </section>

  <!-- About-->

  <?php
  $user = unserialize($_SESSION["user"]);
  $id_instituicao = $user->id;
  ?>
  <script>
    function updateVolsDiv(users) {
      const div = $('#voluntarios');

      //console.log(users);

      const html = users.map(u =>
        `<div class='col-12 col-sm-6 col-md-4 col-xl-3 mb-3'>
                    <div class='card'>
                        <span style="background-color: cornflowerblue;width:100%;height:80px;" lt='Cover' class='card-img-top'></span>
                        <div class='card-body'>
                            <div class="text-center">
                                <img src='data:image/jpeg;base64,${u.foto}' style='width:100px;height:100px;margin-top:-65px' alt='User' class='img-fluid img-thumbnail rounded-circle border-0 mb-3 avatar'>
                                <h3 class='card-title'>${u.nome}</h3>
                            </div>
                            <br></br>
                            <a href="chat.php?vol=${u.id}" class="btn btn-primary id="chat"><?= _("Chat") ?></a>
                            <a href="/volunteer/info.php?vid=${u.id}" class="btn btn-primary id="avaliacoes"><?= _("Avaliações") ?></a>
                            <br></br>
                            <ul class="list-unstyled ml-1">
                                ${mapVol(u)}
                            </ul>
                        </div>
                    </div>
                </div>`);

      div.html(html);
    }

    function pedidos(users) {
      const div = $('#pedidos');

      const html = users.map(u =>
        `<div class='col-12 col-sm-6 col-md-4 col-xl-3 mb-3'>
                    <div class='card'>
                        <span style="background-color: cornflowerblue;width:100%;height:80px;" lt='Cover' class='card-img-top'></span>
                        <div class='card-body'>
                            <div class="text-center">
                                <img src='data:image/jpeg;base64,${u.foto}' style='width:100px;height:100px;margin-top:-65px' alt='User' class='img-fluid img-thumbnail rounded-circle border-0 mb-3 avatar'>
                                
                                <h3 class='card-title'>${u.nome}</h3>

                            </div>
                            <element id="pedido-${u.Volt}" onclick="aceitaRecolha(${u.Volt})" class="btn btn-primary" >Aceitar recolha</element>
                           
                        </div>
                    </div>
                </div>`);

      div.html(html);
    }

    function refreshVols() {
      //enableElements();
      const q = $('#nameSearch').val();
      const distrito = $('#distrito').val();
      const concelho = $('#concelho').val();
      const dia_semana = $('#dia_semana').val();
      const horas_inicio = $('#horas_inicio').val();
      const horas_fim = $('#horas_fim').val();
      const id_instituicao = <?= $id_instituicao; ?>;
      $.ajax({
        url: '/institution/pesquisa.php',
        data: {
          q,
          distrito,
          concelho,
          dia_semana,
          horas_inicio,
          horas_fim,
          id_instituicao
        },

        type: 'get',
        dataType: 'json',
        success: function(resposta) {
          updateVolsDiv(resposta.voluntarios);
          const $mapVoluntarios = document.getElementById('mapVoluntarios');

          if (resposta.voluntarios?.length)
            initialize($mapVoluntarios, resposta.voluntarios.map(v => [v.nome, Number(v.latitude), Number(v.longitude)]));
        },


      })

    }

    function aceitaRecolha(id_voluntario) {
      const id_instituicao = <?= $id_instituicao; ?>;
      //console.log(id_instituicao);
      $.ajax({
        type: "GET",
        url: '/institution/aceitaRecolha.php',
        data: {
          id_voluntario,
          id_instituicao
        },
        success: function(resposta) {
          //console.log(resposta);
          //alert(resposta['pedidos']);

          document.getElementById(`pedido-${resposta['pedidos']}`).className += " disabled";
          document.getElementById(`pedido-${resposta['pedidos']}`).innerHTML = 'Recolha aceite';

          //pedidos(resposta.pedidos);
          //console.log(resposta);
          //desativar botao
        }
      });
    }

    function mostraPedidos() {
      const id_instituicao = <?= $id_instituicao; ?>;
      //console.log(id_instituicao);
      $.ajax({
        type: "GET",
        url: '/institution/mostraPedidos.php',
        data: {
          id_instituicao
        },
        success: function(resposta) {
          pedidos(resposta.pedidos);
          //console.log(resposta);
          //desativar botao
        }
      });

    }

    mostraPedidos();
    //aceitaRecolha();
    refreshVols();
  </script>

  <!-- Maps -->
  <script src="/assets/js/gmaps.js"></script>
  <script type="text/javascript">
    function initMaps() {}

    loadGmaps()
  </script>
</body>

</html>