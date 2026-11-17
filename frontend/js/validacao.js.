/**
 * validacao.js
 * Máscara de WhatsApp em tempo real + validações do formulário de agendamento.
 * Inclusão: <script src="js/validacao.js" defer></script>
 */
(function () {
  'use strict';

  var formulario = document.getElementById('appointment-form');
  var campoTelefone = document.getElementById('patient-phone');

  if (!formulario) return;

  /* ---------- Estilo mínimo (arquivo independente, sem depender de CSS externo) ---------- */
  var estilo = document.createElement('style');
  estilo.textContent =
    '.campo-invalido{border:2px solid #d93025 !important;outline-color:#d93025;}' +
    '.mensagem-erro{display:block;color:#d93025;font-size:0.85rem;margin-top:4px;}';
  document.head.appendChild(estilo);

  /* ---------- 1) Máscara de WhatsApp: (XX) XXXXX-XXXX ---------- */
  function formatarTelefone(valor) {
    var d = valor.replace(/\D/g, '').slice(0, 11); // bloqueia letras e limita a 11 dígitos

    if (d.length === 0) return '';
    if (d.length <= 2) return '(' + d;
    if (d.length <= 7) return '(' + d.slice(0, 2) + ') ' + d.slice(2);
    return '(' + d.slice(0, 2) + ') ' + d.slice(2, 7) + '-' + d.slice(7);
  }

  if (campoTelefone) {
    campoTelefone.setAttribute('inputmode', 'numeric');
    campoTelefone.setAttribute('maxlength', '15');

    campoTelefone.addEventListener('input', function () {
      campoTelefone.value = formatarTelefone(campoTelefone.value);
    });
  }

  /* ---------- Helpers de feedback visual ---------- */
  function mostrarErro(campo, mensagem) {
    limparErro(campo);
    campo.classList.add('campo-invalido');
    campo.setAttribute('aria-invalid', 'true');

    var aviso = document.createElement('span');
    aviso.className = 'mensagem-erro';
    aviso.setAttribute('role', 'alert');
    aviso.textContent = mensagem;
    campo.insertAdjacentElement('afterend', aviso);
  }

  function limparErro(campo) {
    campo.classList.remove('campo-invalido');
    campo.removeAttribute('aria-invalid');

    var proximo = campo.nextElementSibling;
    if (proximo && proximo.classList.contains('mensagem-erro')) {
      proximo.remove();
    }
  }

  /* ---------- Regras de validação ---------- */
  var REGEX_EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

  function hojeISO() {
    var h = new Date();
    var mes = String(h.getMonth() + 1).padStart(2, '0');
    var dia = String(h.getDate()).padStart(2, '0');
    return h.getFullYear() + '-' + mes + '-' + dia; // data local, não UTC
  }

  function ehCampoDeEmail(campo) {
    return campo.type === 'email' || /email/i.test(campo.id || campo.name || '');
  }

  function ehCampoDeData(campo) {
    return campo.type === 'date' || campo.type === 'datetime-local';
  }

  function validarFormulario() {
    var valido = true;
    var primeiroInvalido = null;

    function falhar(campo, mensagem) {
      mostrarErro(campo, mensagem);
      valido = false;
      if (!primeiroInvalido) primeiroInvalido = campo;
    }

    var campos = formulario.querySelectorAll('input, select, textarea');

    campos.forEach(function (campo) {
      if (campo.type === 'submit' || campo.type === 'button' || campo.type === 'hidden') return;

      limparErro(campo);
      var valor = (campo.value || '').trim();

      // Validação 1: obrigatórios
      if (campo.required && valor === '') {
        falhar(campo, 'Este campo é obrigatório.');
        return;
      }

      if (valor === '') return; // opcional e vazio: nada a validar

      // Telefone completo
      if (campo === campoTelefone && valor.replace(/\D/g, '').length < 11) {
        falhar(campo, 'Informe o WhatsApp completo: (XX) XXXXX-XXXX.');
        return;
      }

      // Validação 2: e-mail
      if (ehCampoDeEmail(campo) && !REGEX_EMAIL.test(valor)) {
        falhar(campo, 'Informe um e-mail válido (ex.: nome@dominio.com).');
        return;
      }

      // Validação 3: data não pode ser passada
      if (ehCampoDeData(campo) && valor.slice(0, 10) < hojeISO()) {
        falhar(campo, 'A data da consulta não pode ser anterior a hoje.');
        return;
      }
    });

    if (primeiroInvalido) primeiroInvalido.focus();
    return valido;
  }

  /* ---------- Limpa o erro assim que o usuário corrige o campo ---------- */
  formulario.addEventListener('input', function (e) {
    if (e.target.classList && e.target.classList.contains('campo-invalido')) {
      limparErro(e.target);
    }
  });
  formulario.addEventListener('change', function (e) {
    if (e.target.classList && e.target.classList.contains('campo-invalido')) {
      limparErro(e.target);
    }
  });

  /* ---------- Submit ---------- */
  formulario.setAttribute('novalidate', 'novalidate'); // usamos nossas próprias mensagens

  formulario.addEventListener('submit', function (event) {
    event.preventDefault();

    if (!validarFormulario()) return;

    formulario.submit(); // não dispara o evento "submit" novamente, então não há loop
  });
})();