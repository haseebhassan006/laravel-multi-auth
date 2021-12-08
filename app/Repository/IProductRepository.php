<?php
namespace App\Repository;

interface IProductRepository 
{
    public function getAllProducts();

    public function getProductById($id);

    public function createOrUpdate( $id = null, $collection = [] );

    public function deleteProduct($id);
}