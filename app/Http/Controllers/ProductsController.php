<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\JWTService\JWTService;
use App\Services\ModelServices\Products\ProductSaveService;
use App\Services\ModelServices\Products\ProductsByCategoryService;
use App\Services\ModelServices\Products\ProductsByUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $products = DB::collection('products')->get();

        return new JsonResponse(['data' => $products]);
    }

    /**
     * show
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product)
    {
        return new JsonResponse(['data' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductSaveService $productSaveService
     * @param ProductRequest $request
     * @param Product $product
     * @param JWTService $service
     * @return JsonResponse
     */
    public function store(
        ProductRequest $request,
        Product $product,
        JWTService $service,
        ProductSaveService $productSaveService
    ) : JsonResponse
    {
        $user = $service->getAuthUser($request->header('Authorization'));

        $data = $request->only(['name', 'description']);
        $data['user_id'] = $user->_id;

        $categories = $request['categories'];

        $productSaveService->run($product, $data, $categories);

        return new JsonResponse($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product) : JsonResponse
    {
        $product->delete();

        return new JsonResponse(null, 204);
    }

    /**
     * @param Category $category
     * @param ProductsByCategoryService $service
     * @return JsonResponse
     */
    public function showByCategory(Category $category, ProductsByCategoryService $service) : JsonResponse
    {
        $products = $service->run($category);

        return new JsonResponse($products);
    }

    /**
     * @param User $user
     * @param ProductsByUserService $service
     * @return JsonResponse
     */
    public function showByUser(User $user, ProductsByUserService $service) : JsonResponse
    {
        $products = $service->run($user);

        return new JsonResponse($products);
    }
}
