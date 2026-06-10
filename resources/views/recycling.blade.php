<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Directorio Logístico 100 - Jovancito</title>
    <!-- Fonts from Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cantarell:ital,wght@0,400;0,700;1,400;1,700&family=Outfit:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                        cantarell: ['Cantarell', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            DEFAULT: '#2b1fd1',
                            hover: '#1b0fb3',
                            light: '#f0efff',
                            dark: '#0f0761',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-3xl">♻️</span>
                <div>
                    <h1 class="text-lg font-black font-outfit text-brand tracking-tight">Ameritex Diversion Inc.</h1>
                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Textile Recycling Portal</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-full border border-slate-200">
                    Directorio Logístico - Jovancito
                </span>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-7xl w-full mx-auto px-4 sm:px-6 py-8 flex-grow space-y-8">
        
        <!-- Welcome Card & Global Controls -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="space-y-1">
                <h2 class="text-2xl font-black font-outfit text-slate-900 tracking-tight">Directorio de 100 Tiendas</h2>
                <p class="text-sm text-slate-500">Busca tiendas por ruta o empresa y registra las bolsas de reciclaje recolectadas directamente en Google Sheets.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Manual Entry Button -->
                <button onclick="openLogModal(null)" class="px-5 py-3 bg-brand hover:bg-brand-hover text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all duration-300 shadow-md shadow-brand/10 hover:shadow-brand/20 flex items-center justify-center gap-2">
                    <span>➕</span> <span>Registro Manual</span>
                </button>
            </div>
        </div>

        <!-- Filter and Search Bar -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- View Toggle -->
            <div class="flex bg-slate-100 p-1 rounded-xl w-full md:w-auto">
                <button id="toggle-ruta" onclick="cambiarVista('ruta')" class="flex-1 md:flex-none px-6 py-2.5 bg-white text-slate-900 font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300 shadow-sm">
                    Por Ruta
                </button>
                <button id="toggle-empresa" onclick="cambiarVista('empresa')" class="flex-1 md:flex-none px-6 py-2.5 text-slate-500 hover:text-slate-900 font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300">
                    Por Empresa
                </button>
            </div>

            <!-- Live Search Input -->
            <div class="relative w-full md:max-w-md">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    🔍
                </span>
                <input type="text" id="search-input" oninput="filterDirectory()" placeholder="Buscar por nombre, teléfono, ruta o empresa..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-brand transition-all">
            </div>
        </div>

        <!-- Directory Render Container -->
        <div id="directorio" class="space-y-6">
            <!-- Dynamically populated via JS -->
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        <p>&copy; {{ date('Y') }} Ameritex Diversion Inc. &bull; Directorio Logístico 100</p>
    </footer>

    <!-- Form Logger Modal -->
    <div id="log-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 max-w-lg w-full space-y-6 shadow-2xl relative animate-fade-in">
            <button onclick="closeLogModal()" class="absolute right-5 top-5 text-slate-400 hover:text-slate-600 transition-colors text-lg font-bold">
                ✕
            </button>
            
            <div class="space-y-1">
                <span class="text-xs font-bold text-brand uppercase tracking-widest">Ameritex Sheets Logger</span>
                <h3 class="text-xl font-black font-outfit text-slate-900 uppercase tracking-tight">
                    Registrar Recolección
                </h3>
                <p class="text-xs text-slate-500">Ingresa la cantidad de bolsas recolectadas para esta ubicación.</p>
            </div>

            <form id="recycling-log-form" onsubmit="submitRecyclingLog(event)" class="space-y-4">
                <!-- Date Input -->
                <div class="flex flex-col space-y-1.5">
                    <label class="text-slate-500 font-bold text-xs uppercase tracking-wider">Fecha de Recolección</label>
                    <input type="date" id="log-date" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                </div>

                <!-- Store Input (Read-only if selected, editable if manual) -->
                <div class="flex flex-col space-y-1.5">
                    <label class="text-slate-500 font-bold text-xs uppercase tracking-wider">Tienda / Ubicación</label>
                    <input type="text" id="log-store" required placeholder="Nombre de la tienda..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:border-brand focus:bg-white transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Big Bags -->
                    <div class="flex flex-col space-y-1.5">
                        <label class="text-slate-500 font-bold text-xs uppercase tracking-wider">Bolsas Grandes (BIG)</label>
                        <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl overflow-hidden">
                            <button type="button" onclick="adjustCount('log-big', -1)" class="px-4 py-3 text-slate-500 hover:text-slate-800 hover:bg-slate-100 font-bold text-lg select-none transition-all">-</button>
                            <input type="number" id="log-big" required min="0" value="0" oninput="calculateTotal()" class="w-full bg-transparent border-none text-center text-sm font-bold text-slate-800 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <button type="button" onclick="adjustCount('log-big', 1)" class="px-4 py-3 text-slate-500 hover:text-slate-800 hover:bg-slate-100 font-bold text-lg select-none transition-all">+</button>
                        </div>
                    </div>

                    <!-- Small Bags -->
                    <div class="flex flex-col space-y-1.5">
                        <label class="text-slate-500 font-bold text-xs uppercase tracking-wider">Bolsas Pequeñas (SMALL)</label>
                        <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl overflow-hidden">
                            <button type="button" onclick="adjustCount('log-small', -1)" class="px-4 py-3 text-slate-500 hover:text-slate-800 hover:bg-slate-100 font-bold text-lg select-none transition-all">-</button>
                            <input type="number" id="log-small" required min="0" value="0" oninput="calculateTotal()" class="w-full bg-transparent border-none text-center text-sm font-bold text-slate-800 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <button type="button" onclick="adjustCount('log-small', 1)" class="px-4 py-3 text-slate-500 hover:text-slate-800 hover:bg-slate-100 font-bold text-lg select-none transition-all">+</button>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div class="flex flex-col space-y-1.5">
                    <label class="text-slate-500 font-bold text-xs uppercase tracking-wider">Total de Bolsas</label>
                    <input type="number" id="log-total" required min="0" value="0" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none font-black">
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" id="log-submit-btn" class="w-full py-3.5 bg-brand hover:bg-brand-hover text-white font-black font-outfit rounded-xl transition-all duration-300 text-xs uppercase tracking-wider shadow-lg shadow-brand/10 hover:shadow-brand/20 flex items-center justify-center gap-2">
                        <span id="submit-btn-spinner" class="hidden animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                        <span id="submit-btn-text">Enviar a Google Sheets</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JS Code -->
    <script>
        const lista = [
            // RUTA: Volusia (Alertas)
            {n: "Epiphany Thrift Store ⚠️", t: "(386) 775-6800", w: "https://epiphanythrift.com", a: true, r: "Volusia", e: "Independiente"},
            {n: "Neighborhood of West Volusia ⚠️", t: "(386) 734-8120", w: "https://neighborhoodcenterwv.org", a: true, r: "Volusia", e: "Independiente"},
            {n: "Out Father's Closet ⚠️", t: "(386) 218-4720", w: "https://outfatherscloset.org", a: true, r: "Volusia", e: "Independiente"},
            {n: "Citgo / Punto Conv. ⚠️", t: "N/A", w: "#", a: true, r: "Volusia", e: "Gasolineras"},
            {n: "Habitat ReStore (DeLand)", t: "(386) 279-0622", w: "https://habitatvolusia.org", a: false, r: "Volusia", e: "Habitat for Humanity"},
            {n: "West Volusia Habitat", t: "(386) 734-7170", w: "https://habitatvolusia.org", a: false, r: "Volusia", e: "Habitat for Humanity"},
            {n: "Salvation Army (Deltona)", t: "(386) 574-8666", w: "https://salvationarmyflorida.org", a: false, r: "Volusia", e: "Salvation Army"},
            {n: "Goodwill (Orange City)", t: "(386) 774-5660", w: "https://goodwillcfl.org", a: false, r: "Volusia", e: "Goodwill"},
            {n: "St. Vincent de Paul (Sanford)", t: "(407) 330-4400", w: "https://svdporlando.org", a: false, r: "Volusia", e: "St. Vincent de Paul"},
            {n: "Salvation Army (Sanford)", t: "(407) 322-2642", w: "https://salvationarmyflorida.org", a: false, r: "Volusia", e: "Salvation Army"},
            {n: "Founders Thrift (Lake Mary)", t: "(407) 330-9494", w: "https://foundersthrift.com", a: false, r: "Volusia", e: "Independiente"},
            {n: "Goodwill Xpress (Lake Mary)", t: "(407) 333-2895", w: "https://goodwillcfl.org", a: false, r: "Volusia", e: "Goodwill"},
            {n: "Helping Hand (Eustis)", t: "(352) 589-5654", w: "https://helpinghand.org", a: false, r: "Volusia", e: "Independiente"},
            {n: "Community Thrift (Leesburg)", t: "(352) 326-0000", w: "https://communitythrift.org", a: false, r: "Volusia", e: "Independiente"},
            {n: "Apopka Thrift", t: "(407) 886-0000", w: "https://apopkathrift.com", a: false, r: "Volusia", e: "Independiente"},
            {n: "St. Vincent de Paul (Apopka)", t: "(407) 886-1793", w: "https://svdporlando.org", a: false, r: "Volusia", e: "St. Vincent de Paul"},
            
            // RUTA: Orlando
            {n: "Mustard Seed", t: "(407) 875-2040", w: "https://mustardseedfla.org", a: false, r: "Orlando", e: "Mustard Seed"},
            {n: "Out of the Closet", t: "(407) 583-4916", w: "https://outofthecloset.org", a: false, r: "Orlando", e: "Out of the Closet"},
            {n: "UCP Thrift Store", t: "(407) 852-3300", w: "https://ucponline.org", a: false, r: "Orlando", e: "UCP"},
            {n: "Rescue Mission Thrift", t: "(407) 422-4855", w: "https://orlandorescuemission.org", a: false, r: "Orlando", e: "Rescue Mission"},
            {n: "Amvets Thrift Store", t: "(407) 290-2812", w: "https://amvets.org", a: false, r: "Orlando", e: "Amvets"},
            {n: "Goodwill (Winter Park)", t: "(407) 628-1111", w: "https://goodwillcfl.org", a: false, r: "Orlando", e: "Goodwill"},
            {n: "Hope & Help Thrift", t: "(407) 645-2533", w: "https://hopeandhelp.org", a: false, r: "Orlando", e: "Hope & Help"},
            {n: "Discovery Shop", t: "(407) 629-9114", w: "https://cancer.org", a: false, r: "Orlando", e: "ACS"},
            {n: "Pet Thrift Shop", t: "(407) 644-4860", w: "https://petthriftshop.com", a: false, r: "Orlando", e: "Independiente"},
            {n: "Christian Sharing Center", t: "(407) 260-9155", w: "https://thesharingcenter.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Second Harvest", t: "(407) 295-1066", w: "https://feedhopenow.org", a: false, r: "Orlando", e: "Food Bank"},
            {n: "Thrift Boutique", t: "(407) 896-0101", w: "https://thriftboutique.com", a: false, r: "Orlando", e: "Independiente"},
            {n: "Jewish Family Services", t: "(407) 644-7671", w: "https://jfsorlando.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "St. Vincent de Paul (Orlando)", t: "(407) 859-0099", w: "https://svdporlando.org", a: false, r: "Orlando", e: "St. Vincent de Paul"},
            {n: "Thrift Mart", t: "(407) 246-0000", w: "https://thriftmart.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Sunshine Thrift", t: "(407) 425-0000", w: "https://sunshinethrift.com", a: false, r: "Orlando", e: "Sunshine Thrift"},
            {n: "Care & Share", t: "(407) 896-0000", w: "https://careandshare.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Unity Thrift", t: "(407) 843-0000", w: "https://unitythrift.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Joy Thrift", t: "(407) 299-0000", w: "https://joythrift.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Hope Thrift", t: "(407) 363-0000", w: "https://hopethrift.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Grace Thrift", t: "(407) 648-0000", w: "https://gracethrift.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Faith Thrift", t: "(407) 649-0000", w: "https://faiththrift.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Victory Thrift", t: "(407) 841-0000", w: "https://victorythrift.org", a: false, r: "Orlando", e: "Independiente"},
            {n: "Habitat ReStore (East)", t: "(407) 277-5188", w: "https://habitatorlandoosceola.org", a: false, r: "Orlando", e: "Habitat for Humanity"},
    
            // RUTA: Kissimmee / Lakeland
            {n: "Faith Neighborhood", t: "(407) 847-0100", w: "https://faiththrift.org", a: false, r: "Kissimmee", e: "Independiente"},
            {n: "Salvation Army (Kissimmee)", t: "(407) 846-0683", w: "https://salvationarmyflorida.org", a: false, r: "Kissimmee", e: "Salvation Army"},
            {n: "Habitat ReStore (Kissimmee)", t: "(407) 846-4228", w: "https://habitatorlandoosceola.org", a: false, r: "Kissimmee", e: "Habitat for Humanity"},
            {n: "Goodwill (Kissimmee)", t: "(407) 846-1234", w: "https://goodwillcfl.org", a: false, r: "Kissimmee", e: "Goodwill"},
            {n: "Salvation Army (Lakeland)", t: "(863) 682-1232", w: "https://salvationarmyflorida.org", a: false, r: "Lakeland", e: "Salvation Army"},
            {n: "Helping Hearts", t: "(863) 686-0000", w: "https://helpinghearts.org", a: false, r: "Lakeland", e: "Independiente"},
            {n: "Treasure Chest (Winter Haven)", t: "(863) 293-0000", w: "https://treasurechest.org", a: false, r: "Lakeland", e: "Independiente"},
            {n: "Goodwill (Clermont)", t: "(352) 243-0245", w: "https://goodwillcfl.org", a: false, r: "Lakeland", e: "Goodwill"},
            {n: "The HOPE Chest (Oviedo)", t: "(407) 367-2989", w: "https://thehopechest.com", a: false, r: "Kissimmee", e: "Independiente"},
    
            // RUTA: Miami
            {n: "Miami Rescue Mission", t: "(305) 571-2273", w: "https://miamirescuemission.com", a: false, r: "Miami", e: "Rescue Mission"},
            {n: "Salvation Army Thrift", t: "(305) 573-4200", w: "https://salvationarmyflorida.org", a: false, r: "Miami", e: "Salvation Army"},
            {n: "Goodwill South FL", t: "(305) 325-9114", w: "https://goodwillsouthflorida.org", a: false, r: "Miami", e: "Goodwill"},
            {n: "St. Vincent de Paul", t: "(305) 642-9668", w: "https://svdpmiami.org", a: false, r: "Miami", e: "St. Vincent de Paul"},
            {n: "Sunshine Thrift", t: "(305) 255-0000", w: "https://sunshinethrift.com", a: false, r: "Miami", e: "Sunshine Thrift"},
            {n: "Hope Thrift", t: "(305) 235-0000", w: "https://hopethriftmiami.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Bargain Box", t: "(305) 854-0000", w: "https://bargainboxmiami.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Thrift Mart", t: "(305) 279-0000", w: "https://thriftmart.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Faith Thrift", t: "(305) 666-0000", w: "https://faiththrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Grace Thrift", t: "(305) 674-0000", w: "https://gracethrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Joy Thrift", t: "(305) 635-0000", w: "https://joythrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Victory Thrift", t: "(305) 751-0000", w: "https://victorythrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Care & Share", t: "(305) 891-0000", w: "https://careandshare.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Unity Thrift", t: "(305) 944-0000", w: "https://unitythrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Angel Thrift", t: "(305) 238-0000", w: "https://angelthrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Helping Hearts", t: "(305) 252-0000", w: "https://helpinghearts.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Discovery Shop", t: "(305) 253-0000", w: "https://cancer.org", a: false, r: "Miami", e: "ACS"},
            {n: "Habitat ReStore", t: "(305) 634-3628", w: "https://habitatmiami.org", a: false, r: "Miami", e: "Habitat for Humanity"},
            {n: "Goodwill (Hialeah)", t: "(305) 823-0000", w: "https://goodwillsouthflorida.org", a: false, r: "Miami", e: "Goodwill"},
            {n: "Salvation Army (Hialeah)", t: "(305) 885-0000", w: "https://salvationarmyflorida.org", a: false, r: "Miami", e: "Salvation Army"},
            {n: "St. Vincent de Paul (Hialeah)", t: "(305) 821-0000", w: "https://svdpmiami.org", a: false, r: "Miami", e: "St. Vincent de Paul"},
            {n: "Helping Hands (Hialeah)", t: "(305) 827-0000", w: "https://helpinghands.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Treasure Chest (Coral Gables)", t: "(305) 441-0000", w: "https://treasurechest.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Thrift Shop (Coral Gables)", t: "(305) 445-0000", w: "https://coralgablesthrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Community Thrift (N Miami)", t: "(305) 893-0000", w: "https://communitythrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Hope Thrift (N Miami)", t: "(305) 895-0000", w: "https://hopethrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Sunshine Thrift (N Miami)", t: "(305) 899-0000", w: "https://sunshinethrift.com", a: false, r: "Miami", e: "Sunshine Thrift"},
            {n: "Care & Share (Homestead)", t: "(305) 248-0000", w: "https://careandshare.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Unity Thrift (Homestead)", t: "(305) 247-0000", w: "https://unitythrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Angel Thrift (Homestead)", t: "(305) 245-0000", w: "https://angelthrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Helping Hearts (Homestead)", t: "(305) 242-0000", w: "https://helpinghearts.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Habitat ReStore (Homestead)", t: "(305) 246-0000", w: "https://habitatmiami.org", a: false, r: "Miami", e: "Habitat for Humanity"},
            {n: "Goodwill (Miami Beach)", t: "(305) 538-0000", w: "https://goodwillsouthflorida.org", a: false, r: "Miami", e: "Goodwill"},
            {n: "Salvation Army (Miami Beach)", t: "(305) 534-0000", w: "https://salvationarmyflorida.org", a: false, r: "Miami", e: "Salvation Army"},
            {n: "St. Vincent de Paul (Miami Beach)", t: "(305) 531-0000", w: "https://svdpmiami.org", a: false, r: "Miami", e: "St. Vincent de Paul"},
            {n: "Helping Hands (Miami Beach)", t: "(305) 532-0000", w: "https://helpinghands.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Treasure Chest (Aventura)", t: "(305) 935-0000", w: "https://treasurechest.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Thrift Shop (Aventura)", t: "(305) 932-0000", w: "https://aventurathrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Community Thrift (Kendall)", t: "(305) 271-0000", w: "https://communitythrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Hope Thrift (Kendall)", t: "(305) 273-0000", w: "https://hopethrift.org", a: false, r: "Miami", e: "Independiente"},
            {n: "Sunshine Thrift (Kendall)", t: "(305) 275-0000", w: "https://sunshinethrift.com", a: false, r: "Miami", e: "Sunshine Thrift"},
            {n: "Care & Share (Kendall)", t: "(305) 279-0000", w: "https://careandshare.org", a: false, r: "Miami", e: "Independiente"},
    
            // RUTA: Ft. Lauderdale / Hollywood
            {n: "Helping Hands (Ft Laud)", t: "(954) 522-4855", w: "https://helpinghands.org", a: false, r: "Ft. Lauderdale", e: "Independiente"},
            {n: "Goodwill (Ft Laud)", t: "(954) 749-0000", w: "https://goodwillsouthflorida.org", a: false, r: "Ft. Lauderdale", e: "Goodwill"},
            {n: "Salvation Army (Ft Laud)", t: "(954) 524-0000", w: "https://salvationarmyflorida.org", a: false, r: "Ft. Lauderdale", e: "Salvation Army"},
            {n: "St. Vincent de Paul (Ft Laud)", t: "(954) 462-0000", w: "https://svdpmiami.org", a: false, r: "Ft. Lauderdale", e: "St. Vincent de Paul"},
            {n: "Rescue Mission (Ft Laud)", t: "(954) 524-6991", w: "https://ftlauderdalerescue.org", a: false, r: "Ft. Lauderdale", e: "Rescue Mission"},
            {n: "Treasure Chest (Hollywood)", t: "(954) 921-0000", w: "https://treasurechest.org", a: false, r: "Ft. Lauderdale", e: "Independiente"},
            {n: "Community Thrift (Hollywood)", t: "(954) 961-0000", w: "https://communitythrift.org", a: false, r: "Ft. Lauderdale", e: "Independiente"},
            {n: "Hope Thrift (Hollywood)", t: "(954) 989-0000", w: "https://hopethrift.org", a: false, r: "Ft. Lauderdale", e: "Independiente"},
            {n: "New Life Thrift (Rockledge)", t: "(321) 632-4416", w: "https://newlifethrift.com", a: false, r: "Ft. Lauderdale", e: "Independiente"}
        ];

        let vistaActual = 'ruta';
        let filtroTexto = '';

        function cambiarVista(modo) {
            vistaActual = modo;
            
            // Toggle active classes on view buttons
            const btnRuta = document.getElementById('toggle-ruta');
            const btnEmpresa = document.getElementById('toggle-empresa');
            
            if (modo === 'ruta') {
                btnRuta.className = "flex-1 md:flex-none px-6 py-2.5 bg-brand text-white font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300 shadow-sm shadow-brand/10";
                btnEmpresa.className = "flex-1 md:flex-none px-6 py-2.5 text-slate-500 hover:text-slate-900 font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300";
            } else {
                btnEmpresa.className = "flex-1 md:flex-none px-6 py-2.5 bg-brand text-white font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300 shadow-sm shadow-brand/10";
                btnRuta.className = "flex-1 md:flex-none px-6 py-2.5 text-slate-500 hover:text-slate-900 font-bold font-outfit rounded-lg text-xs uppercase tracking-wider transition-all duration-300";
            }
            
            renderDirectorio();
        }

        function filterDirectory() {
            filtroTexto = document.getElementById('search-input').value.toLowerCase();
            renderDirectorio();
        }

        function renderDirectorio() {
            let html = "";
            let grupos = {};
            
            // Filter list
            const listaFiltrada = lista.filter(item => 
                item.n.toLowerCase().includes(filtroTexto) || 
                item.t.toLowerCase().includes(filtroTexto) || 
                item.r.toLowerCase().includes(filtroTexto) || 
                item.e.toLowerCase().includes(filtroTexto)
            );
            
            listaFiltrada.forEach(item => {
                let clave = vistaActual === 'ruta' ? item.r : item.e;
                if (!grupos[clave]) grupos[clave] = [];
                grupos[clave].push(item);
            });
            
            const keys = Object.keys(grupos).sort();
            
            if (keys.length === 0) {
                document.getElementById("directorio").innerHTML = `
                    <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center text-slate-400">
                        <span class="text-4xl block mb-2">🔍</span>
                        No se encontraron tiendas que coincidan con la búsqueda.
                    </div>
                `;
                return;
            }
            
            keys.forEach(clave => {
                html += `
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="bg-slate-900 px-6 py-4 flex items-center justify-between">
                            <span class="text-white font-black font-outfit text-sm uppercase tracking-wider">${clave}</span>
                            <span class="text-xs bg-slate-800 text-slate-400 px-2.5 py-1 rounded-full font-medium">
                                ${grupos[clave].length} ${grupos[clave].length === 1 ? 'Tienda' : 'Tiendas'}
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                                        <th class="px-6 py-3.5 font-bold">Nombre</th>
                                        <th class="px-6 py-3.5 font-bold">Teléfono</th>
                                        <th class="px-6 py-3.5 font-bold">Web</th>
                                        <th class="px-6 py-3.5 font-bold text-right">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    `;
                
                grupos[clave].forEach(item => {
                    const cleanName = item.n.replace("⚠️", "").trim();
                    html += `
                        <tr class="${item.a ? 'bg-red-50/70 text-red-900 font-semibold' : 'hover:bg-slate-50/50'} transition-colors">
                            <td class="px-6 py-4 flex items-center gap-2">
                                ${item.a ? '<span class="text-red-500">⚠️</span>' : ''}
                                <span class="tracking-wide">${cleanName}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-normal">${item.t}</td>
                            <td class="px-6 py-4">
                                ${item.w !== '#' ? `<a href="${item.w}" target="_blank" class="text-brand hover:underline flex items-center gap-1 font-bold">Visitar ↗</a>` : '<span class="text-slate-400 font-normal">N/A</span>'}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button onclick="openLogModal('${cleanName.replace(/'/g, "\\'")}')" class="px-3.5 py-2 bg-brand/10 hover:bg-brand text-brand hover:text-white rounded-lg text-[10px] uppercase font-black tracking-wider transition-all duration-200">
                                    📝 Registrar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                html += `
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;
            });
            
            document.getElementById("directorio").innerHTML = html;
        }

        // Modal Helpers
        function openLogModal(storeName) {
            document.getElementById('log-modal').classList.remove('hidden');
            
            // Set default date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('log-date').value = today;
            
            const storeInput = document.getElementById('log-store');
            
            if (storeName) {
                storeInput.value = storeName;
                storeInput.readOnly = true;
                storeInput.classList.replace('bg-slate-50', 'bg-slate-100');
                storeInput.classList.add('text-slate-550', 'font-semibold');
            } else {
                storeInput.value = '';
                storeInput.readOnly = false;
                storeInput.classList.replace('bg-slate-100', 'bg-slate-50');
                storeInput.classList.remove('text-slate-550', 'font-semibold');
                storeInput.focus();
            }
            
            // Reset counters
            document.getElementById('log-big').value = 0;
            document.getElementById('log-small').value = 0;
            document.getElementById('log-total').value = 0;
        }

        function closeLogModal() {
            document.getElementById('log-modal').classList.add('hidden');
            document.getElementById('log-store').value = '';
        }

        function adjustCount(inputId, amount) {
            const input = document.getElementById(inputId);
            let current = parseInt(input.value) || 0;
            current = Math.max(0, current + amount);
            input.value = current;
            calculateTotal();
        }

        function calculateTotal() {
            const big = parseInt(document.getElementById('log-big').value) || 0;
            const small = parseInt(document.getElementById('log-small').value) || 0;
            document.getElementById('log-total').value = big + small;
        }

        function submitRecyclingLog(event) {
            event.preventDefault();
            
            const submitBtn = document.getElementById('log-submit-btn');
            const spinner = document.getElementById('submit-btn-spinner');
            const btnText = document.getElementById('submit-btn-text');

            submitBtn.disabled = true;
            spinner.classList.remove('hidden');
            btnText.textContent = 'Enviando...';

            const logData = {
                date: document.getElementById('log-date').value,
                store: document.getElementById('log-store').value,
                big: parseInt(document.getElementById('log-big').value) || 0,
                small: parseInt(document.getElementById('log-small').value) || 0,
                total: parseInt(document.getElementById('log-total').value) || 0,
            };

            fetch('/api/recycling/log', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(logData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('¡Registro guardado con éxito!');
                    closeLogModal();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => {
                console.error("Error submitting log:", err);
                alert('Error de conexión con el servidor.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                spinner.classList.add('hidden');
                btnText.textContent = 'Enviar a Google Sheets';
            });
        }

        // Initialize Page
        window.addEventListener('DOMContentLoaded', () => {
            cambiarVista('ruta');
        });
    </script>

</body>
</html>
