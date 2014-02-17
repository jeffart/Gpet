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
    );


    public function identicalFields($check, $limit){
        $field = key($check);
        return $check[$field] == $this->data['User']['password'];
    }


}