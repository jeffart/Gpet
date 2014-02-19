<?php
App::uses('AppController','Controller');
class PostsController extends AppController{

    // function pour afficher les photos
   public function my() {

   }

    public function edit($id = null){

        // On récupère l'article
        if( $id ){ // si un id est defini
            $post = $this->Post->find('first', array( // on recupere le premiere article
                // conditions le user_id de l'article est le meme que celui de l'utilisateur connecter

                'conditions' => array('Post.user_id' => $this->Auth->user("id"), 'Post.id' => $id)
            ));
            if(empty($post)){ // si on ne trouve pas d'article
                $this->Session->setFlash("Vous ne pouvez pas éditer cet article","flash");
                return $this->redirect(array('action' => 'my')); // on est redirigé sur l'action my
            }
        }

        if(!empty($this->request->data)){  // si on a des données postées
            $this->request->data['Post']['id'] = null; // on empeche a l'utilisateur de modifier ce champs
            if(isset($post)){ // est ce que j'ai un article
                //On definit l'id en fonction de ce que l'on recupere
                $this->request->data['Post']['id'] = $post['Post']['id'];
            }
            // on definit le user_id de la table post qui est ici l'id de lutilisateur
            $this->request->data['Post']['user_id'] = $this->Auth->user('id');
            if($this->Post->saveAll($this->request->data)){ // on sauvegarde les données et si les donnees sont bien sauvegardé
                $post = $this->Post->read(); // on lit les données

                // on affiche un message flash en utilisant le templete flash
                $this->Session->setFlash("L'image a bien été sauvegardée","flash");
                // et on est redirigé vers
                return $this->redirect(array('action'=>'my'));
            }
        }


        // on recupere les animaux sous forme de liste . en precision ce sont les animaux de l'utilisateur actuelement logger
        $pets = $this->Post->Pet->find('list', array(
            'conditions' => array('Pet.user_id' => $this->Auth->user('id'))
        ));

        //debug($pets);
        //die();
        $this->set(compact('pets'));  // on envoi  egalement la liste des animaux a la vue
    }

}