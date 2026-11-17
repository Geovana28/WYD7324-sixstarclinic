/* ===========================================================================
   SixStar Clinic — Filtros de Médicos por Especialidade
   1) Botões de filtro dos cards (seção Especialistas)
   2) Formulário: escolheu a especialidade → só aparecem os médicos dela
   3) "Agendar" / "Selecionar" já preenchem médico e especialidade no form
   =========================================================================== */

document.addEventListener("DOMContentLoaded", function () {
  /* ---------- 1) Filtro dos cards ---------- */
  const filterButtons = document.querySelectorAll(".filter-btn");
  const doctorCards = document.querySelectorAll(".doctors-grid .doctor-card");

  function filtrarCards(especialidade) {
    doctorCards.forEach(function (card) {
      const spec = card.querySelector(".doctor-spec");
      const nomeSpec = spec ? spec.textContent.trim() : "";
      const mostrar = especialidade === "all" || nomeSpec === especialidade;
      card.classList.toggle("is-hidden", !mostrar);
    });
  }

  filterButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      filterButtons.forEach(function (btn) { btn.classList.remove("active"); });
      this.classList.add("active");
      filtrarCards(this.getAttribute("data-filter"));
    });
  });

  /* ---------- 2) Especialidade → Médico no formulário ---------- */
  const selectSpec = document.getElementById("specialty-select");
  const selectMedico = document.getElementById("doctor-select");

  if (!selectSpec || !selectMedico) return;

  // Guarda a lista completa de médicos (lendo a especialidade entre parênteses)
  const todosMedicos = Array.from(selectMedico.options)
    .filter(function (opt) { return opt.value !== ""; })
    .map(function (opt) {
      const match = opt.textContent.match(/\(([^)]+)\)\s*$/);
      return {
        valor: opt.value,
        texto: opt.textContent,
        especialidade: match ? match[1].trim() : ""
      };
    });

  function montarMedicos(especialidade, medicoSelecionado) {
    const lista = especialidade
      ? todosMedicos.filter(function (m) { return m.especialidade === especialidade; })
      : todosMedicos;

    selectMedico.innerHTML = "";

    const placeholder = document.createElement("option");
    placeholder.value = "";
    placeholder.textContent = "Selecione o especialista";
    selectMedico.appendChild(placeholder);

    lista.forEach(function (m) {
      const opt = document.createElement("option");
      opt.value = m.valor;
      opt.textContent = m.texto;
      selectMedico.appendChild(opt);
    });

    // Se só existe um médico na especialidade, já seleciona ele
    if (medicoSelecionado) {
      selectMedico.value = medicoSelecionado;
    } else if (lista.length === 1) {
      selectMedico.value = lista[0].valor;
    }
  }

  selectSpec.addEventListener("change", function () {
    montarMedicos(selectSpec.value);
  });

  // Se escolher o médico primeiro, a especialidade é preenchida sozinha
  selectMedico.addEventListener("change", function () {
    const medico = todosMedicos.find(function (m) { return m.valor === selectMedico.value; });
    if (medico && selectSpec.value !== medico.especialidade) {
      selectSpec.value = medico.especialidade;
      montarMedicos(medico.especialidade, medico.valor);
    }
  });

  /* ---------- 3) Botões "Agendar" (cards) e "Selecionar" (tabela) ---------- */
  function preencherFormulario(nomeMedico) {
    const medico = todosMedicos.find(function (m) { return m.valor === nomeMedico; });
    if (!medico) return;
    selectSpec.value = medico.especialidade;
    montarMedicos(medico.especialidade, medico.valor);
  }

  doctorCards.forEach(function (card) {
    const botao = card.querySelector('a[href="#agendamento"]');
    const nome = card.querySelector(".doctor-name");
    if (botao && nome) {
      botao.addEventListener("click", function () {
        preencherFormulario(nome.textContent.trim());
      });
    }
  });

  document.querySelectorAll(".schedule-table tbody tr").forEach(function (linha) {
    const botao = linha.querySelector('a[href="#agendamento"]');
    const nome = linha.querySelector("strong");
    if (botao && nome) {
      botao.addEventListener("click", function () {
        preencherFormulario(nome.textContent.trim());
        const campoDataBusca = document.getElementById("search-date");
        const campoDataForm = document.getElementById("appointment-date");
        if (campoDataBusca && campoDataBusca.value && campoDataForm) {
          campoDataForm.value = campoDataBusca.value;
        }
      });
    }
  });

  /* ---------- 4) Filtro da tabela de escala por data (#search-date) ---------- */
  const campoBuscaData = document.getElementById("search-date");
  const linhasEscala = document.querySelectorAll(".schedule-table tbody tr");
  const diasSigla = ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"];

  if (campoBuscaData && linhasEscala.length > 0) {
    campoBuscaData.addEventListener("change", function () {
      const valor = campoBuscaData.value;
      if (!valor) {
        linhasEscala.forEach(function (tr) { tr.style.display = ""; });
        return;
      }

      const partes = valor.split("-");
      const dataObj = new Date(Number(partes[0]), Number(partes[1]) - 1, Number(partes[2]));
      const siglaDia = diasSigla[dataObj.getDay()];

      linhasEscala.forEach(function (tr) {
        const celulaDias = tr.children[2] ? tr.children[2].textContent : "";
        tr.style.display = celulaDias.indexOf(siglaDia) !== -1 ? "" : "none";
      });
    });
  }
});
