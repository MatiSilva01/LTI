<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../volunteer/volunteer.php';
require_once __DIR__ . '/../volunteer/mensagemVolu.php';

session_start();

$user = unserialize($_SESSION["user"]);

date_default_timezone_set("Europe/Lisbon");

if (isset($_REQUEST["idInst"]))
    
    $idInst = $_REQUEST["idInst"];
    $idVol = $user->id;

    $selmsg = MensagemVoluntario::selectChat($idInst, $idVol);
    
    foreach($selmsg as $chat) {
        if($chat["opened"] == 0) {
            $opened = 1;
            $idChat = $chat["id"];
            if($chat["sender_volunteer"] == 1) {
                $updOpen = MensagemVoluntario::updateOpen($opened, $idChat)
                ?>
                    <p class="rtext border rounded p-2 mb-1"><?= $chat["mensagem"] ?>
                    <small class="d-block"><?php echo date("d-M-Y, H:i", $chat["created_at"]) ?></small>
                </p>
                <?php
            }
            if($chat["sender_volunteer"] == 0) {
                $updOpen = MensagemVoluntario::updateOpen($opened, $idChat)
                ?>
                    <p class="ltext border rounded p-2 mb-1"><?= $chat["mensagem"] ?>
                    <small class="d-block"><?php echo date("d-M-Y, H:i", $chat["created_at"]) ?></small>
                </p>
                <?php
            }
        } else {
            
        }
    }