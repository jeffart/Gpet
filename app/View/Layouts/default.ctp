
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <title><?= $title_for_layout; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <?= $this->fetch('meta'); ?>

    <!-- Le styles -->
    <?= $this->Html->css('bootstrap'); ?>
      <?= $this->Html->css('custom'); ?>
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
      <?= $this->fetch('css'); ?>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <?= $this->Html->link('Petsy', '/', array('class' => 'brand')); ?>
          <div class="nav-collapse collapse">
            <ul class="nav">
                <!--nocache-->
                <?php if ($this->Session->read('Auth.User.role') == 'admin'): ?>
                    <li><?= $this->Html->link('Espèces', '/admin/species'); ?></li>
                <?php endif ?>
                <!--/nocache-->
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="nav-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
            </ul>
            <!--nocache-->

              <!-- Si on arrive à lire des donnéees de session ce qui veut dire si un utilisateur est connecter , on affiche les bouton -->
              <?php if ($this->Session->read('Auth.User.id')): ?>
                  <ul class="nav pull-right">
                      <li><?= $this->Html->link('Mon compte', array('controller' => 'users', 'action' => 'account', 'admin' => false)); ?></li>
                      <li><?= $this->Html->link('Se déconnecter', array('controller' => 'users', 'action' => 'logout', 'admin' => false)); ?></li>
                  </ul>
              <?php else: ?>
                  <!-- Si aucunes  donnéees de session ce qui veut dire si un utilisateur non connecter , on affiche le formulaire de connexion -->

                  <?= $this->Form->create('User', array('class' => 'navbar-form pull-right', 'action' => 'login')); ?>
                  <?= $this->Form->input('username', array('label' => false, 'div' => false, 'placeholder' => "Nom d'utilisateur", "class" => "span2")); ?>
                  <?= $this->Form->input('password', array('label' => false, 'div' => false, 'placeholder' => "Mot de passe", "class" => "span2")); ?>
                  <button type="submit" class="btn">Se connecter</button>
                  <?= $this->Form->end(); ?>
              <?php endif ?>
            <!--/nocache-->
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

        <?= $this->Session->flash(); ?>
        <?= $this->Session->flash('auth'); ?>
        <?= $this->fetch('content'); ?>

    </div> <!-- /container -->

    <?= $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'); ?>
    <?= $this->Html->script('cakebootstrap'); ?>
    <?= $this->fetch('script'); ?>

  </body>
</html>
