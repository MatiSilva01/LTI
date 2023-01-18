<?php
    class Controller {
        protected $host = "appserver-01.alunos.di.fc.ul.pt";
        protected $user = "asw21";
        // TODO TIRAR TIRAR TIRAR TIRAR
        protected $password = "cudopedro"; //SUSSY BAKA
        protected $database = "asw21";

        public $con = null;

        public function __construct() {
            $this->con = new mysqli($this->host, $this->user, $this->password, $this->database);
            if ($this->con->connect_error) {
                die("Fail {$this->con->connect_error}");
            }

            $this->con->set_charset("utf8mb4");
        }

        public function __destruct() {
            $this->con->close();
        }
    }
    
    $db = new Controller()
?>