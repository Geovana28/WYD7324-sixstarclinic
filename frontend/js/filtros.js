/* ===========================================================================
   SixStar Clinic — Script de Filtragem de Médicos por Especialidade
   =========================================================================== */

document.addEventListener("DOMContentLoaded", function () {
  const filterButtons = document.querySelectorAll(".filter-btn");
  const doctorCards = document.querySelectorAll(".doctors-grid .doctor-card");

  if (filterButtons.length === 0 || doctorCards.length === 0) return;

  filterButtons.forEach(button => {
    button.addEventListener("click", function () {
      // 1. Remove a classe ativa de todos os botões e coloca no clicado
      filterButtons.forEach(btn => btn.classList.remove("active"));
      this.classList.add("active");

      const selectedFilter = this.getAttribute("data-filter");

      // 2. Filtra os cards de médicos
      doctorCards.forEach(card => {
        const specialtyElement = card.querySelector(".doctor-spec");
        if (!specialtyElement) return;

        const doctorSpecialty = specialtyElement.textContent.trim();

        if (selectedFilter === "all" || doctorSpecialty === selectedFilter) {
          card.style.display = "flex"; // Mostra o card
        } else {
          card.style.display = "none"; // Esconde o card
        }
      });
    });
  });
});
