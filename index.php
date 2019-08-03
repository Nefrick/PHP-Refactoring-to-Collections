<?php

require_once './vendor/autoload.php';

function load_json($path)
{
    return json_decode(file_get_contents(__DIR__.'/'.$path), true);
}

$products = collect(load_json('products.json')['products']);

$totalCost = 0;

foreach ($products as $product) {
    if($product['product_type'] == 'lamp' || $product['product_type'] == 'Wallet'){
        foreach ($product['variants'] as $productVariant ){
            $totalCost += $productVariant['price'];
        }
    }
}
//dd($totalCost);

$totalCost  = $products->filter(function ($product){
    return collect(['lamp', 'Wallet'])->contains($product['product_type']);
})->flatMap(function ($product){
    return $product['variants'];
})->sum('price');


dd($totalCost);

// 16