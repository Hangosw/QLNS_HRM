<?php

namespace App\Http\Controllers;

use App\Models\VanThu;
use App\Models\DmVanBan;
use Illuminate\Http\Request;

class VanThuController extends Controller
{
    /**
     * View danh sách văn thư đến
     */
    public function IncomingView()
    {
        return view('documents.incoming');
    }

    /**
     * View danh sách văn thư đi
     */
    public function OutgoingView()
    {
        return view('documents.outgoing');
    }

    /**
     * Lấy dữ liệu văn thư đến cho DataTables
     */
    public function DataIncoming(Request $request)
    {
        return $this->getVanThuData($request, 1); // 1: Đến
    }

    /**
     * Lấy dữ liệu văn thư đi cho DataTables
     */
    public function DataOutgoing(Request $request)
    {
        return $this->getVanThuData($request, 2); // 2: Đi
    }

    /**
     * Helper xử lý dữ liệu DataTables
     */
    private function getVanThuData(Request $request, $huong)
    {
        $query = VanThu::with(['loaiVanBan', 'phongBan'])
            ->where('huong', $huong);

        // Server-side processing
        $totalRecords = $query->count();

        // Search
        if ($request->has('search') && $request->search['value']) {
            $searchValue = $request->search['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('so_hieu_van_ban', 'like', "%{$searchValue}%")
                    ->orWhere('tieu_de', 'like', "%{$searchValue}%");
            });
        }

        $filteredRecords = $query->count();

        // Sorting
        if ($request->has('order')) {
            $columnIndex = $request->order[0]['column'];
            $columnDir = $request->order[0]['dir'];
            $columns = ['id', 'ngay', 'so_hieu_van_ban', 'tieu_de', 'loai_van_ban_id', 'co_quan_id', 'trang_thai'];
            if (isset($columns[$columnIndex])) {
                $query->orderBy($columns[$columnIndex], $columnDir);
            }
        } else {
            $query->orderBy('ngay', 'desc');
        }

        // Pagination
        $start = $request->start ?? 0;
        $length = $request->length ?? 10;
        $data = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }
}
