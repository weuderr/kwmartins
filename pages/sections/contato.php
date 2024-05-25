<div class="card mb-4 shadow-sm card-custom">
    <h5 class="card-header">Contato</h5>
    <div class="card-body">
        <p class="card-text">Horário de atendimento: Terça-feira a Sábado das 09h às 17h</p>
        <p class="card-text">Telefone: <a href="tel:+351939000856">+351 939 000 856</a></p>
        <p class="card-text">Email: <a href="mailto:atendimento@kwmartins.pt">atendimento@kwmartins.pt</a></p>
        <p class="card-text">Rua António Carneiro 147, 4450-047 Matosinhos</p>
        <!-- Mapa OpenStreetMap com Leaflet -->
        <div id="map" style="width: 100%; height: 400px;"></div>
        <!-- Botão para ver no Google Maps -->
        <div class="text-center mt-3">
            <a href="https://www.google.com/maps/search/?api=1&query=41.178083,-8.675401" target="_blank" class="btn btn-primary">
                Ver no Google Maps
            </a>
        </div>
    </div>
    <div class="p-3">
        <p>Entre em contato conosco através do WhatsApp para agendar uma consulta ou tirar dúvidas.</p>
        <a href="https://api.whatsapp.com/send?phone=351966296791&text=Gostaria%20de%20de%20uma%20tirar%20d%C3%BAvida" class="btn btn-principal text-center" target="_blank">Contato via WhatsApp</a>
    </div>
</div>

<!-- Inclui as bibliotecas Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var map = L.map('map').setView([41.1780044, -8.6754612], 14); // Nível de zoom ajustado para 18

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
        }).addTo(map);

        L.marker([41.178083, -8.675401]).addTo(map)
            .bindPopup('KW Martins')
            .openPopup();

        // Ajusta o tamanho do mapa ao contêiner
        setTimeout(function() {
            map.invalidateSize();
        }, 0);
    });
</script>
