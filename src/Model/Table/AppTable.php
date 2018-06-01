<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class AppTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Timestamp');
        // $this->addBehavior('myBehavior2');
        // $this->addBehavior('myBehavior3');
    }
}