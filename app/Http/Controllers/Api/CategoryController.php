<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Traits\HttpResponse;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Category::all();
            return $this->success($categories, 'Categories data successfully');
        } catch (\Throwable $e) {
            return $this->internalError($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CategoryRequest $request)
    {
        try {
            $data = Category::create([
                'name' => $request->name,
            ]);

            return $this->created($data, 'Category created successfully');
        } catch (\Throwable $e) {
            return $this->internalError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->name = $request->name;
        $category->save();

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->notFound('Category not found', 'Category not found');
        }

        $category->delete();

        return $this->success('', 'Category deleted successfully', '200');
    }
}
