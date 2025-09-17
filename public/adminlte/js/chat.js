class ChatManager {
    constructor(userId, receiverId) {
        this.userId = userId;
        this.receiverId = receiverId;
        this.ws = null;
        this.messagesContainer = document.getElementById('chat-messages');
        this.messageInput = document.getElementById('message-input');
        this.sendButton = document.getElementById('send-button');
        this.isConnected = false;

        this.init();
    }

    init() {
        this.bindEvents();
        this.scrollToBottom();
        // Use WebSocket for real-time communication
        this.connectWebSocket();
    }

    connectWebSocket() {
        try {
            this.ws = new WebSocket('ws://localhost:8080');
            console.log('Attempting WebSocket connection to ws://localhost:8080');
            console.log('Current user ID:', this.userId);
            console.log('Receiver ID:', this.receiverId);

            this.ws.onopen = (event) => {
                console.log('✅ Connected to WebSocket successfully');
                this.isConnected = true;
                console.log('🔄 Registering user...');
                this.registerUser();
                // Load initial messages
                this.loadInitialMessages();
            };

            this.ws.onmessage = (event) => {
                const data = JSON.parse(event.data);
                if (data.type === 'message') {
                    this.handleIncomingMessage(data);
                } else if (data.type === 'user_status') {
                    this.handleUserStatusUpdate(data);
                } else if (data.type === 'online_users_list') {
                    this.handleOnlineUsersList(data);
                }
            };

            this.ws.onclose = (event) => {
                console.log('WebSocket connection closed');
                this.isConnected = false;
                // Attempt to reconnect after 5 seconds
                setTimeout(() => this.connectWebSocket(), 5000);
            };

            this.ws.onerror = (error) => {
                console.error('WebSocket error:', error);
                this.isConnected = false;
                alert('Error de conexión WebSocket. Verifica que el servidor esté ejecutándose.');
            };
        } catch (error) {
            console.error('Failed to connect to WebSocket:', error);
            alert('Error: No se pudo conectar al servidor WebSocket. Verifica que esté ejecutándose.');
        }
    }

    registerUser() {
        if (this.ws && this.isConnected) {
            const registerMessage = {
                type: 'register',
                user_id: this.userId
            };
            console.log('📤 Sending registration message:', registerMessage);
            this.ws.send(JSON.stringify(registerMessage));
        } else {
            console.error('❌ Cannot register user: WebSocket not connected');
        }
    }

    loadInitialMessages() {
        fetch(window.routes.getMessages)
        .then(response => response.json())
        .then(data => {
            this.messagesContainer.innerHTML = '';
            data.forEach((message) => {
                this.appendMessage(message, message.sender_id == this.userId);
            });
            this.scrollToBottom();
        })
        .catch(error => {
            console.error('Error loading initial messages:', error);
        });
    }

    bindEvents() {
        console.log('Binding events...');
        console.log('Send button found:', this.sendButton);
        console.log('Message input found:', this.messageInput);

        if (this.sendButton) {
            this.sendButton.addEventListener('click', () => {
                console.log('Send button clicked');
                this.sendMessage();
            });
        }

        if (this.messageInput) {
            this.messageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    console.log('Enter key pressed');
                    this.sendMessage();
                }
            });
        }
    }

    sendMessage() {
        console.log('sendMessage called');
        console.log('messageInput element:', this.messageInput);

        if (!this.messageInput) {
            console.error('Message input element not found');
            return;
        }

        const message = this.messageInput.value.trim();
        console.log('Message to send:', message);

        if (message === '') {
            console.log('Message is empty, not sending');
            return;
        }

        if (this.isConnected && this.ws) {
            // Send via WebSocket only
            this.ws.send(JSON.stringify({
                type: 'message',
                sender_id: this.userId,
                receiver_id: this.receiverId,
                message: message
            }));
            this.messageInput.value = '';
        } else {
            console.error('WebSocket not connected. Cannot send message.');
            alert('Error: No hay conexión WebSocket. Verifica que el servidor esté ejecutándose.');
        }
    }


    handleIncomingMessage(data) {
        // Only show messages between current user and receiver
        if ((data.sender_id == this.userId && data.receiver_id == this.receiverId) ||
            (data.sender_id == this.receiverId && data.receiver_id == this.userId)) {
            // Create message object for appendMessage
            const message = {
                sender: { name: data.sender_id == this.userId ? 'Tú' : 'Usuario' },
                message: data.message,
                created_at: new Date().toISOString()
            };
            this.appendMessage(message, data.sender_id == this.userId);
            this.scrollToBottom();
        }
    }

    handleUserStatusUpdate(data) {
        console.log('📡 User status update received:', data);
        console.log('🎯 Current user ID:', this.userId, 'Receiver ID:', this.receiverId);

        // Update user status in the user list (index page)
        const userElements = document.querySelectorAll(`[data-user-id="${data.user_id}"]`);
        console.log('🔍 Found', userElements.length, 'user elements to update for user', data.user_id);

        userElements.forEach((element, index) => {
            console.log('🔄 Updating user list element', index + 1);
            const statusElement = element.querySelector('.user-status');
            if (statusElement) {
                const newStatus = data.status === 'online' ? 'ACTIVO' : 'DESCONECTADO';
                console.log('📝 Changing user list status to:', newStatus);
                statusElement.textContent = newStatus;
                statusElement.className = `user-status status-${data.status}`;
            } else {
                console.warn('⚠️ No .user-status element found in user list element');
            }
        });

        // Update chat header status if it's the user we're chatting with
        if (data.user_id == this.receiverId) {
            console.log('🎯 Updating chat header for receiver user');
            const chatHeader = document.querySelector('.card-title');
            if (chatHeader) {
                const statusText = data.status === 'online' ? 'ACTIVO' : 'DESCONECTADO';
                const statusClass = data.status === 'online' ? 'text-success' : 'text-danger';

                // Remove existing status indicator
                const existingStatus = chatHeader.querySelector('.user-status-header');
                if (existingStatus) {
                    existingStatus.remove();
                }

                // Add new status indicator
                const statusSpan = document.createElement('span');
                statusSpan.className = `user-status-header ${statusClass}`;
                statusSpan.innerHTML = ` <small>(${statusText})</small>`;
                chatHeader.appendChild(statusSpan);
                console.log('✅ Chat header updated with status:', statusText);
            } else {
                console.warn('⚠️ Chat header not found');
            }
        } else {
            console.log('ℹ️ Status update is not for the current chat receiver');
        }
    }

    handleOnlineUsersList(data) {
        console.log('📋 Received online users list:', data);
        console.log('👥 Online user IDs:', data.online_users);

        // Update all user statuses based on the online users list
        const allUserElements = document.querySelectorAll('[data-user-id]');

        allUserElements.forEach(element => {
            const userId = parseInt(element.getAttribute('data-user-id'));
            const statusElement = element.querySelector('.user-status');

            if (statusElement) {
                const isOnline = data.online_users.includes(userId);
                const newStatus = isOnline ? 'ACTIVO' : 'DESCONECTADO';

                console.log(`🔄 User ${userId}: ${newStatus}`);
                statusElement.textContent = newStatus;
                statusElement.className = `user-status status-${isOnline ? 'online' : 'offline'}`;
            }
        });

        console.log('✅ All user statuses updated from online users list');
    }

    appendMessage(message, isSent) {
        const messageClass = isSent ? 'sent' : 'received';
        const senderName = isSent ? 'Tú' : (message.sender ? message.sender.name : 'Usuario');
        const time = message.created_at ? new Date(message.created_at).toLocaleTimeString() : new Date().toLocaleTimeString();

        const messageHtml = `
            <div class="message ${messageClass}">
                <strong>${senderName}:</strong> ${message.message}
                <small class="text-muted">${time}</small>
            </div>
        `;

        this.messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
    }

    scrollToBottom() {
        this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
    }

}

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Document ready, checking chat config...');
    console.log('chatConfig:', window.chatConfig);
    console.log('csrfToken:', window.csrfToken);
    console.log('routes:', window.routes);

    if (typeof window.chatConfig !== 'undefined') {
        if (window.chatConfig.isIndexPage) {
            console.log('Initializing status-only mode for index page...');
            initializeStatusOnly();
        } else {
            console.log('Initializing ChatManager for show page...');
            new ChatManager(
                window.chatConfig.userId,
                window.chatConfig.receiverId
            );
        }
    } else {
        console.error('window.chatConfig is undefined');
    }
});

// Status-only initialization for index page
function initializeStatusOnly() {
    console.log('🚀 Starting status-only WebSocket connection...');

    const ws = new WebSocket('ws://localhost:8080');
    console.log('Attempting WebSocket connection for status updates...');

    ws.onopen = (event) => {
        console.log('✅ Connected to WebSocket for status updates');
        // Register current user for status updates
        ws.send(JSON.stringify({
            type: 'register',
            user_id: window.chatConfig.userId
        }));
        console.log('📤 Registered user for status updates');
    };

    ws.onmessage = (event) => {
        const data = JSON.parse(event.data);
        if (data.type === 'user_status') {
            console.log('📡 Status update received:', data);
            updateUserStatus(data);
        } else if (data.type === 'online_users_list') {
            console.log('📋 Online users list received:', data);
            updateAllUserStatuses(data);
        }
    };

    ws.onclose = (event) => {
        console.log('WebSocket connection closed, attempting reconnect...');
        setTimeout(() => initializeStatusOnly(), 5000);
    };

    ws.onerror = (error) => {
        console.error('WebSocket error:', error);
    };

    function updateUserStatus(data) {
        console.log('🎯 Updating status for user:', data.user_id);
        const userElements = document.querySelectorAll(`[data-user-id="${data.user_id}"]`);
        console.log('🔍 Found', userElements.length, 'elements to update');

        userElements.forEach((element, index) => {
            const statusElement = element.querySelector('.user-status');
            if (statusElement) {
                const newStatus = data.status === 'online' ? 'ACTIVO' : 'DESCONECTADO';
                console.log('📝 Updating status to:', newStatus);
                statusElement.textContent = newStatus;
                statusElement.className = `user-status status-${data.status}`;
            }
        });
    }

    function updateAllUserStatuses(data) {
        console.log('📋 Updating all user statuses from list:', data.online_users);

        const allUserElements = document.querySelectorAll('[data-user-id]');

        allUserElements.forEach(element => {
            const userId = parseInt(element.getAttribute('data-user-id'));
            const statusElement = element.querySelector('.user-status');

            if (statusElement) {
                const isOnline = data.online_users.includes(userId);
                const newStatus = isOnline ? 'ACTIVO' : 'DESCONECTADO';

                console.log(`🔄 User ${userId}: ${newStatus}`);
                statusElement.textContent = newStatus;
                statusElement.className = `user-status status-${isOnline ? 'online' : 'offline'}`;
            }
        });

        console.log('✅ All user statuses updated from online users list');
    }
}