<div class="row">
    <div class="span8">
        <h1>Derniers commentaires</h1>
        <?php foreach ($comments as $k => $comment): ?>
        <div class="row">
            <div class="span2">
                <?php if ($comment['User']['avatar']): ?>
                    <?= $this->Html->image($comment['User']['avatari'], array('class' => 'img-circle')); ?>
                <?php endif ?>
            </div>
            <div class="span6">
                <p><strong><?= h($comment['User']['username']); ?></strong>, <?= $this->Time->timeAgoInWords($comment['Comment']['created']); ?></p>
                <p>
                    <?= nl2br(h($comment['Comment']['content'])); ?>
                </p>
                <p>
                    <?= $this->Form->postLink('<i class="icon-trash icon-white"></i> Supprimer ce commentaire', array('action' => 'delete', 'controller' => 'comments', $comment['Comment']['id']), array('class' => 'btn btn-danger', 'escape' => false), 'Voulez vous vraiment supprimer ?'); ?>
                </p>
                <p><em>sur <?= $this->Html->link($comment['Post']['name'], $comment['Post']['url']); ?></em></p>
            </div>
        </div>
        <hr>
        <?php endforeach ?>

        <?= $this->Paginator->numbers(); ?>
    </div>
    <?= $this->element('sidebar_account'); ?>
</div>