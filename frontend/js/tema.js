/* ===========================================================================
   SixStar Clinic — Alternância de Tema Escuro / Claro (frontend/js/tema.js)
   - Liga/desliga o css/tema-claro.css (link#tema-claro-css)
   - Usa o checkbox #theme-checkbox do cabeçalho (o rótulo troca via CSS :has)
   - Salva a escolha no localStorage e respeita o tema do sistema na 1ª visita
   Carregado SEM defer no <head> para aplicar o tema antes de pintar a página
   (evita o "piscar" escuro → claro).
   =========================================================================== */

(function () {
  var CHAVE = "sixstar-tema";
  var html = document.documentElement;
  var linkClaro = document.getElementById("tema-claro-css");

  function temaInicial() {
    var salvo = null;
    try { salvo = localStorage.getItem(CHAVE); } catch (e) { /* modo privado */ }
    if (salvo === "claro" || salvo === "escuro") return salvo;
    return window.matchMedia && window.matchMedia("(prefers-color-scheme: light)").matches
      ? "claro"
      : "escuro";
  }

  function aplicarTema(tema) {
    var claro = tema === "claro";
    // media="all" ativa o tema claro; "not all" desativa (funciona em todos os navegadores)
    if (linkClaro) linkClaro.media = claro ? "all" : "not all";
    html.setAttribute("data-theme", claro ? "light" : "dark");
    html.style.colorScheme = claro ? "light" : "dark";

    var checkbox = document.getElementById("theme-checkbox");
    if (checkbox) checkbox.checked = claro;
  }

  // 1) Aplica imediatamente (ainda no <head>)
  aplicarTema(temaInicial());

  // 2) Quando o HTML terminar de carregar, sincroniza e escuta o botão
  document.addEventListener("DOMContentLoaded", function () {
    var checkbox = document.getElementById("theme-checkbox");
    aplicarTema(temaInicial());

    if (!checkbox) return;

    checkbox.addEventListener("change", function () {
      var tema = checkbox.checked ? "claro" : "escuro";
      aplicarTema(tema);
      try { localStorage.setItem(CHAVE, tema); } catch (e) { /* modo privado */ }
    });
  });
})();
