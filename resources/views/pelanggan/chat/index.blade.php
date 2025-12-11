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
                        <th>Kurir</th>
                        <th>Status Pesanan</th>
                        <th>Terakhir Chat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $p)
                    <tr>
                        <td><strong>{{ $p->kode_booking }}</strong></td>
                        <td>
                            @if($p->pengantaran && $p->pengantaran->kurir)
                                {{ $p->pengantaran->kurir->nama }}
                            @else
                                <span class="text-muted">Belum ada kurir</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $p->status_badge }}">
                                {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                            </span>
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
                            @if($p->pengantaran && $p->pengantaran->kurir_id)
                                <a href="{{ route('pelanggan.chat.show', $p->pesanan_id) }}" 
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-chat"></i> Chat
                                </a>
                            @else
                                <span class="text-muted">Menunggu kurir</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-inbox"></i> Tidak ada pesanan yang dapat di-chat
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

