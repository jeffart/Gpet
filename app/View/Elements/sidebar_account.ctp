<div class="span4">
    <h2>Navigation</h2>
    <ul class="nav nav-tabs nav-stacked">
        <!-- si l'action c'est account on met la class acount actif et donc le lien est actif et on affiche le compte-->


        <li<?php if($this->request->action == 'account'): ?> class="active"<?php endif; ?>>
            <?= $this->Html->link('Mon compte', array('controller' => 'users', 'action' => 'account')); ?>
        </li>

        <li<?php if($this->request->controller == 'posts'): ?> class="active"<?php endif; ?>>
            <?= $this->Html->link('Ajouter une photos', array('controller' => 'posts', 'action' => 'edit')); ?>
        </li>



        <!-- si l'action c'est pet on met la class pet a actif et donc le lien est actif et affiche la partie consacré au animaux-->
        <li<?php if($this->request->controller == 'pets'): ?> class="active"<?php endif; ?>>
            <?= $this->Html->link('Mes animaux', array('controller' => 'pets', 'action' => 'my')); ?>
        </li>

        <li<?php if($this->request->action == 'edit'): ?> class="active"<?php endif; ?>>
            <?= $this->Html->link('Mon profil', array('controller' => 'users', 'action' => 'edit')); ?>
        </li>


    </ul>
</div>