<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
require_once __DIR__ . '/../i18n/index.php';
require_once __DIR__ . '/../volunteer/disponibilidade_voluntario.php';
require_once __DIR__ . '/../volunteer/volunteer.php';
require_once __DIR__ . '/../institution/institution.php';
require_once __DIR__ . '/../volunteer/mensagemVolu.php';

date_default_timezone_set("Europe/Lisbon");

$id_voluntario = $_GET["vol"];

session_start();

$user = unserialize($_SESSION["user"]);
$id_instituicao = current($user);

$info = Voluntario::getOne($id_voluntario);

$id = $info->id;
$nome = $info->nome;
$foto = $info->foto;

$updateChat = MensagemVoluntario::selectChat($id_instituicao, $id)
?>
<!--
    Código da cor do logo: #0c4ca2
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once __DIR__ . '/../components/head.php'; ?>
    <script src="/assets/js/maps.js"></script>
    <style>
        .vh-100 {
            min-height: 100vh;
        }

        .w-400 {
            width: 400px;
        }

        .fs-xs {
            font-size: 1rem;
        }

        .w-10 {
            width: 10%;
        }

        a {
            text-decoration: none;
        }

        .fs-big {
            font-size: 5rem !important;
        }

        .online {
            width: 10px;
            height: 10px;
            background: green;
            border-radius: 50%;
        }

        .w-15 {
            width: 15%;
        }

        .fs-sm {
            font-size: 1.4rem;
        }

        .btn {
            text-align: center;
            margin-top: 10px;
            margin-left: 3.5em;
        }

        small {
            color: #bbb;
            font-size: 0.8rem;
            text-align: right;
        }

        .chat-box {
            overflow-y: auto;
            max-height: 50vh;
        }

        .rtext {
            margin-left: auto;
            margin-right: 0;
            text-align: left;
            width: 65%;
            background: #3289c8;
            color: #fff;
        }

        .ltext {
            margin-left: 0;
            margin-right: auto;
            width: 65%;
            text-align: left;
            background: #f8f9fa;
            color: #444;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <!-- Navigation-->
    <header>
        <div class="chat-popup" id="myForm" style='max-width: 400px; min-height:800px; padding: 10px;background-color: white;display:block;bottom:30px;right:30px;border:3px solid #f1f1f1; z-index: 9;'>
            <h3 style='margin-top:10px; text-align: center;'>Chat</h3>
            <hr>
            <div class="d-flex align-items-center" style='margin-right:250px;'>
                <img src='data:image/jpeg;base64,<?= $foto ?>' style='width:50px;height:50px;' alt='User' class='img-fluid img-thumbnail rounded-circle border-0 mb-3 avatar'>
                <h3 class="cart-title"><?= $nome ?>
                    <br>
                    <div class="d-flex align-items-center" title="online">
                        <span style='color: green;'>●</span>
                        <small> Online</small>
                    </div>
                </h3>
            </div>
            <div id="chatbox" style="min-height:500px;" class="shadow p-4 rounded d-flex flex-column mt-2 chat-box">
                <?php if (!empty($updateChat)) {
                    $time = time();
                    foreach ($updateChat as $row) {
                        $mensagem = $row['mensagem'];
                        $tempo = $row['created_at'];
                        if ($row['sender_volunteer'] == 0) {
                            ?><p class="rtext border rounded p-2 mb-1"><?= $mensagem ?>
                            <small class="d-block"><?php echo date("d-M-Y, H:i", $tempo) ?></small>
                            </p><?php
                        }
                        if ($row['sender_volunteer'] == 1) {
                            ?><p class="ltext border rounded p-2 mb-1"><?= $mensagem ?>
                            <small class="d-block"><?php echo date("d-M-Y, H:i", $tempo) ?></small>
                            </p><?php
                        }
                    }
                                ?>
                <?php  } else { ?>
                    <div class="alert alert-secondary text-center" role="alert">
                        <i class="far fa-comment-dots d-block fs-big" style="margin-left:100px;"></i>
                        Ainda não existem mensagens, inicie uma conversa!
                    </div>
                <?php
                }
                ?>


            </div>
            <br>
            <div class="input-group flex-nowrap">
                <textarea id="message" cols="3" rows="1.5" class="form-control" name="msg" placeholder='Digite a mensagem...'></textarea>
            </div>
            <button id="submit" type="submit" class="btn">Send</button>
            <a type="button" class="btn cancel" href="area.php">Close</a>
        </div>
    </header>
    <script scr="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script>
        var scrollDown = function() {
            let chatBox = document.getElementById('chatbox');
            chatbox.scrollTop = chatbox.scrollHeight;
        }

        scrollDown();

        $(document).ready(function() {

            $("#submit").on('click', function() {
                mensagem = $("#message").val();
                if (mensagem == "") return;

                $.post("insertMessage.php", {
                        idVol: <?= $id ?>,
                        mensagem: mensagem
                    },
                    function(dados, status) {
                        $("#message").val("");
                        scrollDown();
                    });
            });
            let fetchData = function(){
                $.get("loopMensagensInst.php",
                    {
                        idVol: <?= $id ?>,
                    },
                    function(dados, status) {
                        $("#chatbox").append(dados);
                        if (dados != "") scrolldown;
                    });
            }
            fetchData();
            setInterval(fetchData, 500);
        });
    </script>
</body>