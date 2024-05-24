<?php
    class Conexion {
        public function conectar() {
            $servidor = "localhost";
            $usuario = "id22200224_user";
            $password = "*User1503";
            $db = "id22200224_helpd01";
            // Intentar establecer la conexión
            $conexion = mysqli_connect($servidor, $usuario, $password, $db);

            return $conexion;
        }
    }
    