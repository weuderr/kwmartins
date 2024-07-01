<?php
    $pageTitle = "FAQ - ";
?>

<h5 class="mb-4">FAQ - Perguntas Frequentes</h5>
<div class="faq">
    <p class="faq-question">Que serviços oferecem?</p>
    <p class="faq-answer">Oferecemos uma gama variada de serviços estéticos, incluindo tratamentos faciais, depilação a laser, massagens terapêuticas e outros cuidados de beleza. Cada tratamento é personalizado para atender às necessidades específicas dos nossos clientes.</p>
</div>
<div class="faq">
    <p class="faq-question">Como posso marcar uma consulta?</p>
    <p class="faq-answer">Marcar uma consulta é simples! Pode contactar-nos através do nosso site, por telemóvel ou visitar o nosso espaço. A nossa equipa terá todo o gosto em ajudar a encontrar o horário que melhor se adapta à sua agenda.</p>
</div>
<div class="faq">
    <p class="faq-question">Quais são os horários de funcionamento?</p>
    <p class="faq-answer">O nosso horário de funcionamento é de terça-feira a sábado, das 9h às 17h. Encerramos aos domingos e feriados.</p>
</div>
<div class="faq">
    <p class="faq-question">Que métodos de pagamento aceitam?</p>
    <p class="faq-answer">Aceitamos pagamentos em dinheiro, transferências bancárias e pagamentos por aplicações móveis como MB Way.</p>
</div>
<div class="faq">
    <p class="faq-question">Os produtos utilizados são seguros?</p>
    <p class="faq-answer">Sim, todos os nossos produtos são testados e aprovados por entidades reguladoras. Utilizamos apenas produtos de alta qualidade e reconhecidos no mercado.</p>
</div>
<div class="faq">
    <p class="faq-question">Oferecem serviços para homens?</p>
    <p class="faq-answer">Sim, oferecemos diversos serviços estéticos para homens, incluindo tratamentos faciais e outos.</p>
</div>
<div class="faq">
    <p class="faq-question">Posso cancelar ou remarcar a minha consulta?</p>
    <p class="faq-answer">Sim, pode cancelar ou remarcar a sua consulta com pelo menos 24 horas de antecedência sem nenhum custo. Para cancelamentos de última hora, poderá haver uma taxa.</p>
</div>
<div class="faq">
    <p class="faq-question">Há estacionamento disponível?</p>
    <p class="faq-answer">Sim, temos estacionamento disponível para os nossos clientes nas proximidades do nosso espaço.</p>
</div>
<div class="faq">
    <p class="faq-question">Oferecem atendimento ao domicílio?</p>
    <p class="faq-answer">Atualmente, não oferecemos atendimento ao domicílio. Todos os nossos serviços são realizados no nosso espaço para garantir a melhor qualidade e segurança.</p>
</div>
<div class="faq">
    <p class="faq-question">Posso comprar produtos utilizados nos tratamentos?</p>
    <p class="faq-answer">Sim, temos uma loja no nosso espaço onde pode adquirir os produtos utilizados nos tratamentos, além de outros produtos de beleza e cuidados pessoais.</p>
</div>
<div class="faq">
    <p class="faq-question">Oferecem pacotes promocionais?</p>
    <p class="faq-answer">Sim, oferecemos pacotes promocionais e descontos especiais em determinados períodos do ano. Consulte a nossa equipa ou o nosso site para mais informações.</p>
</div>
<div class="faq">
    <p class="faq-question">Como posso entrar em contacto convosco?</p>
    <p class="faq-answer">Pode entrar em contacto connosco através do nosso site, por telemóvel, e-mail ou pelas nossas redes sociais. A nossa equipa está sempre pronta para o atender.</p>
</div>
<div class="faq">
    <p class="faq-question">Atendem sem marcação prévia?</p>
    <p class="faq-answer">Recomendamos que marque a sua consulta com antecedência para garantir o atendimento. No entanto, atendemos sem marcação prévia conforme a disponibilidade.</p>
</div>
<div class="faq">
    <p class="faq-question">Posso levar crianças para o espaço?</p>
    <p class="faq-answer">Para garantir um ambiente tranquilo e seguro para todos os clientes, sugerimos que evite trazer crianças para o espaço. No entanto, se necessário, entre em contacto connosco para discutir as opções.</p>
</div>
<div class="faq">
    <p class="faq-question">Qual é a duração média dos tratamentos?</p>
    <p class="faq-answer">A duração dos tratamentos varia conforme o tipo de serviço. Os nossos tratamentos faciais geralmente duram entre 30 e 90 minutos. Consulte a nossa equipa para mais detalhes sobre cada serviço.</p>
</div>
<div class="faq">
    <p class="faq-question">Oferecem consultas de avaliação gratuitas?</p>
    <p class="faq-answer">Sim, oferecemos consultas de avaliação gratuitas para entender melhor as suas necessidades e recomendar os melhores tratamentos para si.</p>
</div>
<div class="faq">
    <p class="faq-question">Os tratamentos são dolorosos?</p>
    <p class="faq-answer">A maioria dos nossos tratamentos é indolor ou causa apenas um leve desconforto. A nossa equipa está sempre disponível para garantir que se sinta confortável durante todo o processo.</p>
</div>
<div class="faq">
    <p class="faq-question">Utilizam tecnologias inovadoras?</p>
    <p class="faq-answer">Sim, estamos constantemente a atualizar os nossos métodos e equipamentos para incorporar as mais recentes tecnologias estéticas disponíveis no mercado.</p>
</div>
<div class="faq">
    <p class="faq-question">Têm algum programa de fidelidade?</p>
    <p class="faq-answer">Sim, oferecemos um programa de fidelidade com diversas vantagens para os nossos clientes frequentes. Consulte a nossa equipa para saber mais detalhes e como se inscrever.</p>
</div>
<div class="faq">
    <p class="faq-question">Posso oferecer um tratamento como presente?</p>
    <p class="faq-answer">Sim, oferecemos vales-presente que pode adquirir no nosso espaço ou pelo nosso site. É uma excelente opção de presente para quem ama.</p>
</div>





<script>
    document.querySelectorAll('.faq-question').forEach(item => {
        item.addEventListener('click', () => {
            const answer = item.nextElementSibling;
            answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
        });
    });
</script>