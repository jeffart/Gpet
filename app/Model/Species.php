<?php
class Species extends AppModel{

    public $order = 'Species.name ASC'; // on defini un systeme d'organistaion par defaut des espece( les espece seront trié par ordre alphabétique).

// Grace a cette focntion on poura generer des liens de maniere automatique . lorsque l'on ferra appel au controller species.
    public function afterFind($results, $primary = false){
        foreach($results as $k=>$result){
            //debug($results);

            if(isset($result[$this->alias]['slug'])){  // si on recupere un slug
                $results[$k][$this->alias]['url'] = array( // on genere l'url qui sera un tableau  avec le nom du controller l'action et le slug
                    'controller' => 'posts',
                    'action'     => 'species',
                    'slug'       => $result[$this->alias]['slug']
                );
            }

            //debug($results[$k][$this->alias]);
        }
        return $results;
    }
}