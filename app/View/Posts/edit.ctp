<div class="row">
    <div class="span12">
        <h1>Editer une photo</h1>
        <p>&nbsp;</p>
    </div>

    <div class="span6">
        <?= $this->Form->create('Post', array('type' => 'file')); ?>
            <?= $this->Form->input('name', array('label' => 'Titre')); ?>
            <?= $this->Form->input('photo', array('label' => 'Photo (format jpg seulement)', 'type' => 'file')); ?>
            <?= $this->Form->input('content', array('label' => 'Description')); ?>
            <?= $this->Form->input('pets', array('label' => 'Animaux sur cette photo', 'multiple' => true)); ?>
        <?= $this->Form->end('Envoyer'); ?>
    </div>
</div>
<?php $this->Html->css('chosen', null, array('inline' => false)); ?>
<?php $this->Html->script('chosen.jquery.min', array('inline' => false)); ?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
(function($){

$('select').chosen();

})(jQuery);
<?php $this->Html->scriptEnd(); ?>
