<?php
namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface{
    public function create($data);
    public function update($data,$id);
    public function delete($id);
    public function find($id);
    public function all();
}
