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
            $table->string('name');
            $table->string('slug', 22)->unique();

            // Functional status (enabled/disabled)
            $table->boolean('is_active')->default(true);

            // Audit fields
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            // Optional deletion reason
            $table->text('deletion_reason')->nullable();

            // Created at & Updated at
            $table->timestamps();

            // Soft delete (deleted_at)
            $table->softDeletes();

            // Optional foreign keys to users table
            $table->foreign('created_by')
                        ->references('id')->on('users')
                        ->nullOnDelete();
            $table->foreign('deleted_by')
                        ->references('id')->on('users')
                        ->nullOnDelete();
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
