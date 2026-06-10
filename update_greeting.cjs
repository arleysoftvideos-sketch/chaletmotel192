const fs = require('fs');

const dataPath = 'lang/en.json';
let translations = JSON.parse(fs.readFileSync(dataPath, 'utf8'));

translations['¡Hola! ¿En qué te puedo ayudar hoy? Puedes usar los botones o escribirme lo que necesitas.'] = "Hi! How can I help you today? You can use the buttons or type what you need.";

fs.writeFileSync(dataPath, JSON.stringify(translations, null, 4));
console.log("Translation for greeting added successfully.");
