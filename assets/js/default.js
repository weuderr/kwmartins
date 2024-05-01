!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1133221804700004');

function Sleep(number) {
    return new Promise(resolve => setTimeout(resolve, number));
}

// eventos -> https://www.facebook.com/business/help/402791146561655?id=1205376682832142
$(document).ready(function() {
    let allServicos = [];
    let allCategories = [];
    let appointmentServiceId = null;

    $.ajax({
        url: 'get-category.php',
        method: 'GET',
        success: function(response) {
            if(response.status === 'success') {
                allCategories = response.categories; // Armazenar todas as categorias
                allCategories.forEach(category => $('#serviceTypeFilter').append(`<option value="${category.id}">${category.name}</option>`)); // Preencher filtro
            }
        },
        error: function(error) {
            console.error(error);
        }
    });

    $.ajax({
        url: 'get-services.php',
        method: 'GET',
        success: function(response) {
            if(response.status === 'success') {
                allServicos = response.services; // Armazenar todos os serviços
                Sleep(1000).then(r => {
                    console.log(allServicos);
                    updateServiceDisplay(allServicos); // Exibir todos os serviços inicialmente
                });
            }
        },
        error: function(error) {
            console.error(error);
        }
    });

    // Evento de mudança para o filtro
    $('#serviceTypeFilter').change(function() {
        const selectedType = $(this).val();
        const filteredServicos = selectedType === 'all' ? allServicos : allServicos.filter(servico => servico.category_id == selectedType);
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

    function openAppointment(id, name) {
        appointmentServiceId = id;
        fbq('track', 'ViewContent');
        $('[name="message"]').val(name);
        $('#modalAppointmentName').text(name);

        $('#appointmentModal').modal('show');
    }

    function sendAppointment() {
        const name = $('#name').val();
        const phone = $('#phone').val();
        const msg = $('[name="message"]').val();
        const professionalPhone = $('[name="professional-phone"]').val();
        console.log(name, phone);
        if (name || phone ) {
            const fullText = `Olá, meu nome é ${name}. \nEstou entrando em contato para agendar um horário. \nPor favor, poderia me informar os horários disponíveis para ${msg}? Muito obrigado(a) pela atenção.`;
            $.ajax({
                url: 'save-appointment.php',
                method: 'POST',
                data: {
                    name: name,
                    phone: phone,
                    message: fullText,
                    service_id: appointmentServiceId,
                    professionalPhone: professionalPhone,
                    date: new Date().toISOString()
                },
                success: function(response) {
                    console.log(response);
                }
            });
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
        const type = allCategories.filter(category => category.id === servico.category_id);
        return `
                <div class="col-md-4">
                    <div class="card shadow-sm card-custom">
                        <div class="card-header">${servico.name}</div>
                        <div class="card-body">
                            <h5 class="card-title">${type[0].name}</h5>
                            <p class="card-text">${servico.description}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button class="btn btn-custom float-right" onclick="openAppointment('${servico.id}', '${servico.name}')">Agendar</button>
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
