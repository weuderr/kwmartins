
$(document).ready(function() {
    var resolucaoTela = window.innerWidth + 'x' + window.innerHeight;
    var tipoDispositivo = 'Desktop'; // Padrão para desktop
    if (window.innerWidth <= 768) {
        tipoDispositivo = 'Mobile';
    } else if (window.innerWidth <= 1024) {
        tipoDispositivo = 'Tablet';
    }
    var idiomaNavegador = navigator.language || navigator.userLanguage;
    var suporteCookies = navigator.cookieEnabled;
    var velocidadeConexao = navigator.connection ? navigator.connection.downlink + 'Mbps' : 'Desconhecido';

    // Tentativa de obter a localização geográfica do usuário
    var latitude = 'Desconhecido';
    var longitude = 'Desconhecido';

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;

            // Atualiza as informações no banco de dados, incluindo a localização
            console.log("Geolocalização obtida: ", latitude, longitude);
            atualizarInformacoes(latitude, longitude);
        }, function(error) {
            console.error("Erro ao obter localização geográfica: ", error);

            // Atualiza as informações no banco de dados mesmo sem a localização
            atualizarInformacoes(latitude, longitude);
        });
    } else {
        console.log("Geolocalização não é suportada neste navegador.");

        // Atualiza as informações no banco de dados mesmo sem a localização
        atualizarInformacoes(latitude, longitude);
    }

    function atualizarInformacoes(lat, lng) {
        var id = $('#hiddenData').data('id');
        console.log(resolucaoTela, tipoDispositivo, idiomaNavegador, suporteCookies, velocidadeConexao, lat, lng, id);
        $.ajax({
            url: 'update.php',
            method: 'POST',
            data: {
                id: id,
                resolucaoTela: resolucaoTela,
                tipoDispositivo: tipoDispositivo,
                idiomaNavegador: idiomaNavegador,
                suporteCookies: suporteCookies,
                velocidadeConexao: velocidadeConexao,
                latitude: lat,
                longitude: lng
            }
        });
    }
});