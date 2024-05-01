$(document).ready(function() {
    // Envia uma nova mensagem
    $('#messageForm').submit(function(e) {
        e.preventDefault();
        var messageData = {
            message: $('#message').val(),
            message_type: 'pergunta'
        };

        $.ajax({
            type: 'POST',
            url: 'sync-message.php',
            data: JSON.stringify(messageData),
            contentType: "application/json",
            success: function(response) {
                $('#message').val('');
                loadMessages(); // Carrega mensagens após o envio
            },
            error: function() {
                alert('Erro ao enviar a mensagem.');
            }
        });
    });

    function formatDate(isoString) {
        var date = new Date(isoString);
        var day = ('0' + date.getDate()).slice(-2);
        var month = ('0' + (date.getMonth() + 1)).slice(-2);
        var year = date.getFullYear();
        var hours = ('0' + date.getHours()).slice(-2);
        var minutes = ('0' + date.getMinutes()).slice(-2);

        return day + '/' + month + '/' + year + ' ' + hours + ':' + minutes;
    }

    function appendMessage(msg) {
        var messageClass = msg.message_type === 'pergunta' ? 'cliente' : 'funcionario';
        $('#messagesContainer').append('<div class="' + messageClass + '">' + msg.message + '<br><small style="align-self: flex-end;">' + formatDate(msg.timestamp) + '</small></div>');
    }

    // Carrega mensagens
    function loadMessages() {
        $.get('sync-message.php', function(data) {
            var messages = JSON.parse(data);
            $('#messagesContainer').html(''); // Limpa mensagens anteriores
            messages = startMessage.concat(messages);
            messages.forEach(function(msg) {
                appendMessage(msg);
            });
        });
    }


    const startMessage = [
        {
            message: 'Caro(a) cliente, é com enorme prazer que recebemos o seu contacto. Agradecemos o seu interesse pelos nossos serviços.',
            message_type: 'resposta',
            timestamp: new Date().toISOString()
        },
        {
            message: 'De momento, encontramo-nos com uma agenda bastante preenchida. No entanto, temos uma vaga disponível amanhã pelas 10h. Ser-lhe-ia conveniente?',
            message_type: 'resposta',
            timestamp: new Date().toISOString()
        }
    ];


    function main() {
        $('#messagesContainer').html(''); // Limpa mensagens anteriores
        startMessage.forEach(function(msg) {
            appendMessage(msg);
        });
        loadMessages();
        // Atualiza as mensagens a cada 5 segundos
        // setInterval(loadMessages, 5000);
    }

    main();
});