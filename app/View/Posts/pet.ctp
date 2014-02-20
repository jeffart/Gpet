<?php $this->set('title_for_layout', $pet['Pet']['name'] . ' | Photos de ' . $pet['Species']['name']); ?>
<?php $this->Html->meta('description', 'Photo du ' . $pet['Species']['name'] . ' ' . $pet['Pet']['name'], array('inline' => false)); ?>



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

                <!--on creer le bouton de desabonnement et de  souscription  action (unsubscribe et souscribe)  contoller Pet  et on lui passe en parametre id de l'animal-->

                <!-- si on retrouve l'id de l'animal dans le tableau de souscription contenu dans les données de session on affiche le bouton se desabonner-->

                <?php if(in_array($pet['Pet']['id'], $this->Session->read('Auth.Subscription'))): ?>
                    <?= $this->Html->link(
                        '<i class="icon-remove icon-white"></i> Se désabonner',
                        array('action' => 'unsubscribe', 'controller' => 'pets', $pet['Pet']['id']),
                        array('escape' => false, 'class' => 'btn btn-warning')
                    ); ?>
                <?php else: ?>   <!-- si on ne retrouve l'id de l'animal dans le tableau de souscription contenu dans les données de session on affiche le bouton se Subscription-->

                    <?= $this->Html->link(
                        '<i class="icon-ok icon-white"></i> S\'abonner',
                        array('action' => 'subscribe', 'controller' => 'pets', $pet['Pet']['id']),
                        array('escape' => false, 'class' => 'btn btn-success')
                    ); ?>
                <?php endif; ?>


            <?php endif ?>
             <!--/nocache-->
        </p>
    </div>
    </div>

