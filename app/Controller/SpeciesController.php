<?php
App::uses('AppController','Controller');
class SpeciesController extends AppController{

    public function admin_index(){
        $species = $this->Species->find('all');
        $this->set(compact('species'));
    }



}