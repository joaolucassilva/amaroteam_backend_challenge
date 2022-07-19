<?php

namespace App\Services\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class JsonFile implements ImportFileInterface
{
    public function execute(string $file)
    {
        $file = json_decode($file);
        if (!empty($file->products)) {
            foreach ($file->products as $product) {
                Product::firstOrCreate(
                    ['name' => $product->name],
                    [
                        'id_import' => $product->id,
                        'uuid' => Str::uuid()->toString(),
                        'name' => $product->name,
                        'tags' => json_encode($product->tags)
                    ]
                );
            }
            Cache::flush();
        }
    }
}
