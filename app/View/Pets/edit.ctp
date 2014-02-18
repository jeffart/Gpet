
<div class="row">
    <div class="span8">
        <!-- formulaire de creation et ou de modification des animaux -->


        <?= $this->Form->create('Pet', array('type' => 'file')); ?>
            <?= $this->Form->input('name', array('label' => 'Nom')); ?>
            <?= $this->Form->input('avatarf', array('label' => 'Avatar', 'type' => 'file')); ?>
            <?= $this->Form->input('gender', array('label' => 'Sexe', 'options' => array(
                'M' => 'Male',
                'F' => 'Femelle'
            ))); ?>
            <?= $this->Form->input('species_id', array('label' => 'Animal')); ?>
        <!-- petite precision sur la date de naissance  on definit une annéé minimale et un année maximale-->
            <?= $this->Form->input('birthday', array('label' => 'Date de naissance', 'minYear' => date('Y') - 70, 'maxYear' => date('Y'))); ?>
        <?= $this->Form->end('Envoyer'); ?>
    </div>
    <?= $this->element('sidebar_account'); ?>
</div>