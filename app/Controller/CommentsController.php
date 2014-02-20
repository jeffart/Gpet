<?php
App::uses('AppController', 'Controller');
class CommentsController extends AppController{



    public function delete($id){
        // si cette action est appelé d'une manière autre que post
        if(!$this->request->is('post')){
            throw new NotFoundException(); // on retourne une erreur
        }
        $this->Comment->contain('Post');

        // on recupere le commentaire par rapport a l'id qui a été postée
        // on recupere aussi l'id de l'auteur de l'article et aussi l'id de l'auteur du commentaire.
        $comment = $this->Comment->findById($id, array('Comment.id','Post.user_id','Comment.user_id'));
        if(
            // si on est l'auteur du commentaire
            // si on est l'auteur du post
            // ou si on a un role d'admin
            $this->Auth->user('id') == $comment['Comment']['user_id'] ||
            $this->Auth->user('id') == $comment['Post']['user_id'] ||
            $this->Auth->user('role') == 'admin'
        ){
            $this->Comment->delete($id);  // on supprime le commentaire
            // et on envoie un message de confirmation
            $this->Session->setFlash("Commentaire supprimé","flash", array('class' => 'success'));
        }else{
            // si non on envoie un message d'erreur
            $this->Session->setFlash("Vous n'avez pas le droit de supprimer ce commentaire", "flash", array('class' => 'error'));
        }
        // puis on est rediriger sur la page sur laquelle on était.
        return $this->redirect($this->referer());
    }



}