<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->make('auth')->loginUsingId(1); // Login as someone

use App\Http\Controllers\NghiPhepController;
use Illuminate\Http\Request;

$req = new Request([
    'NhanVienId' => 7,
    'LoaiNghiPhepId' => 1,
    'TuNgay' => '2026-02-18',
    'DenNgay' => '2026-02-28',
    'LyDo' => 'Test from script'
]);

$controller = new NghiPhepController();
$response = $controller->TaoMoi($req);

echo "Response Content: " . $response->getContent() . "\n";
