<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\DangKyNghiPhep;
use App\Models\CauHinhLichLamViec;
use Carbon\Carbon;

// Use NghiPhepController's logic logic helper (simulated)
function calculate($tu, $den)
{
    $schedule = CauHinhLichLamViec::all()->keyBy('Thu');
    $count = 0;
    $cur = $tu->copy();
    while ($cur->lte($den)) {
        $dayOfWeek = $cur->dayOfWeek;
        $dbDayOfWeek = ($dayOfWeek === 0) ? 8 : ($dayOfWeek + 1);
        if (isset($schedule[$dbDayOfWeek]) && $schedule[$dbDayOfWeek]->CoLamViec)
            $count++;
        $cur->addDay();
    }
    return $count;
}

$tu = Carbon::parse('2026-02-18');
$den = Carbon::parse('2026-02-28');
$soNgay = calculate($tu, $den);

echo "Calculated days: $soNgay\n";

$record = DangKyNghiPhep::create([
    'NhanVienId' => 7,
    'LoaiNghiPhepId' => 1,
    'TuNgay' => $tu->format('Y-m-d'),
    'DenNgay' => $den->format('Y-m-d'),
    'SoNgayNghi' => $soNgay,
    'LyDo' => 'Test calculation fix',
    'TrangThai' => 2,
    'Dem' => 1
]);

echo "Created Record ID: {$record->id}, Saved SoNgayNghi: {$record->SoNgayNghi}\n";
