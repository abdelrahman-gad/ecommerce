<?php

namespace App\Repositories\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected Model $model;
    public function __construct()
    {
       $this->model = new \App\Models\User();
    }
  
    public function listUserTypes(){
        return \App\Models\UserType::all();
    }
}
