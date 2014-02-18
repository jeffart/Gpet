<div class="row">
    <div class="span12">

        <?= $this->Form->create('Species'); ?>
            <?= $this->Form->input('id'); ?>
            <?= $this->Form->input('name', array('label' => 'Nom de l\'espèce')); ?>
        <?= $this->Form->end('Envoyer'); ?>

    </div>
</div>