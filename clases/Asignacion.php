
<?php
    include "Conexion.php";

    class Asignacion extends Conexion {
        public function agregarAsignacion($datos) {
            $conexion = Conexion::conectar();
            $sql = "INSERT INTO t_asignacion_equipo (id_persona,
                                id_equipo,
                                marca,
                                modelo,
                                color,
                                descripcion,
                                memoria,
                                disco_duro,
                                procesador)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $query = $conexion->prepare($sql);
            $query -> bind_param('iisssssss', $datos['idPersona'],
                                              $datos['idEquipo'],
                                              $datos['marca'],
                                              $datos['modelo'],
                                              $datos['color'],
                                              $datos['descripcion'],
                                              $datos['memoria'],
                                              $datos['discoDuro'],
                                              $datos['procesador']);
            $respuesta = $query->execute();
            $query->close();
            return $respuesta;
        }

        public function eliminarAsignacion($idAsignacion) {
            $conexion = Conexion::conectar();
            $sql = "DELETE FROM t_asignacion_equipo WHERE id_asignacion_equipo = ?";
            $query = $conexion->prepare($sql);
            $query->bind_param('i', $idAsignacion);
            $respuesta = $query->execute();
            $query->close();
            return $respuesta;
        }
    }
?>