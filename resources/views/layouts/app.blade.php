<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwiftJoß</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col font-sans">
    <nav class="border-b border-slate-800 bg-slate-950 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('jobs.index') }}" class="text-xl font-bold text-indigo-400">SwiftJoß</a>

            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('jobs.index') }}" class="hover:text-indigo-400">Jobs</a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('jobs.create') }}" class="text-emerald-400 font-semibold">+ Post Job</a>
                        <a href="{{ route('admin.candidates') }}" class="hover:text-indigo-400">Candidates</a>
                        <a href="{{ route('admin.applications') }}" class="hover:text-indigo-400">Applications</a>
                    @else
                        <a href="{{ route('profile.edit') }}" class="hover:text-indigo-400">My Profile</a>
                    @endif
                    <span class="text-xs bg-indigo-900/50 text-indigo-300 px-2 py-1 rounded border border-indigo-700/50 uppercase font-bold">{{ auth()->user()->role }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-white">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-indigo-400">Login</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 px-3 py-1.5 rounded-lg text-white font-medium">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 py-8">
        @if(session('success'))
            <div class="p-4 mb-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="p-4 mb-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-xl text-sm">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

<button 
    id="chatbot-toggle-btn" 
    onclick="toggleChatbot()" 
    class="fixed bottom-6 right-6 bg-indigo-600 hover:bg-indigo-500 text-white p-4 rounded-full shadow-2xl z-50 flex items-center justify-center transition-transform transform hover:scale-110 focus:outline-none"
    title="Open AI Assistant"
>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
    </svg>
</button>

<div 
    id="chatbot-container" 
    class="hidden fixed bottom-6 right-6 w-80 sm:w-96 bg-slate-950 border border-slate-800 rounded-2xl shadow-2xl z-50 overflow-hidden flex flex-col transition-all duration-300"
    style="height: 480px;"
>
    <div class="bg-slate-900 border-b border-slate-800 px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
            <h3 class="font-bold text-xs text-white">AI Assistant</h3>
        </div>
        
        <button 
            onclick="toggleChatbot()" 
            class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition-colors focus:outline-none"
            title="Close Chat"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div id="chat-messages" class="flex-1 p-4 overflow-y-auto space-y-3 text-xs text-slate-300">
        <div class="bg-slate-900 p-3 rounded-xl border border-slate-800 max-w-[85%] text-slate-300">
            Hello! I am your AI assistant. How can I help you today?
        </div>
    </div>

    <form id="chat-form" onsubmit="sendChatMessage(event)" class="p-3 border-t border-slate-800 bg-slate-950 flex gap-2">
        @csrf
        <input 
            type="text" 
            id="chat-input" 
            placeholder="Type a message..." 
            class="flex-1 bg-slate-900 border border-slate-800 text-xs text-white p-2.5 rounded-xl focus:outline-none focus:border-indigo-500"
            required
        >
        <button 
            type="submit" 
            class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs px-3 py-2.5 rounded-xl font-semibold transition-colors flex items-center justify-center"
        >
            Send
        </button>
    </form>
</div>

<script>
    function toggleChatbot() {
        const container = document.getElementById('chatbot-container');
        const toggleBtn = document.getElementById('chatbot-toggle-btn');
        
        if (container.classList.contains('hidden')) {
            container.classList.remove('hidden');
            toggleBtn.classList.add('hidden');
        } else {
            container.classList.add('hidden');
            toggleBtn.classList.remove('hidden');
        }
    }

    async function sendChatMessage(e) {
        e.preventDefault();
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        if (!message) return;

        const messagesContainer = document.getElementById('chat-messages');

        const userDiv = document.createElement('div');
        userDiv.className = 'bg-indigo-600 text-white p-3 rounded-xl ml-auto max-w-[85%] text-xs';
        userDiv.textContent = message;
        messagesContainer.appendChild(userDiv);

        input.value = '';
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        try {
            const response = await fetch("{{ route('chatbot.respond') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();

            const botDiv = document.createElement('div');
            botDiv.className = 'bg-slate-900 p-3 rounded-xl border border-slate-800 max-w-[85%] text-slate-300';
            botDiv.textContent = data.reply || "Sorry, I couldn't process that request.";
            messagesContainer.appendChild(botDiv);
            
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        } catch (err) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'bg-rose-900/50 text-rose-300 p-3 rounded-xl border border-rose-800 max-w-[85%] text-xs';
            errorDiv.textContent = 'Error connecting to assistant server.';
            messagesContainer.appendChild(errorDiv);
        }
    }
</script>
</body>
</html>