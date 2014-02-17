<div class="row">

    <div class="span12">
        <h1>S'inscrire</h1>

        <?= $this->Form->create('User'); ?>
            <?= $this->Form->input('username', array('label' => "Nom d'utilisateur")); ?>
            <?= $this->Form->input('password', array('label' => "Mot de passe")); ?>
            <?= $this->Form->input('password2', array('type' => 'password', 'label' => "Confirmer Mot de passe")); ?>
            <?= $this->Form->input('mail', array('label' => 'Email')); ?>
        <?= $this->Form->end("S'inscrire"); ?>
    </div>

</div>