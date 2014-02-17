<?php
App::uses('AppController','Controller');
class UsersController extends AppController{


    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('signup','login','activate');
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

    // fonction d'activation d'un compte utulisation

    public function activate($user_id, $token){  // cette fonction prend  2 parametres

        // on recherche le premier utilisateur dont id et le token corespondent aux valeur passe en parametres
        $user = $this->User->find('first', array(
            'fields'     => array('id'),
            'conditions' => array('id' => $user_id, 'token' => $token)
        ));

        // si on ne trouve pas d'utilistaeur c est que le lien de validation n'est pas bon
        if (empty($user)) {
            $this->Session->setFlash('Ce lien de validation ne semble pas bon');
            return $this->redirect('/');  // on est rediriger vers la homepage
        }
        // si l'utilisateur est est trouvé
        $this->Session->setFlash('Votre compte a bien été validé');
        $this->User->save(array(
            'id'     => $user['User']['id'], // on precise quel utilisateur on veut modifier.
            'active' => 1,       // on met le champs active du user a 1
            'token'  => ''       // et on vide le token
        ));
        // puis on est redirger vers la page de connexion. pas besoin de préciser le controller
        // car on est deja dans le controller User.
        return $this->redirect(array('action' => 'login'));
    }







}