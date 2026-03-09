<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CauHinhController extends Controller
{
    public function index()
    {
        $configs = \App\Models\SystemConfig::pluck('value', 'key')->toArray();
        $caLamViecs = \App\Models\DmCaLamViec::all();
        return view('config.index', compact('configs', 'caLamViecs'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token']);

        foreach ($data as $key => $value) {
            if ($value === 'on') {
                $value = 1;
            }
            \App\Models\SystemConfig::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Đã lưu cấu hình hệ thống thành công!');
    }

    public function updateCaLamViec(Request $request)
    {
        $data = $request->validate([
            'ca_lam_viecs' => 'required|array',
            'ca_lam_viecs.*.MaCa' => 'required',
            'ca_lam_viecs.*.TenCa' => 'required',
            'ca_lam_viecs.*.GioVao' => 'required',
            'ca_lam_viecs.*.GioRa' => 'required',
            'ca_lam_viecs.*.BatDauNghi' => 'required',
            'ca_lam_viecs.*.KetThucNghi' => 'required',
            'ca_lam_viecs.*.GhiChu' => 'nullable|string',
            'ca_lam_viecs.*.PhuCapCaDem' => 'nullable|numeric',
        ]);

        foreach ($data['ca_lam_viecs'] as $id => $caData) {
            $dmCa = \App\Models\DmCaLamViec::find($id);
            if ($dmCa) {
                // If the checkbox is checked, it will be in the request data, otherwise it won't be
                $isQuaDem = isset($request->ca_lam_viecs[$id]['LaCaQuaDem']);
                $caData['LaCaQuaDem'] = $isQuaDem ? 1 : 0;
                $caData['PhuCapCaDem'] = $caData['PhuCapCaDem'] ?? 0;

                $dmCa->update($caData);
            }
        }

        return redirect()->back()->with('success', 'Đã cập nhật thông tin ca làm việc thành công!');
    }
}
