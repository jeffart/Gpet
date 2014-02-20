<?php
class Post extends AppModel{

    public $hasAndBelongsToMany = array('Pet'); // un article va avoir plusieurs animaux
    public $hasMany = array('Comment'); // un article va avoir plusieur commentaires
  // regele de validation pour l'editon et la creation des post
    public $validate = array(
        'name' => 'notEmpty',
        'photo' => array(          // 2 regle
            'create' => array(
                'rule' => 'forceJpg',   // on force jpg
                'on'   => 'create'      // la regle ne s'applique qu'a la creation
            ),
            'update' => array(
                'rule' => 'isJpg',
                'on'   => 'update'   // seulement  pour le mise à jour
            )
        )
    );

    public function forceJpg($check, $limit){
        $field = key($check);
        $filename = $check[$field]['name'];
        if(empty($filename)){
            return false;
        }
        $info = pathinfo($filename);
        return strtolower($info['extension']) == 'jpg';
    }

    // petite presistion cette fonction doit etre creer pour trouver les photos d'un post


    public function afterFind($results, $primary = false){

        //debug($results);
        foreach($results as $k=>$result){
            if(isset($result[$this->alias]['id'])){
                $results[$k][$this->alias]['photo'] = 'photos/' . ceil($result[$this->alias]['id']/1000) . '/' . $result[$this->alias]['id'] . '.jpg';
                $results[$k][$this->alias]['thumb'] = 'photos/' . ceil($result[$this->alias]['id']/1000) . '/' . $result[$this->alias]['id'] . '_thumb.jpg';
                // si on a une id de definit
                $results[$k][$this->alias]['url'] = array('controller' => 'posts', 'action' => 'view', $result[$this->alias]['id']);

               // debug($results[$k][$this->alias]['url']); die();
            }
        }
        return $results;
    }

// function untilisée pour supprimmer les photos avant la suppression d'un post
    public function beforeDelete($cascade = true){// avant la suppression
        $post = $this->read('id'); // on recupere  l'id
        if(isset($post[$this->alias]['photo'])){
            unlink(IMAGES . $post[$this->alias]['photo']); // on supprime les photo
            unlink(IMAGES . $post[$this->alias]['thumb']); // on supprime les thumbs


        }
        return true;
    }


    public function afterSave($created){

        // Upload de l'avatar de l'animal


        // si j'ai un avatar et si le temp name est different de vide
        if(isset($this->data[$this->alias]['photo']) && !empty($this->data[$this->alias]['photo']['tmp_name'])){
            $file = $this->data[$this->alias]['photo'];

            //on definit le dossier de destination
            $dest = IMAGES . 'photos' . DS . ceil($this->id/1000);

            // si le dossier n'existe pas on va le créee. ici le troisieme parametre true
            //(signifie recursive a true. On cree tous les dossier dont on a besoin)
            if(!file_exists($dest)){
                mkdir($dest, 0777, true);
            }
            // on inclut le plugin imagine.phar
            require APP . 'Vendor' . DS . 'imagine.phar';

            // on initialise la librairie
            $imagine = new Imagine\Gd\Imagine();
            // ici on met toute l'operation de dimensionnement dans un try
            // ici on va cree 2 version dimages (370, 208) (940, 530)
            try{
                $imagine
                    ->open($file['tmp_name'])  // on ouvrre limage
                    ->thumbnail(               // puis on utilise la fonction thumbnail
                        new Imagine\Image\Box(370, 208), // la taille du redimentionnement
                        Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND) // le type de redimentionnement
                    ->save($dest . DS . $this->id . '_thumb.jpg'); // puis on enregistre l'image
                $imagine
                    ->open($file['tmp_name'])
                    ->thumbnail(
                        new Imagine\Image\Box(940, 530),
                        Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND)
                    ->save($dest . DS . $this->id . '.jpg');
            }catch(Imagine\Exception\Exception $e){
                debug($e);
            }

        }
    }





}