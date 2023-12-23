<?php
namespace App\Repositories\Eloquents;

use App\Models\Otp;
use App\Repositories\Interfaces\OtpRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class OtpRepository extends BaseRepository implements OtpRepositoryInterface {
    protected Otp  $otp;

    public function __construct() {
        $this->model = new \App\Models\Otp();
    }

    
}