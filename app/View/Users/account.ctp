<div class="row">
    <div class="span8">
        <h1>Mon compte</h1>
        <p>&nbsp;</p>
        <div class="row">

            <div class="span6">
                <?= $this->Form->create('User', array('type' => 'file')); ?>
                    <?= $this->Form->input('avatarf', array('type' => 'file', 'label' => 'Avatar (au format jpg)')); ?>
                    <?= $this->Form->input('username', array('label' => "Nom d'utilisateur", "disabled" => true, 'value' => $this->Session->read('Auth.User.username'))); ?>
                    <?= $this->Form->input('firstname', array('label' => 'Prénom')); ?>
                    <?= $this->Form->input('lastname', array('label' => 'Nom')); ?>
                <?= $this->Form->end('Modifier'); ?></div>
        </div>
    </div>
    <div class="span4">

    </div>
</div>