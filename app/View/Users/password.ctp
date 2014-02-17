<div class="row">

    <div class="span12">
        <h1>Modifier mon mot de passe</h1>

        <?= $this->Form->create('User'); ?>
            <?= $this->Form->input('password', array('label' => "Mot de passe")); ?>
            <?= $this->Form->input('password2', array('type' => 'password', 'label' => "Confirmer Mot de passe")); ?>
        <?= $this->Form->end("Modifier"); ?>
    </div>

</div>