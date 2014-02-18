<?php
class Pet extends AppModel{

    public $belongsTo = array('Species');  // un animal appartient a une espece.

     // regle de validation pour le model pet
    public $validate = array(
        'name' => 'notEmpty',   // remplire le champs name
        'gender' => '/^(M|F)$/'  // type mal ou femmelle

    );



}