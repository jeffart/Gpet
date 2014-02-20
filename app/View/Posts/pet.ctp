
<?php $this->extend('index'); ?>
<div class="row">
    <p>&nbsp;</p>
    <?php if (isset($pet['Pet']['avatari'])): ?>
        <div class="span2">
            <p align="center"><?= $this->Html->image($pet['Pet']['avatari'], array('class' => 'img-circle', 'width' => 100)); ?></p>
        </div>
    <?php endif ?>
    <div class="span10">
        <h1><?= $pet['Pet']['name']; ?></h1>
        <p>
            <?= $pet['Species']['name']; ?>,
            <?php
            $birthday = new DateTime($pet['Pet']['birthday']);
            echo $birthday->diff(new DateTime('now'))->y
            ?> Ans
            <!--nocache-->
            <!-- petite precision importante ici on envoie des infos en get dans l'url  ici notre url est de la forme (http://localhost/Gpet/posts/edit?pet=1)-->

            <?php if ($pet['Pet']['user_id'] == $this->Session->read('Auth.User.id')): ?>
                , <?= $this->Html->link('Ajouter une photo', array('action' => 'edit', '?' => 'pet=' . $pet['Pet']['id'])); ?>

            <?php else: ?>

                <!--on creer le bouton de souscription  action (souscribe)  contoller Pet  et on lui passe en parametre id de l'animal-->
                <?= $this->Html->link(
                    '<i class="icon-ok icon-white"></i> S\'abonner',
                    array('action' => 'subscribe', 'controller' => 'pets', $pet['Pet']['id']),
                    array('escape' => false, 'class' => 'btn btn-success')
                ); ?>


            <?php endif ?>
             <!--/nocache-->
        </p>
    </div>
    </div>

