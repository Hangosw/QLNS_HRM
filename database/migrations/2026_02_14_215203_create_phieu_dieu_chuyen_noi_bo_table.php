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
        if (!Schema::hasTable('phieu_dieu_chuyen_noi_bo')) {
            Schema::create('phieu_dieu_chuyen_noi_bo', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('NhanVienId');
                $table->unsignedBigInteger('NguoiYeuCauId');
                $table->unsignedBigInteger('DonViMoiId')->nullable();
                $table->unsignedBigInteger('PhongBanMoiId')->nullable();
                $table->unsignedBigInteger('ChucVuMoiId')->nullable();
                $table->date('NgayDuKien');
                $table->text('LyDo');
                $table->text('GhiChuLanhDao')->nullable();
                $table->string('TrangThai')->default('cho_duyet'); // cho_duyet, da_duyet, tu_choi
                $table->timestamps();

                // Foreign keys
                $table->foreign('NhanVienId')->references('id')->on('nhan_viens')->onDelete('cascade');
                $table->foreign('NguoiYeuCauId')->references('id')->on('nhan_viens')->onDelete('cascade');
                $table->foreign('DonViMoiId')->references('id')->on('don_vis')->onDelete('set null');
                $table->foreign('PhongBanMoiId')->references('id')->on('dm_phong_bans')->onDelete('set null');
                $table->foreign('ChucVuMoiId')->references('id')->on('dm_chuc_vus')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phieu_dieu_chuyen_noi_bo');
    }
};
