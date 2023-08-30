<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest('id')->get();

        return new CategoryResource($categories);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories',
        ]);

        //Validator Back
        if ($data->fails()) {
            return (new ErrorResource($data->getMessageBag()))->response()->setStatusCode(422);
        }

        $formData = $data->validated();
        $formData['slug'] = Str::slug($formData['name']);

        Category::create($formData);

        return (new SuccessResource(['message' => 'Category Created Successfully']))
        ->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories',
        ]);

        //Validator Back
        if ($data->fails()) {
            return (new ErrorResource($data->getMessageBag()))->response()->setStatusCode(422);
        }

        $formData = $data->validated();
        $formData['slug'] = Str::slug($formData['name']);

        $category->update($formData);

        return (new SuccessResource(['message' => 'Category Updated Successfully']))
        ->response()->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return (new SuccessResource(['message' => 'Category Deleted Successfully']))
        ->response()->setStatusCode(201);
    }
}
