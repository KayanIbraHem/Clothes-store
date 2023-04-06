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

    public function edit($id)
    {
        $categories = $this->categoryService->getAllCategories();
        $product = $this->productService->getById($id);
        return view('dashboard.products.edit', compact('categories', 'product'));
    }

    public function update($id, Request $request)
    {
        $this->productService->update($id, $request->all());
        return redirect()->route('dashboard.products.edit', $id)->with('success', 'تم التعديل بنجاح');
    }

    public function delete(ProductDeleteRequest $request)
    {
        $this->productService->delete($request->validated());
        return redirect()->route('dashboard.products.index');
    }
}
