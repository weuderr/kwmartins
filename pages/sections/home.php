    <div class="welcome-section mt-5">
        <h1 class="text-center">Bem-vindo à KW Martins</h1>
        <p>Aqui você pode encontrar informações sobre nossos serviços, produtos e muito mais. Não deixe de visitar nossas redes sociais e conferir as novidades.</p>
    </div>

    <div class="row mt-5" id="galeria">
        <div class="col-md-12">
            <h5 class="mb-4">Trabalhos</h5>
            <div class="row" onclick="window.location.href='servicos'">
                <div class="col-4 gallery-img"><img style="border-radius: 5px" src="../assets/img/galeria/kw-espaco%20(17).jpg" alt="Imagem da profissional da KW Martins"></div>
                <div class="col-4 gallery-img"><img style="border-radius: 5px" src="../assets/img/galeria/kw-espaco%20(16).jpg" alt="Imagem de um olhar feito na KW Martins"></div>
                <div class="col-4 gallery-img"><img style="border-radius: 5px" src="../assets/img/galeria/kw-espaco%20(14).jpg" alt="Imagem de unhas feitas na KW Martins"></div>
            </div>
        </div>
    </div>

    <div class="row mt-5" id="servicos">
        <div class="col-md-12">
            <h5 class="mb-2">Linhas de atuação</h5>
            <div class="row">
                <!-- Card de Alongamento de unhas -->
                <div class="col-md-4 mt-2">
                    <div class="card service-card p-2">
                        <h3 class="text-center">Alongamento de unhas</h3>
                        <p>Esta categoria inclui serviços que visam alongar as unhas. Os serviços nesta categoria geralmente levam de tempo variável e os preços variam.</p>
                        <footer class="mt-2 text-center">
                            <button class="btn btn-custom float-right">Confira os serviços</button>
                        </footer>
                    </div>
                </div>

                <!-- Card de Estetico -->
                <div class="col-md-4 mt-2">
                    <div class="card service-card p-2">
                        <h3 class="text-center">Estético</h3>
                        <p>Esta categoria inclui serviços estéticos. Os serviços nesta categoria geralmente levam de tempo variável e o preço é de valor variável.</p>
                        <footer class="mt-2 text-center">
                            <button class="btn btn-custom float-right">Confira os serviços</button>
                        </footer>
                    </div>
                </div>

                <!-- Card de Manicure -->
                <div class="col-md-4 mt-2">
                    <div class="card service-card p-2">
                        <h3 class="text-center">Manicure</h3>
                        <p>Esta categoria inclui serviços de cuidado e embelezamento das unhas das mãos. Os serviços nesta categoria geralmente levam de tempo variável e os preços variam.</p>
                        <footer class="mt-2 text-center">
                            <button class="btn btn-custom float-right">Confira os serviços</button>
                        </footer>
                    </div>
                </div>

                <!-- Card de Pedicure -->
                <div class="col-md-4 mt-2">
                    <div class="card service-card p-2">
                        <h3 class="text-center">Pedicure</h3>
                        <p>Esta categoria inclui serviços de cuidado e embelezamento das unhas dos pés. Os serviços nesta categoria geralmente levam de tempo variável e os preços variam.</p>
                        <footer class="mt-2 text-center">
                            <button class="btn btn-custom float-right">Confira os serviços</button>
                        </footer>
                    </div>
                </div>

                <!-- Card de Pestanas -->
                <div class="col-md-4 mt-2">
                    <div class="card service-card p-2">
                        <h3 class="text-center">Pestanas</h3>
                        <p>Esta categoria inclui serviços de extensão de pestanas. Os serviços nesta categoria geralmente levam de tempo variável e os preços variam.</p>
                        <footer class="mt-2 text-center">
                            <button class="btn btn-custom float-right">Confira os serviços</button>
                        </footer>
                    </div>
                </div>

                <!-- Card de Sobrancelhas -->
                <div class="col-md-4 mt-2">
                    <div class="card service-card p-2">
                        <h3 class="text-center">Sobrancelhas</h3>
                        <p>Esta categoria inclui serviços de design e embelezamento das sobrancelhas. Os serviços nesta categoria geralmente levam de tempo variável e os preços variam.</p>
                        <footer class="mt-2 text-center">
                            <button class="btn btn-custom float-right">Confira os serviços</button>
                        </footer>
                    </div>
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
</script>