<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ProductRepository implements ProductRepositoryInterface
{
    protected Model $model;
    public function __construct()
    {
       $this->model = new \App\Models\Product();
    }
    public function  create($data)
    {
        return $this->model->create($data);
    }

    public function  update($data, $id)
    {
        $record = $this->find($id);
        return $record->update($data);
    }

    public function  delete($id)
    {
        return $this->model->destroy($id);
    }

    public function  find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function  all()
    {
        return $this->model->all();
    }


}
