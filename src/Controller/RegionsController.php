<?php

namespace App\Controller;

use App\Controller\AppController;

class RegionsController extends AppController {

    public $paginate = [
        'page' => 1,
        'limit' => 100,
        'maxLimit' => 150,
/*        'fields' => [
            'id', 'name', 'description'
        ],
*/        'sortWhitelist' => [
            'id', 'name', 'description'
        ]
    ];

}
