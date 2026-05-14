<?php
class ConectorLocal {
    private $srv = "localhost";
    private $usr = "root";
    private $pw  = ""; 
    private $db_name = "prueba tecnica";
    private $port = 3309; 
    public $link;

    public function abrirConexion() {
        $this->link = null;
        try {
            $this->link = new mysqli($this->srv, $this->usr, $this->pw, $this->db_name, $this->port);
            if ($this->link->connect_error) {
                throw new Exception("Error: " . $this->link->connect_error);
            }
            $this->link->set_charset("utf8");
        } catch (Exception $e) {
            die("Fallo de base de datos: " . $e->getMessage());
        }
        return $this->link;
    }
}