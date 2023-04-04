<?php

namespace App\Services;

use App\Models\Category;
use App\Utils\ImageUpload;
use Yajra\DataTables\Facades\DataTables;
use App\Repositorties\CategoryRepository;

class CategoryService
{

    public $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->baseQuery(['child'])->get();
    }

    public function getMainCategorey()
    {
        return $this->categoryRepository->getMainCategorey();
    }

    public function getById($id, $childrenCount = false)
    {
        return $this->categoryRepository->getById($id, $childrenCount);
    }

    public function store($request)
    {
        $request['parent_id'] = $request['parent_id'] ?? 0;
        if (isset($request['image'])) {
            $request['image'] = ImageUpload::UploadImage($request['image']);
        }
        return $this->categoryRepository->store($request);
    }

    public function update($id, $request)
    {
        $request['parent_id'] = $request['parent_id'] ?? 0;
        if (isset($request['image'])) {
            $request['image'] = ImageUpload::UploadImage($request['image']);
        }
        return $this->categoryRepository->update($id, $request);
    }

    public function delete($request)
    {
        return $this->categoryRepository->delete($request);
    }
    public function dataTable()
    {
        $query = $this->categoryRepository->baseQuery(['parent']);
        return  DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $btn = '
                        <a href="' . Route('dashboard.categories.edit', $row->id) . '"  class="edit btn btn-success btn-sm" ><i class="fa fa-edit"></i></a>
                        <button type="button" id="deleteBtn"  data-id="' . $row->id . '" class="btn btn-danger mt-md-0 mt-2" data-bs-toggle="modal"
                        data-original-title="test" data-bs-target="#deletemodal"><i class="fa fa-trash"></i></button>';
            })
            ->addColumn('parent', function ($row) {
                if ($row->parent) {
                    return $row->parent->name;
                }
                return 'قسم رئيسي';
            })
            ->addColumn('image', function ($row) {
                return '<img src="' . asset($row->image) . '" width="100px" height="100px">';
            })
            ->rawColumns(['parent', 'action', 'image'])
            ->make(true);
    }
    
}
