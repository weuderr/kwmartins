<div id="div-firebar" class="red-line" style="height: 34px; width: 100%; z-index: 1000; display: none;">
    <p id="msg-firebar" style="background-color: #F13776; padding: 5px; width: 100%; color: white; text-align: center; font-weight: bold;">
        Oferta única e exclusiva. Fim em: <span id="countdown"></span>
    </p>
    <span id="close" style="position: absolute; right: 10px; cursor: pointer; color: white; font-size: 20px;">&times;</span>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var firebar = document.getElementById('div-firebar');
        var close = document.getElementById('close');
        var countdown = document.getElementById('countdown');
        var valueCountdown = parseInt(localStorage.getItem('countdown') || 66);
        var promoActive = false;
        var timer;

        // Define function to start countdown
        function startCountdown() {
            timer = setInterval(function() {
                if (valueCountdown >= 0) {
                    var hours = Math.floor(valueCountdown / 3600);
                    var minutes = Math.floor((valueCountdown % 3600) / 60);
                    var seconds = valueCountdown % 60;
                    countdown.innerHTML = hours + 'h ' + minutes + 'm ' + seconds + 's';
                    localStorage.setItem('countdown', valueCountdown); // Save count in localStorage
                    valueCountdown--;
                    document.getElementById('promo-msg').style.display = 'block'
                } else {
                    clearInterval(timer);
                    firebar.style.display = 'none';
                    localStorage.removeItem('countdown');
                    if (promoActive) {
                        $('#modalAgendamento').modal('show');
                        localStorage.setItem('firebar', 'true');
                    }
                }
            }, 1000);
        }

        // Set up close button
        close.onclick = function() {
            firebar.style.display = 'none';
            clearInterval(timer);
        };

        // Check URL for promo term
        var url = window.location.href;
        var hasTerm = url.includes('?Trafego=') || url.includes('?gad_source=');
        var hasShown = localStorage.getItem('firebar') === 'true';
        promoActive = (hasTerm || localStorage.getItem('promoActive') === 'true') && !hasShown;

        if (promoActive) {
            firebar.style.display = 'block';
            localStorage.setItem('promoActive', 'true');
            startCountdown();
        }

        // Event listener for scroll to toggle fixed position
        window.addEventListener('scroll', function() {
            if (window.scrollY > 0) {
                firebar.style.position = 'fixed';
                firebar.style.top = '0';
                firebar.style.left = '0';
            } else {
                firebar.style.position = 'static';
            }
        });
    });
</script>
