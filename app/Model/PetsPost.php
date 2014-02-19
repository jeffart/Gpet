<?php
class PetsPost extends AppModel{

    public $belongsTo = array('Post','Pet'); // appartient au articles et aux animaux.

}