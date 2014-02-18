<div class="row">
    <div class="span12">
        <p><?= $this->Html->link('<i class="icon-plus-sign icon-white"></i> Ajouter une nouvelle espèce', array('action' => 'edit'), array('class' => 'btn btn-primary', 'escape' => false)); ?></p>



        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($species as $k => $v): ?>

                <tr>
                    <td><?= $v['Species']['id']; ?></td>
                    <td><?= $v['Species']['name']; ?></td>
                    <td>
                        <?= $this->Html->link('Editer', array('action' => 'edit', $v['Species']['id'])); ?>
                        -
                        <?= $this->Html->link('Supprimer', array('action' => 'delete', $v['Species']['id']), array('confirm' => 'Voulez vous vraiment supprimer ?')); ?>
                    </td>
                </tr>

                <?php endforeach ?>
            </tbody>
        </table>

    </div>
</div>