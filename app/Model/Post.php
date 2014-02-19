<?php
class Post extends AppModel{

    public $hasAndBelongsToMany = array('Pet'); // un article va avoir plusieurs animaux

}