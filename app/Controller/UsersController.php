<?php
App::uses('AppController','Controller');
class UsersController extends AppController{


    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('signup','login','activate','forgot','password');
    }

// fonction de connxion à l'application

    public function login(){
        if (!empty($this->request->data)) {  // on verifie si des données ont été poste

            if ($this->Auth->login()) {  // si on arrive à connecter l'utilisateur message de succes
                $this->Session->setFlash("Vous êtes maintenant connecté","flash", array('class' => 'success'));
            }else{  // sinon message identifiant pas correct
                $this->Session->setFlash("Identifiants incorrects","flash", array('class' => 'error'));
            }
        }
    }


    // fonction de deconnxion à l'application

    public function logout(){
        $this->Auth->logout();
        return $this->redirect('/'); // rediriger l'user vers la page d'accueil.
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
                //specification du type de message grace  mot clé class
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


    /**
     * Permet de regénérer un mot de passe pour un utilisateur
     */



    public function forgot(){  // permet de regenerer un mot de pass et l'envoyer a l'utilisateur
        if (!empty($this->request->data)) {  // si des donnees sont postées

            // on recupere l'id de 'utilistaeur auquel est associé le mail et on le met dans la variable$user
            $user = $this->User->findByMail($this->request->data['User']['mail'], array('id'));
            if(empty($user)){ // si c 'est vide
                $this->Session->setFlash("Ce email n'est associé a aucun compte","flash", array('class' => 'error'));
            }else{// sinon

              //  debug($user);

                $token = md5(uniqid().time());
                $this->User->id = $user['User']['id'];
                $this->User->saveField('token', $token);

                App::uses('CakeEmail', 'Network/Email');
                $cakeMail = new CakeEmail('gmail');
                $cakeMail->from('dekogha@gmail.com');
                $cakeMail->to($this->request->data['User']['mail']);
                $cakeMail->subject('Régénération de mot de passe');
                $cakeMail->template('password');
                $cakeMail->viewVars(array('token' => $token, 'id' => $user['User']['id']));
                $cakeMail->emailFormat('text');
                $cakeMail->send();

                $this->Session->setFlash("Un email vous a été envoyé avec les instructions pour regénérer votre mot de passe","flash", array('class' => 'success'));


                }
        }
    }

    // Formulaire de saisi du nouveau mot de passe

    public function password($user_id, $token){  // cette fonction prend  2 parametres
        // on recherche le premier utilisateur dont id et le token corespondent aux valeur passe en parametres
        $user = $this->User->find('first', array(
            'fields'     => array('id'),
            'conditions' => array('id' => $user_id, 'token' => $token)
        ));
        // si on ne trouve pas d'utilistaeur c est que le lien de validation n'est pas bon
        if (empty($user)) {
            $this->Session->setFlash('Ce lien ne semble pas bon');
            return $this->redirect(array('action' => 'forgot')); // on est rediriger vers la page forgot
        }

        // si on  trouve l'utilistaeur c est que le lien de validation est  bon
        if(!empty($this->request->data)){
            $this->User->create($this->request->data);
            if($this->User->validates()){   // on valide les données passw et password2
                $this->User->create();

                // on enregistre le mot de passe
                $this->User->save(array(
                    'id' => $user['User']['id'],
                    'token' => '',// on vide le champs token
                    'active' => 1, // on force le active à 1
                    'password' => $this->Auth->password($this->request->data['User']['password'])
                ));
                // on affiche message ...  on utilise le template flash et la class success
                $this->Session->setFlash("Votre mot de passe a bien été modifié","flash", array('class' => 'success'));
                return $this->redirect(array('action' => 'login')); // on redirige l'utilisateur vers la page de login
            }
        }
    }




}