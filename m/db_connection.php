<?php
    class DBconnection {
        private $conn;
    
        public function openDB(){
            $this->conn = pg_connect(
                "host=localhost port=5433 dbname=release_students_areas user=postgres password=021114"
            );
            
            if (!$this->conn) {
                die("Error de conexión: " . pg_last_error());
            }
        }
    
        public function query($sql){
            if (!$this->conn) {
                die("Error: No hay conexión a la base de datos.");
            }
            return pg_query($this->conn, $sql); // Se pasa la conexión explícitamente
        }
    
        public function closeDB(){
            if ($this->conn) {
                pg_close($this->conn); // Se cierra la conexión correctamente
            }
        }
    }
    
?>