<?php

namespace App\Services;

use App\Utils\ImageUpload;
use App\Repositorties\ProductRepository;
use Yajra\DataTables\Facades\DataTables;

class ProductService
{
    public $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }

    public function getAll()
    {
        return $this->productRepository->baseQuery();
    }

    public function getById($id)
    {
        return $this->productRepository->baseQuery([], [], ['id' => $id])->firstOrFail();
    }

    public function store($request)
    {
        if (isset($request['image'])) {
            $request['image'] = ImageUpload::UploadImage($request['image'],null,null,'product/');
        }
        return $this->productRepository->store($request);
    }

    public function update($id, $request)
    {
    }

    public function delete($request)
    {
        return $this->productRepository->delete($request);
    }

    public function dataTable()
    {
        $query = $this->productRepository->baseQuery(relations: ['category'],withCount:['productColor']);
        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                return $btn = '
                <a href="' . Route('dashboard.products.edit', $row->id) . '"  class="edit btn btn-success btn-sm" ><i class="fa fa-edit"></i></a>
                <button type="button" id="deleteBtn"  data-id="' . $row->id . '" class="btn btn-danger mt-md-0 mt-2" data-bs-toggle="modal"
                data-original-title="test" data-bs-target="#deletemodal"><i class="fa fa-trash"></i></button>';
            })
            ->addColumn('category', function ($row) {
                return $row->category->name;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
