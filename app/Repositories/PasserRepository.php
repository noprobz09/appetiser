<?php

namespace App\Repositories;

use App\Repositories\Traits\CommonRepoMethod;
use App\Passer;

Class PasserRepository
{	
    use CommonRepoMethod;

    
    const primary_key = 'id';

    const firstname = 'firstname';

    const lastname = 'lastname';

    const school_id = 'school_id';

    public $id;

    protected $limit = 50;


    public function __construct() 
    {
        $this->model = new Passer;
    }

    public function store(array $data)
    {   
        
        $model = $this->model->create([
            self::firstname     => $data['firstname'],
            self::lastname      => $data['lastname'],
            self::school_id     => $data['school_id'],
        ]);

        $this->setId($model->id);

        return $model;
    }


    public function getPassers(string $search='')
    {
        return $this->model->with('school', 'school.division')
                    ->where(function($query) use ($search){

                        if (!empty($search)) {
                            $query->orWhere('lastname', 'like', '%' . $search . '%');
                            $query->orWhere('firstname', 'like', '%' . $search . '%');
                            $query->orWhere(function ($query) use ($search) {
                                $query->orWhereHas('school', function ($query) use ($search) {
                                    $query->where('name', 'like', '%' . $search . '%');
                                });

                                $query->orWhereHas('school.division', function ($query) use ($search) {
                                    $query->where('name', 'like', '%' . $search . '%');
                                });
                            });
                        }

                    })
                    ->orderBy('lastname', 'asc')
                    ->paginate($this->limit);
    }    
}
