document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('loading-icon').style.display = 'none';
    document.getElementById('main-content').style.display = 'block';
});

document.getElementById('accept-gdpr').addEventListener('click', function() {
    localStorage.setItem('gdpr-consent', 'true');
    document.getElementById('gdpr-consent-container').style.display = 'none';
});

if (localStorage.getItem('gdpr-consent') === 'true') {
    document.getElementById('gdpr-consent-container').style.display = 'none';
}