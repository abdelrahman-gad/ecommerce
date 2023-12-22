<?php
namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface extends BaseRepositoryInterface{
    public function assignPricesToProduct($productId,$prices);
    public function updateProductPrices($productId,$prices);
}
