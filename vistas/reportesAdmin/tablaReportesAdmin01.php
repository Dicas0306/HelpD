<?php
    session_start();
    include "../../clases/Conexion.php";
    $con = new Conexion();
    $conexion = $con->conectar();
    $idUsuario = $_SESSION['usuario']['id'];

    // Consulta para obtener la información del usuario
    $sqlUsuario = "SELECT CONCAT(paterno, ' ', materno, ' ', nombre) AS nombreCompleto
                    FROM t_persona WHERE id_persona = '$idUsuario'";
    $resultadoUsuario = mysqli_query($conexion, $sqlUsuario);
    $filaUsuario = mysqli_fetch_assoc($resultadoUsuario);
    $nombreUsuario = $filaUsuario['nombreCompleto'];

    $contador = 1;
    $sql = "SELECT 
                reporte.id_reporte AS idReporte,
                reporte.id_usuario AS idUsuario,
                CONCAT(persona.paterno,
                        ' ',
                        persona.materno,
                        ' ',
                        persona.nombre) AS nombrePersona,
                equipo.id_equipo AS idEquipo,
                equipo.nombre AS nombreEquipo,
                reporte.descripcion_problema AS problema,
                reporte.estatus AS estatus,
                reporte.solucion_problema AS solucion,
                reporte.fecha AS fecha
            FROM
                t_reportes AS reporte
                    INNER JOIN
                t_usuarios AS usuario ON reporte.id_usuario = usuario.id_usuario
                    INNER JOIN
                t_persona AS persona ON usuario.id_persona = persona.id_persona
                    INNER JOIN
                t_cat_equipo AS equipo ON reporte.id_equipo = equipo.id_equipo
                ORDER BY reporte.fecha DESC";
    $respuesta = mysqli_query($conexion, $sql);
?>

<!-- Aquí puedes mostrar el nombre del usuario -->
<h3>Bienvenido, <?php echo $nombreUsuario; ?></h3>

<!-- table-bordered va dentro de la clase de table para colocar bordes -->
<table class="table table-sm dt-responsive nowrap" style="width:100%" id="tablaReportesAdminDataTable">
    <thead>
        <th>No. Reporte</th>
        <th>Nombre</th> 
        <th>Dispositivo</th>
        <th>Fecha</th>
        <th>Descripción</th>
        <th>Estatus</th>
        <th>Solución</th>
        <th>Eliminar</th>
    </thead>
    <tbody>
    <?php while($mostrar = mysqli_fetch_array($respuesta)) { ?>
        <tr>
            <td><?php echo $contador++; ?></td>
            <td><?php echo $mostrar['nombrePersona']; ?></td>
            <td><?php echo $mostrar['nombreEquipo']; ?></td>
            <td><?php echo $mostrar['fecha']; ?></td>
            
            <!-- Modificación para mantener un ancho específico -->
            <td style="width: 200px;"><pre><?php echo nl2br($mostrar['problema']); ?></pre></td>

            <td>
                <?php
                    $estatus = $mostrar['estatus'];
                    $cadenaEstatus = '<span class="badge badge-danger">Abierto</span>';
                    if ($estatus == 0) {
                        $cadenaEstatus = '<span class="badge badge-success">Cerrado</span>';
                    }
                    echo $cadenaEstatus;
                ?>
            </td>
            <td>
                <button class="btn btn-info btn-sm"
                        onclick="obtenerDatosSolucion(<?php echo $mostrar['idReporte']; ?>)"
                        data-toggle="modal" data-target="#modalAgregarSolucionReporte">
                    Solución
                </button>

                <!-- Modificación para mantener un ancho específico -->
                <td style="width: 200px;"><pre><?php echo nl2br($mostrar['solucion']); ?></pre></td>
            </td>
            <td>
                <?php
                    if ($mostrar['solucion'] == "") {
                ?>
                        <button class="btn btn-danger btn-sm"
                            onclick="eliminarReporteAdmin(<?php echo $mostrar['idReporte'] ?>)">
                            Eliminar
                        </button>
                <?php
                    }
                ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tablaReportesAdminDataTable').DataTable();
    });
</script>
