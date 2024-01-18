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
        Schema::create('deteils', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger("company_id"); 
        $table->foreign("company_id")->references("id")->on("companies")->onDelete("cascade");
        $table->text("B_Name");
        $table->text("B_Address");
        $table->string("B_Tel");
        $table->text("B_Dapart");
        $table->text("B_AddName");
        $table->timestamps();
        $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deteils');
    }
};
