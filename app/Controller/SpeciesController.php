<?php
App::uses('AppController','Controller');
class SpeciesController extends AppController{

    public function admin_index(){
        $species = $this->Species->find('all'); // on recherche toutes les especes
        $this->set(compact('species'));  // on envoi le resultat a la vue  admin_index
    }
  // Fonction d'ajout et de modification des especes
    public function admin_edit($id = null){
        if (!empty($this->request->data)) { // si des données sont posté
            $this->Species->save($this->request->data); // on sauvegarde des données
            $this->Session->setFlash("L'espèce a bien été modifée", "flash");
            return $this->redirect(array('action' => 'index')); // puis on est rediriger vers la ge index
        }else if($id){
            $this->request->data = $this->Species->findById($id); // cette ligne nous permet d'afficher le nom de lespece sur le formulaire d'edition des espece (admin_edit.ctp)
        }
    }


    // Fonction de supression des especes

    public function admin_delete($id){  // elle prend en parametre l'id de l'espece
        $this->Species->delete($id);
        $this->Session->setFlash("L'espèce a bien été supprimée", "flash");
        return $this->redirect(array('action' => 'index')); // on est rediriger vers la page admin index du controller species.
    }



}