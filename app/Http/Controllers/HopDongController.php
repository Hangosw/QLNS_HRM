<?php

namespace App\Http\Controllers;

use App\Models\DmChucVu;
use App\Models\DmPhongBan;
use App\Models\DonVi;
use App\Models\NhanVien;
use Illuminate\Http\Request;

class HopDongController extends Controller
{
    public function DanhSachView()
    {
        return view('contracts.index');
    }

    public function DataHopDong(Request $request)
    {
        $query = \App\Models\HopDong::with(['nhanVien']);

        // Server-side processing
        $totalRecords = $query->count();

        // Search
        if ($request->has('search') && $request->search['value']) {
            $searchValue = $request->search['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('SoHopDong', 'like', "%{$searchValue}%")
                    ->orWhereHas('nhanVien', function ($sq) use ($searchValue) {
                        $sq->where('Ten', 'like', "%{$searchValue}%");
                    });
            });
        }

        $filteredRecords = $query->count();

        // Sorting
        if ($request->has('order')) {
            $columnIndex = $request->order[0]['column'];
            $columnDir = $request->order[0]['dir'];
            $columns = ['id', 'NhanVienId', 'Loai', 'NgayBatDau', 'TongLuong', 'TrangThai'];
            if (isset($columns[$columnIndex])) {
                $query->orderBy($columns[$columnIndex], $columnDir);
            }
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

    public function Info($id)
    {
        $hopDong = \App\Models\HopDong::with([
            'nhanVien',
            'nguoiKy',
            'donVi',
            'phongBan',
            'chucVu',
            'loaiHopDong'
        ])->findOrFail($id);

        return view('contracts.show', compact('hopDong'));
    }

    public function XoaNhieu(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids)) {
            \App\Models\HopDong::whereIn('id', $ids)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa ' . count($ids) . ' hợp đồng thành công!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Vui lòng chọn hợp đồng để xóa'
        ], 400);
    }

    public function TaoView()
    {
        $donvi = DonVi::all();
        $phongban = DmPhongBan::all();
        $chucvu = DmChucVu::all();
        $nhanvien = NhanVien::with(['ttCongViec.chucVu', 'ttCongViec.phongBan', 'ttCongViec.donVi'])->get();

        // Get current base salary
        $baseSalary = \App\Models\ThamSoLuong::getCurrentBaseSalary();
        $mucLuongCoSo = $baseSalary ? $baseSalary->MucLuongCoSo : 2340000; // Default fallback

        return view('contracts.create', compact('nhanvien', 'donvi', 'phongban', 'chucvu', 'mucLuongCoSo'));
    }

    public function Tao(Request $request)
    {
        // Debug: Log request data
        \Log::info('Contract Creation Request:', $request->all());

        // Validate incoming request
        $validated = $request->validate([
            'nhan_vien_id' => 'required|exists:nhan_viens,id',
            'NguoiKyId' => 'required|exists:nhan_viens,id',
            'so_hop_dong' => 'required|string|max:255',
            'loai_hop_dong_id' => 'required|integer',
            'loai' => 'required|string|max:50',
            'don_vi_id' => 'required|exists:don_vis,id',
            'phong_ban_id' => 'required|exists:dm_phong_bans,id',
            'chuc_vu_id' => 'required|exists:dm_chuc_vus,id',
            'NgayBatDau' => 'required|date_format:d/m/Y',
            'NgayKetThuc' => 'nullable|date_format:d/m/Y',
            'trang_thai' => 'required|in:0,1,2',
            // Salary fields
            'luong_co_ban' => 'required|numeric|min:5310000',
            'phu_cap_chuc_vu' => 'nullable|numeric|min:0',
            'phu_cap_trach_nhiem' => 'nullable|numeric|min:0',
            'phu_cap_doc_hai' => 'nullable|numeric|min:0',
            'phu_cap_tham_nien' => 'nullable|numeric|min:0',
            'phu_cap_khu_vuc' => 'nullable|numeric|min:0',
            'phu_cap_an_trua' => 'nullable|numeric|min:0',
            'phu_cap_xang_xe' => 'nullable|numeric|min:0',
            'phu_cap_dien_thoai' => 'nullable|numeric|min:0',
            'phu_cap_nha_o' => 'nullable|numeric|min:0',
            'phu_cap_khac' => 'nullable|numeric|min:0',
            'tong_luong' => 'required|numeric|min:0',
            // File upload
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        try {
            // Map snake_case form inputs to PascalCase database columns
            $data = [
                'NhanVienId' => $validated['nhan_vien_id'],
                'NguoiKyId' => $validated['NguoiKyId'], // Use validated data
                'SoHopDong' => $validated['so_hop_dong'],
                'Loai' => $validated['loai'],
                'DonViId' => $validated['don_vi_id'],
                'PhongBanId' => $validated['phong_ban_id'],
                'ChucVuId' => $validated['chuc_vu_id'],
                'TrangThai' => $validated['trang_thai'],
                // Salary fields
                'LuongCoBan' => $validated['luong_co_ban'],
                'PhuCapChucVu' => $validated['phu_cap_chuc_vu'] ?? 0,
                'PhuCapTrachNhiem' => $validated['phu_cap_trach_nhiem'] ?? 0,
                'PhuCapDocHai' => $validated['phu_cap_doc_hai'] ?? 0,
                'PhuCapThamNien' => $validated['phu_cap_tham_nien'] ?? 0,
                'PhuCapKhuVuc' => $validated['phu_cap_khu_vuc'] ?? 0,
                'PhuCapAnTrua' => $validated['phu_cap_an_trua'] ?? 0,
                'PhuCapXangXe' => $validated['phu_cap_xang_xe'] ?? 0,
                'PhuCapDienThoai' => $validated['phu_cap_dien_thoai'] ?? 0,
                'PhuCapKhac' => ($validated['phu_cap_khac'] ?? 0) + ($validated['phu_cap_nha_o'] ?? 0),
                'TongLuong' => $validated['tong_luong'],
            ];

            // Convert date format from dd/mm/yyyy to yyyy-mm-dd
            $data['NgayBatDau'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['NgayBatDau'])->format('Y-m-d');
            if (!empty($validated['NgayKetThuc'])) {
                $data['NgayKetThuc'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['NgayKetThuc'])->format('Y-m-d');
            }

            // Handle file upload if present
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/contracts'), $filename);
                $data['File'] = 'uploads/contracts/' . $filename;
            }

            // Create contract
            $hopDong = \App\Models\HopDong::create($data);

            // Update or create employee's department and position in tt_nhan_vien_cong_viecs
            \App\Models\TtNhanVienCongViec::updateOrCreate(
                ['NhanVienId' => $data['NhanVienId']], // Find by NhanVienId
                [
                    'PhongBanId' => $data['PhongBanId'],
                    'ChucVuId' => $data['ChucVuId'],
                    'DonViId' => $data['DonViId'],
                ]
            );


            // Return JSON response for AJAX requests
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Hợp đồng đã được tạo thành công và thông tin nhân viên đã được cập nhật!'
                ]);
            }

            return redirect()->route('contracts.index')->with('success', 'Hợp đồng đã được tạo thành công và thông tin nhân viên đã được cập nhật!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors as JSON
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            // Return general errors as JSON
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
