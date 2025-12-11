@extends('layouts.app')
@section('title', 'Chat')
@section('page-title', 'Daftar Chat')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-chat-dots"></i> Daftar Chat</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Pelanggan</th>
                        <th>Status Pengantaran</th>
                        <th>Terakhir Chat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengantaran as $p)
                    <tr>
                        <td><strong>{{ $p->pesanan->kode_booking }}</strong></td>
                        <td>{{ $p->pesanan->pelanggan->nama }}</td>
                        <td>
                            @php
                                $badgeColor = match($p->status) {
                                    'dijadwalkan' => 'warning',
                                    'dalam_perjalanan' => 'info',
                                    'selesai' => 'success',
                                    'gagal' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeColor }}">{{ ucfirst(str_replace('_', ' ', $p->status)) }}</span>
                        </td>
                        <td>
                            @php
                                $lastMessage = \App\Models\Pesan::where('pesanan_id', $p->pesanan_id)
                                    ->where(function($q) {
                                        $q->where('pengirim_id', auth()->id())
                                          ->orWhere('penerima_id', auth()->id());
                                    })
                                    ->latest()
                                    ->first();
                            @endphp
                            @if($lastMessage)
                                <small class="text-muted">{{ $lastMessage->created_at->diffForHumans() }}</small>
                            @else
                                <span class="text-muted">Belum ada chat</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('kurir.chat.show', $p->pesanan_id) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="bi bi-chat"></i> Chat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-inbox"></i> Tidak ada pengantaran yang dapat di-chat
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

