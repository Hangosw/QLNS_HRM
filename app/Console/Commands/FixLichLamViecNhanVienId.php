<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixLichLamViecNhanVienId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:fix-lichlamviec';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix LichLamViec NhanVienId issue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            try {
                \Illuminate\Support\Facades\DB::statement('ALTER TABLE lich_lam_viecs DROP FOREIGN KEY lich_lam_viecs_ibfk_1;');
                $this->info('Dropped FK lich_lam_viecs_ibfk_1.');
            } catch (\Exception $e) {
                $this->info('FK already dropped: ' . $e->getMessage());
            }

            try {
                \Illuminate\Support\Facades\DB::statement('ALTER TABLE lich_lam_viecs DROP INDEX unique_nv_ngay;');
                $this->info('Dropped unique index unique_nv_ngay.');
            } catch (\Exception $e) {
                $this->info('Index already dropped: ' . $e->getMessage());
            }

            try {
                \Illuminate\Support\Facades\DB::statement('ALTER TABLE lich_lam_viecs DROP FOREIGN KEY lich_lam_viecs_nhanvienid_foreign;');
                $this->info('Dropped FK lich_lam_viecs_nhanvienid_foreign.');
            } catch (\Exception $e) {
                $this->info('Old FK not active: ' . $e->getMessage());
            }

            \Illuminate\Support\Facades\DB::statement('ALTER TABLE lich_lam_viecs MODIFY NhanVienId bigint(20) unsigned NULL;');
            $this->info('Column NhanVienId modified to nullable.');

            \Illuminate\Support\Facades\DB::statement('ALTER TABLE lich_lam_viecs ADD CONSTRAINT lich_lam_viecs_nhanvienid_foreign FOREIGN KEY (NhanVienId) REFERENCES nhan_viens(id) ON DELETE SET NULL;');
            $this->info('FK re-added with SET NULL.');

            \Illuminate\Support\Facades\DB::statement('ALTER TABLE lich_lam_viecs ADD UNIQUE INDEX unique_nv_ngay (NhanVienId, NgayLamViec);');
            $this->info('Unique index unique_nv_ngay restored.');

            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $this->info('Schema update successful!');

        } catch (\Exception $e) {
            $this->error('Failed: ' . $e);
        }
    }
}
