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


    public function edit($id = null){

        // On récupère l'animal
        if( $id ){
            $pet = $this->Pet->find('first', array(
                'conditions' => array('Pet.user_id' => $this->Auth->user("id"), 'Pet.id' => $id)
            ));
            if(empty($pet)){
                $this->Session->setFlash("Vous ne pouvez pas éditer cet animal","flash");
                return $this->redirect(array('action' => 'my'));
            }
        }

        // Des donnée ont été postées
        if (!empty($this->request->data)) {
            $this->request->data['Pet']['id'] = null;
            if(isset($pet)){
                $this->request->data['Pet']['id'] = $pet['Pet']['id'];
            }
            $this->request->data['Pet']['user_id'] = $this->Auth->user('id');
            if($this->Pet->save($this->request->data)){
                $this->Session->setFlash("L'animal a bien été modifé","flash");
                return $this->redirect(array('action' => 'my'));
            }
        }else if($id){
            $this->request->data = $pet;
        }

        // on liste les especes et les met dens la variable $species.
        // ne pas oublié de creer notre model Pet.php
        // ici On passe par le model pet pour attaquer le modele species vu que les deux modeles sont associés.

        $species = $this->Pet->Species->find('list');
        $this->set(compact('species')); // on envoi  egalement la liste des especes a la vue
    }


}