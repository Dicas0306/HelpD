<?php
include "../../clases/Conexion.php";
$con = new Conexion();
$conexion = $con->conectar();

$sql = "SELECT 
            persona.id_persona AS idPersona,
            CONCAT(persona.paterno, ' ', persona.materno, ' ', persona.nombre) AS nombrePersona,
            equipo.id_equipo AS idEquipo,
            equipo.nombre AS nombreEquipo,
            asignacion.id_asignacion_equipo AS idAsignacion,
            asignacion.marca,
            asignacion.modelo,
            asignacion.color,
            asignacion.descripcion,
            asignacion.memoria,
            asignacion.disco_duro AS discoDuro,
            asignacion.procesador
        FROM
            t_asignacion_equipo AS asignacion
            INNER JOIN t_persona AS persona ON asignacion.id_persona = persona.id_persona
            INNER JOIN t_cat_equipo AS equipo ON asignacion.id_equipo = equipo.id_equipo";

$respuesta = mysqli_query($conexion, $sql);
?>

<div class="table-responsive">
    <table class="table table-sm dt-responsive nowrap" style="width:100%" id="tablaAsignacionDataTable">
        <thead>
            <tr>
                <th>Persona</th>
                <th>Equipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Color</th>
                <th>Descripción</th>
                <th>Memoria</th>
                <th>Disco Duro</th>
                <th>Procesador</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($mostrar = mysqli_fetch_array($respuesta)) {
            ?>
                <tr>
                    <td><?php echo $mostrar['nombrePersona']; ?></td>
                    <td><?php echo $mostrar['nombreEquipo']; ?></td>
                    <td><?php echo $mostrar['marca']; ?></td>
                    <td><?php echo $mostrar['modelo']; ?></td>
                    <td><?php echo $mostrar['color']; ?></td>
                    <td><?php echo $mostrar['descripcion']; ?></td>
                    <td><?php echo $mostrar['memoria']; ?></td>
                    <td><?php echo $mostrar['discoDuro']; ?></td>
                    <td><?php echo $mostrar['procesador']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="fixed-bottom fixed-right p-3">
    <button class="btn btn-danger btn-sm">
        Eliminar
    </button>
</div>

<script>
    $(document).ready(function() {
        $('#tablaAsignacionDataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            }
        });
    });
</script>
