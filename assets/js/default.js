function Sleep(number) {
    return new Promise(resolve => setTimeout(resolve, number));
}

// eventos -> https://www.facebook.com/business/help/402791146561655?id=1205376682832142
$(document).ready(function() {
    let allServicos = [];
    let allCategories = [];
    let selectedService = {};

    function obterCategorias() {

        $.ajax({
            url: 'get-category.php',
            method: 'GET',
            success: function(response) {
                if(response.status === 'success') {
                    allCategories = response.categories; // Armazenar todas as categorias
                    const urlParams = new URLSearchParams(window.location.search);
                    const serviceStorage = urlParams.get('service');
                    allCategories.forEach(category => $('#serviceTypeFilter').append(`<option value="${category.id}" ${serviceStorage == category.name ? 'selected' : ''}>${category.name}</option>`));
                    updateServiceDisplay(allServicos);
                    filtraServicoSelecionado();
                }
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    $.ajax({
        url: 'get-services.php',
        method: 'GET',
        success: function(response) {
            if(response.status === 'success') {
                allServicos = response.services; // Armazenar todos os serviços
                obterCategorias();
            }
        },
        error: function(error) {
            console.error(error);
        }
    });

    // Evento de mudança para o filtro
    $('#serviceTypeFilter').change(function() {
        filtraServicoSelecionado();
    });

    function filtraServicoSelecionado() {
        const selectedType = $('#serviceTypeFilter').val();
        const filteredServicos = selectedType === 'all' ? allServicos : allServicos.filter(servico => servico.category_id == selectedType);
        updateServiceDisplay(filteredServicos);
    }

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
        if(!id && !name) {
            id = selectCategoria.val();
            name = selectCategoria.find('option:selected').text();
        } else {
            $('#appointmentModal').modal('show');
        }
        $('[name="message"]').val(name);
        $('#modalAppointmentName').text(name);
        const service = allServicos.filter(servico => servico.id == id);
        selectedService = service[0];

        fbq('track', 'ViewContent');
        // gtag('event', 'interest', {
        //     'event_category': 'appointment',
        //     'event_label': 'open',
        //     'value': selectedService?.price,
        // });
        // ttq.track('ViewContent', {
        //     "contents": [
        //         {
        //             "content_id": selectedService?.id, // string. ID of the product. Example: "1077218".
        //             "content_type": "Appointment", // string. Either product or product_group.
        //             "content_name": selectedService?.name, // string. The name of the page or product. Example: "shirt".
        //         }
        //     ],
        //     "value": selectedService?.price, // number. Value of the order or items sold. Example: 100.
        //     "currency": "EUR" // string. The 4217 currency code. Example: "USD".
        // });
    }

    function sendAppointment() {
        const name = $('#name').val();
        const phone = $('#phone').val();

        if (phone.length < 9) {
            alert('Número de telefone inválido');
            return;
        }

        if (name.length < 2) {
            alert('Nome inválido');
            return;
        }

        this.msgAgendamento += $('[name="message"]').val();
        const professionalPhone = $('[name="professional-phone"]').val();

        if (name || phone ) {
            const fullText = `Agendamento realizado pelo site. Nome: ${name}, Telefone: ${phone}`;
            const dataSend = {
                name: name,
                phone: phone,
                message: fullText,
                service_id: selectedService?.id,
                professionalPhone: professionalPhone,
                date: new Date().toISOString()
            };

            $.ajax({
                url: 'save-appointment.php',
                method: 'POST',
                data: dataSend,
                success: function(response) {
                    console.log(response);
                    if (response.status === 'success') {
                        console.log('Agendamento realizado com sucesso!');
                        alert('Agendamento realizado com sucesso! Aguarde o contato do profissional.');
                        // $('#appointmentModal').modal('hide');
                        $('#modalAgendamento').modal('hide');
                    }
                }
            });

            fbq('track', 'Lead');
            <!-- Event snippet for Visualização de página conversion page -->
            // gtag('event', 'conversion', {
            //     'send_to': 'AW-16557132820/UO70CNKcxq0ZEJSYh9c9',
            //     'value': selectedService?.price,
            //     'currency': 'EUR'
            // });

            ttq.track('Contact', {
                "contents": [
                    {
                        "content_id": selectedService?.id, // string. ID of the product. Example: "1077218".
                        "content_type": "Appointment", // string. Either product or product_group.
                        "content_name": selectedService?.name, // string. The name of the page or product. Example: "shirt".
                        "price": selectedService?.price
                    }
                ],
                "value": selectedService?.price, // number. Value of the order or items sold. Example: 100.
                "currency": "EUR" // string. The 4217 currency code. Example: "USD".
            });
        } else {
            alert('Preencha todos os campos!');
        }
    }

    window.sendAppointment = sendAppointment;
    window.openAppointment = openAppointment;

    function generateCardHTML(servico) {
        const type = allCategories.filter(category => category.id == servico.category_id);
        return `
                <div class="col-md-4">
                    <div class="card shadow-sm card-custom service-appointment" onclick="openAppointment('${servico.id}', '${servico.name}')">
                        <div class="card-header">${servico.name}</div>
                        <div class="card-body">
                            <h5 class="card-title">${type[0].name}</h5>
                            <p class="card-text">${servico.description}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button class="btn btn-principal float-right" >Agendar</button>
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
        $('.nav-item').removeClass('nav-active');
        if (sectionElement) {
            sectionElement.style.display = 'block';
            sectionElement.scrollIntoView({ behavior: 'smooth' });
            $(`#${section}`).parent().addClass('nav-active');
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





    let selectCategoria = $('#categoria');

    let selectServico = $('#servico');
    selectServico.html('');
    let opcao2 = $('<option></option>').attr('value', '').text('Selecione um serviço');
    selectServico.append(opcao2);

    let categorias = ['Alongamento de unhas', 'Estético', 'Manicure', 'Pedicure', 'Pestanas', 'Sobrancelhas'];
    fillCategorias();
    function fillCategorias() {
        selectCategoria.html('');
        selectCategoria.append($('<option></option>').attr('value', '').text('Selecione uma categoria'));
        for (let i = 0; i < categorias.length; i++) {
            let opcao = $('<option></option>').attr('value', categorias[i]).text(categorias[i]);
            selectCategoria.append(opcao);
        }
    }

    function showPromoModal() {
        const lastShown = localStorage.getItem('modalLastShown');

        if (!lastShown) {
            $('#modalAgendamento').modal('show');
            localStorage.setItem('modalLastShown', Date.now());
        } else {
            const diff = Date.now() - lastShown;

            if (diff >= 3600000) {
                $('#modalAgendamento').modal('show');
                localStorage.setItem('modalLastShown', Date.now());
            }
        }
    }

    // showPromoModal();

    selectCategoria.on('change', function() {
        selectServico.html('');
        let categoriaSelecionada = $(this).val();

        let opcao2 = $('<option></option>').attr('value', '').text('Selecione um serviço');
        selectServico.append(opcao2);

        $.ajax({
            url: 'get-services.php',
            method: 'POST',
            data: { categoria: categoriaSelecionada },
            success: function(response) {
                let services = response.services;
                for (let i = 0; i < services.length; i++) {
                    let opcao = $('<option></option>').attr('value', services[i].id).text(services[i].name);
                    selectServico.append(opcao);
                }
                // servico_div show
                $('#servico_div').show();
            }
        });
    });

    selectServico.on('change', function() {
        $('#nome_div').show();
        $('#telefone_div').show();
        $('#btnCancelAgendamento').hide();
    });

    $('#modalAgendamento').on('show.bs.modal', function() {
        fillCategorias();
        selectCategoria.prop('selectedIndex', 0);
        selectServico.html('');
        selectServico.prop('selectedIndex', 0);
        $('#name').val('');
        $('#phone').val('');
    });

    $('#modalAgendamento').on('shown.bs.modal', function() {
        selectCategoria.focus();
    });

    //if button agendar is clicked
    $('#btnAgendar').on('click', function() {
        selectedService.id = selectServico.val();
        const nameService = selectServico.find('option:selected').text();
        $('[name="message"]').val(nameService);
        if (!selectedService) {
            alert('Selecione um serviço');
            return;
        }
        sendAppointment();
    });

    $('#modalAgendamento').on('hidden.bs.modal', function() {
        $('#servico_div').hide();
        $('#nome_div').hide();
        $('#telefone_div').hide();
        $('#btnCancelAgendamento').show();
    });

});
