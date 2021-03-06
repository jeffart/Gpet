<?php
class Pet extends AppModel{

    public $belongsTo = array('Species');  // un animal appartient a une espece.

     // regle de validation pour le model pet
    public $validate = array(
        'name' => 'notEmpty',   // remplire le champs name
        'gender' => '/^(M|F)$/',  // type mal ou femmelle
        'avatarf' => array(
            'rule' => array('sizeimg',150, 150)  // une regle qui definit la taille de l'avatar
        )
    );

    // petite presistion cette fonction doit etre creer pour trouver l'avatar de l'animal
// pour afficher cette avatar dans le compte user


    public function afterFind($results, $primary = false){
        foreach($results as $k=>$result){
            if(isset($result[$this->alias]['avatar']) && isset($result[$this->alias]['id'])){
                $results[$k][$this->alias]['avatari'] = 'pets/' . ceil($result[$this->alias]['id']/1000) . '/' . $result[$this->alias]['id'] . '.jpg';
            }
        }
        return $results;
    }

    public function afterSave($created){
        // Upload de l'avatar de l'animal

       // debug($this->data);
        //die();
        //debug(get_defined_constants());
        //die();

        // si j'ai un avatar et si le temp name est different de vide
        if(isset($this->data[$this->alias]['avatarf']) && !empty($this->data[$this->alias]['avatarf']['tmp_name'])){
            $file = $this->data[$this->alias]['avatarf'];
            $dest = IMAGES . 'pets' . DS . ceil($this->id/1000); //on definit le dossier de destination
            if(!file_exists($dest)){
                mkdir($dest, 0777, true); // si le dossier n'existe pas on va le créee. ici le troisieme parametre true (signifie recursive a true. On cree tous les dossier dont on a besoin)
            }
            $dest .= DS . $this->id . '.jpg'; // ensuite on stocke le nom de l'image.   le (.dest) pour la concatenation.

            //debug($dest);
            //die();
            require APP . 'Vendor' . DS . 'imagine.phar'; // on inclut le plugin imagine.phar
            $imagine = new Imagine\Gd\Imagine(); // on initialise la librairie
            try{  // ici on met toute l'operation de dimensionnement dans un try
                $imagine
                    ->open($file['tmp_name'])   // on ouvrre limage
                    ->thumbnail(      // puis on utilise la fonction thumbnail
                        new Imagine\Image\Box(150, 150),
                        Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND)  // le type de redimentionnement
                    ->save($dest); // puis on enregistre l'image
                $this->saveField('avatar', 1); // ne pas oublier de mettre le champ avatar a 1 dans la base de données si tout c'est bien passé.
            }catch(Imagine\Exception\Exception $e){  // en cas d'erreur on recupere l'erreur
                debug($e);
            }

        }
    }

    // cette fonction va nous permettre de gerer la suppresion des images des avatar si jamais l'utilisateur supprme un animal.

    public function beforeDelete($cascade = true){   // avant la suppression
        $pet = $this->read('avatar,id');    // on recupere les donnés

        //debug($pet);
        //die();
        if(isset($pet[$this->alias]['avatari'])){  // si on a avatari (voir //debug($pet);)
            unlink(IMAGES . $pet[$this->alias]['avatari']); // on supprime le fichier
        }
        return true;
    }

}