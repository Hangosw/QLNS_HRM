<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\DangKyNghiPhep;

$table = 'dang_ky_nghi_pheps';
$columns = Schema::getColumnListing($table);
echo "Columns: " . implode(', ', $columns) . "\n\n";

$latest = DB::table($table)->orderBy('id', 'desc')->first();
if ($latest) {
    echo "Latest Record (ID: {$latest->id}):\n";
    foreach ($latest as $col => $val) {
        echo "$col: $val\n";
    }
} else {
    echo "No records found.\n";
}
