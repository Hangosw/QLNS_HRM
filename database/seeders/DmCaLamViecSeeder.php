<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DmCaLamViecSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $caLamViecs = [
            [
                'MaCa' => 'HC',
                'TenCa' => 'Ca Hành chính',
                'GioVao' => '08:00:00',
                'GioRa' => '17:00:00',
                'BatDauNghi' => '12:00:00',
                'KetThucNghi' => '13:00:00',
                'LaCaQuaDem' => false,
                'PhuCapCaDem' => 0,
                'GhiChu' => 'Dành cho khối văn phòng',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'MaCa' => 'CA1',
                'TenCa' => 'Ca 1 (Sáng)',
                'GioVao' => '06:00:00',
                'GioRa' => '14:00:00',
                'BatDauNghi' => '11:30:00',
                'KetThucNghi' => '12:00:00',
                'LaCaQuaDem' => false,
                'PhuCapCaDem' => 0,
                'GhiChu' => 'Ca sáng khối sản xuất',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'MaCa' => 'CA2',
                'TenCa' => 'Ca 2 (Chiều)',
                'GioVao' => '14:00:00',
                'GioRa' => '22:00:00',
                'BatDauNghi' => '17:30:00',
                'KetThucNghi' => '18:00:00',
                'LaCaQuaDem' => false,
                'PhuCapCaDem' => 0,
                'GhiChu' => 'Ca chiều khối sản xuất',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'MaCa' => 'CA3',
                'TenCa' => 'Ca 3 (Đêm)',
                'GioVao' => '22:00:00',
                'GioRa' => '06:00:00',
                'BatDauNghi' => '02:00:00',
                'KetThucNghi' => '02:45:00',
                'LaCaQuaDem' => true, // Cờ xử lý qua đêm
                'PhuCapCaDem' => 30,  // Cộng 30% lương
                'GhiChu' => 'Ca xuyên đêm, phụ cấp 30% theo luật',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('dm_ca_lam_viecs')->insert($caLamViecs);
    }
}