<?php

include "Conexion.php";

class Usuarios extends Conexion {
    public function loginUsuario($usuario, $password) {
        $conexion = Conexion::conectar();
        $usuario = mysqli_real_escape_string($conexion, $usuario); // Escapar caracteres especiales
        $password = mysqli_real_escape_string($conexion, $password); // Escapar caracteres especiales
        
        $sql = "SELECT * FROM t_usuarios
                WHERE usuario = '$usuario' AND password = '$password'";
        $respuesta = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($respuesta) > 0) {
            $datosUsuario = mysqli_fetch_array($respuesta);
            $_SESSION['usuario']['nombre'] = $datosUsuario['usuario'];
            $_SESSION['usuario']['id'] = $datosUsuario['id_usuario']; // Corregido de 'id_usuario'
            $_SESSION['usuario']['rol'] = $datosUsuario['id_rol'];
            return 1;
        } else {
            return 0;
        }
    }
    
    public function agregarNuevoUsuario($datos) {
        $conexion = Conexion::conectar();
        $idPersona = self::agregarPersona($datos);
        if ($idPersona > 0) {
            $sql = "INSERT INTO t_usuarios (id_rol, id_persona, usuario, password, ubicacion)
                    VALUES (?, ?, ?, ?, ?)";
            $query = $conexion->prepare($sql);
            $query -> bind_param("iisss", $datos['idRol'],
                                          $idPersona,
                                          $datos['usuario'],
                                          $datos['password'],
                                          $datos['ubicacion']);
            $respuesta = $query->execute();
            return $respuesta;
        } else {
            return 0;
        }
    }
    
    public function agregarPersona($datos) {
        $conexion = Conexion::conectar();
        $sql = "INSERT INTO t_persona (paterno,
                                        materno,
                                        nombre,
                                        fecha_nacimiento,
                                        sexo,
                                        telefono,
                                        correo)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $query = $conexion->prepare($sql);
        $query->bind_param("sssssss", $datos['paterno'],
                                      $datos['materno'],
                                      $datos['nombre'],
                                      $datos['fechaNacimiento'],
                                      $datos['sexo'],
                                      $datos['telefono'],
                                      $datos['correo']);
        $respuesta = $query->execute();
        $idPersona = mysqli_insert_id($conexion);
        $query->close();
        return $idPersona;
    }
    
    public function obtenerDatosUsuario($idUsuario) {
        $conexion = Conexion::conectar();

        $sql = "SELECT 
                    usuarios.id_usuario as idUsuario,
                    usuarios.usuario as nombreUsuario,
                    roles.nombre as rol,
                    usuarios.id_rol as idRol,
                    usuarios.ubicacion as ubicacion,
                    usuarios.activo as estatus,
                    usuarios.id_persona as idPersona,
                    persona.nombre as nombrePersona,
                    persona.paterno as paterno,
                    persona.materno as materno,
                    persona.fecha_nacimiento as fechaNacimiento,
                    persona.sexo as sexo,
                    persona.telefono as telefono,
                    persona.correo as email
                FROM
                    t_usuarios AS usuarios
                        INNER JOIN
                    t_cat_roles AS roles ON usuarios.id_rol = roles.id_rol
                        INNER JOIN
                    t_persona AS persona on usuarios.id_persona = persona.id_persona
                WHERE usuarios.id_usuario = ?"; // Corregido para evitar inyección SQL
        $query = $conexion->prepare($sql);
        $query->bind_param('i', $idUsuario);
        $query->execute();
        $resultado = $query->get_result();
        $usuario = $resultado->fetch_assoc();
        $query->close();

        return $usuario;
    }

    public function actualizarUsuario($datos) {
        $conexion = Conexion::conectar();
        $exitoPersona = self::actualizarPersona($datos);

        if ($exitoPersona) {
            $sql = "UPDATE t_usuarios SET id_rol = ?,
                                            usuario = ?,
                                            ubicacion = ?
                    WHERE id_usuario = ?";
            $query = $conexion->prepare($sql);
            $query->bind_param('issi', $datos['idRol'],
                                        $datos['usuario'],
                                        $datos['ubicacion'],
                                        $datos['idUsuario']);
            $respuesta = $query->execute();
            $query->close();
            return $respuesta;
        } else {
            return 0;
        }
    }

    public function actualizarPersona($datos) {
        $conexion = Conexion::conectar();
        $idPersona = self::obtenerIdPersona($datos['idUsuario']);
        $sql = "UPDATE t_persona SET paterno = ?,
                                     materno = ?,
                                     nombre = ?,
                                     fecha_nacimiento = ?,
                                     sexo = ?,
                                     telefono = ?,
                                     correo = ?
                WHERE id_persona = ?";
        $query = $conexion->prepare($sql);
        $query->bind_param('sssssssi', $datos['paterno'],
                                       $datos['materno'],
                                       $datos['nombre'],
                                       $datos['fechaNacimiento'],
                                       $datos['sexo'],
                                       $datos['telefono'],
                                       $datos['correo'],
                                       $idPersona);
        $respuesta = $query->execute();
        $query->close();
        return $respuesta;
    }

    public function obtenerIdPersona($idUsuario) {
        $conexion = Conexion::conectar();
        $sql = "SELECT 
                    persona.id_persona AS idPersona
                FROM
                    t_usuarios AS usuarios
                        INNER JOIN
                    t_persona AS persona ON usuarios.id_persona = persona.id_persona
                WHERE usuarios.id_usuario = ?";
        $query = $conexion->prepare($sql);
        $query->bind_param('i', $idUsuario);
        $query->execute();
        $resultado = $query->get_result();
        $idPersona = $resultado->fetch_assoc()['idPersona'];
        $query->close();
        return $idPersona;
    }
}
