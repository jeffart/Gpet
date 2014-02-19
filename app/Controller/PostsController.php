<?php
App::uses('AppController','Controller');
class PostsController extends AppController{

    // function pour afficher les photos
   public function my() {

   }

    public function edit($id = null){

        // on recupere les animaux sous forme de liste . en precision ce sont les animaux de l'utilisateur actuelement logger
        $pets = $this->Post->Pet->find('list', array(
            'conditions' => array('Pet.user_id' => $this->Auth->user('id'))
        ));

        //debug($pets);
        //die();
        $this->set(compact('pets'));
    }

}