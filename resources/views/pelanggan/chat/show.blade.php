@extends('layouts.app')
@section('title', 'Chat')
@section('page-title', 'Chat - ' . $pesanan->kode_booking)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-chat-dots"></i> Chat dengan Kurir
                    @if($pesanan->pengantaran && $pesanan->pengantaran->kurir)
                        - {{ $pesanan->pengantaran->kurir->nama }}
                    @endif
                </h5>
                <a href="{{ route('pelanggan.chat.index') }}" class="btn btn-sm btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">
                        <strong>Pesanan:</strong> {{ $pesanan->kode_booking }} | 
                        <strong>Status:</strong> 
                        <span class="badge bg-{{ $pesanan->status_badge }}">
                            {{ ucfirst(str_replace('_', ' ', $pesanan->status)) }}
                        </span>
                    </small>
                </div>
                
                <div id="chat-messages" style="height: 400px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; background-color: #f8f9fa; margin-bottom: 15px;">
                    @forelse($pesan as $msg)
                    <div class="mb-3 {{ $msg->pengirim_id == auth()->id() ? 'text-end' : '' }}">
                        <div class="d-inline-block {{ $msg->pengirim_id == auth()->id() ? 'bg-primary text-white' : 'bg-white' }} p-2 rounded" 
                             style="max-width: 70%; {{ $msg->pengirim_id == auth()->id() ? '' : 'border: 1px solid #dee2e6;' }}">
                            <small class="d-block {{ $msg->pengirim_id == auth()->id() ? 'text-white-50' : 'text-muted' }}">
                                {{ $msg->pengirim->nama }} - {{ $msg->created_at->format('d/m/Y H:i') }}
                            </small>
                            <div class="mt-1">{{ $msg->isi_pesan }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-chat"></i> Belum ada pesan. Mulai percakapan!
                    </div>
                    @endforelse
                </div>

                <form id="chat-form" method="POST" action="{{ route('pelanggan.chat.store', $pesanan->pesanan_id) }}">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="isi_pesan" id="isi_pesan" class="form-control" 
                               placeholder="Ketik pesan..." required>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto scroll to bottom
    const chatMessages = document.getElementById('chat-messages');
    chatMessages.scrollTop = chatMessages.scrollHeight;

    // Auto refresh chat every 3 seconds
    setInterval(function() {
        fetch('{{ route("pelanggan.chat.show", $pesanan->pesanan_id) }}')
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newMessages = doc.getElementById('chat-messages');
                if (newMessages) {
                    const currentScroll = chatMessages.scrollTop;
                    const isAtBottom = chatMessages.scrollHeight - chatMessages.scrollTop <= chatMessages.clientHeight + 100;
                    
                    chatMessages.innerHTML = newMessages.innerHTML;
                    
                    if (isAtBottom) {
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    }, 3000);

    // Handle form submission
    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const messageInput = document.getElementById('isi_pesan');
        const message = messageInput.value;

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageInput.value = '';
                // Reload page to show new message
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengirim pesan. Silakan coba lagi.');
        });
    });
</script>
@endpush
@endsection

