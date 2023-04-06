<?php

namespace App\Repositorties;

use App\Models\Product;
use App\Models\Category;
use App\Utils\ImageUpload;
use Yajra\DataTables\Facades\DataTables;
use App\Repositorties\RepositoryInterface;

class ProductRepository  implements RepositoryInterface
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
        $product = $this->getById($id);
        $images = $this->uploadMultipleImages($request, $product);
        $product->images()->createmany($images);
        return $product->update($request);
    }

    public function delete($request)
    {
        $product = $this->getById($request['id']);
        return $product->delete();
    }
    private function uploadMultipleImages($request, $product)
    {
        $images = [];
        if (isset($request['images'])) {
            $i = 0;
            foreach ($request['images'] as $image) {
                $images[$i]['image'] =  ImageUpload::UploadImage($image);
                $images[$i]['product_id'] = $product->id;
                $i++;
            }
        }
        return $images;
    }
}
