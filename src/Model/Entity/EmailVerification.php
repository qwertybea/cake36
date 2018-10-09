<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Document extends Entity
{
    protected $_accessible = [
        'user_id' => true,
        'code' => true,
        'created' => true,
        'modified' => true,
        'user' => true
    ];
}
