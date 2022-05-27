<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('morphables', static function (Blueprint $table) {
            $table->id();
            $table->morphs('targetable');
            $table->morphs('morphable');
            $table->smallInteger('order_column');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('morphables');
    }
};
