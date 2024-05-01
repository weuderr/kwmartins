let selectedClient = null;

$(document).ready(function() {
    loadClients();

    $('#replyForm').submit(function(e) {
        e.preventDefault();
        if (!selectedClient) {
            alert('Por favor, selecione um cliente para responder.');
            return;
        }

        var message = $('#replyMessage').val();

        // Substitua 'send-reply.php' pelo seu endpoint real
        $.post('sync-message.php', { message: message, cliente_id: selectedClient }, function(data) {
            $('#replyMessage').val(''); // Limpa o campo de texto
            loadMessages(selectedClient); // Recarrega as mensagens do cliente selecionado
        });
    });

    function loadClients() {
        // Substitua 'fetch-clients.php' pelo seu endpoint real
        $.get('fetch-clients.php', function(data) {
            $('#clientList').html(data);
            $('#clientList li').click(function() {
                selectedClient = $(this).attr('data-client-id');
                loadMessages(selectedClient);
            });
        });
    }

    function loadMessages(clientId) {
        // Substitua 'fetch-messages.php?cliente_id=' pelo seu endpoint real
        $.get('fetch-clients.php?cliente_id=' + clientId, function(data) {
            $('#messagesContainer').html(data);
        });
    }

    // Função para verificar novas mensagens de todos os clientes
    function checkForNewMessages() {
        // Substitua 'fetch-new-messages.php' pelo seu endpoint real
        $.get('fetch-new-messages.php', function(data) {
            const newMessages = JSON.parse(data);
            newMessages.forEach(function(message) {
                // Atualiza a lista de clientes se houver novas mensagens
                loadClients();
            });
        });
    }

    // Verifica novas mensagens a cada 5 segundos
    setInterval(checkForNewMessages, 5000);
});