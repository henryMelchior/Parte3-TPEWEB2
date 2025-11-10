<?php
require_once 'app\models\noticiasModel.php';
require_once 'app\views\json.view.php';

class NoticiasApiController{
    private $model;
    private $view;
    public function __construct() {
        $this->model = new NoticiasModel();
        $this->view = new JSONView();
    }
    public function getAll($req, $res) {
        if(!$res->user) {
            return $this->view->response("No autorizado", 401);
        }
        $filtrarCategoria = null;
        // obtengo las tareas de la DB
        if(isset($req->query->filtrarCategoria)) {
            $filtrarCategoria = $req->query->filtrarCategoria;
        }
        $order = false;
        if(isset($req->query->order))
            $order = $req->query->order;
           
        
        $orderBy = false;
        if(isset($req->query->orderBy))
            $orderBy = $req->query->orderBy;

        $noticias = $this->model->getNoticias($filtrarCategoria,$orderBy,$order );
        $noticiasPaginado=[];
        $pagina=null;
        if(isset($req->query->pagina)){
            $pagina=$req->query->pagina;
            $limite=5;
            if($pagina==1){
                $paginaContador=0;
            }else{
                $i=$pagina-1;
                $paginaContador=$limite*$i;
            }
            $limite*=$pagina;
            if($limite>count($noticias)){
                $limite=1-count($noticias);
            }

            
           for($i=$paginaContador;$i<$limite;$i++){
                $noticiasPaginado[]=$noticias[$i];
           }
           if(count($noticiasPaginado)>0){
                return $this->view->response($noticiasPaginado);
           }else{
                return $this->view->response("La pagina $pagina  no existe", 404);
           }
           

        }

        


        return $this->view->response($noticias);
    }
    
    public function getById($req, $res) {
        if(!$res->user) {
            return $this->view->response("No autorizado", 401);
        }
        $id=$req->params->id;
        // obtengo las tareas de la DB
        $noticia=$this->model->getNoticia($id);
        if(!$noticia) {
            return $this->view->response("la noticia con el id=$id no existe", 404);
        }
    
        return $this->view->response($noticia);
    }

    public function create($req, $res) {
         if(!$res->user) {
            return $this->view->response("No autorizado", 401);
        }
        // valido los datos

        if (empty($req->body->titulo) || empty($req->body->parrafo)|| empty($req->body->id_categoria)) {
            return $this->view->response('Faltan completar datos', 400);
        }
        // obtengo los datos
        $titulo = $req->body->titulo;     
        $parrafo = $req->body->parrafo;          
        $cat=$req->body->id_categoria;
        // inserto los datos
        $categoria=$this->model->getCategoria($cat);

        if($categoria==null){
             return $this->view->response('la categoria no existe', 400);
        }
        $id = $this->model->insertarNoticia($titulo, $parrafo,$cat );

        if (!$id) {
            return $this->view->response("Error al insertar noticia", 500);
        }

        // buena práctica es devolver el recurso insertado
        $noticia = $this->model->getNoticia($id);
        return $this->view->response($noticia, 201);
    }

    public function eliminar($req, $res) {
        if(!$res->user) {
            return $this->view->response("No autorizado", 401);
        }
        $id = $req->params->id;
        $noticia = $this->model->getNoticia($id);
        
        if(!$noticia) {
            return $this->view->response("La noticia con el id=$id no exite", 404);
        }

        $this->model->borrarNoticia($id);
        $this->view->response("La noticia con el id=$id se elimino con exito");
    }

    public function update($req, $res) {
          if(!$res->user) {
            return $this->view->response("No autorizado", 401);
        }
        $id = $req->params->id;

        $noticia = $this->model->getNoticia($id);

        if(!$noticia){
            return $this->view->response("El plato con el id=$id no existe", 404);
        }

        //valido los datos
        if(empty($req->body->titulo) || empty($req->body->parrafo)|| empty($req->body->id_categoria)){
            return $this->view->response('Faltan completar datos', 400);
        }

        //obtengo los datos
        $titulo = $req->body->titulo;     
        $parrafo = $req->body->parrafo;          
        $cat=$req->body->id_categoria;

        //actualizo el plato
        $this->model->editarNoticia($id,$titulo,$parrafo,$cat);

        //obtengo el plato modificado y lo devuevlo en la respuesta
        $noticia = $this->model->getNoticia($id);
        $this->view->response($noticia, 200);
    }
}