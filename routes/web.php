<?php

use App\Models\Product;

Route::get('/', function () {
    $products = Product::all();

    foreach ($products as $product) {
        $product->categories()->attach(mt_rand(1, 2));
    }
});