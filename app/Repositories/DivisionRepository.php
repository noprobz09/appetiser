<?php

namespace App\Repositories;

use App\Repositories\Traits\CommonRepoMethod;
use App\Division;

Class DivisionRepository
{	
    use CommonRepoMethod;

    
    const primary_key = 'id';

    const name = 'name';

    public $id;


    public function __construct() 
    {
        $this->model = new Division;
    }

    public function store(array $data)
    {   
        
        $model = $this->model->create([
            self::name      => $data['name'],
        ]);

        $this->setId($model->id);

        return $model;
    }


    public function exist(string $name) 
    {
        return ($this->model->whereName($name)->count() > 0)    ?   true    :   false;
    }
    
}
