const fs = require('fs');

const dataPath = 'lang/en.json';
let translations = JSON.parse(fs.readFileSync(dataPath, 'utf8'));

const newTranslations = {
    "En línea": "Online",
    "¡Hola! Soy <b>Adi</b>, tu asistente virtual en Chalet Motel 192 😎🌴. ¿En qué te puedo ayudar hoy?": "Hi! I'm <b>Adi</b>, your virtual assistant at Chalet Motel 192 😎🌴. How can I help you today?",
    "Habitaciones": "Rooms",
    "Contacto": "Contact",
    "Ubicación": "Location",
    "Redes Sociales": "Social Networks",
    "Escribe un mensaje...": "Type a message...",
    "Quiero ver habitaciones": "I want to see rooms",
    "¿Cómo los contacto?": "How do I contact you?",
    "¿Dónde están ubicados?": "Where are you located?",
    "¿Quiénes son ustedes?": "Who are you?",
    "Redes sociales": "Social networks",
    "Contamos con hermosas habitaciones como nuestra <b>King Suite</b> o habitaciones de dos camas. Nuestras tarifas básicas son:<br><br><b>Tarifas Diarias:</b><br>• 1 Persona: $75/día<br>• 2 Personas (1 o 2 camas): $105/día<br>• 3 Personas: $140/día<br><br><b>Tarifas Mensuales:</b><br>• Desde $800 al mes<br><br>Si deseas reservar, <a href='tel:+14077731461' class='text-gold underline font-bold'>llámanos al +1 407 773 1461</a> o contáctanos por WhatsApp.": "We have beautiful rooms like our <b>King Suite</b> or rooms with two beds. Our basic rates are:<br><br><b>Daily Rates:</b><br>• 1 Guest: $75/day<br>• 2 Guests (1 or 2 beds): $105/day<br>• 3 Guests: $140/day<br><br><b>Monthly Rates:</b><br>• Starting from $800/month<br><br>If you want to book, <a href='tel:+14077731461' class='text-gold underline font-bold'>call us at +1 407 773 1461</a> or contact us via WhatsApp.",
    "Puedes comunicarte directamente con nosotros por teléfono o WhatsApp: <br><br> 📞 <a href=\"tel:+14077731461\" class=\"text-gold underline font-bold\">+1 407 773 1461</a> <br> 💬 <a href=\"https://wa.me/14077731461\" target=\"_blank\" class=\"text-[#25D366] underline font-bold\">WhatsApp (+1 407 773 1461)</a>.": "You can contact us directly by phone or WhatsApp: <br><br> 📞 <a href=\"tel:+14077731461\" class=\"text-gold underline font-bold\">+1 407 773 1461</a> <br> 💬 <a href=\"https://wa.me/14077731461\" target=\"_blank\" class=\"text-[#25D366] underline font-bold\">WhatsApp (+1 407 773 1461)</a>.",
    "📍 Estamos ubicados en:<br><b>4741 W Irlo Bronson Memorial Hwy, Kissimmee, FL 34746</b>.<br><br><a href=\"https://maps.google.com/?q=4741+W+Irlo+Bronson+Memorial+Hwy,+Kissimmee,+FL+34746\" target=\"_blank\" class=\"text-gold underline font-bold\">👉 Ver en Google Maps</a>": "📍 We are located at:<br><b>4741 W Irlo Bronson Memorial Hwy, Kissimmee, FL 34746</b>.<br><br><a href=\"https://maps.google.com/?q=4741+W+Irlo+Bronson+Memorial+Hwy,+Kissimmee,+FL+34746\" target=\"_blank\" class=\"text-gold underline font-bold\">👉 View on Google Maps</a>",
    "🏨 Somos <b>Chalet Motel 192</b>, tu mejor opción de descanso en Kissimmee, Florida. Nuestro compromiso es ofrecerte habitaciones cómodas y una estancia relajante. ¡Esperamos verte pronto!": "🏨 We are <b>Chalet Motel 192</b>, your best option for rest in Kissimmee, Florida. Our commitment is to offer you comfortable rooms and a relaxing stay. We hope to see you soon!",
    "¡Síguenos en nuestras redes para no perderte de nada! <br><br> <a href=\"https://www.facebook.com/profile.php?id=61590106737806\" target=\"_blank\" class=\"text-[#1877F2] underline font-bold\">📘 Facebook</a> <br> <a href=\"https://www.instagram.com/kissmemotel192/\" target=\"_blank\" class=\"text-pink-400 underline font-bold\">📸 Instagram</a> <br> <a href=\"https://www.tiktok.com/@chalet.motel.192\" target=\"_blank\" class=\"text-white underline font-bold\">🎵 TikTok</a>": "Follow us on our social networks so you don't miss anything! <br><br> <a href=\"https://www.facebook.com/profile.php?id=61590106737806\" target=\"_blank\" class=\"text-[#1877F2] underline font-bold\">📘 Facebook</a> <br> <a href=\"https://www.instagram.com/kissmemotel192/\" target=\"_blank\" class=\"text-pink-400 underline font-bold\">📸 Instagram</a> <br> <a href=\"https://www.tiktok.com/@chalet.motel.192\" target=\"_blank\" class=\"text-white underline font-bold\">🎵 TikTok</a>",
    "Mmm, no estoy seguro de la respuesta a eso 🤔. Pero no te preocupes, para otras consultas específicas, preguntas o reservas, <b>¡comunícate con nosotros directamente!</b><br><br>📞 <a href=\"tel:+14077731461\" class=\"text-gold underline font-bold\">Llamar al Motel</a> <br>💬 <a href=\"https://wa.me/14077731461\" target=\"_blank\" class=\"text-[#25D366] underline font-bold\">Chat por WhatsApp</a>": "Mmm, I'm not sure about the answer to that 🤔. But don't worry, for other specific queries, questions or reservations, <b>contact us directly!</b><br><br>📞 <a href=\"tel:+14077731461\" class=\"text-gold underline font-bold\">Call the Motel</a> <br>💬 <a href=\"https://wa.me/14077731461\" target=\"_blank\" class=\"text-[#25D366] underline font-bold\">WhatsApp Chat</a>",
    "Nuestras Redes Sociales": "Our Social Networks",
    "Alquileres de Largo Plazo": "Long Term Rentals",
    "Conéctate con nosotros en todas nuestras redes sociales oficiales.": "Connect with us on all our official social networks.",
    "Sitio Web Oficial": "Official Website",
    "Copiar": "Copy",
    "Compartir": "Share",
    "¡Copiado!": "Copied!",
    "Mira el canal oficial de Chalet Motel 192:": "Check out the official channel of Chalet Motel 192:",
    "Enlace copiado al portapapeles para compartir:": "Link copied to clipboard to share:"
};

for (const [key, val] of Object.entries(newTranslations)) {
    translations[key] = val;
}

fs.writeFileSync(dataPath, JSON.stringify(translations, null, 4));
console.log("Translations added successfully.");
