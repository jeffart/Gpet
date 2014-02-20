<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Session',
        'Cookie',
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'scope' => array('User.active' => 1)
                )
            )
        )
    );

    public function beforeFilter(){
        parent::beforeFilter();
        if(isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin'){
            if($this->Auth->user('role') != 'admin'){
                throw new NotFoundException();
            }
        }

       // debug($this->Session->read());
        //die();

        // si on arrive pas avoir la liste des annimaux auquel on est abonnée alors qu'on est connecté
        if($this->Session->read('Auth.User.id') && !$this->Session->read('Auth.Subscription')){
            $this->loadModel('Subscription');  // on charge le model subscription
            //On recupere la liste des abonements pour l'utilisateur
            $subscriptions = $this->Subscription->find('list', array(
                'fields' => array('pet_id','pet_id'),
                'conditions' => array('user_id' => $this->Auth->user('id')
                )));
            // On va créer cette liste ici
            $this->Session->write('Auth.Subscription', $subscriptions);


        }

        //debug($this->Session->read());die();

    }





}
