<?php

namespace App\Http\Resources\Site;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => $this->is_active,
            'description' => $this->description,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'price' =>  $this->getPriceByUserTypes(),
        ];
    }

    function getPriceByUserTypes(): string
    {
        $price = $this->prices->first();
        return number_format($price->price,2);
    }

    public function with($request): array
    {
        return [
            'status' => true,
            'message' => 'Product list',
        ];
    }
}
