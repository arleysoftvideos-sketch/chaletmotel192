<div id="aki-chatbot" class="fixed bottom-6 right-6 z-50 font-outfit">
    <!-- Chat Window -->
    <div id="aki-chat-window" class="hidden flex-col bg-[#0a1831]/95 backdrop-blur-md border border-blue-950 w-80 sm:w-96 h-[30rem] max-h-[80vh] rounded-2xl shadow-2xl overflow-hidden mb-4 transition-all duration-300 transform scale-95 opacity-0 origin-bottom-right">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-950 to-navy p-4 flex items-center justify-between border-b border-white/10 shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full border-2 border-gold overflow-hidden bg-navy-dark shadow-inner">
                    <img src="{{ asset('images/aki_avatar.png') }}" alt="Aki Avatar" class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 class="text-white font-bold tracking-wider leading-tight">Aki</h3>
                    <p class="text-gold/80 text-[10px] uppercase font-black tracking-widest flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> {{ __('En línea') }}
                    </p>
                </div>
            </div>
            <button id="aki-close-btn" class="text-slate-400 hover:text-white transition-colors bg-white/5 hover:bg-white/10 p-2 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Messages Area (Added min-h-0 for proper scrolling inside flex-col) -->
        <div id="aki-messages" class="flex-1 min-h-0 p-4 overflow-y-auto space-y-4 scrollbar-thin scrollbar-thumb-blue-900 scrollbar-track-transparent">
            <!-- Initial Message -->
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-full border border-gold/50 overflow-hidden bg-navy shadow-sm flex-shrink-0">
                    <img src="{{ asset('images/aki_avatar.png') }}" alt="Aki Avatar" class="w-full h-full object-cover">
                </div>
                <div class="bg-blue-900/50 text-white text-sm p-3 rounded-2xl rounded-tl-none border border-white/5 shadow-sm">
                    {!! __('¡Hola! Soy <b>Aki</b>, tu asistente virtual en Chalet Motel 192 😎🌴. ¿En qué te puedo ayudar hoy?') !!}
                </div>
            </div>
            
            <!-- Quick Reply Buttons (Initial) -->
            <div class="flex flex-wrap gap-2 pt-2" id="aki-quick-replies">
                <button onclick="akiAsk('habitaciones')" class="text-xs bg-gold/10 hover:bg-gold/20 text-gold border border-gold/30 px-3 py-1.5 rounded-full transition-colors">{{ __('Habitaciones') }} 🛏️</button>
                <button onclick="akiAsk('contacto')" class="text-xs bg-gold/10 hover:bg-gold/20 text-gold border border-gold/30 px-3 py-1.5 rounded-full transition-colors">{{ __('Contacto') }} 📞</button>
                <button onclick="akiAsk('ubicacion')" class="text-xs bg-gold/10 hover:bg-gold/20 text-gold border border-gold/30 px-3 py-1.5 rounded-full transition-colors">{{ __('Ubicación') }} 📍</button>
                <button onclick="akiAsk('nosotros')" class="text-xs bg-gold/10 hover:bg-gold/20 text-gold border border-gold/30 px-3 py-1.5 rounded-full transition-colors">{{ __('Nosotros') }} 🏨</button>
                <button onclick="akiAsk('redes')" class="text-xs bg-gold/10 hover:bg-gold/20 text-gold border border-gold/30 px-3 py-1.5 rounded-full transition-colors">{{ __('Redes Sociales') }} 📱</button>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-3 bg-navy/80 border-t border-white/10 backdrop-blur-md">
            <form id="aki-form" class="flex gap-2">
                <input type="text" id="aki-input" placeholder="{{ __('Escribe un mensaje...') }}" class="flex-1 bg-white/5 border border-white/10 rounded-full px-4 py-2 text-sm text-white placeholder-slate-400 focus:outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all" autocomplete="off">
                <button type="submit" class="bg-gold hover:bg-yellow-500 text-navy w-10 h-10 rounded-full flex items-center justify-center transition-colors shadow-md group">
                    <svg class="w-5 h-5 translate-x-[-1px] group-hover:translate-x-[1px] transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Floating Button -->
    <button id="aki-toggle-btn" class="w-16 h-16 bg-gradient-to-tr from-gold to-yellow-400 rounded-full shadow-[0_0_20px_rgba(255,215,0,0.4)] hover:shadow-[0_0_30px_rgba(255,215,0,0.6)] hover:-translate-y-1 transition-all duration-300 flex items-center justify-center ml-auto border-4 border-navy relative overflow-hidden group">
        <img src="{{ asset('images/aki_avatar.png') }}" alt="Aki" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
        <!-- Notification Dot -->
        <span class="absolute top-0 right-0 w-4 h-4 bg-red-500 border-2 border-navy rounded-full animate-bounce"></span>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatWindow = document.getElementById('aki-chat-window');
        const toggleBtn = document.getElementById('aki-toggle-btn');
        const closeBtn = document.getElementById('aki-close-btn');
        const form = document.getElementById('aki-form');
        const input = document.getElementById('aki-input');
        const messagesArea = document.getElementById('aki-messages');
        const quickReplies = document.getElementById('aki-quick-replies');

        let isChatOpen = false;

        function toggleChat() {
            isChatOpen = !isChatOpen;
            if (isChatOpen) {
                chatWindow.classList.remove('hidden');
                // Allow a small delay for display:block to apply before animating opacity/transform
                setTimeout(() => {
                    chatWindow.classList.remove('scale-95', 'opacity-0');
                    chatWindow.classList.add('scale-100', 'opacity-100');
                    input.focus();
                }, 10);
                
                // Hide notification dot
                const notif = toggleBtn.querySelector('span.bg-red-500');
                if(notif) notif.classList.add('hidden');
            } else {
                chatWindow.classList.remove('scale-100', 'opacity-100');
                chatWindow.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    chatWindow.classList.add('hidden');
                }, 300);
            }
        }

        toggleBtn.addEventListener('click', toggleChat);
        closeBtn.addEventListener('click', toggleChat);

        // Avatar Image Template for bot messages
        const botAvatarHtml = `
            <div class="w-8 h-8 rounded-full border border-gold/50 overflow-hidden bg-navy shadow-sm flex-shrink-0 mt-1">
                <img src="{{ asset('images/aki_avatar.png') }}" alt="Aki" class="w-full h-full object-cover">
            </div>
        `;

        function appendUserMessage(text) {
            const msgDiv = document.createElement('div');
            msgDiv.className = 'flex justify-end gap-2 mb-4';
            msgDiv.innerHTML = `
                <div class="bg-gold text-navy text-sm p-3 rounded-2xl rounded-tr-none shadow-md max-w-[85%] font-medium">
                    ${text}
                </div>
            `;
            // insert before quick replies
            messagesArea.insertBefore(msgDiv, quickReplies);
            messagesArea.scrollTop = messagesArea.scrollHeight;
        }

        function appendBotMessage(html) {
            const msgDiv = document.createElement('div');
            msgDiv.className = 'flex items-start gap-3 mb-4 opacity-0 translate-y-2 transition-all duration-300';
            msgDiv.innerHTML = `
                ${botAvatarHtml}
                <div class="bg-blue-900/50 text-white text-sm p-3 rounded-2xl rounded-tl-none border border-white/5 shadow-sm max-w-[85%]">
                    ${html}
                </div>
            `;
            messagesArea.insertBefore(msgDiv, quickReplies);
            
            // Trigger animation
            setTimeout(() => {
                msgDiv.classList.remove('opacity-0', 'translate-y-2');
                messagesArea.scrollTop = messagesArea.scrollHeight;
            }, 50);
        }

        function showTypingIndicator() {
            const indicatorId = 'aki-typing-' + Date.now();
            const msgDiv = document.createElement('div');
            msgDiv.id = indicatorId;
            msgDiv.className = 'flex items-center gap-3 mb-4';
            msgDiv.innerHTML = `
                ${botAvatarHtml}
                <div class="bg-blue-900/30 py-2 px-4 rounded-2xl rounded-tl-none border border-white/5 shadow-sm flex gap-1">
                    <span class="w-2 h-2 bg-gold/70 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                    <span class="w-2 h-2 bg-gold/70 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                    <span class="w-2 h-2 bg-gold/70 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                </div>
            `;
            messagesArea.insertBefore(msgDiv, quickReplies);
            messagesArea.scrollTop = messagesArea.scrollHeight;
            return indicatorId;
        }

        window.akiAsk = function(intent, userText = null) {
            if(userText) appendUserMessage(userText);
            else {
                // Determine text based on intent if clicked from quick replies
                let text = '';
                switch(intent) {
                    case 'habitaciones': text = `{{ __('Quiero ver habitaciones') }}`; break;
                    case 'contacto': text = `{{ __('¿Cómo los contacto?') }}`; break;
                    case 'ubicacion': text = `{{ __('¿Dónde están ubicados?') }}`; break;
                    case 'nosotros': text = `{{ __('¿Quiénes son ustedes?') }}`; break;
                    case 'redes': text = `{{ __('Redes sociales') }}`; break;
                    default: text = intent;
                }
                appendUserMessage(text);
            }

            const typingId = showTypingIndicator();

            setTimeout(() => {
                const indicator = document.getElementById(typingId);
                if(indicator) indicator.remove();

                let responseHtml = '';

                switch(intent) {
                    case 'habitaciones':
                        responseHtml = `{!! __('Contamos con hermosas habitaciones como nuestra <b>King Suite</b> o habitaciones de dos camas. ¡Pronto añadiremos más! Si deseas reservar o saber precios exactos, <a href="tel:+14077731461" class="text-gold underline font-bold">llámanos al +1 407 773 1461</a>.') !!}`;
                        break;
                    case 'contacto':
                        responseHtml = `{!! __('Puedes comunicarte directamente con nosotros por teléfono o WhatsApp: <br><br> 📞 <a href="tel:+14077731461" class="text-gold underline font-bold">+1 407 773 1461</a> <br> 💬 <a href="https://wa.me/14077731461" target="_blank" class="text-[#25D366] underline font-bold">WhatsApp (+1 407 773 1461)</a>.') !!}`;
                        break;
                    case 'ubicacion':
                        responseHtml = `{!! __('📍 Estamos ubicados en:<br><b>4741 W Irlo Bronson Memorial Hwy, Kissimmee, FL 34746</b>.<br><br><a href="https://maps.google.com/?q=4741+W+Irlo+Bronson+Memorial+Hwy,+Kissimmee,+FL+34746" target="_blank" class="text-gold underline font-bold">👉 Ver en Google Maps</a>') !!}`;
                        break;
                    case 'nosotros':
                        responseHtml = `{!! __('🏨 Somos <b>Chalet Motel 192</b>, tu mejor opción de descanso en Kissimmee, Florida. Nuestro compromiso es ofrecerte habitaciones cómodas y una estancia relajante. ¡Esperamos verte pronto!') !!}`;
                        break;
                    case 'redes':
                        responseHtml = `{!! __('¡Síguenos en nuestras redes para no perderte de nada! <br><br> <a href="https://www.facebook.com/profile.php?id=61590106737806" target="_blank" class="text-[#1877F2] underline font-bold">📘 Facebook</a> <br> <a href="https://www.instagram.com/kissmemotel192/" target="_blank" class="text-pink-400 underline font-bold">📸 Instagram</a>') !!}`;
                        break;
                    default:
                        responseHtml = `{!! __('Mmm, no estoy seguro de la respuesta a eso 🤔. Pero no te preocupes, para otras consultas específicas, preguntas o reservas, <b>¡comunícate con nosotros directamente!</b><br><br>📞 <a href="tel:+14077731461" class="text-gold underline font-bold">Llamar al Motel</a> <br>💬 <a href="https://wa.me/14077731461" target="_blank" class="text-[#25D366] underline font-bold">Chat por WhatsApp</a>') !!}`;
                        break;
                }

                appendBotMessage(responseHtml);
            }, 800); // Simulate network delay
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const val = input.value.trim().toLowerCase();
            if(!val) return;
            
            const originalText = input.value.trim();
            input.value = '';

            // Simple intent detection (English / Spanish)
            let intent = 'unknown';
            if(val.includes('cuarto') || val.includes('habitacion') || val.includes('cama') || val.includes('precio') || val.includes('reserva') || val.includes('dormir') || val.includes('room') || val.includes('bed') || val.includes('price') || val.includes('book')) {
                intent = 'habitaciones';
            } else if(val.includes('contacto') || val.includes('telefono') || val.includes('llamar') || val.includes('whatsapp') || val.includes('numero') || val.includes('contact') || val.includes('phone') || val.includes('call') || val.includes('number')) {
                intent = 'contacto';
            } else if(val.includes('donde') || val.includes('ubicacion') || val.includes('direccion') || val.includes('llegar') || val.includes('mapa') || val.includes('where') || val.includes('location') || val.includes('address') || val.includes('map')) {
                intent = 'ubicacion';
            } else if(val.includes('nosotros') || val.includes('quienes') || val.includes('historia') || val.includes('about') || val.includes('who') || val.includes('story')) {
                intent = 'nosotros';
            } else if(val.includes('redes') || val.includes('facebook') || val.includes('instagram') || val.includes('social') || val.includes('network')) {
                intent = 'redes';
            }

            akiAsk(intent, originalText);
        });
    });
</script>
