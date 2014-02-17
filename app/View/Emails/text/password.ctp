Bonjour,

Vous avez demandez à regénérer votre mot de passe. Si vous êtes bien à l'origine de cette demande merci de suivre ce lien
<?= $this->Html->url(array('controller' => 'users', 'action' => 'password', $id, $token), true); ?>

Merci