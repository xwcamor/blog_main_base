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
        Schema::create('locales', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 22)->unique();            
            $table->string('code', 10);    // es_PE, es_VE, pt_BR
            $table->string('name');        // Español (Perú), Español (Venezuela)
            $table->foreignId('language_id')->constrained();       

            // Functional status (enabled/disabled)
            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('locales');
    }
};
