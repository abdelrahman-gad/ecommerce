<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
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
            'prices' =>$this->getPricesWithUserTypes(),
        ];
    }

    function getPricesWithUserTypes(): array
    {
        $prices = [];
        foreach ($this->prices as $price) {
            $prices[] = [
                'id' => $price->id,
                'price' => $price->price,
                'user_type' => $price->userTypes->name,
            ];
        }
        return $prices;
    }
}
