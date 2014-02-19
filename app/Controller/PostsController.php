<?php
App::uses('AppController','Controller');
class PostsController extends AppController{

    public $paginate = array(
        'PetsPost' => array(
            'limit' => 9,  // pour une pagination sur tois colones et trois lignes
            'contain' => array('Post.id', 'Post.name', 'Post.content')
        )
    );

    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('pet');
    }



  // cette fonction peut etre en acces pour tout le monde donc creer une methode beforefilter.
    public function pet($id){ // reçoit en argument l'id de l'animal a voir
        // on dit ici que notre post-pet va egalement contenir le nom de l'espece
        $this->Post->Pet->contain('Species.name');
        $pet = $this->Post->Pet->findById($id); // on recupere les informations sur l'animal
        if(empty($pet)){  //si on n'a pas d'animal
            throw new NotFoundException(); // on renvoie vers une page notfound
        }
        // pour avoir toutes les imags sur un animal on se base sur la table de liaison petsposts
        // on va donc creer ce model.
        $this->loadModel('PetsPost');
        // on ne recupere que les images dont l'id est passe en paramettre
        $posts = $this->paginate('PetsPost', array('pet_id' => $id));
        $this->set(compact('pet','posts')); // on envoie les données à la vue pet.ctp
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
             //debug($this->request->data);
            //die();

            if($this->Post->saveAll($this->request->data)){ // on sauvegarde les données et si les donnees sont bien sauvegardé
                $post = $this->Post->read(); // on lit les données

                // on affiche un message flash en utilisant le templete flash
                $this->Session->setFlash("L'image a bien été sauvegardée","flash");
                // et on est redirigé vers

                // puis  on sera rediriger vers l'url de l'article en question
                //debug($post['Post']['url']); die();

                return $this->redirect($post['Post']['url']); // on est redirigé sur l'action my

            }
        }else if($id){
            $this->request->data = $post;
            // on creer et on charge un sousmodel basé sur la table pets_posts
            //cela nou permetra de recuperer les donné dans la select box au niveau de la
            // vue edit
            $this->loadModel('PetsPost');
            $this->request->data['Pet']['Pet'] = $this->PetsPost->find('list', array(
                'fields' => array('pet_id', 'pet_id'),
                'conditions' => array('post_id' => $post['Post']['id']) // on ne recupere que les element ou l'article correspond a l'id
            ));

        }

        //debug($this->request->query); die();
        if ($this->request->query('pet')) {

            //debug($this->request->query('pet')); die(); affiche l'id de l'animal
            //on recupere le id des annimaux et on le met dans un tableau qui servira d'index
            $this->request->data['Pet']['Pet'][] = $this->request->query('pet');

            //debug($this->request->data['Pet']['Pet']); die(); affiche par exemple
            //array(
             //         (int) 0 => '1'
             //       )
        }

        debug($this->request->data);
        // on recupere les animaux sous forme de liste . en precision ce sont les animaux de l'utilisateur actuelement logger
        $pets = $this->Post->Pet->find('list', array(
            'conditions' => array('Pet.user_id' => $this->Auth->user('id'))
        ));

        //debug($pets);
        //die();
        $this->set(compact('pets'));  // on envoi  egalement la liste des animaux a la vue
    }


//

    public function view($id){ // prend en parametre l'id de la photo

        // On a besoin des different animaux present sur la photo
        $this->Post->contain('Pet');

        // on recupere l'article
        $post = $this->Post->findById($id);
        //si je n'ai pas d'article je renvoi un not find exeption
        if(empty($post)){
            throw new NotFoundException();
        }
        // puis on envoie les données a la vue.
        $this->set(compact('post'));
    }



    public function delete($id){
        if(!$this->request->is('post')){  // on verifie si on n'est pas en post
            throw new NotFoundException(); // message d'erreur
        }

        // si on est en post On recupere le premier article qui par rapport à l'id de l'utilisateur
        $post = $this->Post->find('first', array(
            'conditions' => array('Post.user_id' => $this->Auth->user("id"), 'Post.id' => $id)
        ));
        // si on trouve pas d'article
        if(empty($post)){
            // on affiche le message
            $this->Session->setFlash("Vous ne pouvez pas éditer cet article","flash");
            // on est rediriger vers la page precedente
            return $this->redirect($this->referer());
        }

        // si on trouve un article on le supprime et on affiche le message de suppression
        $this->Session->setFlash("La photo a bien été supprimée","flash");
        $this->Post->delete($post['Post']['id']);
        // et on redirige vers la page d'accueil.
        return $this->redirect('/');
    }


}