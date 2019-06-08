<?php

namespace App\Repositories\Traits;

Trait CommonRepoMethod
{   
    
    public function getFirstByColumn(array $conditions)
    {
        $model = $this->model->query();
        foreach ($conditions as $key => $value) {
            $model->where($key, $value);
        }

        return $model->first();

    }


    public function setId(int $id)
    {
        $this->id = $id;
    }


    public function getId()
    {
        return $this->id;
    }


    public function firstOrCreate(array $condition, array $data) {
        return $this->model->firstOrCreate($condition, $data);
    }

}


