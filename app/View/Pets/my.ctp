<div class="row">
    <div class="span8">
        <h1>Mes animaux</h1>
        <!-- WR-->

        <!-- On affiche un lien qui permet d'ajouter un novel animal-->

        <p>
            <?= $this->Html->link('<i class="icon-plus-sign icon-white"></i> Ajouter un nouvel animal de compagnie', array('action' => 'edit'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
        </p>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th> </th>
                <th>Nom</th>
                <th>Sexe</th>
                <th>Age</th>
                <th>Animal</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($pets as $k => $pet): ?>
                <tr>

                    <td><?= $this->Html->image($pet['Pet']['avatari']. '?' . rand(), array('width' => 50, 'class' => 'img-circle')); ?></td>

                    <td><?= $pet['Pet']['name']; ?></td>
                    <td><?= $pet['Pet']['gender']; ?></td>
                    <td>
                        <?php
                        $birthday = new DateTime($pet['Pet']['birthday']);
                        echo $birthday->diff(new DateTime('now'))->y
                        ?> Ans
                    </td>
                    <td><?= $pet['Species']['name']; ?></td>
                    <td>
                        <?= $this->Html->link('Editer', array('action' => 'edit', $pet['Pet']['id'])); ?>
                        -
                        <?= $this->Form->postLink('Supprimer', array('action' => 'delete', $pet['Pet']['id']), array(), 'Voulez vous vraiment supprimer ?'); ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>


    </div>
    <?= $this->element('sidebar_account'); ?>
</div>