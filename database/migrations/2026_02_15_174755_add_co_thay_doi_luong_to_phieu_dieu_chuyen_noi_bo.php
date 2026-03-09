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
            $table->boolean('CoThayDoiLuong')->default(0)->after('LyDo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phieu_dieu_chuyen_noi_bo', function (Blueprint $table) {
            $table->dropColumn('CoThayDoiLuong');
        });
    }
};
