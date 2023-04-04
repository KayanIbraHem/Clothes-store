<?php

namespace App\Repositorties;

use App\Models\Product;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use App\Repositorties\RepositoryInterface;

class ProductRepository  implements  RepositoryInterface
{
    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function baseQuery($relations = [], $withCount = [], $where = [])
    {
        $query = $this->product->select('*')->with($relations);
        foreach ($withCount as $key => $value) {
            $query->withCount($value);
        }
        foreach ($where as $key => $value) {
            $query->where($key, $value);
        }
        return $query;
    }

    public function getById($id)
    {
        return $this->product->where('id', $id)->firstOrFail();
    }

    public function store($request)
    {
        return $this->product->create($request);
    }

    public function update($id, $request)
    {
    }

    public function delete($request)
    {
        $product=$this->getById($request['id']);
        return $product->delete();
    }
}
