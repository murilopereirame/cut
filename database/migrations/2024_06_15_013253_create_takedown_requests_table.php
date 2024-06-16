<?php

use App\Enums\TakedownStatus;
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
        Schema::create('takedown_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('url_id');
            $table->string('reason', 300);
            $table->enum('status', TakedownStatus::toArray())->default(TakedownStatus::PENDING->asValue());
            $table->text('observations')->nullable();

            $table->foreign('url_id')->references('id')->on('shorten_urls')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('takedown_requests');
    }
};
