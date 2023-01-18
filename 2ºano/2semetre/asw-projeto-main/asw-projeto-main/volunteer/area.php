<!-- TODO i18n -->
<?php
require_once __DIR__ . '/../i18n/index.php';
require_once __DIR__ . '/../volunteer/disponibilidade_voluntario.php';
require_once __DIR__ . '/../volunteer/volunteer.php';


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
   <!-- Navigation-->
   <!-- Masthead-->
   <header class="masthead3">
   </header>
   <section class="signup-section" id="signup">
      <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
         <div class="d-flex justify-content-center">
            <div class="text-center">
               <h1 class="mx-auto my-0 text-uppercase" style="color: White">Instituições:</h1>
               <br /><br />
               <div class="content">
                  <div class="row mb-3">
                     <div class="row mb-3">
                        <div class="col-4">
                           <input id="nameSearch" class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Search" onkeyup="refreshInstituicoes()" />
                        </div>
                        <div class="col-4">
                           <select id="distrito" class='form-select' onchange="refreshInstituicoes()">
                              <option value="">Distrito</option>
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
                           <select id="concelho" class='form-select' onchange="refreshInstituicoes()">
                              <option value="">Concelho</option>
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
                     <div class="col-4">
                        <select id="tipo_doacao" class='form-select' onchange="refreshInstituicoes()">
                           <option value="">
                              Tipo de doação
                           </option>
                           <option value="Longa duração">
                              Bens alimentares de longa duracao
                           </option>
                           <option value="Consumo próprio dia">
                              Consumo proprio dia
                           </option>
                        </select>
                     </div>
                     <div class="col-4">
                        <select id="tipo_instituicao" class='form-select' onchange="refreshInstituicoes()">
                           <option value="">
                              Tipo de instituição
                           </option>
                           <option value="Café">
                              Cafe
                           </option>
                           <option value="Restaurante">
                              Restaurante
                           </option>
                           <option value="Refeitório">
                              Refeitorio
                           </option>
                           <option value="Supermercado">
                              Supermercado
                           </option>
                           <option value="Distribuidor">
                              Distribuidor
                           </option>
                           <option value="Mercado de agricultores">
                              Mercado de agricultores
                           </option>
                           <option value="Cooperativa agricula">
                              Cooperativa agricula
                           </option>
                           <option value="Agricultores">
                              Agricultores
                           </option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row gutters-sm" id='instituicoes'>
                  <!-- Voluntarios injetadas aqui -->
               </div>

               <div class="row justify-content-center">
                  <div class="col-11">
                     <div id="mapInstituicoes" style="width:calc(50vw-0px);height:400px;"></div>
                  </div>
               </div>
            </div>
            </br>
         </div>
      </div>

   </section>
   <?php
   $user = unserialize($_SESSION["user"]);
   $id_voluntario = current($user);
   ?>

   <script>
      function updateInstitDiv(instits) {
         const div = $('#instituicoes');
         const html = instits.map(u =>
            `<div class='col-12 col-sm-6 col-md-4 col-xl-3 mb-3'>
                        <div class='card'>
                            <span style="background-color: cornflowerblue;width:100%;height:80px;" lt='Cover' class='card-img-top'><\/span>
                            <div class='card-body'>
                                <div class="text-center">
                                    <img src='data:image/jpeg;base64,${u.foto}' style='width:100px;height:100px;margin-top:-65px' alt='User' class='img-fluid img-thumbnail rounded-circle border-0 mb-3 avatar'>
                                    <h3 class='card-title'>${u.nome}<\/h3>
                                    <a onclick="pedidoRecolha(${u.id})" class="btn btn-primary btn-lg" id="pedido-${u.id}">Efetuar pedido de recolha</a>
                                    <br></br>
                                    <a href="chat.php?inst=${u.id}" class="btn btn-primary id="chat"><?= _("Chat") ?></a>
                                    <a href="/institution/info.php?iid=${u.id}" class="btn btn-primary id="avaliacoes"><?= _("Avaliações") ?></a>
                                    <br></br>
                                <\/div>
                                <ul class="list-unstyled ml-1">
                                    ${mapInstitArea(u)}
                                <\/ul>
                            <\/div>
                        <\/div>
            
                    <\/div>`);

         div.html(html);
      }



      function refreshInstituicoes() {
         const q = $('#nameSearch').val();
         const distrito = $('#distrito').val();
         const concelho = $('#concelho').val();
         const dia_semana = $('#dia_semana').val();
         const horas_inicio = $('#horas_inicio').val();
         const horas_fim = $('#horas_fim').val();
         const id_voluntario = <?php echo $id_voluntario; ?>;
         const tipo_instituicao = $('#tipo_instituicao').val();
         const tipo_doacao = $('#tipo_doacao').val();

         $.ajax({
            url: '/volunteer/pesquisa.php',
            data: {
               q,
               distrito,
               concelho,
               dia_semana,
               horas_inicio,
               horas_fim,
               id_voluntario,
               tipo_instituicao,
               tipo_doacao
            },
            type: 'get',
            dataType: 'json',
            success: function(resposta) { //(res) => {
               updateInstitDiv(resposta.instituicoes);
               const $mapInstituicoes = document.getElementById('mapInstituicoes');

               if (resposta.instituicoes?.length)
                  initialize($mapInstituicoes, resposta.instituicoes.map(v => [v.nome, Number(v.latitude), Number(v.longitude)]));


               const ids = [];
               x = resposta.instituicoes.map(u => u.id);
               verificaPedidos(x);
            }
         })
      }

      //
      //function pedidoRecolha(id_instituicao){
      //  const id_voluntario = <?php echo $id_voluntario; ?>;
      //console.log(id_instituicao);
      //  $.ajax({
      //    type: "GET",
      //    url: '/volunteer/aceitarRecolha.php',
      //    data: {
      //      id_voluntario,
      //      id_instituicao
      //    },
      //    success: function(resposta){
      //console.log(resposta);
      //desativar botao
      //    }
      //  });
      //}

      function pedidoRecolha(id_instituicao) {

         const id_voluntario = <?php echo $id_voluntario; ?>;

         $.ajax({
            type: "GET",
            url: '/volunteer/pedidosRecolha.php',
            data: {
               id_voluntario,
               id_instituicao
            },
            success: function(resposta) {
               //console.log(resposta);
               //desativar botao
               //document.getElementById(`pedido-${id_instituicao}`).className += " disabled";
               // document.getElementById(`pedido-${id_instituicao}`).innerHTML = 'Pedido recolha efetuado';

            }
         });
         // }
      }


      function verificaPedidos(id_instituicao) {

         $.ajax({
            type: "GET",
            url: '/volunteer/verificaPedidos.php',
            data: {
               id_instituicao
            },
            success: function(resposta) {
               for (var i = 0; i < resposta['aceite'].length; i++) {
                  // resposta['aceite'][i] = {Inst: 1}
                  // resposta['aceite'][i]['Inst'] = 1
                  document.getElementById(`pedido-${resposta['aceite'][i]['Inst']}`).className += " disabled";
                  document.getElementById(`pedido-${resposta['aceite'][i]['Inst']}`).innerHTML = 'Recolha atribuida';


               }
               // 😋😋😋😋😋😋😋😋
            }
         });
      }

      refreshInstituicoes();
   </script>

   <!-- Maps -->
   <script src="/assets/js/gmaps.js"></script>
   <script type="text/javascript">
      function initMaps() {}

      loadGmaps()
   </script>
</body>

</html>