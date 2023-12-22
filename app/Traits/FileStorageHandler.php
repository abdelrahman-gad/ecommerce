<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait FileStorageHandler
 {
    public function storeFile( UploadedFile $file ):string {
        $fileName = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $name               = $fileName . '_' . time() . '.' . $ext;
        $destinationPath    = public_path() . '/products';
        $file->move( $destinationPath, $name );
        $path = url( 'products' ) . '/'. $name;
        return $path;
    }
}