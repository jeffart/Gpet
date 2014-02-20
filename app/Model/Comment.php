<?php
class Comment extends AppModel{

    // regle de validation pour le formulaire de commentaire
    public $validate = array(
        'content' => array(
            'rule' => 'notEmpty',  // le champs doit etre rempli
            'message' => 'Vous devez entrer un message'
        ),
        'mail'   => array(
            'rule' => 'email',
        ),
        'username' => array(
            'rule' => 'notEmpty'
        )
    );

    // un commentaire va appartenir à un utilisateur et à un article
    public $belongsTo = array('User','Post');

    // cette fonction est mise en place pour mieux faire fonctionner l'envoie de commentaire surtout si l'utilisateur n'est pas logger.
    // cette fonction va nous permetre d'injecter des valeur

    public function afterFind($results, $primary = false){

        foreach($results as $k => $result) {
            if(isset($result[$this->alias])){
                $data = $result[$this->alias];
                // si on a un user et s'il est different de null  on injecte le username
                if(isset($data['username']) && $data['username'] != null){
                    $results[$k]['User']['username'] = $data['username'];
                }
                // si on a un mail et s'il est different de null  on injecte l'avatar
                if(isset($data['mail']) && $data['mail'] != null){
                    $results[$k]['User']['avatari'] = 'http://www.gravatar.com/avatar/' . md5($data['mail']) . '?size=150';
                    $results[$k]['User']['avatar'] = 1;
                }
            }
        }

        //debug($results); die();
        return $results;
    }


}