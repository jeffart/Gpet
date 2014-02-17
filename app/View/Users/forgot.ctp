<div class="row">
    <div class="span12">
        <h1>Rappel du mot de passe</h1>
        <?= $this->Form->create('User'); ?>
            <?= $this->Form->input('mail'); ?>
        <?= $this->Form->end('Regénérer mon mot de passe'); ?>
    </div>
</div>