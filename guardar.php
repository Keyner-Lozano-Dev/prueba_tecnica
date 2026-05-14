<?php
include 'config_db.php';
include 'gestor_nomina.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = (new ConectorLocal())->abrirConexion();
    $repo = new GestorNomina($db);
    $roles = $_POST['roles'] ?? [];
    if($repo->procesarFicha($_POST, $roles)) {
        header("Location: index.php?success=1");
    } else {
        echo "Error al procesar.";
    }
}