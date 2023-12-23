<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\User\StoreUserRequest;
use App\Http\Resources\Dashboard\UserResource;
use App\Repositories\Eloquents\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    protected UserRepository $userRepository;

    public function __construct(){
        $this->userRepository = new UserRepository();
    }

    public function listUserTypes(){
        $userTypes = $this->userRepository->listUserTypes();
        return response()->json(['userTypes'=>$userTypes]);
    }

    public function index()
    {
       $perPage = request()->perPage ?? 10;
       $users = $this->userRepository->paginate($perPage);
       return  UserResource::collection( $users )->response();
    }

 
    public function store(StoreUserRequest $request)
    {
        if ( $request->hasFile( 'avatar' ) ) {
            $avatar = $this->storeFile( $request->image );
            $request->merge(['avatar'=>$avatar]);
        }
      $user  = $this->userRepository->create($request->all());
      return (new UserResource($user))->response();
    }

 
    public function show($id)
    {
        $user = $this->userRepository->find($id);
        return (new UserResource($user))->response();
    }

 
    public function update(Request $request)
    { 
        $user = $this->userRepository->find($request->id);
        
        if($request->hasFile('avatar')){
            $avatar = $this->storeFile($request->avatar);
            $request->merge(['avatar'=>$avatar]);
        }

        $user->update($request->all());
        return (new UserResource($user))->response();
    }

 
    public function destroy($id)
    {
        $user = $this->userRepository->find($id);
        $user->delete();
        return response()->json(['message'=>'User Deleted Successfully']);
    }
}
