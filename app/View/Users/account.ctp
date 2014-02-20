<div class="row">
    <div class="span8">
        <h1>Mes abonnements</h1>
        <div class="row">
            <?php foreach ($posts as $k => $post): ?>
                <div class="span4">
                    <a href="<?= $this->Html->url($post['Post']['url']); ?>">
                        <h3><?= h($post['Post']['name']); ?></h3>
                        <?= $this->Html->image($post['Post']['thumb']); ?>
                    </a>
                </div>
            <?php endforeach ?>
            <div class="span8">
                <?= $this->Paginator->numbers(); ?>
            </div>
        </div>
    </div>
    <div class="span4">
        <h3>Derniers commentaires</h3>

        <?php foreach ($comments as $k => $comment): ?>
            <p><strong><?= h($comment['User']['username']); ?></strong>, <?= $this->Time->timeAgoInWords($comment['Comment']['created']); ?></p>
            <p>
                <?= nl2br(h($comment['Comment']['content'])); ?>
            </p>
            <p>
                <em>sur <?= $this->Html->link($comment['Post']['name'], $comment['Post']['url']); ?></em>
            </p>
            <hr>
        <?php endforeach ?>
        <p>
            <?= $this->Html->link('<i class="icon-inbox icon-white"></i> Voir tous les commentaires', array('action' => 'user', 'controller' => 'comments'), array('class' => 'btn btn-primary', 'escape' => false)); ?>

        </p>

        <div class="row">
            <?= $this->element('sidebar_account'); ?>
        </div>
    </div>
</div>