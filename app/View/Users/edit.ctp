<div class="row">
    <div class="span8">
        <h1>Mon compte</h1>
        <p>&nbsp;</p>
        <div class="row">
            <div class="span2">
                <!-- on verifie si l'utilisateur a un avatar -->

                <?php if ($this->Session->read('Auth.User.avatar')): ?>
                    <!-- si ou on affiche l'avatar -->
                    <?= $this->Html->image($this->Session->read('Auth.User.avatari') . '?' . rand()); ?>
                <?php endif ?>
            </div>
            <div class="span6">
                <?= $this->Form->create('User', array('type' => 'file')); ?>
                    <?= $this->Form->input('avatarf', array('type' => 'file', 'label' => 'Avatar (au format jpg)')); ?>
                    <?= $this->Form->input('username', array('label' => "Nom d'utilisateur", "disabled" => true, 'value' => $this->Session->read('Auth.User.username'))); ?>
                    <?= $this->Form->input('firstname', array('label' => 'Prénom')); ?>
                    <?= $this->Form->input('lastname', array('label' => 'Nom')); ?>
                <?= $this->Form->end('Modifier'); ?></div>
        </div>
    </div>
    <?= $this->element('sidebar_account'); ?>
</div>