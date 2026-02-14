@extends('layouts.app')

@section('title', 'Quản lý phòng ban - Vietnam Rubber Group')

@section('content')
    <div class="page-header">
        <h1>Quản lý phòng ban</h1>
        <p>Danh sách các phòng ban trong công ty</p>
    </div>

    <!-- Actions Bar -->
    <div class="card">
        <div class="action-bar">
            <div class="search-bar">
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" class="form-control" placeholder="Tìm kiếm phòng ban..." id="searchInput">
            </div>
            <div class="action-buttons">
                <a href="{{ route('phong-ban.taoView') }}" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Thêm phòng ban
                </a>
            </div>
        </div>
    </div>

    <!-- Cards Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 24px;">
        @forelse($phongBans ?? [] as $phongBan)
            <a href="{{ route('phong-ban.info', $phongBan->id) }}" style="text-decoration: none; color: inherit;">
                <div class="card department-card" style="transition: box-shadow 0.2s; cursor: pointer;">
                    <div style="display: flex; align-items: flex-start; gap: 16px;">
                        <div
                            style="width: 48px; height: 48px; background-color: rgba(15, 81, 50, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg fill="none" stroke="#0F5132" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div style="flex: 1;">
                            <h3 style="font-size: 18px; font-weight: 600; color: #1f2937; margin-bottom: 8px;">
                                {{ $phongBan->Ten }}</h3>
                            <p style="font-size: 14px; color: #6b7280; margin-bottom: 16px;">
                                {{ $phongBan->donVi->Ten ?? 'Chưa có đơn vị' }}</p>

                            <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px;">
                                <div
                                    style="display: flex; align-items: center; justify-content: space-between; font-size: 14px;">
                                    <span style="color: #6b7280;">Mã phòng ban:</span>
                                    <span class="font-medium" style="color: #1f2937;">{{ $phongBan->Ma }}</span>
                                </div>
                                <div
                                    style="display: flex; align-items: center; justify-content: space-between; font-size: 14px;">
                                    <span style="color: #6b7280;">Số nhân viên:</span>
                                    <span class="font-medium" style="color: #0F5132;">{{ $phongBan->nhanViens->count() ?? 0 }}
                                        người</span>
                                </div>
                            </div>

                            <div style="padding-top: 16px; border-top: 1px solid #f3f4f6;">
                                <span class="badge badge-success">Hoạt động</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 48px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    style="width: 48px; height: 48px; margin: 0 auto 16px; color: #9ca3af;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <p style="color: #6b7280; font-size: 16px;">Chưa có phòng ban nào</p>
                <a href="{{ route('phong-ban.taoView') }}" class="btn btn-primary" style="margin-top: 16px;">Thêm phòng ban đầu
                    tiên</a>
            </div>
        @endforelse
    </div>
@endsection

@push('styles')
    <style>
        .department-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function () {
            const searchTerm = this.value.toLowerCase();
            const cards = document.querySelectorAll('.department-card');

            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.parentElement.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
@endpush