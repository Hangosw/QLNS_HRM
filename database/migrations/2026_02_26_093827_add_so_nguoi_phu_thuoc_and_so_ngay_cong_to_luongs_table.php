<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('luongs', function (Blueprint $table) {
            if (!Schema::hasColumn('luongs', 'SoNguoiPhuThuoc')) {
                $table->unsignedInteger('SoNguoiPhuThuoc')->default(0);
            }
            if (!Schema::hasColumn('luongs', 'SoNgayCong')) {
                $table->unsignedInteger('SoNgayCong')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('luongs', function (Blueprint $table) {
            $table->dropColumn(['SoNguoiPhuThuoc', 'SoNgayCong']);
        });
    }
};
