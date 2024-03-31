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

        //”company_id”のカラムを追加
        $table->unsignedBigInteger("company_id"); 
        //"companies"テーブルに外部制約キーを追加してondelete以降は参照しているレコードが削除されると関連する行を自動で削除
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
