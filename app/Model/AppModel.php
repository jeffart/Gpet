<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    public $recursive = -1; // on doit bloquer la recursivité vue que nous avons de association entre les modele
    public $actsAs = array('Containable');

     // on definit une regle general pour la taille des avatar.
    public function sizeimg($check, $width, $height, $limit){

        //debug($check);
        //debug($limit);

        //debug(func_get_args());



        $field = key($check);  // on recupere le non du champs (avatarf)
        $value = $check[$field];  // on recupere la valeur contenu dans le champs
        //debug($value);
        //die();
        if(empty($value['tmp_name'])){ // si aucune image n'est envoyer
            return true;
        }
        $file =  pathinfo(strtolower($value['name'])); // on recupere le chemin du fichier et on le met en miniscule
        //debug($file);
        //die();
        if(!in_array($file['extension'], array('jpg','jpeg','png'))){
            return false;
        } // si on trouve pas d'extension image on retourne faux

        $size = getimagesize($value['tmp_name']);  // on recupere la taille de l'image

        //debug($size);
        //die();
        return $size[0] > $width && $size[1] > $height;
    }
}
