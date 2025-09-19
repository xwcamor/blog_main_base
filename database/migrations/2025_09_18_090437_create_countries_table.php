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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained();
            $table->string('name');          // Perú
            $table->char('iso_code', 2);     // PE
            $table->string('currency', 3);   // PEN
            $table->string('timezone');      // America/Lima
            $table->foreignId('default_locale_id')->constrained('locales');
            $table->string('slug', 22)->unique();

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
        Schema::dropIfExists('countries');
    }
};
