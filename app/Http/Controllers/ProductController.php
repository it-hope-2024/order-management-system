<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getProducts(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::select([
                'id',
                // 'name',
                'name->en as name_en',
                'name->ar as name_ar',
                'price',
                'stock'
            ]);



            return DataTables::of($products)
                // ->addColumn('name_en', function ($product) {
                //     return $product->getTranslation('name', 'en');  // Assuming you want the English translation
                // })
                // ->addColumn('name_ar', function ($product) {
                //     return $product->getTranslation('name', 'ar');  // Assuming you want the English translation
                // })
                ->filterColumn('name_en', function ($query, $keyword) {
                    $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.en'))) LIKE ?", ["%" . strtolower($keyword) . "%"]);
                })
                ->filterColumn('name_ar', function ($query, $keyword) {
                    $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar'))) LIKE ?", ["%" . strtolower($keyword) . "%"]);
                })

                ->addColumn('action', function ($product) {
                    // Concatenate both Edit and Delete buttons
                    return '
                    <div class="d-flex justify-content-between">
                        <a href="' . route('products.edit', $product->id) . '" class="btn btn-info btn-sm">Edit</a>
                        
                        <form action="' . route('products.destroy', $product->id) . '" method="POST" class="delete-form">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                        </form>
                    </div>
                ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('products.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name.en' => 'required|unique:products,name->en|string|max:255',
            'name.ar' => 'required|unique:products,name->ar|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
        ]);

        Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
        ]);

        return redirect()->route('products.list')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name.en' => 'required|string|max:255|unique:products,name->en,' . $product->id,
            'name.ar' => 'required|string|max:255|unique:products,name->ar,' . $product->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
        ]);

        $product->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
        ]);

        return redirect()->route('products.list')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {


        $product->delete();

        return back()->with('delete', 'Your Product was deleted!');
    }
}
