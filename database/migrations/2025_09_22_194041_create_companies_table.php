<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');         // Razón social
            $table->string('num_doc', 11)->unique(); // RUC o documento
            $table->string('slug')->unique(); // Para el slug
            $table->boolean('is_active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }


};
