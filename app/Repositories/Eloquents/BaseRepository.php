<?php
namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;
    public function __construct()
    {
       $this->model = new Model();
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
    public function  paginate($perPage)
    {
        return $this->model->paginate($perPage);
    }
    public function  where($column, $value)
    {
        return $this->model->where($column, $value);
    }

    public function whereColumns($columns)
    {
        $query = $this->model;
        foreach ($columns as $key => $value) {
            $query = $query->where($key, $value);
        }
        return $query;
    }

    public function search($queryArray)
    {
        $query = $this->model;
        foreach ($queryArray as $key => $value) {
            $query = $query->where($key, 'LIKE', '%' . $value . '%');
        }
        return $query;
    }
  
    public function with($relations)
    {
        return $this->model->with($relations);
    }
    public function toSql()
    {
        return $this->model->toSql();
    }
    public function first()
    {
        return $this->model->first();
    }
    public function last()
    {
        return $this->model->last();
    }
    public function firstOrCreate($data)
    {
        return $this->model->firstOrCreate($data);
    }

    public function findWhere($field, $condition, $columns)
    {
        return $this->model->where($field, $condition)->get($columns);
    }
    public function whereIn($attribute, $values)
    {
        return $this->model->whereIn($attribute, $values)->get();
    }
    public function max($column)
    {
        return $this->model->max($column);
    }
    public function min($column)
    {
        return $this->model->min($column);
    }
    public function avg($column)
    {
        return $this->model->avg($column);
    }
    public function truncate()
    {
        return $this->model->truncate();
    }
    public function count($columns)
    {
        return $this->model->count($columns);
    }
    public function simplePaginate($limit, $columns)
    {
        return $this->model->simplePaginate($limit, $columns);
    }
    public function pluck($value, $key)
    {
        return $this->model->pluck($value, $key);
    }
    public function withTrashed()
    {
        return $this->model->withTrashed();
    }
    public function onlyTrashed()
    {
        return $this->model->onlyTrashed();
    }
    public function restore()
    {
        return $this->model->restore();
    }
    public function forceDelete()
    {
        return $this->model->forceDelete();
    }
    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }



    

}