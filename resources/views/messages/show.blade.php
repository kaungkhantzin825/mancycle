@extends('layouts.mancycle')

@section('title', 'Messages - ManCycle')

@section('content')
<section style="padding: 2rem 0; background: #f8fafc; min-height: calc(100vh - 200px);">
    <div class="container">
        <div class="chat-container" style="display: grid; grid-template-columns: 320px 1fr; background: #fff; border-radius: 1rem; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);">
            <!-- Sidebar -->
            <aside style="border-right: 1px solid #e5e7eb; display: flex; flex-direction: column;">
                <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #e5e7eb; display:flex; align-items:center; justify-content: space-between;">
                    <h2 style="font-size: 1rem; font-weight: 700; color:#1f2937;">Conversations</h2>
                </div>
                <div style="padding: 0.75rem 1rem;">
                    <input type="text" id="chatSearch" placeholder="Search..." style="width:100%; padding:0.5rem 0.75rem; border:1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem;">
                </div>
                <div id="chatList" style="flex:1; overflow-y:auto;">
                    @forelse($chats as $c)
                        @php
                            $other = auth()->id() === $c->buyer_id ? $c->seller : $c->buyer;
                            $active = $c->id === $chat->id;
                        @endphp
                        <a href="{{ route('messages.show', $c) }}" style="display:flex; gap:0.75rem; align-items:center; padding:0.75rem 1rem; text-decoration:none; background: {{ $active ? '#eff6ff' : 'transparent' }}; border-left: 3px solid {{ $active ? '#667eea' : 'transparent' }};">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($other->name) }}&background=667eea&color=fff" alt="{{ $other->name }}" style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
                            <div style="min-width:0;">
                                <div style="font-weight:600; color:#1f2937; font-size:0.9rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $other->name }}</div>
                                <div style="color:#6b7280; font-size:0.75rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ optional($c->latestMessage)->message ?? 'No messages yet' }}
                                </div>
                            </div>
                        </a>
                    @empty
                        <div style="padding:1rem; color:#6b7280;">No conversations yet.</div>
                    @endforelse
                </div>
            </aside>

            <!-- Main Chat -->
            <div style="display:flex; flex-direction:column; min-height:540px;">
                <!-- Header -->
                @php $other = auth()->id() === $chat->buyer_id ? $chat->seller : $chat->buyer; @endphp
                <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #e5e7eb; display:flex; align-items:center; gap:0.75rem; background:#f9fafb;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($other->name) }}&background=667eea&color=fff" alt="{{ $other->name }}" style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
                    <div>
                        <div style="font-weight:700; color:#1f2937;">{{ $other->name }}</div>
                        <div style="font-size:0.8rem; color:#6b7280;">{{ $chat->listing->title ?? 'General chat' }}</div>
                    </div>
                    @if($chat->listing)
                    <a href="{{ route('listings.show', $chat->listing) }}" style="margin-left:auto; background:#667eea; color:white; text-decoration:none; padding:0.4rem 0.75rem; border-radius: 0.375rem; font-size:0.8rem;">View Listing</a>
                    @endif
                </div>

                <!-- Messages -->
                <div id="messagesArea" style="flex:1; overflow-y:auto; padding:1rem; display:flex; flex-direction:column; gap:0.75rem;">
                    @foreach($messages as $m)
                        @php $isMine = $m->sender_id === auth()->id(); @endphp
                        <div style="display:flex; gap:0.5rem; {{ $isMine ? 'justify-content:flex-end;' : '' }}">
                            @unless($isMine)
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($m->sender->name) }}&background=6b7280&color=fff" alt="{{ $m->sender->name }}" style="width:28px; height:28px; border-radius:50%; object-fit:cover;">
                            @endunless
                            <div style="max-width:70%; display:flex; flex-direction:column; align-items: {{ $isMine ? 'flex-end' : 'flex-start' }};">
                                @if($m->message)
                                <div style="background: {{ $isMine ? '#667eea' : '#f3f4f6' }}; color: {{ $isMine ? 'white' : '#111827' }}; padding:0.5rem 0.75rem; border-radius: 0.75rem; font-size:0.9rem;">{{ $m->message }}</div>
                                @endif
                                @if($m->attachments)
                                  <div style="margin-top:0.35rem; display:flex; gap:0.5rem; flex-wrap:wrap;">
                                    @foreach($m->attachments as $att)
                                      @php $cat = $att['category'] ?? 'file'; @endphp
                                      @if($cat === 'image')
                                        <a href="{{ asset('storage/'.($att['path'] ?? '')) }}" target="_blank" style="display:inline-block; border-radius:0.5rem; overflow:hidden; border:1px solid #e5e7eb;">
                                          <img src="{{ asset('storage/'.($att['path'] ?? '')) }}" alt="attachment" style="width:120px; height:120px; object-fit:cover; display:block;">
                                        </a>
                                      @elseif($cat === 'audio')
                                        <audio controls src="{{ asset('storage/'.($att['path'] ?? '')) }}" style="max-width:250px;"></audio>
                                      @else
                                        <a href="{{ asset('storage/'.($att['path'] ?? '')) }}" target="_blank" style="color:#2563eb; text-decoration:underline;">{{ $att['original'] ?? 'Download file' }}</a>
                                      @endif
                                    @endforeach
                                  </div>
                                @endif
                                <div style="font-size:0.7rem; color:#9ca3af; margin-top:0.15rem;">{{ $m->created_at->format('H:i') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Local Attachment Preview (before send) -->
                <div id="attachPreview" style="padding:0 1rem 0.25rem 1rem; display:none;">
                    <div id="attachPreviewList" style="display:flex; gap:0.5rem; flex-wrap:wrap;"></div>
                </div>

                <!-- Input -->
                <form id="messageForm" method="POST" action="{{ route('messages.store', $chat) }}" enctype="multipart/form-data" style="padding:0.75rem 1rem; border-top:1px solid #e5e7eb; display:flex; align-items:center; gap:0.5rem;">
                    @csrf
                    <label for="attachInput" title="Attach images or audio" style="cursor:pointer; display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:50%; background:#f3f4f6; color:#6b7280;"><i class="fas fa-paperclip"></i></label>
                    <input type="file" id="attachInput" name="attachments[]" multiple accept="image/*,audio/*" style="display:none;">
                    <button type="button" id="voiceBtn" title="Record voice" style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:50%; background:#f3f4f6; color:#6b7280; border: none;"><i class="fas fa-microphone"></i></button>
                    <input type="text" id="messageInput" name="message" placeholder="Type your message..." autocomplete="off" style="flex:1; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius: 1rem; font-size:0.9rem;">
                    <button type="submit" class="btn btn-primary" style="padding:0.5rem 0.9rem;">Send</button>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
(function(){
    const form = document.getElementById('messageForm');
    const input = document.getElementById('messageInput');
    const files = document.getElementById('attachInput');
    const area = document.getElementById('messagesArea');
    const previewWrap = document.getElementById('attachPreview');
    const previewList = document.getElementById('attachPreviewList');
    const voiceBtn = document.getElementById('voiceBtn');

    // Voice recording state
    let mediaRecorder = null;
    let voiceChunks = [];
    let voiceBlob = null; // pending to send
    let voicePreviewEl = null;

    function scrollBottom(){ area.scrollTop = area.scrollHeight; }
    document.addEventListener('DOMContentLoaded', scrollBottom);

    // Render local previews for selected files
    files.addEventListener('change', function(){
        previewList.innerHTML = '';
        const fl = Array.from(files.files || []);
        if (!fl.length) { previewWrap.style.display = 'none'; return; }
        previewWrap.style.display = 'block';
        fl.forEach(file => {
            const type = file.type || '';
            if (type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = e => {
                    const box = document.createElement('div');
                    box.style.cssText = 'width:64px;height:64px;border:1px solid #e5e7eb;border-radius:0.5rem;overflow:hidden;';
                    box.innerHTML = `<img src="${e.target.result}" alt="preview" style="width:100%;height:100%;object-fit:cover;">`;
                    previewList.appendChild(box);
                };
                reader.readAsDataURL(file);
            } else if (type.startsWith('audio/')) {
                const chip = document.createElement('div');
                chip.style.cssText = 'padding:0.25rem 0.5rem;border:1px solid #e5e7eb;border-radius:999px;background:#f9fafb;font-size:0.75rem;color:#374151;';
                chip.textContent = file.name;
                previewList.appendChild(chip);
            } else {
                const chip = document.createElement('div');
                chip.style.cssText = 'padding:0.25rem 0.5rem;border:1px solid #e5e7eb;border-radius:999px;background:#f9fafb;font-size:0.75rem;color:#374151;';
                chip.textContent = file.name;
                previewList.appendChild(chip);
            }
        });
        // If files selected manually, clear any voice preview
        voiceBlob = null;
        if (voicePreviewEl) { voicePreviewEl.remove(); voicePreviewEl = null; }
    });

    // Voice recording logic using MediaRecorder
    async function toggleRecording(){
        if (!mediaRecorder || mediaRecorder.state === 'inactive'){
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                voiceChunks = [];
                mediaRecorder.ondataavailable = e => { if (e.data && e.data.size) voiceChunks.push(e.data); };
                mediaRecorder.onstop = () => {
                    voiceBlob = new Blob(voiceChunks, { type: 'audio/webm' });
                    // Show preview chip/audio
                    if (voicePreviewEl) voicePreviewEl.remove();
                    const url = URL.createObjectURL(voiceBlob);
                    voicePreviewEl = document.createElement('div');
                    voicePreviewEl.style.cssText = 'margin-top:0.25rem;';
                    voicePreviewEl.innerHTML = '<audio controls src="'+url+'" style="max-width:250px;"></audio>';
                    previewList.appendChild(voicePreviewEl);
                    previewWrap.style.display = 'block';
                };
                mediaRecorder.start();
                voiceBtn.style.background = '#fee2e2';
                voiceBtn.style.color = '#ef4444';
            } catch(err){
                alert('Microphone permission denied or not available.');
            }
        } else if (mediaRecorder.state === 'recording') {
            mediaRecorder.stop();
            voiceBtn.style.background = '#f3f4f6';
            voiceBtn.style.color = '#6b7280';
        }
    }

    voiceBtn.addEventListener('click', toggleRecording);

    form.addEventListener('submit', async function(e){
        e.preventDefault();
        const url = this.action;
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const fd = new FormData();
        if (input.value.trim()) fd.append('message', input.value.trim());
        if (files.files && files.files.length) {
            for (let i=0; i<files.files.length; i++) fd.append('attachments[]', files.files[i]);
        }
        if (voiceBlob) {
            fd.append('attachment', voiceBlob, 'voice-message.webm');
        }
        if (!fd.has('message') && !files.files.length) return;

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: fd
            });
            if (!res.ok) throw new Error('HTTP ' + res.status);
            const data = await res.json();
            const msg = data.message;

            // Append to UI
            const wrap = document.createElement('div');
            wrap.style.display = 'flex';
            wrap.style.gap = '0.5rem';
            wrap.style.justifyContent = 'flex-end';
            const parts = [];
            parts.push('<div style="max-width:70%; display:flex; flex-direction:column; align-items:flex-end;">');
            if (msg.message) {
                parts.push('<div style="background:#667eea; color:white; padding:0.5rem 0.75rem; border-radius:0.75rem; font-size:0.9rem;">'+
                    String(msg.message).replace(/</g,'&lt;') + '</div>');
            }
            if (msg.attachments && msg.attachments.length) {
                parts.push('<div style="margin-top:0.35rem; display:flex; gap:0.5rem; flex-wrap:wrap;">');
                for (const att of msg.attachments) {
                    const cat = att.category || 'file';
                    if (cat === 'image') {
                        const url = '/storage/' + att.path;
                        parts.push('<a href="'+url+'" target="_blank" style="display:inline-block; border-radius:0.5rem; overflow:hidden; border:1px solid #e5e7eb;"><img src="'+url+'" style="width:120px; height:120px; object-fit:cover; display:block;"></a>');
                    } else if (cat === 'audio') {
                        const url = '/storage/' + att.path;
                        parts.push('<audio controls src="'+url+'" style="max-width:250px;"></audio>');
                    } else {
                        const url = '/storage/' + att.path;
                        parts.push('<a href="'+url+'" target="_blank" style="color:#2563eb; text-decoration:underline;">'+(att.original||'Download file')+'</a>');
                    }
                }
                parts.push('</div>');
            }
            parts.push('<div style="font-size:0.7rem; color:#9ca3af; margin-top:0.15rem;">Just now</div>');
            parts.push('</div>');
            wrap.innerHTML = parts.join('');
            area.appendChild(wrap);
            input.value = '';
            files.value = '';
            previewList.innerHTML = '';
            previewWrap.style.display = 'none';
            voiceBlob = null;
            if (voicePreviewEl) { voicePreviewEl.remove(); voicePreviewEl = null; }
            scrollBottom();
        } catch(err){
            console.error('Failed to send:', err);
            alert('Failed to send message. Please try again.');
        }
    });
})();
</script>
@endpush
@endsection
