!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1133221804700004');
// eventos -> https://www.facebook.com/business/help/402791146561655?id=1205376682832142
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
        fbq('track', 'ViewContent');
        $('[name="professional-phone"]').val(phone);
        $('[name="message"]').val(msg);

        $('#appointmentModal').modal('show');
    }

    function sendAppointment() {
        const name = $('#name').val();
        const phone = $('#phone').val();
        const msg = $('[name="message"]').val();
        const professionalPhone = $('[name="professional-phone"]').val();

        console.log(name, phone);
        if (name || phone ) {
            $.ajax({
                url: 'save-appointment.php',
                method: 'POST',
                data: {
                    name: name,
                    phone: phone,
                    message: msg,
                    professionalPhone: professionalPhone,
                    date: new Date().toISOString()
                },
                success: function(response) {
                    console.log(response);
                }
            });
            const fullText = `Olá, meu nome é ${name}. \nEstou entrando em contato para agendar um horário. \nPor favor, poderia me informar os horários disponíveis para ${msg}? Muito obrigado(a) pela atenção.`;
            window.open('https://api.whatsapp.com/send?phone=' + professionalPhone + '&text=' + encodeURIComponent(fullText));
            // Ssend fbq track enviar solicitação
            fbq('track', 'Lead');

            $('#appointmentModal').modal('hide');
        } else {
            alert('Preencha todos os campos!');
        }
    }

    window.sendAppointment = sendAppointment;
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
                            <button class="btn btn-custom float-right" onclick="openAppointment('${servico.Serviço}', '${servico.Telefone}')">Agendar</button>
                        </div>
                    </div>
                </div>
               `;
    }

    function init() {
        selecionarSection();
        generateMetaDescription();
    }


    function selecionarSection() {
        const section = window.location.pathname.split('/').pop().split('.').shift();
        console.log(section);
        const sectionElement = document.getElementById(section);
        $('.nav-item').removeClass('active');
        if (sectionElement) {
            sectionElement.style.display = 'block';
            sectionElement.scrollIntoView({ behavior: 'smooth' });
            $(`#${section}`).parent().addClass('active');
        }
    }

    // $('.nav-item').click(function() {
    //     selecionarSection();
    // });

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

    function generateMetaDescription() {
        let containerContent = document.querySelector('.conteudo')?.innerText;

        if (!containerContent || containerContent.trim().length === 0) {
            return;
        }

        let trimmedContent = containerContent.trim().replace(/\s+/g, ' '); // Remove espaços em branco extras

        const maxLength = 160;
        let metaDescription = trimmedContent.substring(0, maxLength);

        const lastSpace = metaDescription.lastIndexOf(' ');
        if (lastSpace !== -1) {
            metaDescription = metaDescription.substring(0, lastSpace);
        }

        if (metaDescription.length < trimmedContent.length) {
            metaDescription += '...';
        }

        const metaDescriptionTag = document.querySelector('meta[name="description"]');
        if (metaDescriptionTag) {
            metaDescriptionTag.setAttribute('content', metaDescription);
        } else {
            const newMetaTag = document.createElement('meta');
            newMetaTag.setAttribute('name', 'description');
            newMetaTag.setAttribute('content', metaDescription);
            document.head.appendChild(newMetaTag);
        }
        console.log(metaDescription);
    }
});
