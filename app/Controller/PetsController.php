<?php
App::uses('AppController','Controller');
class PetsController extends AppController{


    // cette fonction permet de lister les animaux du user
    public function my(){
        $pets = $this->Pet->find('all', array(
            'conditions' => array('Pet.user_id' => $this->Auth->user("id")), // la condition permet de recuperer les animaux qui appartiennent à l'utilisateur
            'contain'    => array('Species.name')// important de mettre cette ligne ( vue my pour recuperer le type d'animal)
        ));
        $this->set(compact('pets'));// puis on passe les animaux à la vue
    }


    public function edit($id = null){

        // On récupère l'animal
        if( $id ){ // si un id est defini
            $pet = $this->Pet->find('first', array( // on recupere le premiere animal
                // conditions le user_id de l'animal est le meme que celui de l'utilisateur connecter et l'id de l'animal est egale à l'id
                'conditions' => array('Pet.user_id' => $this->Auth->user("id"), 'Pet.id' => $id)
            ));
            if(empty($pet)){ // si on ne trouve pas d'animal
                $this->Session->setFlash("Vous ne pouvez pas éditer cet animal","flash"); // on envoie un petit message
                return $this->redirect(array('action' => 'my')); // on est redirigé sur l'action my
            }
        }

        // si Des donnée ont été postées
        if (!empty($this->request->data)) {
            $this->request->data['Pet']['id'] = null; // on empeche a l'utilisateur de modifier ce champs
            if(isset($pet)){  // est ce que j'ai un animal
                $this->request->data['Pet']['id'] = $pet['Pet']['id']; // si oui
            }
            $this->request->data['Pet']['user_id'] = $this->Auth->user('id'); // on definit le user_id de la table pet qui est ici l'id de lutilisateur
            if($this->Pet->save($this->request->data)){ // si les donnees sont bien sauvegardé
                $this->Session->setFlash("L'animal a bien été modifé","flash"); // on affiche un message flash en utilisant le templete flash
                return $this->redirect(array('action' => 'my')); // et on est redirigé vers l'action my pour afficher les animaux de l'utilisateur
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


    public function delete($id){   // on lui passe l'id de l'animal en parametre
        if(!$this->request->is('post')){  // une astuce qui permet de se proteger contre les faille csrf.
            throw new NotFoundException();
        }

        // conditions le user_id de l'animal est le meme que celui de l'utilisateur connecter et l'id de l'animal est egale à l'id
        // pour eviter de supprimer l'animal de quelqu'un d'autre.
        $pet = $this->Pet->find('first', array(
            'conditions' => array('Pet.user_id' => $this->Auth->user("id"), 'Pet.id' => $id)
        ));
        if(empty($pet)){ // si on n'a pas d'animal
            $this->Session->setFlash("Vous ne pouvez pas éditer cet animal","flash"); // on envoi un message
            return $this->redirect(array('action' => 'my')); // on est rediriger vers l'action my
        }
        $this->Session->setFlash("L'animal a bien été supprimé","flash"); // si tout ce passe bien
        $this->Pet->delete($pet['Pet']['id']); // on supprime l'animal
        return $this->redirect(array('action' => 'my')); // on est rediriger vers l'action my
    }

// la fonction de souscription a un animal
// elle va rajouter dans la table subscription l'id de l'utilisateur et l'id de l'animal auquel on souhaite s'inscrire.
    public function subscribe($pet_id){  // elle reçoit en parametre l'id de l'animal

        $this->Pet->id = $pet_id;
        if(!$this->Pet->exists()){
            throw new NotFoundException();
        }

        // on met en place des condition
        // l'id de l'animal est celui qui est passé en parametre
        //l'id de l'utilisateur est celui de l'utilisateur actuelement  connecté.
        $conditions = array(
            'pet_id' => $pet_id,
            'user_id'=> $this->Auth->user("id")
        );
        $this->loadModel('Subscription'); // on charge le model Subscription

        // on verifi si un utilisateur est deja abonné à un animal grace au condition
        $count = $this->Subscription->find('count', array(
            'conditions' => $conditions
        ));
        if($count > 0){  // si l'utilisateur est abonné
            // on ne fait pas la sauvegarde
            $this->Session->setFlash("Vous êtes déjà abonné à cet animal","flash", array('class' => 'error'));
        }else{ // si l'utilisateur n'est pas abonné
            $this->Subscription->save($conditions); // on enregistre les donnée
            $this->Session->write("Auth.Subscription.$pet_id", $pet_id); // on ecrit l'id de l'animal dans "Auth.Subscription.$pet_id"
            $this->Session->setFlash("Merci pour votre abonnement","flash", array('class' => 'success'));
        }
        return $this->redirect($this->referer()); // on redirige l'utilisateur vers la page d'ou il vient
    }
// la fonction de desabonnement a un animal
// elle va supprimer dans la table subscription l'id de l'utilisateur et l'id de l'animal auquel on souhaite se desabonner.


    public function unsubscribe($pet_id){
        $this->Pet->id = $pet_id;
        if(!$this->Pet->exists()){
            throw new NotFoundException();
        }
        $conditions = array(
            'Subscription.pet_id' => $pet_id,
            'Subscription.user_id'=> $this->Auth->user("id")
        );
        $this->Session->delete("Auth.Subscription.$pet_id"); // on supprime l'id de l'animal de "Auth.Subscription.$pet_id"
        $this->loadModel('Subscription');
        $count = $this->Subscription->deleteAll($conditions);
        $this->Subscription->save($conditions);
        $this->Session->setFlash("Merci pour votre désabonnement","flash", array('class' => 'success'));
        return $this->redirect($this->referer());
    }

}