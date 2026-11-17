/* ===========================================================================
   SixStar Clinic — Scripts do Painel Administrativo (backend/admin/admin.js)
   Pede confirmação antes de cancelar um agendamento.
   (Fica em arquivo separado: nada de JavaScript no meio do HTML/PHP.)
   =========================================================================== */

document.addEventListener("DOMContentLoaded", function () {
  const botoesCancelar = document.querySelectorAll(".btn-excluir");

  botoesCancelar.forEach(function (botao) {
    botao.addEventListener("click", function (evento) {
      // O nome do paciente vem do atributo data-nome do link
      const nome = botao.getAttribute("data-nome") || "este paciente";
      const confirmou = confirm("Deseja realmente cancelar o agendamento de " + nome + "?");

      if (!confirmou) {
        evento.preventDefault(); // não segue o link excluir.php
      }
    });
  });
});
