$(document).ready(function() {
    let allServicos = []; // Para armazenar todos os serviços

    // Carregar serviços e preencher o filtro
    $.getJSON('servicos.json', function(servicos) {
        allServicos = servicos; // Armazenar todos os serviços
        const tipos = new Set(servicos.map(servico => servico.Tipo)); // Extrair tipos únicos
        tipos.forEach(tipo => $('#serviceTypeFilter').append(`<option value="${tipo}">${tipo}</option>`)); // Preencher filtro
        updateServiceDisplay(servicos); // Exibir todos os serviços inicialmente
    });

    // Evento de mudança para o filtro
    $('#serviceTypeFilter').change(function() {
        const selectedType = $(this).val();
        const filteredServicos = selectedType === 'all' ? allServicos : allServicos.filter(servico => servico.Tipo === selectedType);
        updateServiceDisplay(filteredServicos); // Atualizar exibição com serviços filtrados
    });

    // Função para atualizar a exibição dos serviços
    function updateServiceDisplay(servicos) {
        const container = $('#servicosContainer');
        container.empty(); // Limpar exibição atual
        servicos.forEach((servico) => {
            const cardHTML = generateCardHTML(servico);
            container.append(cardHTML);
        });
    }

    function openAppointment(msg, phone) {
        // show a confirmation message
        if (confirm('Deseja agendar um horário para ' + msg + '?' + '\n\nClique em OK para abrir o WhatsApp.')) {
            const fullText = 'Gostaria de agendar um horário: ' + msg + '.';
            window.open('https://api.whatsapp.com/send?phone='+phone+'&text=' + encodeURIComponent(fullText));
        }
    }

    window.openAppointment = openAppointment;

    function generateCardHTML(servico) {
        return `
                <div class="col-md-4">
                    <div class="card shadow-sm card-custom">
                        <div class="card-header">${servico.Serviço}</div>
                        <div class="card-body">
                            <h5 class="card-title">${servico.Tipo}</h5>
                            <p class="card-text">${servico.Descrição}</p>
                            <p class="card-text"><strong>Detalhes:</strong> ${servico.Detalhes}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <div class="d-block">
                                <p class="card-text ml-1"><strong>Tempo:</strong> ${servico["Tempo (min)"]} (min)</p>
                                <p class="card-text ml-1"><strong>Preço:</strong> ${servico.Preço}</p>
                            </div>
                            <button class="btn btn-custom float-right" onclick="openAppointment('${servico.Serviço}','${servico.Telefone}')">Agendar</button>
                        </div>
                    </div>
                </div>
               `;
    }

    const sections = ['quem-somos', 'missao', 'servicos', 'galeria', 'depoimentos', 'faq', 'contato'];
    const sectionsinit = ['servicos', 'galeria', 'depoimentos', 'faq', 'contato'];
    function init() {
        // verificar se a url tem um hash
        if (window.location.hash) {
            hideItems(sections);
            const section = window.location.hash.replace('#', '');
            selecionarSection(section);
        } else {
            hideItems(sectionsinit);
        }
    }

    function hideItems(values) {
        values.forEach(section => {
            const sectionElement = document.getElementById(section);
            if (sectionElement) {
                sectionElement.style.display = 'none';
            }
        });
    }

    function selecionarSection(section) {
        const sectionElement = document.getElementById(section);
        $('.nav-item').removeClass('active');
        if (sectionElement) {
            sectionElement.style.display = 'block';
            sectionElement.scrollIntoView({ behavior: 'smooth' });
            $(`.nav-item a[href="#${section}"]`).parent().addClass('active');
        }
    }

    $('.nav-item').click(function() {
        hideItems(sections);
        const section = $(this).find('a').attr('href').replace('#', '');
        selecionarSection(section);
    });

    // if scroller need to down the navigation bar position: fixed; bottom: 0; width: 100%;
    window.onscroll = function() {scrollFunction()};
    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("navigation-bar").style.position = "fixed";
            // document.getElementById("navigation-bar").style.animation = "slide-down 0.5s ease-in-out";
        } else {
            document.getElementById("navigation-bar").style.position = "relative";
        }
    }

    $('html').click(function() {
        if ($('#navbarNav').hasClass('show')) {
            setTimeout(function() {
                $('#navbarNav').removeClass('show');
                $('#navbarNav').prev().attr('aria-expanded', 'false');
            }, 100);
        }
    });

    init();

});
