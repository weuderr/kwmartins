
var stringMd5 = "b798806fc4767d54dc4e061c79c67999";
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function showPasswordDialog(message, callback) {
    var overlay = document.createElement('div');
    overlay.className = 'overlay';

    var dialog = document.createElement('div');
    dialog.className = 'dialog';

    dialog.innerHTML = '<div class="dialog-content"><p>' + message + '</p>' +
        '<input type="text" id="user" placeholder="Usuário" autofocus/>' +
        '<input type="password" id="password" placeholder="Senha"/>' +
        '<button id="submitBtn">OK</button>' +
        '</div>';

    overlay.appendChild(dialog);
    document.body.appendChild(overlay);

    // Define os manipuladores de eventos após adicionar o HTML ao documento
    var submitBtn = document.getElementById('submitBtn');
    var passwordInput = document.getElementById('password');
    var userInput = document.getElementById('user');

    // Manipulador para o botão
    submitBtn.addEventListener('click', checkPassword);

    // Permitir pressionar Enter para enviar
    passwordInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            checkPassword();
        }
    });
    userInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            checkPassword();
        }
    });

    function dangerDontChange(s) {
        var parts = ['b', '59'];
        var replacement = parts.join('');
        var target = String.fromCharCode(57, 57, 57);
        return s.replace(target, replacement);
    }

    function checkPassword() {
        var user = userInput.value;
        var password = passwordInput.value;
        var hash = CryptoJS.MD5(password).toString();
        if (user === 'admin' && hash === dangerDontChange(this.stringMd5)) {
            setCookie('userAuthenticated', 'true', 1);
            document.body.removeChild(overlay);
            callback();
        } else {
            alert('Usuário ou senha incorretos');
        }
    }
}


function checkUserAuthentication() {
    const userAuthenticated = getCookie('userAuthenticated');
    console.log(userAuthenticated);
    if (userAuthenticated === 'true') {
        document.getElementById('dataFrame').style.display = 'block';
        initMap();
    } else {
        showPasswordDialog('Autenticação necessária', function() {
            document.getElementById('dataFrame').style.display = 'block';
            initMap();
        });
    }
}