<?php

App::uses('AppController', 'Controller');

class PagesController extends AppController {


	public $name = 'Pages';


	public $uses = array();
// on autorise la page d'accueil
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('index');
    }


	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}


    public function index(){

        // ici on recupere les 5 derniers animaux créer
        $this->loadModel('Pet'); // on charge le model Pet
        $pets = $this->Pet->find('all', array(
            'order' => array('created DESC'),
            'contain'=> array('Species.name'),
            'limit' => 5
        ));

        // ici on recupere les 8 derniers articles créer
        $this->loadModel('Post'); // on charge le Model Post
        $posts = $this->Post->find('all', array(
            'order' => array('created DESC'),
            'limit'	=> 8
        ));

        // charger le model des especes
        $this->loadModel('Species');
        $species = $this->Species->find('all');

        $this->set(compact('posts','pets','species')); // on passe les données a la vue
    }

    // fonction pour le dashboard

    public function admin_index(){

    }
}


