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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('google_id')->nullable()->unique();            
            $table->string('password')->nullable();
            $table->string('name');            
            $table->string('photo')->nullable();            
            $table->string('slug', 22)->unique();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();

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

            // Optional foreign keys to users table
            $table->foreign('created_by')
                        ->references('id')->on('users')
                        ->nullOnDelete();
            $table->foreign('deleted_by')
                        ->references('id')->on('users')
                        ->nullOnDelete();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
