<?php
class User extends AppModel{

    public $validate = array(
        'username' => array(
            'alpha' => array(
                'rule' => '/^[a-z0-9A-Z]*$/',
                'message' => 'Votre nom d\'utilisateur n\'est pas valide'
            ),
            'uniq' => array(
                'rule' => 'isUnique',
                'message' => "Ce pseudo est déjà utilisé"
            )
        ),
        'mail' => array(
            'mail' => array(
                'rule' => 'email'
            ),
            'uniq' => array(
                'rule' => 'isUnique',
                'message' => "Ce mail est déjà utilisé"
            )
        ),
        'password' => array(
            'rule' => 'notEmpty'
        ),
        'password2' => array(
            'rule' => 'identicalFields',
            'required' => false,
        ),
        'avatarf' => array(
            'rule' => 'isJpg',
            'message' => 'Vous devez envoyer un jpg'
        )
    );


    public function identicalFields($check, $limit){
        $field = key($check);
        return $check[$field] == $this->data['User']['password'];
    }



// petite presistion cette fonction doit etre creer pour trouver l'avatar de l'utilisateur
// pour afficher cette avatar dans le compte user
// elle doit etre creer apres le formulaire acoount parti qui affiche la photo

    public function afterFind($results, $primary = false){
        foreach($results as $k=>$result){
            if(isset($result[$this->alias]['avatar']) && isset($result[$this->alias]['id'])){
                $results[$k][$this->alias]['avatari'] = 'avatars/' . ceil($result[$this->alias]['id']/1000) . '/' . $result[$this->alias]['id'] . '.jpg';
            }
        }
        return $results;
    }


}