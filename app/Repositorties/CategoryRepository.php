<?php

namespace App\Repositorties;

use App\Models\Category;

class CategoryRepository
{

    public $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    public function baseQuery($relations = [])
    {
        return $this->category->select('*')->with($relations);
    }
    public function getMainCategorey()
    {
        return $this->category->where('parent_id', 0)->get();
    }

    public function getById($id, $childrenCount = false)
    {
        $query = $this->category->where('id', $id);
        if ($childrenCount) {
            $query->withCount('child');
        }
        return $query->firstorfail();
    }

    public function store($request)
    {
        return $this->category->create($request);
    }

    public function update($id, $request)
    {
        $category = $this->getById($id);
        return $category->update($request);
    }

    public function delete($request)
    {
        $category = $this->getById($request['id']);
        return $category->delete();
    }
}
