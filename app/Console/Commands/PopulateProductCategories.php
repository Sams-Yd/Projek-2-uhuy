<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;

class PopulateProductCategories extends Command
{
    protected $signature = 'products:populate-categories';
    protected $description = 'Populate product categories from category text or category_id';

    public function handle()
    {
        $this->info('Mengisi kategori produk...');

        // Get all categories
        $categories = Category::all()->keyBy('name');

        // Update all products
        $products = Product::all();
        $updated = 0;
        $skipped = 0;

        foreach ($products as $product) {
            // If product already has category_id, use it to fill category field
            if ($product->category_id && !$product->category) {
                $cat = Category::find($product->category_id);
                if ($cat) {
                    $product->update(['category' => $cat->name]);
                    $updated++;
                    $this->line("✓ Produk #{$product->id} ({$product->name}) → {$cat->name}");
                } else {
                    $skipped++;
                }
            }
            // If product has category text but no category_id, find matching category
            elseif ($product->category && !$product->category_id) {
                if (isset($categories[$product->category])) {
                    $cat = $categories[$product->category];
                    $product->update(['category_id' => $cat->id]);
                    $updated++;
                    $this->line("✓ Produk #{$product->id} ({$product->name}) → ID {$cat->id}");
                } else {
                    $skipped++;
                }
            }
            // Both are filled
            elseif ($product->category_id && $product->category) {
                $cat = Category::find($product->category_id);
                if ($cat && $cat->name !== $product->category) {
                    $product->update(['category' => $cat->name]);
                    $updated++;
                    $this->line("✓ Sinkronisasi Produk #{$product->id} → {$cat->name}");
                }
            }
        }

        $this->info("\n✓ Selesai! {$updated} produk diperbarui, {$skipped} produk dilewati.");
    }
}
