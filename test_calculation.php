<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\CauHinhLichLamViec;
use Carbon\Carbon;

$schedule = CauHinhLichLamViec::all()->keyBy('Thu');
$tuNgay = Carbon::parse('2026-02-13');
$denNgay = Carbon::parse('2026-02-20');
$count = 0;
$cur = $tuNgay->copy();

echo "Testing from 2026-02-13 to 2026-02-20\n";
while ($cur->lte($denNgay)) {
    $dayOfWeek = $cur->dayOfWeek;
    $dbDayOfWeek = ($dayOfWeek === 0) ? 8 : ($dayOfWeek + 1);
    if (isset($schedule[$dbDayOfWeek])) {
        $coLam = $schedule[$dbDayOfWeek]->CoLamViec;
        echo "Day: {$cur->toDateString()} (Thu: $dbDayOfWeek), CoLamViec: $coLam\n";
        if ($coLam)
            $count++;
    }
    $cur->addDay();
}
echo "Total Count: $count\n";
