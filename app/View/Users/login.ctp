<div class="row">

    <div class="span12">
        <h1>Se connecter</h1>

        <?= $this->Form->create('User'); ?>
            <?= $this->Form->input('username', array('label' => "Nom d'utilisateur")); ?>
            <?= $this->Form->input('password', array('label' => "Mot de passe")); ?>
        <?= $this->Form->end("Se connecter"); ?>
        <p><em><?= $this->Html->link('Mot de passe oublié ?', array('action' => 'forgot')); ?></em></p>
    </div>

</div>