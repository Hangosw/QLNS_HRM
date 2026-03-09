<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('phieu_dieu_chuyen_noi_bo', function (Blueprint $table) {
            $table->boolean('DaTaoHopDong')->default(0)->after('CoThayDoiLuong');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phieu_dieu_chuyen_noi_bo', function (Blueprint $table) {
            $table->dropColumn('DaTaoHopDong');
        });
    }
};
