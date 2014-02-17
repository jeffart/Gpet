Bonjour,

Merci <?= $username; ?> pour votre inscription
Vous pouvez valider votre compte en vous rendant lien
<?= $this->Html->url(array('controller' => 'users', 'action' => 'activate', $id, $token), true); ?>

Merci.