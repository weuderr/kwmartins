<?php
    $pageTitle = "Home - ";
?>

        <!-- Seção de Boas-vindas -->
        <div class="welcome-section mt-5 text-center">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-black break-words mb-4">Bem-vindo à KW-Martins - Beleza e Estética</h1>
            <p class="text-base md:text-lg lg:text-xl max-w-3xl mx-auto text-center">
              Na KW Martins Beleza e Estética, oferecemos uma ampla gama de serviços para realçar sua beleza e bem-estar. Nossa equipe de especialistas é dedicada a proporcionar cuidados excepcionais em designer de sobrancelhas, extensão de pestanas, micropigmentação e muito mais. Com um enfoque detalhado em estética e manicure, garantimos resultados surpreendentes que elevam sua autoestima e destacam sua beleza natural. Venha experimentar nossos serviços e descubra como podemos transformar sua aparência com técnicas avançadas e um atendimento personalizado.
            </p>
        </div>


        <!-- Seção de Trabalhos -->
        <div class="trabalhos mt-5" id="galeria">
            <div class="col-md-12">
                <h2 class="text-center">Nossos Trabalhos</h2>
                <div class="galeria-trabalhos d-flex flex-wrap justify-content-center">
                    <div class="trabalho p-2">
                        <div class="gallery-img">
                            <img style="border-radius: 5px" src="../assets/img/galeria/kw-espaco%20(18).jpeg" alt="Imagem de unhas feitas na KW Martins">
                        </div>
                        <p>Experimente a elegância do alongamento de unhas na KW Martins. Nossas unhas são o toque perfeito de glamour para qualquer ocasião.</p>
                    </div>
                    <div class="trabalho p-2">
                        <div class="gallery-img">
                            <img style="border-radius: 5px" src="../assets/img/galeria/kw-espaco%20(17).jpg" alt="Imagem da profissional da KW Martins">
                        </div>
                        <p>Nossas talentosas profissionais orgulhosamente exibem sua certificação de excelência em beleza. Venha descobrir os serviços de alta qualidade que só a KW Martins pode oferecer!</p>
                    </div>
                    <div class="trabalho p-2">
                        <div class="gallery-img">
                            <img style="border-radius: 5px" src="../assets/img/galeria/kw-espaco%20(16).jpg" alt="Imagem de um olhar feito na KW Martins">
                        </div>
                        <p>Realce a beleza dos seus olhos com nossas extensões de cílios! Veja como nossos especialistas podem transformar seu olhar, proporcionando um visual deslumbrante e natural.</p>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button class="btn btn-principal m-1" onclick="window.location.href = 'galeria'">Ver mais</button>
                    <button class="btn btn-action m-1" data-toggle="modal" data-target="#modalAgendamento">Agende seu horário</button>
                </div>
            </div>
        </div>

        <!-- Informações de Contato -->
        <div class="container mt-5">
            <h2 class="text-3xl md:text-5xl lg:text-6xl font-black break-words mb-4" style="text-align: center;">Informações</h2>
            <div class="row">
                <div class="col-md-6 contact-info p-3">
                    <div class="info-section">
                        <i class="fas fa-map-marker-alt"></i>
                        <span style="font-weight: bold;">Endereço</span>
                        <div style="margin-left: 30px;">
                            <span class="d-block">Rua António Carneiro 147 - Matosinhos, PT 4450-047</span>
                        </div>
                    </div>
                    <div class="info-section mt-3">
                        <i class="fas fa-clock"></i>
                        <span style="font-weight: bold;">Horário de Funcionamento</span>
                        <div style="margin-left: 30px;">
                            <div class="d-block"><span style="font-weight: bold;">Terça-feira: </span><span>09:00 - 17:00</span></div>
                            <div class="d-block"><span style="font-weight: bold;">Quarta-feira: </span><span>09:00 - 17:00</span></div>
                            <div class="d-block"><span style="font-weight: bold;">Quinta-feira: </span><span>09:00 - 17:00</span></div>
                            <div class="d-block"><span style="font-weight: bold;">Sexta-feira: </span><span>09:00 - 17:00</span></div>
                            <div class="d-block"><span style="font-weight: bold;">Sábado: </span><span>09:00 - 17:00</span></div>
                        </div>
                    </div>
                    <div class="info-section mt-3 mb-5">
                        <i class="fas fa-phone"></i>
                        <span style="font-weight: bold;">Número de telefone</span>
                        <div style="margin-left: 30px;">
                            <a href="tel:+351939000856" class="">+351 939 000 856</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="map" class="shadow-lg border-0 border-gray-100 rounded-lg" style="height: 400px;"></div>
                </div>
            </div>
        </div>
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

        <a class="nav-link btn whatsapp-button"
            href="https://api.whatsapp.com/send?phone=351939000856&text=Ol%C3%A1%20gostaria%20de%20fazer%20um%20agendamento" target="_blank">
            <span style="color: #25d366; font-weight: bold;">Atendimento</span>
            <i class="fab fa-lg fa-whatsapp" style="color: #25d366; margin-left: 10px;"></i>
        </a>



        <!-- Seção de Depoimentos -->
        <div class="row mt-5" id="depoimentos">
            <div class="col-md-12 text-center">
                <h2 class="mb-4">Depoimentos</h2>
                <div id="depoimentosCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="d-flex flex-column align-items-center">
                                <img src="../assets/img/clientes/cliente (1).png" class="rounded-circle mb-3" alt="Depoimento de cliente 1" style="width: 75px; height: 75px;">
                                <p class="w-75">Maria S.</p>
                                <p class="w-95">Adorei o atendimento e o resultado final! Minhas unhas nunca estiveram tão bonitas!</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex flex-column align-items-center">
                                <img src="../assets/img/clientes/cliente (2).png" class="rounded-circle mb-3" alt="Depoimento de cliente 2" style="width: 75px; height: 75px;">
                                <p class="w-75">Felipa R.</p>
                                <p class="w-95">Serviço de alta qualidade e profissionais muito competentes. Recomendo!</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex flex-column align-items-center">
                                <img src="../assets/img/clientes/cliente (3).png" class="rounded-circle mb-3" alt="Depoimento de cliente 3" style="width: 75px; height: 75px;">
                                <p class="w-75">Ana P.</p>
                                <p class="w-95">Extensão de cílios perfeita! O ambiente é super acolhedor e confortável.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex flex-column align-items-center">
                                <img src="../assets/img/clientes/cliente (4).png" class="rounded-circle mb-3" alt="Depoimento de cliente 4" style="width: 75px; height: 75px;">
                                <p class="w-75">Joana M.</p>
                                <p class="w-95">Fiz um design de sobrancelhas e amei o resultado! Voltarei com certeza.</p>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#depoimentosCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#depoimentosCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Próximo</span>
                    </a>
                </div>
            </div>
        </div>


        <!-- Seção de Serviços -->
        <div class="row mt-5" id="servicos">
            <div class="col-md-12">
                <h2 class="text-center mb-4">Nossos Serviços</h2>
                <div class="row">
                    <!-- Card de Alongamento de unhas -->
                    <div class="col-md-4 mt-2">
                        <div class="card service-card p-3">
                            <h3 class="text-center">Alongamento de unhas</h3>
                            <p>Esta categoria inclui serviços que visam alongar as unhas. Os serviços nesta categoria geralmente levam de tempo variável e os preços variam.</p>
                            <footer class="text-center">
                                <button class="btn btn-secondary">Confira os serviços</button>
                            </footer>
                        </div>
                    </div>
                    <!-- Card de Estetico -->
                    <div class="col-md-4 mt-2">
                        <div class="card service-card p-3">
                            <h3 class="text-center">Estético</h3>
                            <p>Esta categoria inclui serviços estéticos. Os serviços nesta categoria geralmente levam de tempo variável e o preço é de valor variável.</p>
                            <footer class="text-center">
                                <button class="btn btn-secondary">Confira os serviços</button>
                            </footer>
                        </div>
                    </div>
                    <!-- Card de Manicure -->
                    <div class="col-md-4 mt-2">
                        <div class="card service-card p-3">
                            <h3 class="text-center">Manicure</h3>
                            <p>Esta categoria inclui serviços de cuidado e embelezamento das unhas das mãos. Os serviços nesta categoria geralmente levam de tempo variável e os preços variam.</p>
                            <footer class="text-center">
                                <button class="btn btn-secondary">Confira os serviços</button>
                            </footer>
                        </div>
                    </div>
                    <!-- Card de Pedicure -->
                    <div class="col-md-4 mt-2">
                        <div class="card service-card p-3">
                            <h3 class="text-center">Pedicure</h3>
                            <p>Esta categoria inclui serviços de cuidado e embelezamento das unhas dos pés. Os serviços nesta categoria geralmente levam de tempo variável e os preços variam.</p>
                            <footer class="text-center">
                                <button class="btn btn-secondary">Confira os serviços</button>
                            </footer>
                        </div>
                    </div>
                    <!-- Card de Pestanas -->
                    <div class="col-md-4 mt-2">
                        <div class="card service-card p-3">
                            <h3 class="text-center">Pestanas</h3>
                            <p>Esta categoria inclui serviços de extensão de pestanas. Os serviços nesta categoria geralmente levam de tempo variável e os preços variam.</p>
                            <footer class="text-center">
                                <button class="btn btn-secondary">Confira os serviços</button>
                            </footer>
                        </div>
                    </div>
                    <!-- Card de Sobrancelhas -->
                    <div class="col-md-4 mt-2">
                        <div class="card service-card p-3">
                            <h3 class="text-center">Sobrancelhas</h3>
                            <p>Esta categoria inclui serviços de design e embelezamento das sobrancelhas. Os serviços nesta categoria geralmente levam de tempo variável e os preços variam.</p>
                            <footer class="text-center">
                                <button class="btn btn-secondary">Confira os serviços</button>
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    <!-- Modal transparecen 95 -->
    <div class="modal fade" id="modalAgendamento" tabindex="-1" role="dialog" aria-labelledby="modalAgendamentoLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.50);">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgendamentoLabel">Pre-agendamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border-radius: 5px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="promo-msg" style="display: none;">
                    <div class="red-line">
                        <p style="background-color: #F13776; padding: 5px; width: 100%; color: white; text-align: center; font-weight: bold;">
                            Primeira manutenção grátis!
                        </p>
                    </div>
                    <p style="text-align: center; padding: 5px; color: #717171;font-size: 12px;">
                        Oferta única e exclusiva de campanha. Não perca!
                    </p>
                </div>
                <div class="modal-body">
                    <form>
                        <div id="categoria_div" class="form-group">
                            <label for="categoria">Categoria</label>
                            <select class="form-control" id="categoria">
                                <!-- Opções de categoria aqui -->
                            </select>
                        </div>
                        <div id="servico_div" class="form-group" style="display: none;">
                            <label for="servico">Serviço</label>
                            <select class="form-control" id="servico">
                                <!-- Opções de serviço aqui -->
                            </select>
                        </div>
                        <div id="nome_div" class="form-group" style="display: none;">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" placeholder="Seu nome">
                        </div>
                        <div id="telefone_div" class="form-group" style="display: none;">
                            <label for="phone">Telefone</label>
                            <input type="tel" class="form-control" id="phone" placeholder="Seu telefone">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnCancelAgendamento" type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button id="btnAgendar" type="button" class="btn btn-primary">Agendar</button>
                </div>
            </div>
        </div>
    </div>

<script>
    const serviceCards = document.querySelectorAll('.service-card');

    serviceCards.forEach(card => {
        card.addEventListener('click', () => {
            window.location.href = 'servicos?service=' + encodeURIComponent(card.querySelector('h3').innerText);
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
        if (document.getElementById('promo-msg').style.display === 'block') {
            $('#modalAgendamento').on('hide.bs.modal', function (e) {
                if (confirm('Não será possível abrir o modal novamente. Deseja continuar?')) {
                    $('#modalAgendamento').modal('hide');
                }
            });
        }
        }, 2000);
    });
</script>