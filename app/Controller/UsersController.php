<?php
App::uses('AppController','Controller');
class UsersController extends AppController{


    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('signup','login');
    }



    public function signup(){
        if (!empty($this->request->data)) {   // on verifie si des deonnées sont postée
            $this->User->create($this->request->data);  // si des données exitent on les passe au model
            if($this->User->validates()){  // si les données sont validées
                $token = md5(time() . ' - ' . uniqid()); // chaine generé de maniere aleatoire

                // on crée un nouvel utilisateur
                $this->User->create(array(
                    'username' => $this->request->data['User']['username'],
                    'password' => $this->Auth->password($this->request->data['User']['password']),
                    'mail'     => $this->request->data['User']['mail'],
                    'token'    => $token
                ));
                $this->User->save(); // on sauvegarde les données en base

                // on se charge ici de l'envoie du mail

                App::uses('CakeEmail', 'Network/Email'); // on charge cakeemail
                $CakeEmail = new CakeEmail('gmail');  // on cree un nouvel objet
                $CakeEmail->from('dekogha@gmail.com');
                $CakeEmail->to($this->request->data['User']['mail']);  // on specifie a qui est destiné le mail
                $CakeEmail->subject('Votre inscription Petsy');  // le sujet du mail

                // on envoi des informations a notre template
                // ici les données posté l'id et le token
                $CakeEmail->viewVars(
                    $this->request->data['User'] +
                    array(
                        'token' => $token,
                        'id' => $this->User->id
                    )
                );
                $CakeEmail->emailFormat('text'); // le format de notre email
                $CakeEmail->template('signup');  // le template a utiliser
                $CakeEmail->send(); // on envoie le mail

                $this->Session->setFlash('Merci vous êtes inscrit');
            }else{
                $this->Session->setFlash('Merci de corriger vos erreurs', 'flash', array('class' => 'error'));
            }
        }
    }

    /**
     * Permet de regénérer un mot de passe pour un utilisateur
     */






}