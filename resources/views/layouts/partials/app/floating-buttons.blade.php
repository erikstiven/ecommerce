{{-- resources/views/layouts/partials/app/floating-buttons.blade.php --}}
<div style="position:fixed; bottom:1rem; right:1rem; z-index:1000; display:flex; flex-direction:column; gap:0.75rem;">
    {{-- WhatsApp --}}
    <a href="https://wa.me/593979018689?text=Hola%2C%20me%20interesan%20los%20servicios%20y%20productos%20que%20muestran%20en%20su%20p%C3%A1gina%20web." target="_blank" rel="noopener"
       style="width:3rem; height:3rem; border-radius:50%; background-color:#25D366; color:#fff;
              display:flex; align-items:center; justify-content:center;
              box-shadow:0 4px 8px rgba(0,0,0,0.25); font-size:1.25rem;
              transition:transform 0.2s, box-shadow 0.2s;"
       onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.4)';"
       onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.25)';">
        <i class="fab fa-whatsapp"></i>
    </a>

    {{-- Ubicación --}}
    <a href="{{ route('ubicacion') }}"
       style="width:3rem; height:3rem; border-radius:50%; background-color:#E53E3E; color:#fff;
              display:flex; align-items:center; justify-content:center;
              box-shadow:0 4px 8px rgba(0,0,0,0.25); font-size:1.25rem;
              transition:transform 0.2s, box-shadow 0.2s;"
       onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.4)';"
       onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.25)';">
        <i class="fas fa-map-marker-alt"></i>
    </a>

    {{-- Preguntas --}}
    <a href="{{ route('sobre-nosotros') }}"
       style="width:3rem; height:3rem; border-radius:50%; background-color:#3B82F6; color:#fff;
              display:flex; align-items:center; justify-content:center;
              box-shadow:0 4px 8px rgba(0,0,0,0.25); font-size:1.25rem;
              transition:transform 0.2s, box-shadow 0.2s;"
       onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.4)';"
       onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.25)';">
        <i class="fas fa-question"></i>
    </a>
</div>
