<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Query\Builder;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query()
        ->when(request('search'), function(Builder  $query, $search) {
            return $query->where('name', 'like', '%'.$search. '%');
        });

         // Lấy giá trị của tham số 'page' từ query string (mặc định là 1 nếu không có)
        $page = $request->input('page', 1);

        // Số lượng bản ghi muốn hiển thị trên mỗi trang (ví dụ: 20 bản ghi mỗi trang)
        $perPage = 20;

        // Lấy các Category đã phân trang
        $categories = $query->paginate($perPage);

        // return $query->simplePaginate();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => 'required|max:255',
        ]);
        return Category::create($validated);

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        return $category;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $validated = $request->validate([
            'name' => 'nullable|unique:categories|max:255',
            'description' => 'nullable|max:255',
        ]);

        $category->update($validated);

        return $category;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        $category->delete();

        return $category;

    }
}
