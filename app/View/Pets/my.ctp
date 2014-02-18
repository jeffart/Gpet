<div class="row">
    <div class="span8">
        <h1>Mes animaux</h1>

        <!-- On affiche un lien qui permet d'ajouter un novel animal-->

        <p>
            <?= $this->Html->link('<i class="icon-plus-sign icon-white"></i> Ajouter un nouvel animal de compagnie', array('action' => 'edit'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
        </p>




    </div>

</div>