 <div class="hero-unit">
    <h1>Bienvenue sur Petsy</h1>
    <p>Le site communautaire pour partager des photos de vos animaux de compagnie</p>
    <p>
        <a href="<?= $this->Html->url(array('controller' => 'users', 'action' => 'signup')); ?>" class="btn btn-primary btn-large">
            S'inscrire &raquo;
        </a>
    </p>
  </div>


<div class="row">
    <div class="span8">
        <h1>Dernières photos</h1>
        <div class="row">
            <?php foreach ($posts as $k => $post): ?>
            <div class="span4">
                <a href="<?= $this->Html->url($post['Post']['url']); ?>">
                    <h3><?= h($post['Post']['name']); ?></h3>
                    <?= $this->Html->image($post['Post']['thumb']); ?>
                </a>
            </div>
            <?php endforeach ?>
        </div>

    </div>
    <div class="span4">
        <h2>Filter par animaux</h2>
        <ul class="nav nav-tabs nav-stacked">
            <?php foreach ($species as $k => $spe): ?>
                <li><?= $this->Html->link($spe['Species']['name'], $spe['Species']['url']); ?></li>
            <?php endforeach ?>
        </ul>

        <h2>Nouveaux venus  </h2>
        <?php foreach ($pets as $k => $pet): ?>
        <a href="<?= $this->Html->url(array('controller' => 'posts', 'action' => 'pet', $pet['Pet']['id'])); ?>" class="pet">
            <?php if ($pet['Pet']['avatar']): ?>
                <?= $this->Html->image('pets/' . ceil($pet['Pet']['id'] / 1000) . '/' . $pet['Pet']['id'] . '.jpg', array('class' => 'img-circle')); ?>
            <?php endif ?>
            <p><?= $pet['Pet']['name']; ?></p>
            <p>
                <?= $pet['Species']['name']; ?>, <em><?php
                    $birthday = new DateTime($pet['Pet']['birthday']);
                    echo $birthday->diff(new DateTime('now'))->y
                    ?> Ans</em>
            </p>
        </a>
        <?php endforeach ?>
    </div>
</div>