<div class="w-full bg-[#0c1b35] border border-blue-900/80 rounded-3xl p-6 md:p-8 shadow-2xl">
    <form action="{{ route('rooms.index') }}" method="GET" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <!-- Check In Date -->
            <div class="relative group">
                <label for="check_in" class="block text-xs font-bold text-yellow-500 uppercase tracking-wider mb-2 group-focus-within:text-yellow-400 transition-colors">
                    Fecha de Entrada
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input type="date" name="check_in" id="check_in" required
                        class="block w-full pl-10 pr-4 py-3 bg-[#081326] border border-blue-900 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all hover:border-blue-800"
                        min="{{ date('Y-m-d') }}" value="{{ request('check_in', date('Y-m-d')) }}">
                </div>
            </div>

            <!-- Check Out Date -->
            <div class="relative group">
                <label for="check_out" class="block text-xs font-bold text-yellow-500 uppercase tracking-wider mb-2 group-focus-within:text-yellow-400 transition-colors">
                    Fecha de Salida
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input type="date" name="check_out" id="check_out" required
                        class="block w-full pl-10 pr-4 py-3 bg-[#081326] border border-blue-900 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all hover:border-blue-800"
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ request('check_out', date('Y-m-d', strtotime('+1 day'))) }}">
                </div>
            </div>

            <!-- Guests Count -->
            <div class="relative group">
                <label for="guests" class="block text-xs font-bold text-yellow-500 uppercase tracking-wider mb-2 group-focus-within:text-yellow-400 transition-colors">
                    Huéspedes
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <select name="guests" id="guests"
                        class="block w-full pl-10 pr-4 py-3 bg-[#081326] border border-blue-900 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all hover:border-blue-800 appearance-none">
                        <option value="1" {{ request('guests') == 1 ? 'selected' : '' }}>1 Persona</option>
                        <option value="2" {{ request('guests', 2) == 2 ? 'selected' : '' }}>2 Personas</option>
                        <option value="3" {{ request('guests') == 3 ? 'selected' : '' }}>3 Personas</option>
                        <option value="4" {{ request('guests') == 4 ? 'selected' : '' }}>4 Personas</option>
                        <option value="5" {{ request('guests') == 5 ? 'selected' : '' }}>5+ Personas</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Room Type -->
            <div class="relative group">
                <label for="room_type" class="block text-xs font-bold text-yellow-500 uppercase tracking-wider mb-2 group-focus-within:text-yellow-400 transition-colors">
                    Tipo de Habitación
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <select name="room_type" id="room_type"
                        class="block w-full pl-10 pr-4 py-3 bg-[#081326] border border-blue-900 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all hover:border-blue-800 appearance-none">
                        <option value="">Todas las categorías</option>
                        <option value="Individual" {{ request('room_type') == 'Individual' ? 'selected' : '' }}>Individual</option>
                        <option value="Doble" {{ request('room_type') == 'Doble' ? 'selected' : '' }}>Doble</option>
                        <option value="Suite" {{ request('room_type') == 'Suite' ? 'selected' : '' }}>Suite</option>
                        <option value="Deluxe" {{ request('room_type') == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        <div class="flex justify-end pt-2">
            <button type="submit"
                class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-yellow-500 to-amber-600 hover:from-yellow-400 hover:to-amber-500 text-[#0a1831] font-extrabold text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-yellow-500/10 hover:shadow-yellow-500/20 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-3">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Buscar Disponibilidad
            </button>
        </div>
    </form>
</div>
