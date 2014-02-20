<?= $this->fetch('content'); ?>

<div class="row">
    <?php foreach ($posts as $k => $post): ?>
        <div class="span4">
            <a href="<?= $this->Html->url($post['Post']['url']); ?>">
                <h3><?= h($post['Post']['name']); ?></h3>
                <?= $this->Html->image($post['Post']['thumb']); ?>
            </a>
        </div>
    <?php endforeach ?>
    <div class="span12">
        <?= $this->Paginator->numbers(); ?>
    </div>
</div>