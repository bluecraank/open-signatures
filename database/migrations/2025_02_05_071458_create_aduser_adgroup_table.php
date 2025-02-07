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
        Schema::create('aduser_adgroup', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aduser_id')->constrained("ad_users")->onDelete('cascade');
            $table->foreignId('adgroup_id')->constrained("ad_groups")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aduser_adgroup');
    }
};
