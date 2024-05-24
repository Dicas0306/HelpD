<?php
    //header('Content-Type: application/json; charset=UTF-8');
    $idReporte = $_POST['idReporte'];

    include "../../clases/Reportes.php";
    $Reportes = new Reportes();
    echo json_encode($Reportes->obtenerSolucion($idReporte));