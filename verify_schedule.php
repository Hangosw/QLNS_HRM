<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\CauHinhLichLamViec;

$schedule = CauHinhLichLamViec::all();
echo "Full Working Schedule Configuration:\n";
foreach ($schedule as $s) {
    echo "Thu: {$s->Thu}, Ten: {$s->TenThu}, CoLamViec: {$s->CoLamViec}\n";
}

use Carbon\Carbon;
$tu = Carbon::parse('2026-02-18');
$den = Carbon::parse('2026-02-28');
$sched = $schedule->keyBy('Thu');
$count = 0;
$cur = $tu->copy();

echo "\nCalculation for 2026-02-18 to 2026-02-28:\n";
while ($cur->lte($den)) {
    $dayOfWeek = $cur->dayOfWeek;
    $dbDayOfWeek = ($dayOfWeek === 0) ? 8 : ($dayOfWeek + 1);
    $coLam = isset($sched[$dbDayOfWeek]) ? $sched[$dbDayOfWeek]->CoLamViec : 'MISSING';
    echo "Date: {$cur->toDateString()} (Thu: $dbDayOfWeek), CoLamViec: $coLam\n";
    if ($coLam === 1 || $coLam === '1' || $coLam === true)
        $count++;
    $cur->addDay();
}
echo "Total Working Days calculated: $count\n";
