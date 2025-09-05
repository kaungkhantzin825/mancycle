@extends('layouts.mancycle')

@section('title', 'Messages - ManCycle')

@section('content')
<!-- Messages Interface -->
<section style="padding: 2rem 0; background: #f8fafc; min-height: calc(100vh - 200px);">
    <div class="container">
        <div class="chat-container">
            <!-- Chat Sidebar -->
            <div class="chat-sidebar">
                <div class="chat-header">
                    <h2>Messages</h2>
                    <button class="new-chat-btn">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                
                <div class="chat-search">
                    <input type="text" placeholder="Search conversations..." id="chatSearch">
                    <i class="fas fa-search"></i>
                </div>
                
                <div class="chat-list">
                    <!-- Sample Chat Items -->
                    <div class="chat-item active" onclick="selectChat(1)">
                        <div class="chat-avatar">
                            <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=667eea&color=fff" alt="Sarah">
                            <div class="online-indicator"></div>
                        </div>
                        <div class="chat-info">
                            <div class="chat-name">Sarah Johnson</div>
                            <div class="chat-preview">Interested in your Honda Civic...</div>
                            <div class="chat-time">2 min ago</div>
                        </div>
                        <div class="unread-badge">3</div>
                    </div>
                    
                    <div class="chat-item" onclick="selectChat(2)">
                        <div class="chat-avatar">
                            <img src="https://ui-avatars.com/api/?name=Mike+Chen&background=f59e0b&color=fff" alt="Mike">
                        </div>
                        <div class="chat-info">
                            <div class="chat-name">Mike Chen</div>
                            <div class="chat-preview">Is the motorcycle still available?</div>
                            <div class="chat-time">1 hour ago</div>
                        </div>
                    </div>
                    
                    <div class="chat-item" onclick="selectChat(3)">
                        <div class="chat-avatar">
                            <img src="https://ui-avatars.com/api/?name=Emma+Davis&background=10b981&color=fff" alt="Emma">
                        </div>
                        <div class="chat-info">
                            <div class="chat-name">Emma Davis</div>
                            <div class="chat-preview">Can we meet tomorrow?</div>
                            <div class="chat-time">3 hours ago</div>
                        </div>
                        <div class="unread-badge">1</div>
                    </div>
                    
                    <div class="chat-item" onclick="selectChat(4)">
                        <div class="chat-avatar">
                            <img src="https://ui-avatars.com/api/?name=Alex+Wilson&background=ef4444&color=fff" alt="Alex">
                        </div>
                        <div class="chat-info">
                            <div class="chat-name">Alex Wilson</div>
                            <div class="chat-preview">Thanks for the quick response!</div>
                            <div class="chat-time">Yesterday</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Chat Main Area -->
            <div class="chat-main">
                <!-- Chat Header -->
                <div class="chat-main-header">
                    <div class="chat-user-info">
                        <div class="chat-avatar">
                            <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=667eea&color=fff" alt="Sarah">
                            <div class="online-indicator"></div>
                        </div>
                        <div>
                            <div class="chat-user-name">Sarah Johnson</div>
                            <div class="chat-user-status">Online • Last seen 2 min ago</div>
                        </div>
                    </div>
                    
                    <div class="chat-actions">
                        <button class="chat-action-btn">
                            <i class="fas fa-phone"></i>
                        </button>
                        <button class="chat-action-btn">
                            <i class="fas fa-video"></i>
                        </button>
                        <button class="chat-action-btn">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Listing Context -->
                <div class="listing-context">
                    <div class="listing-thumb">
                        <div style="background: linear-gradient(45deg, #667eea, #764ba2); height: 60px; width: 60px; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                            <i class="fas fa-car"></i>
                        </div>
                    </div>
                    <div class="listing-details">
                        <div class="listing-title">2020 Honda Civic - Excellent Condition</div>
                        <div class="listing-price">$18,500</div>
                    </div>
                    <button class="view-listing-btn">View Listing</button>
                </div>
                
                <!-- Messages Area -->
                <div class="messages-area" id="messagesArea">
                    <!-- Sample Messages -->
                    <div class="message received">
                        <div class="message-avatar">
                            <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=667eea&color=fff" alt="Sarah">
                        </div>
                        <div class="message-content">
                            <div class="message-bubble">
                                Hi! I'm interested in your Honda Civic. Is it still available?
                            </div>
                            <div class="message-time">10:30 AM</div>
                        </div>
                    </div>
                    
                    <div class="message sent">
                        <div class="message-content">
                            <div class="message-bubble">
                                Yes, it's still available! Would you like to schedule a viewing?
                            </div>
                            <div class="message-time">10:32 AM</div>
                        </div>
                    </div>
                    
                    <div class="message received">
                        <div class="message-avatar">
                            <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=667eea&color=fff" alt="Sarah">
                        </div>
                        <div class="message-content">
                            <div class="message-bubble">
                                That would be great! What's the best time for you? I'm free this weekend.
                            </div>
                            <div class="message-time">10:35 AM</div>
                        </div>
                    </div>
                    
                    <div class="message sent">
                        <div class="message-content">
                            <div class="message-bubble">
                                Saturday afternoon works for me. How about 2 PM?
                            </div>
                            <div class="message-time">10:37 AM</div>
                        </div>
                    </div>
                    
                    <div class="message received">
                        <div class="message-avatar">
                            <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=667eea&color=fff" alt="Sarah">
                        </div>
                        <div class="message-content">
                            <div class="message-bubble">
                                Perfect! Can you share the location?
                            </div>
                            <div class="message-time">Just now</div>
                        </div>
                    </div>
                    
                    <!-- Typing Indicator -->
                    <div class="typing-indicator">
                        <div class="message-avatar">
                            <img src="https://ui-avatars.com/api/?name=You&background=6b7280&color=fff" alt="You">
                        </div>
                        <div class="typing-dots">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
                
                <!-- Message Input -->
                <div class="message-input-area">
                    <div class="message-input-container">
                        <button class="attachment-btn">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <input type="text" placeholder="Type your message..." id="messageInput" class="message-input">
                        <button class="emoji-btn">
                            <i class="fas fa-smile"></i>
                        </button>
                        <button class="send-btn" onclick="sendMessage()">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.chat-container {
    display: grid;
    grid-template-columns: 350px 1fr;
    height: 600px;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.chat-sidebar {
    border-right: 1px solid #e5e7eb;
    display: flex;
    flex-direction: column;
}

.chat-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-header h2 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
}

.new-chat-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.new-chat-btn:hover {
    transform: scale(1.1);
}

.chat-search {
    padding: 1rem 1.5rem;
    position: relative;
}

.chat-search input {
    width: 100%;
    padding: 0.75rem 2.5rem 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    outline: none;
}

.chat-search i {
    position: absolute;
    right: 2rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
}

.chat-list {
    flex: 1;
    overflow-y: auto;
}

.chat-item {
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
    position: relative;
}

.chat-item:hover {
    background: #f9fafb;
}

.chat-item.active {
    background: #eff6ff;
    border-right: 3px solid #667eea;
}

.chat-avatar {
    position: relative;
    flex-shrink: 0;
}

.chat-avatar img {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
}

.online-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 12px;
    height: 12px;
    background: #10b981;
    border: 2px solid white;
    border-radius: 50%;
}

.chat-info {
    flex: 1;
    min-width: 0;
}

.chat-name {
    font-weight: 500;
    color: #1f2937;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.chat-preview {
    color: #6b7280;
    font-size: 0.75rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.chat-time {
    color: #9ca3af;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.unread-badge {
    background: #ef4444;
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 1rem;
    min-width: 20px;
    text-align: center;
}

.chat-main {
    display: flex;
    flex-direction: column;
}

.chat-main-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.chat-user-name {
    font-weight: 600;
    color: #1f2937;
}

.chat-user-status {
    color: #10b981;
    font-size: 0.875rem;
}

.chat-actions {
    display: flex;
    gap: 0.5rem;
}

.chat-action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #f3f4f6;
    border: none;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.chat-action-btn:hover {
    background: #e5e7eb;
    color: #374151;
}

.listing-context {
    padding: 1rem 1.5rem;
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.listing-details {
    flex: 1;
}

.listing-title {
    font-weight: 500;
    color: #1f2937;
    font-size: 0.875rem;
}

.listing-price {
    color: #059669;
    font-weight: 600;
    font-size: 1rem;
}

.view-listing-btn {
    background: #667eea;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.view-listing-btn:hover {
    background: #5a67d8;
}

.messages-area {
    flex: 1;
    padding: 1.5rem;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.message {
    display: flex;
    gap: 0.75rem;
    max-width: 70%;
}

.message.sent {
    align-self: flex-end;
    flex-direction: row-reverse;
}

.message-avatar img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
}

.message-content {
    display: flex;
    flex-direction: column;
}

.message.sent .message-content {
    align-items: flex-end;
}

.message-bubble {
    background: #f3f4f6;
    padding: 0.75rem 1rem;
    border-radius: 1rem;
    font-size: 0.875rem;
    line-height: 1.4;
}

.message.sent .message-bubble {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.message-time {
    font-size: 0.75rem;
    color: #9ca3af;
    margin-top: 0.25rem;
}

.typing-indicator {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.typing-dots {
    background: #f3f4f6;
    padding: 0.75rem 1rem;
    border-radius: 1rem;
    display: flex;
    gap: 0.25rem;
}

.typing-dots span {
    width: 6px;
    height: 6px;
    background: #9ca3af;
    border-radius: 50%;
    animation: typing 1.4s infinite;
}

.typing-dots span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dots span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {
    0%, 60%, 100% {
        transform: translateY(0);
    }
    30% {
        transform: translateY(-10px);
    }
}

.message-input-area {
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
}

.message-input-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: #f9fafb;
    border-radius: 1.5rem;
    padding: 0.75rem 1rem;
}

.attachment-btn,
.emoji-btn {
    width: 32px;
    height: 32px;
    border: none;
    background: transparent;
    color: #6b7280;
    cursor: pointer;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.attachment-btn:hover,
.emoji-btn:hover {
    background: #e5e7eb;
    color: #374151;
}

.message-input {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    font-size: 0.875rem;
    padding: 0.5rem 0;
}

.send-btn {
    width: 32px;
    height: 32px;
    border: none;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    cursor: pointer;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}

.send-btn:hover {
    transform: scale(1.1);
}

@media (max-width: 768px) {
    .chat-container {
        grid-template-columns: 1fr;
        height: auto;
    }
    
    .chat-sidebar {
        display: none;
    }
}
</style>
@endpush

@push('scripts')
<script>
function selectChat(chatId) {
    // Remove active class from all chat items
    document.querySelectorAll('.chat-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Add active class to selected chat
    event.currentTarget.classList.add('active');
    
    // Here you would typically load the chat messages for the selected chat
    console.log('Selected chat:', chatId);
}

function sendMessage() {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    
    if (message) {
        // Add message to chat (this would typically send to server)
        const messagesArea = document.getElementById('messagesArea');
        const messageElement = document.createElement('div');
        messageElement.className = 'message sent';
        messageElement.innerHTML = `
            <div class="message-content">
                <div class="message-bubble">${message}</div>
                <div class="message-time">Just now</div>
            </div>
        `;
        
        // Remove typing indicator
        const typingIndicator = document.querySelector('.typing-indicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
        
        messagesArea.appendChild(messageElement);
        messagesArea.scrollTop = messagesArea.scrollHeight;
        
        input.value = '';
    }
}

// Send message on Enter key
document.getElementById('messageInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

// Auto-scroll to bottom
document.addEventListener('DOMContentLoaded', function() {
    const messagesArea = document.getElementById('messagesArea');
    messagesArea.scrollTop = messagesArea.scrollHeight;
});
</script>
@endpush
@endsection