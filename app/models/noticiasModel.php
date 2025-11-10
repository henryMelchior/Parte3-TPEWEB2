<?php
class NoticiasModel{
    private $db;

    public function __construct() {
        $this->db = $this->connectionDb();
    }
    private function connectionDb(){
        return new PDO('mysql:host=localhost;dbname=db_noticia;charset=utf8', 'root', '');
     }

    public function getNoticias($filtrarCateogria = null, $orderBy = false,$order = false) {
        $sql = 'SELECT * FROM noticia';
        if($filtrarCateogria!= null) {
            
                $sql .= ' WHERE id_categoria = '.$filtrarCateogria;
           
        }
        if($orderBy) {
            switch($orderBy) {
                case 'titulo':
                    $sql .= ' ORDER BY titulo';
                    break;
                case 'categoria':
                    $sql .= ' ORDER BY id_categoria';
                    break;
            }
        }
        if($order) {
            switch($order) {
                case 'ascendente':
                    $sql .= ' ASC';
                    break;
                case 'descendente':
                    $sql .= ' DESC';
                    break;
            }
        }

        // 2. Ejecuto la consulta
        $query = $this->db->prepare($sql);
        $query->execute();
    
        // 3. Obtengo los datos en un arreglo de objetos
        $tasks = $query->fetchAll(PDO::FETCH_OBJ); 
    
        return $tasks;
    }
    function getNoticia($id) {
        $query = $this->db->prepare('SELECT * FROM noticia WHERE id_plato = ?');
    
        
        $query->execute([$id]);
    
        $platos = $query->fetchAll(PDO::FETCH_OBJ);
        
        return $platos;
    }
    function insertarNoticia($titulo, $parrafo, $categoria){
        $query = $this->db->prepare('INSERT INTO noticia (titulo, parrafo, id_categoria) VALUES (?,?,?)'); 
        $query->execute([$titulo, $parrafo, $categoria]);
        return $this->db->lastInsertId();
    }
    function borrarNoticia($id) {
        $query = $this->db->prepare('DELETE FROM noticia WHERE id_plato = ?');
        $query->execute([$id]);
    }
    function editarNoticia($id,$titulo, $parrafo, $categoria){
        $query = $this->db->prepare('UPDATE noticia SET titulo = ?, parrafo = ?, id_categoria = ? WHERE id_plato = ?');
        $query->execute([$id,$titulo, $parrafo, $categoria]);
    }
    public function getCategoria($id) {
        // 2. ejecuto la consulta SQL (SELECT * FROM tareas)
                
        $query = $this->db->prepare('SELECT * FROM categoria WHERE id_categoria = ?');
        $query->execute([$id]);
        $task = $query->fetch(PDO::FETCH_OBJ);

        return $task;

    }
}