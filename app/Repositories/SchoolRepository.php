<?php

namespace App\Repositories;

use App\Repositories\Traits\CommonRepoMethod;
use App\School;

Class SchoolRepository
{	
    use CommonRepoMethod;

    
    const primary_key = 'id';

    const name = 'name';

    const division_id = 'division_id';

    public $id;


    public function __construct() 
    {
        $this->model = new School;
    }

    public function store(array $data)
    {   
        
        $model = $this->model->create([
            self::name          =>  $data['name'],
            self::division_id   =>  $data['division_id'],
        ]);

        $this->setId($model->id);

        return $model;
    }


    public function exist(string $name) 
    {
        return ($this->model->whereName($name)->count() > 0)    ?   true    :   false;
    }

    public function lists()
    {
        return $this->model->withCount('passers')->orderBy('passers_count', 'desc')->get();
    }

}
