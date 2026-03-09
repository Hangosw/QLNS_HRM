<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncLeaveBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phep:sync';
    protected $description = 'Đồng bộ lại số ngày đã nghỉ và còn lại trong bảng quan_ly_phep_nams';

    public function handle()
    {
        $this->info('Bắt đầu đồng bộ dữ liệu phép năm...');

        $nam = now()->year;
        $qhPhep = \App\Models\QuanLyPhepNam::where('Nam', $nam)->get();

        foreach ($qhPhep as $phep) {
            $nhanVienId = $phep->NhanVienId;

            // Tính tổng ngày nghỉ của các đơn "Nghỉ phép năm" đã được DUYỆT (TrangThai = 1) trong năm nay
            $daNghi = \App\Models\DangKyNghiPhep::where('NhanVienId', $nhanVienId)
                ->where('TrangThai', 1)
                ->whereHas('loaiNghiPhep', function ($q) {
                    $q->where('Ten', 'Nghỉ phép năm');
                })
                ->whereYear('TuNgay', $nam)
                ->sum('SoNgayNghi');

            $phep->DaNghi = $daNghi;
            $phep->ConLai = (float) $phep->TongPhepDuocNghi - (float) $daNghi;
            $phep->save();

            $this->line("Nhân viên ID {$nhanVienId}: Đã nghỉ {$daNghi} ngày, Còn lại {$phep->ConLai} ngày.");
        }

        $this->info('Đã hoàn thành đồng bộ dữ liệu phép năm!');
    }
}
