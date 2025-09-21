<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_modules', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 22)->unique();            
            $table->string('name'); // Ej: América del Sur
            $table->string('permission_key')->unique();     // permission (ej: "languages.index", "languages.index")

            // Audit fields
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            // Deletion reason
            $table->text('deleted_description')->nullable();

            // Created at & Updated at
            $table->timestamps();

            // Soft delete (deleted_at)
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_modules');
    }
};