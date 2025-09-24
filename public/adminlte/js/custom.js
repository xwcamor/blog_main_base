// ===============================
// Función: Cambia el avatar en login según focus
// ===============================
function initLoginAvatar() {
  const avatar = document.getElementById('login-avatar');
  if (!avatar) return;

  const defaultImg = avatar.dataset.default;
  const emailImg   = avatar.dataset.email;
  const passImg    = avatar.dataset.pass;

  const emailInput = document.querySelector('input[name="email"]');
  const passInput  = document.querySelector('input[name="password"]');

  if (emailInput) {
    emailInput.addEventListener('focus', () => avatar.src = emailImg);
    emailInput.addEventListener('blur',  () => avatar.src = defaultImg);
  }

  if (passInput) {
    passInput.addEventListener('focus', () => avatar.src = passImg);
    passInput.addEventListener('blur',  () => avatar.src = defaultImg);
  }
}


// ===============================
// Función: agrega títulos a labels, botones e inputs
// ===============================
function addTitles() {
  const selectors = [
    'label',
    'button',
    'a.btn',
    'input[type="submit"]',
    'input[type="button"]',
    'input[type="reset"]'
  ];

  document.querySelectorAll(selectors.join(',')).forEach(function (el) {
    if (el.hasAttribute('title') || el.hasAttribute('aria-hidden')) return;

    let text = '';

    if (el.tagName === 'INPUT') {
      text = el.value ? el.value.trim() : '';
    } else {
      text = el.textContent ? el.textContent.trim() : '';
    }

    text = text.replace(/\s+/g, ' '); // limpiar espacios múltiples

    if (text.length > 0) {
      el.setAttribute('title', text);
    }
  });
}
 
 
// ===============================
// Inicializador principal
// ===============================
function initCustomScripts() {
  initLoginAvatar();  
  addTitles();
 
}

// ===============================
// Ejecutar al cargar DOM
// ===============================
document.addEventListener('DOMContentLoaded', initCustomScripts);