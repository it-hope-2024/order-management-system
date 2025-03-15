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

                ->addColumn('action', function ($product) {
                    // Concatenate both Edit and Delete buttons
                    return '
                    <a href="' . route('products.edit', $product->id) . '" class="btn btn-info btn-sm">Edit</a>
                            <form action="' . route('products.destroy', $product->id) . '" method="POST" class="delete-form" style="display:inline;">
            ' . csrf_field() . '
            ' . method_field('DELETE') . '
            <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
        </form>

                ';
                })
                //     <form action="' . route('products.destroy', $product->id) . '" method="POST" style="display:inline;">
                //     ' . csrf_field() . '
                //     ' . method_field('DELETE') . '
                //     <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete?\')">Delete</button>
                // </form>
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
