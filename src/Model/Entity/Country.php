<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Country extends Entity
{

    protected $_accessible = [
        'name' => true,
        'code' => true,
        'regions' => true,
        'documents' => true,
    ];
}
