<?php
class Subscription extends AppModel{

    // noter cette table permet de faire la liaison avec 2 autres model
    // un abonnement appartient à un utilisateur mais aussi à un animal.
    public $belongsTo = array(
        'User',
        'Pet' => array(
            'counterCache' => true   // cela nous permetra de conter facilement.
        )
    );

}