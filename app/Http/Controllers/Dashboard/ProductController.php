<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Products\ProductStoreRequest;
use App\Http\Requests\Dashboard\Products\ProductDeleteRequest;

class ProductController extends Controller
{
    public $productService;
    public $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return view('dashboard.products.index');
    }

    public function getall()
    {
        return $this->productService->dataTable();
    }

    public function create()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(ProductStoreRequest $request)
    {
        $this->productService->store($request->validated());
        return redirect()->route('dashboard.products.index')->with('success', 'تم الاضافة بنجاح');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function delete(ProductDeleteRequest $request)
    {
        $this->productService->delete($request->validated());
        return redirect()->route('dashboard.products.index');
    }

    public function destroy($id)
    {
    }
}
