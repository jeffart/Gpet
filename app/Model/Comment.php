<?php
class Comment extends AppModel{

    // regle de validation pour le formulaire de commentaire
    public $validate = array(
        'content' => array(
            'rule' => 'notEmpty',  // le champs doit etre rempli
            'message' => 'Vous devez entrer un message'
        )
    );

    // un commentaire va appartenir à un utilisateur et à un article
    public $belongsTo = array('User','Post');




}