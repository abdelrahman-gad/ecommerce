<?php
namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface {
    
    public function create($data);
    public function update($data,$id);
    public function delete($id);
    public function find($id);
    public function all();
    public function paginate($perPage);
    public function search($query);
    public function with($relations);
    public function toSql();
    public function first();
    public function last();
    public function firstOrCreate($data);
    public function where($column, $value);
    public function whereColumns($columns);
    public function findWhere($field,$condition,$columns);
    public function whereIn($attribute,$values);
    public function max($column);
    public function min($column);
    public function avg($column);
    public function truncate();
    public function count($columns);
    public function simplePaginate($limit,$columns);
    public function pluck($value,$key);
    public function withTrashed();
    public function onlyTrashed();
    public function restore();
    public function forceDelete();
    public function findOrFail($id);
}