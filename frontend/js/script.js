// ===========================================================================
// SixStar Clinic — Comportamento da página (frontend/js/script.js)
// Aula 06 · Primeiros passos em JavaScript
// ===========================================================================

// Passo 1: conferindo se o script.js foi carregado pelo navegador com defer
console.log("O script.js está ligado.");

// Passo 2: rolagem suave para as âncoras (#home, #agendamento...)
// Feita em JS para funcionar em qualquer navegador e descontar a altura
// do cabeçalho fixo, assim o título da seção não fica escondido.
(function () {
  const header = document.getElementById("header");
  const DURACAO = 700; // ms

  function alturaHeader() {
    return header ? header.offsetHeight : 0;
  }

  // Curva de aceleração suave (easeInOutCubic)
  function ease(t) {
    return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
  }

  function rolarPara(destinoY) {
    const inicioY = window.scrollY;
    const distancia = destinoY - inicioY;
    let inicio = null;

    function passo(tempo) {
      if (inicio === null) inicio = tempo;
      const progresso = Math.min((tempo - inicio) / DURACAO, 1);
      // "instant" evita conflito com o scroll-behavior: smooth do CSS
      window.scrollTo({ top: inicioY + distancia * ease(progresso), behavior: "instant" });
      if (progresso < 1) requestAnimationFrame(passo);
    }

    requestAnimationFrame(passo);
  }

  document.addEventListener("click", function (e) {
    const link = e.target.closest('a[href^="#"]');
    if (!link) return;

    const id = link.getAttribute("href");

    // Link "#" (logo) volta para o topo
    if (id === "#") {
      e.preventDefault();
      rolarPara(0);
      history.replaceState(null, "", " ");
      return;
    }

    const alvo = document.querySelector(id);
    if (!alvo) return;

    e.preventDefault();
    const destino = alvo.getBoundingClientRect().top + window.scrollY - alturaHeader() - 12;
    rolarPara(Math.max(destino, 0));
    history.replaceState(null, "", id);
  });

  // Passo 3: destaca no menu a seção que está na tela
  const navLinks = document.querySelectorAll(".main-nav .nav-link");
  const secoes = Array.from(navLinks)
    .map(function (link) { return document.querySelector(link.getAttribute("href")); })
    .filter(Boolean);

  function atualizarMenuAtivo() {
    const posicao = window.scrollY + alturaHeader() + 40;
    let atual = secoes[0];

    secoes.forEach(function (secao) {
      if (secao.offsetTop <= posicao) atual = secao;
    });

    // No fim da página, ativa a última seção
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 2) {
      atual = secoes[secoes.length - 1];
    }

    navLinks.forEach(function (link) {
      link.classList.toggle("active", atual && link.getAttribute("href") === "#" + atual.id);
    });
  }

  window.addEventListener("scroll", atualizarMenuAtivo, { passive: true });
  atualizarMenuAtivo();
})();
