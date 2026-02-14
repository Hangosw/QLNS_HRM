<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\DangKyNghiPhep;

$records = DangKyNghiPhep::latest()->take(5)->get();
echo "Latest 5 records:\n";
foreach ($records as $l) {
    echo "ID: {$l->id}, NV: {$l->NhanVienId}, Tu: {$l->TuNgay->toDateString()}, Den: {$l->DenNgay->toDateString()}, Days: {$l->SoNgayNghi}\n";
}
