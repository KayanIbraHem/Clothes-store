<?php

namespace App\Services;

use App\Models\Category;
use App\Utils\ImageUpload;
use Yajra\DataTables\Facades\DataTables;

class CategoryService
{

    public function getMainCategorey()
    {
        return  Category::where('parent_id', 0)->orwhere('parent_id', null)->get();
    }

    public function getById($id, $childrenCount = false)
    {
        $query = Category::where('id', $id);
        if ($childrenCount) {
            $query->withCount('child');
        }
        return $query->firstorfail();
    }

    public function store($request)
    {
        $request['parent_id'] = $request['parent_id'] ?? 0;
        if (isset($request['image'])) {
            $request['image'] = ImageUpload::UploadImage($request['image']);
        }
        return Category::create($request);
    }
    public function update($id, $request)
    {
        $category = $this->getById($id);
        $request['parent_id'] = $request['parent_id'] ?? 0;
        if (isset($request['image'])) {
            $request['image'] = ImageUpload::UploadImage($request['image']);
        }
        return $category->update($request);
    }
    public function dataTable()
    {
        $query = Category::select('*')->with('parent');
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
