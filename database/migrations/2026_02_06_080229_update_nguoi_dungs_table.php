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
        Schema::table('nguoi_dungs', function (Blueprint $table) {
            // Rename existing columns if they exist
            if (Schema::hasColumn('nguoi_dungs', 'name')) {
                $table->renameColumn('name', 'TaiKhoan');
            }
            if (Schema::hasColumn('nguoi_dungs', 'email')) {
                $table->renameColumn('email', 'Email');
            }
            if (Schema::hasColumn('nguoi_dungs', 'password')) {
                $table->renameColumn('password', 'MatKhau');
            }

            // Add missing columns
            if (!Schema::hasColumn('nguoi_dungs', 'SoDienThoai')) {
                $table->string('SoDienThoai')->nullable()->after('Email');
            }
            if (!Schema::hasColumn('nguoi_dungs', 'TrangThai')) {
                $table->integer('TrangThai')->default(1)->after('SoDienThoai');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nguoi_dungs', function (Blueprint $table) {
            if (Schema::hasColumn('nguoi_dungs', 'TaiKhoan')) {
                $table->renameColumn('TaiKhoan', 'name');
            }
            if (Schema::hasColumn('nguoi_dungs', 'Email')) {
                $table->renameColumn('Email', 'email');
            }
            if (Schema::hasColumn('nguoi_dungs', 'MatKhau')) {
                $table->renameColumn('MatKhau', 'password');
            }
            $table->dropColumn(['SoDienThoai', 'TrangThai']);
        });
    }
};
