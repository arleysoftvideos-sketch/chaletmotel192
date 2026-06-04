<div id="aki-chatbot" class="fixed bottom-6 right-6 z-50 font-outfit">
    <!-- Chat Window -->
    <div id="aki-chat-window" class="hidden flex flex-col bg-[#0a1831]/95 backdrop-blur-md border border-blue-950 w-80 sm:w-96 h-[30rem] max-h-[80vh] rounded-2xl shadow-2xl overflow-hidden mb-4 transition-all duration-300 transform scale-95 opacity-0 origin-bottom-right">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-950 to-[#0a1831] p-4 flex items-center justify-between border-b border-white/10 shadow-md relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full border-2 border-gold overflow-hidden bg-navy-dark shadow-inner">
                    <img src="{{ asset('images/aki_avatar.png') }}" alt="Aki Avatar" class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 class="text-white font-bold tracking-wider leading-tight">Aki</h3>
                    <p class="text-gold/80 text-[10px] uppercase font-black tracking-widest flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> <span id="aki-status-text">Online</span>
                    </p>
                </div>
            </div>
            <button id="aki-close-btn" class="text-slate-400 hover:text-white transition-colors bg-white/5 hover:bg-white/10 p-2 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Messages Area -->
        <div id="aki-messages" class="flex-1 min-h-0 p-4 overflow-y-auto space-y-4 scrollbar-thin scrollbar-thumb-blue-900 scrollbar-track-transparent pb-16 relative">
            <!-- Messages will be injected here -->
            <div id="aki-quick-replies" class="flex flex-wrap gap-2 pt-2 transition-all"></div>
        </div>

        <!-- Input Area -->
        <div class="p-3 bg-[#0a1831] border-t border-white/10 relative z-10">
            <form id="aki-form" class="flex gap-2">
                <input type="text" id="aki-input" placeholder="Escribe un mensaje..." class="flex-1 bg-white/5 border border-white/10 rounded-full px-4 py-2 text-sm text-white placeholder-slate-400 focus:outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all" autocomplete="off">
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
        const statusText = document.getElementById('aki-status-text');

        let isChatOpen = false;
        let chatState = 'ASK_LANG'; // ASK_LANG, READY, COLLECT_NAME, COLLECT_EMAIL, COLLECT_PHONE, COLLECT_MESSAGE
        let botLang = 'es';
        let contactData = { name: '', email: '', phone: '', message: '' };

        const dict = {
            es: {
                welcome_lang: "Para empezar, por favor elige tu idioma / To start, please choose your language:<br><br><b>1.</b> English 🇺🇸<br><b>2.</b> Español 🇪🇸",
                greeting: "¡Hola! Soy <b>Aki</b>, tu asistente virtual en Chalet Motel 192 😎🌴. ¿En qué te puedo ayudar hoy?",
                greeting_fallback: "¡Hola! ¿En qué te puedo ayudar hoy? Puedes usar los botones o escribirme lo que necesitas.",
                rooms_btn: "Habitaciones 🛏️",
                contact_btn: "Contacto 📞",
                location_btn: "Ubicación 📍",
                about_btn: "Nosotros 🏨",
                social_btn: "Redes 📱",
                rooms_res: "Contamos con hermosas habitaciones como nuestra <b>King Suite</b> o habitaciones de dos camas. <a href='tel:+14077731461' class='text-gold underline font-bold'>Llámanos al +1 407 773 1461</a>.",
                contact_res: "Puedes comunicarte directamente con nosotros por teléfono o WhatsApp: <br><br> 📞 <a href='tel:+14077731461' class='text-gold underline font-bold'>+1 407 773 1461</a> <br> 💬 <a href='https://wa.me/14077731461' target='_blank' class='text-[#25D366] underline font-bold'>WhatsApp (+1 407 773 1461)</a>.",
                location_res: "📍 Estamos ubicados en:<br><b>4741 W Irlo Bronson Memorial Hwy, Kissimmee, FL 34746</b>.<br><br><a href='https://maps.google.com/?q=4741+W+Irlo+Bronson+Memorial+Hwy,+Kissimmee,+FL+34746' target='_blank' class='text-gold underline font-bold'>👉 Ver en Google Maps</a>",
                about_res: "🏨 Somos <b>Chalet Motel 192</b>, tu mejor opción de descanso en Kissimmee, Florida. Nuestro compromiso es ofrecerte habitaciones cómodas y una estancia relajante. ¡Esperamos verte pronto!",
                social_res: "¡Síguenos en nuestras redes para no perderte de nada! <br><br> <a href='https://www.facebook.com/profile.php?id=61590106737806' target='_blank' class='text-[#1877F2] underline font-bold'>📘 Facebook</a> <br> <a href='https://www.instagram.com/kissmemotel192/' target='_blank' class='text-pink-400 underline font-bold'>📸 Instagram</a>",
                default_res: "😊 ¡Qué buena pregunta! Aunque no tengo esa información disponible en este momento, puedo ayudarte de dos maneras:<br><br>Puedo <b>agendar una llamada</b> para que uno de nuestros agentes te contacte personalmente, o si lo prefieres, puedo <b>comunicarte por WhatsApp</b> ahora mismo. ¿Qué prefieres?"
                call_btn: "📞 Llamar ahora",
                schedule_btn: "📅 Agendar llamada",
                whatsapp_btn: "💬 WhatsApp",
                collect_name: "¡Genial! Para agendar tu llamada necesito algunos datos. 😊<br>¿Cuál es tu <b>nombre</b>?",
                collect_email: "Gracias, <b>{name}</b>! ¿Cuál es tu <b>correo electrónico</b>?",
                collect_phone: "¡Anotado! ¿A qué <b>número de teléfono</b> te llamamos?",
                collect_message: "Perfecto! ¿Cuál es tu <b>consulta o pregunta</b> para nuestro equipo?",
                success_msg: "✅ ¡Listo, <b>{name}</b>! Hemos recibido tu solicitud. Nuestro equipo te llamará al <b>{phone}</b> muy pronto. ¡Gracias por contactarnos! 🌴",
                aki_personal: "😎 ¡Con mucho gusto te cuento! Soy <b>Aki</b>, el asistente virtual de <b>Chalet Motel 192</b>. Fui creado para ayudarte con todo lo que necesites sobre el motel: habitaciones, ubicación, contacto y más. No tengo vida personal fuera de aquí, ¡pero estoy 100% dedicado a ti! 😄",
                off_topic: "🙂 ¡Gracias por tu mensaje! Soy Aki, el asistente oficial de <b>Chalet Motel 192</b>, y mi especialidad es todo lo relacionado con el motel. Para otros temas, ¡hay mejores recursos disponibles! ¿Puedo ayudarte con algo del motel?",
                placeholder: "Escribe un mensaje...",
                online: "En línea"
            },
            en: {
                welcome_lang: "To start, please choose your language: <br><br><b>1.</b> English 🇺🇸<br><b>2.</b> Español 🇪🇸",
                greeting: "Hi! I'm <b>Aki</b>, your virtual assistant at Chalet Motel 192 😎🌴. How can I help you today?",
                greeting_fallback: "Hi! How can I help you today? You can use the buttons or type what you need.",
                rooms_btn: "Rooms 🛏️",
                contact_btn: "Contact 📞",
                location_btn: "Location 📍",
                about_btn: "About Us 🏨",
                social_btn: "Networks 📱",
                rooms_res: "We have beautiful rooms like our <b>King Suite</b> or rooms with two beds. <a href='tel:+14077731461' class='text-gold underline font-bold'>Call us at +1 407 773 1461</a>.",
                contact_res: "You can contact us directly by phone or WhatsApp: <br><br> 📞 <a href='tel:+14077731461' class='text-gold underline font-bold'>+1 407 773 1461</a> <br> 💬 <a href='https://wa.me/14077731461' target='_blank' class='text-[#25D366] underline font-bold'>WhatsApp (+1 407 773 1461)</a>.",
                location_res: "📍 We are located at:<br><b>4741 W Irlo Bronson Memorial Hwy, Kissimmee, FL 34746</b>.<br><br><a href='https://maps.google.com/?q=4741+W+Irlo+Bronson+Memorial+Hwy,+Kissimmee,+FL+34746' target='_blank' class='text-gold underline font-bold'>👉 View on Google Maps</a>",
                about_res: "🏨 We are <b>Chalet Motel 192</b>, your best option for rest in Kissimmee, Florida. Our commitment is to offer you comfortable rooms and a relaxing stay. We hope to see you soon!",
                social_res: "Follow us on our social networks so you don't miss anything! <br><br> <a href='https://www.facebook.com/profile.php?id=61590106737806' target='_blank' class='text-[#1877F2] underline font-bold'>📘 Facebook</a> <br> <a href='https://www.instagram.com/kissmemotel192/' target='_blank' class='text-pink-400 underline font-bold'>📸 Instagram</a>",
                default_res: "😊 Great question! Although I don't have that information right now, I can help you in two ways:<br><br>I can <b>schedule a call</b> so one of our agents contacts you personally, or if you prefer, I can <b>connect you via WhatsApp</b> right now. Which do you prefer?"
                call_btn: "📞 Call now",
                schedule_btn: "📅 Schedule a call",
                whatsapp_btn: "💬 WhatsApp",
                collect_name: "Great! To schedule your call I need a few details. 😊<br>What is your <b>name</b>?",
                collect_email: "Thank you, <b>{name}</b>! What is your <b>email address</b>?",
                collect_phone: "Got it! What <b>phone number</b> should we call you on?",
                collect_message: "Perfect! What is your <b>question or inquiry</b> for our team?",
                success_msg: "✅ Done, <b>{name}</b>! We have received your request. Our team will call you at <b>{phone}</b> very soon. Thank you for reaching out! 🌴",
                aki_personal: "😎 Happy to introduce myself! I'm <b>Aki</b>, the virtual assistant for <b>Chalet Motel 192</b>. I was created to help you with everything about the motel: rooms, location, contact and more. I don't have a personal life outside of here, but I'm 100% dedicated to you! 😄",
                off_topic: "🙂 Thanks for your message! I'm Aki, the official assistant of <b>Chalet Motel 192</b>, and my specialty is everything related to the motel. For other topics, there are better resources available! Can I help you with something about the motel?",
                placeholder: "Type a message...",
                online: "Online"
            }
        };

        const botAvatarHtml = `
            <div class="w-8 h-8 rounded-full border border-gold/50 overflow-hidden bg-navy shadow-sm flex-shrink-0 mt-1">
                <img src="{{ asset('images/aki_avatar.png') }}" alt="Aki" class="w-full h-full object-cover">
            </div>
        `;

        function updateLangUI() {
            input.placeholder = dict[botLang].placeholder;
            statusText.innerText = dict[botLang].online;
        }

        function showLangSelection() {
            appendBotMessage(dict.es.welcome_lang);
            quickReplies.innerHTML = `
                <button onclick="setLang('en')" class="text-xs bg-white/10 hover:bg-white/20 text-white border border-white/30 px-3 py-1.5 rounded-full transition-colors">1. English 🇺🇸</button>
                <button onclick="setLang('es')" class="text-xs bg-white/10 hover:bg-white/20 text-white border border-white/30 px-3 py-1.5 rounded-full transition-colors">2. Español 🇪🇸</button>
            `;
        }

        window.setLang = function(lang) {
            botLang = lang;
            chatState = 'READY';
            updateLangUI();
            appendUserMessage(lang === 'en' ? 'English' : 'Español');
            quickReplies.innerHTML = '';
            
            const typingId = showTypingIndicator();
            setTimeout(() => {
                document.getElementById(typingId)?.remove();
                appendBotMessage(dict[botLang].greeting);
                showMainQuickReplies();
            }, 600);
        };

        function showMainQuickReplies() {
            quickReplies.innerHTML = `
                <button onclick="akiAsk('habitaciones')" class="text-xs bg-gold/10 hover:bg-gold/20 text-gold border border-gold/30 px-3 py-1.5 rounded-full transition-colors">${dict[botLang].rooms_btn}</button>
                <button onclick="akiAsk('contacto')" class="text-xs bg-gold/10 hover:bg-gold/20 text-gold border border-gold/30 px-3 py-1.5 rounded-full transition-colors">${dict[botLang].contact_btn}</button>
                <button onclick="akiAsk('ubicacion')" class="text-xs bg-gold/10 hover:bg-gold/20 text-gold border border-gold/30 px-3 py-1.5 rounded-full transition-colors">${dict[botLang].location_btn}</button>
                <button onclick="akiAsk('nosotros')" class="text-xs bg-gold/10 hover:bg-gold/20 text-gold border border-gold/30 px-3 py-1.5 rounded-full transition-colors">${dict[botLang].about_btn}</button>
                <button onclick="akiAsk('redes')" class="text-xs bg-gold/10 hover:bg-gold/20 text-gold border border-gold/30 px-3 py-1.5 rounded-full transition-colors">${dict[botLang].social_btn}</button>
            `;
        }

        function appendUserMessage(text) {
            const msgDiv = document.createElement('div');
            msgDiv.className = 'flex justify-end gap-2 mb-4';
            msgDiv.innerHTML = `
                <div class="bg-gold text-navy text-sm p-3 rounded-2xl rounded-tr-none shadow-md max-w-[85%] font-medium">
                    ${text}
                </div>
            `;
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
                    case 'habitaciones': text = botLang === 'en' ? 'I want to see rooms' : 'Quiero ver habitaciones'; break;
                    case 'contacto': text = botLang === 'en' ? 'How do I contact you?' : '¿Cómo los contacto?'; break;
                    case 'ubicacion': text = botLang === 'en' ? 'Where are you located?' : '¿Dónde están ubicados?'; break;
                    case 'nosotros': text = botLang === 'en' ? 'Who are you?' : '¿Quiénes son ustedes?'; break;
                    case 'redes': text = botLang === 'en' ? 'Social networks' : 'Redes sociales'; break;
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
                    case 'saludo': responseHtml = dict[botLang].greeting_fallback; break;
                    case 'habitaciones': responseHtml = dict[botLang].rooms_res; break;
                    case 'contacto': responseHtml = dict[botLang].contact_res; break;
                    case 'ubicacion': responseHtml = dict[botLang].location_res; break;
                    case 'nosotros': responseHtml = dict[botLang].about_res; break;
                    case 'redes': responseHtml = dict[botLang].social_res; break;
                    case 'aki_personal': responseHtml = dict[botLang].aki_personal; break;
                    case 'off_topic': responseHtml = dict[botLang].off_topic; break;
                    default:
                        appendBotMessage(dict[botLang].default_res);
                        // After a short delay, show 2 options only
                        setTimeout(() => {
                            quickReplies.innerHTML = `
                                <button onclick="akiStartSchedule()" class="flex items-center gap-2 text-xs bg-gold/20 hover:bg-gold/30 text-gold border border-gold/40 px-4 py-2 rounded-full transition-colors font-medium">
                                    📅 ${dict[botLang].schedule_btn.replace('📅 ','')}
                                </button>
                                <button onclick="window.open('https://wa.me/14077731461','_blank')" class="flex items-center gap-2 text-xs bg-green-900/40 hover:bg-green-800/50 text-green-400 border border-green-700 px-4 py-2 rounded-full transition-colors font-medium">
                                    💬 WhatsApp
                                </button>
                            `;
                            messagesArea.scrollTop = messagesArea.scrollHeight;
                        }, 900);
                        return;
                }

                appendBotMessage(responseHtml);
            }, 800);
        };

        // --- Schedule call flow ---
        window.akiStartSchedule = function() {
            chatState = 'COLLECT_NAME';
            contactData = { name: '', email: '', phone: '', message: '' };
            quickReplies.innerHTML = '';
            const typingId = showTypingIndicator();
            setTimeout(() => {
                document.getElementById(typingId)?.remove();
                appendBotMessage(dict[botLang].collect_name);
                messagesArea.scrollTop = messagesArea.scrollHeight;
            }, 600);
        };

        function sendContactToServer() {
            fetch('/api/chat-contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    name: contactData.name,
                    email: contactData.email,
                    phone: contactData.phone,
                    message: contactData.message
                })
            }).catch(() => { /* silent fail */ });
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const val = input.value.trim().toLowerCase();
            if(!val) return;
            
            const originalText = input.value.trim();
            input.value = '';

            // --- Language selection ---
            if (chatState === 'ASK_LANG') {
                if (val === '1' || val.includes('english') || val.includes('inglés') || val.includes('ingles')) {
                    setLang('en');
                } else if (val === '2' || val.includes('español') || val.includes('spanish') || val.includes('espanol')) {
                    setLang('es');
                } else {
                    appendUserMessage(originalText);
                    const typingId = showTypingIndicator();
                    setTimeout(() => {
                        document.getElementById(typingId)?.remove();
                        appendBotMessage("Please type 1 for English or 2 for Español. / Por favor, escribe 1 para Inglés o 2 para Español.");
                    }, 500);
                }
                return;
            }

            // --- Contact collection states ---
            if (chatState === 'COLLECT_NAME') {
                appendUserMessage(originalText);
                contactData.name = originalText;
                chatState = 'COLLECT_EMAIL';
                const typingId = showTypingIndicator();
                setTimeout(() => {
                    document.getElementById(typingId)?.remove();
                    appendBotMessage(dict[botLang].collect_email.replace('{name}', contactData.name));
                    messagesArea.scrollTop = messagesArea.scrollHeight;
                }, 600);
                return;
            }

            if (chatState === 'COLLECT_EMAIL') {
                appendUserMessage(originalText);
                contactData.email = originalText;
                chatState = 'COLLECT_PHONE';
                const typingId = showTypingIndicator();
                setTimeout(() => {
                    document.getElementById(typingId)?.remove();
                    appendBotMessage(dict[botLang].collect_phone);
                    messagesArea.scrollTop = messagesArea.scrollHeight;
                }, 600);
                return;
            }

            if (chatState === 'COLLECT_PHONE') {
                appendUserMessage(originalText);
                contactData.phone = originalText;
                chatState = 'COLLECT_MESSAGE';
                const typingId = showTypingIndicator();
                setTimeout(() => {
                    document.getElementById(typingId)?.remove();
                    appendBotMessage(dict[botLang].collect_message);
                    messagesArea.scrollTop = messagesArea.scrollHeight;
                }, 600);
                return;
            }

            if (chatState === 'COLLECT_MESSAGE') {
                appendUserMessage(originalText);
                contactData.message = originalText;
                chatState = 'READY';
                sendContactToServer();
                const typingId = showTypingIndicator();
                setTimeout(() => {
                    document.getElementById(typingId)?.remove();
                    const successMsg = dict[botLang].success_msg
                        .replace('{name}', contactData.name)
                        .replace('{phone}', contactData.phone);
                    appendBotMessage(successMsg);
                    showMainQuickReplies();
                    messagesArea.scrollTop = messagesArea.scrollHeight;
                }, 800);
                return;
            }

            // --- Normal intent detection ---
            let intent = 'unknown';

            // --- Aki personal profile (highest priority) ---
            if(val.includes('como te llamas') || val.includes('tu nombre') || val.includes('quien eres') || val.includes('qué eres') || val.includes('que eres') || val.includes('eres un bot') || val.includes('eres humano') || val.includes('eres robot') || val.includes('eres real') || val.includes('cuantos años') || val.includes('your name') || val.includes('who are you') || val.includes('what are you') || val.includes('are you a bot') || val.includes('are you human') || val.includes('are you real') || val.includes('how old are you')) {
                intent = 'aki_personal';

            // --- Off-topic deflection ---
            } else if(val.includes('politica') || val.includes('deporte') || val.includes('futbol') || val.includes('fútbol') || val.includes('clima') || val.includes('chiste') || val.includes('broma') || val.includes('cuento') || val.includes('receta') || val.includes('cocina') || val.includes('noticias') || val.includes('politics') || val.includes('sports') || val.includes('weather') || val.includes('joke') || val.includes('recipe') || val.includes('news') || val.includes('movie') || val.includes('pelicula') || val.includes('película')) {
                intent = 'off_topic';

            // --- Normal intents ---
            } else if(val.includes('cuarto') || val.includes('habitacion') || val.includes('cama') || val.includes('precio') || val.includes('reserva') || val.includes('dormir') || val.includes('room') || val.includes('bed') || val.includes('price') || val.includes('book')) {
                intent = 'habitaciones';
            } else if(val.includes('contacto') || val.includes('telefono') || val.includes('llamar') || val.includes('whatsapp') || val.includes('numero') || val.includes('contact') || val.includes('phone') || val.includes('call') || val.includes('number')) {
                intent = 'contacto';
            } else if(val.includes('donde') || val.includes('ubicacion') || val.includes('direccion') || val.includes('llegar') || val.includes('mapa') || val.includes('where') || val.includes('location') || val.includes('address') || val.includes('map')) {
                intent = 'ubicacion';
            } else if(val.includes('nosotros') || val.includes('quienes') || val.includes('historia') || val.includes('about') || val.includes('who') || val.includes('story')) {
                intent = 'nosotros';
            } else if(val.includes('redes') || val.includes('facebook') || val.includes('instagram') || val.includes('social') || val.includes('network')) {
                intent = 'redes';
            } else if(val.includes('hola') || val.includes('buenas') || val.includes('buenos') || val.includes('hi') || val.includes('hello') || val.includes('hey') || val.includes('saludos')) {
                intent = 'saludo';
            }

            akiAsk(intent, originalText);
        });

        // Initialize chat window UI state
        let hasInitialized = false;

        function toggleChat() {
            isChatOpen = !isChatOpen;
            if (isChatOpen) {
                chatWindow.classList.remove('hidden');
                setTimeout(() => {
                    chatWindow.classList.remove('scale-95', 'opacity-0');
                    chatWindow.classList.add('scale-100', 'opacity-100');
                    input.focus();
                }, 10);
                
                const notif = toggleBtn.querySelector('span.bg-red-500');
                if(notif) notif.classList.add('hidden');

                if (!hasInitialized) {
                    hasInitialized = true;
                    showLangSelection();
                }
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
    });
</script>
