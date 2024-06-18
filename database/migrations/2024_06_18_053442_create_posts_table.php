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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Title of the post
            $table->string('slug')->unique(); // Unique URL slug for the post
            $table->text('excerpt'); // Short summary of the post
            $table->text('content'); // Full content of the post
            $table->unsignedBigInteger('category_id'); // Foreign key for the category
            $table->unsignedBigInteger('user_id'); // Foreign key for the user who created the post
            $table->timestamp('published_at')->nullable(); // Date and time of publication (can be null)
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
