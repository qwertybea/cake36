<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Region extends Entity
{

    protected $_accessible = [
        'name' => true,
        'country_id' => true,
        'code' => true,
        'country' => true,
    ];
}
