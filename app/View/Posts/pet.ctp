

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
            <?php if ($pet['Pet']['user_id'] == $this->Session->read('Auth.User.id')): ?>
                , <?= $this->Html->link('Ajouter une photo', array('action' => 'edit', '?' => 'pet=' . $pet['Pet']['id'])); ?>
            <?php endif ?>
             <!--/nocache-->
        </p>
    </div>
    </div>

<div class="row">
    <?php foreach($posts as $k => $post):?>

        <div class ="span4">
            <?=  $this->Html->image($post['Post']['thumb']) ;?>
        </div>

    <?php endforeach ?>
<div class="span12">
    <?= $this->Paginator->numbers(); ?>
</div>

</div>