<div class="row">
    <div class="span12">
        <!--on affiche le titre-->
        <h1><?= h($post['Post']['name']); ?></h1>
        <!--nocache-->
        <?php if ($this->Session->read('Auth.User.id') == $post['Post']['user_id']): ?>
            <p>
                <?= $this->Html->link('<i class="icon-edit icon-white"></i> Modifer cette photo', array('action' => 'edit', $post['Post']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
                <?= $this->Form->postLink('<i class="icon-trash icon-white"></i> Supprimer cette photo', array('action' => 'delete', $post['Post']['id']), array('class' => 'btn btn-danger', 'escape' => false), 'Voulez vous vraiment supprimer ?'); ?>
            </p>
        <?php endif ?>
        <!--/nocache-->
        <!--on affiche l'image -->
        <p><?= $this->Html->image($post['Post']['photo']); ?></p>
        <p><?= h($post['Post']['content']); ?></p>
    </div>

    <div class="span8">
        <h2>Commentaires</h2>

    </div>

    <div class="span4">
        <h2>Présent sur cette photo </h2>

        <!--Grace au belongtomanay on recupere toutes les infos qu'on souhaite-->
        <!-- <?= debug($post); ?> -->




        <?php foreach ($post['Pet'] as $k => $pet): ?>
            <a href="<?= $this->Html->url(array('action' => 'pet', $pet['id'])); ?>" class="pet">
                <?php if ($pet['avatar']): ?>
                    <?= $this->Html->image('pets/' . ceil($pet['id'] / 1000) . '/' . $pet['id'] . '.jpg', array('class' => 'img-circle')); ?>
                <?php endif ?>
                <p><?= $pet['name']; ?></p>
                <p>
                    <em><?php
                        $birthday = new DateTime($pet['birthday']);
                        echo $birthday->diff(new DateTime('now'))->y
                        ?> Ans</em>
                </p>
            </a>
        <?php endforeach ?>
    </div>

</div>