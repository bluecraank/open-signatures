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
        Schema::create('adgroup_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adgroup_id')->constrained("ad_groups")->onDelete('cascade');
            $table->foreignId('group_id')->constrained("groups")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adgroup_group');
    }
};
