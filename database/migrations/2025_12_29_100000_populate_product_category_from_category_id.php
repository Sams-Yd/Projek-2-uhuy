<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // For existing products, set the `category` text column from the categories table using category_id
        if (Schema::hasTable('products') && Schema::hasTable('categories')) {
            DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->whereNotNull('products.category_id')
                ->update(['products.category' => DB::raw('categories.name')]);
        }
    }

    public function down()
    {
        // Optionally clear category column (no irreversible data loss)
        if (Schema::hasTable('products')) {
            DB::table('products')->update(['category' => null]);
        }
    }
};
