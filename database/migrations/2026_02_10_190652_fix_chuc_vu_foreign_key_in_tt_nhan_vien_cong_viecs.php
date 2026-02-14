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
        Schema::table('tt_nhan_vien_cong_viecs', function (Blueprint $table) {
            // Drop the old foreign key constraint using array notation
            $table->dropForeign(['ChucVuId']);

            // Add the correct foreign key constraint
            $table->foreign('ChucVuId')
                ->references('id')
                ->on('dm_chuc_vus')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tt_nhan_vien_cong_viecs', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['ChucVuId']);

            // Restore the old foreign key constraint (for rollback)
            $table->foreign('ChucVuId')
                ->references('id')
                ->on('chuc_vus')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }
};
