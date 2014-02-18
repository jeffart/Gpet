<?php
App::uses('AppController','Controller');
class PetsController extends AppController{


    // cette fonction permet de lister les animaux du user
    public function my(){
        $pets = $this->Pet->find('all', array(
            'conditions' => array('Pet.user_id' => $this->Auth->user("id")), // la condition permet de recuperer les animaux qui appartiennent à l'utilisateur
            'contain'    => array('Species.name')
        ));
        $this->set(compact('pets'));// puis on passe les animaux à la vue
    }



}