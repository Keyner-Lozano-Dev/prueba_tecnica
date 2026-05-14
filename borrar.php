<?php
include 'config_db.php';
include 'gestor_nomina.php';
$id = isset($_GET['cod']) ? intval($_GET['cod']) : 0;
if($id > 0) {
    $db = (new ConectorLocal())->abrirConexion();
    $repo = new GestorNomina($db);
    if($repo->quitarDelSistema($id)) {
        header("Location: index.php?deleted=1");
    }
}