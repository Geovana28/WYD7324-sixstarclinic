document.addEventListener("DOMContentLoaded", () => {
    const botaoTema = document.getElementById("toggle-theme-btn"); // Ajuste o ID se o seu botão for diferente
    const linkTemaClaro = document.getElementById("tema-claro-css"); // Link do CSS opcional ou manipulação de classe na body
    const body = document.body;

    // Recupera a preferência salva no navegador ao carregar a página
    const temaSalvo = localStorage.getItem("tema");

    if (temaSalvo === "claro") {
        body.classList.add("tema-claro");
        if (linkTemaClaro) linkTemaClaro.removeAttribute("disabled");
    } else {
        body.classList.remove("tema-claro");
        if (linkTemaClaro) linkTemaClaro.setAttribute("disabled", "true");
    }

    // Escuta o clique no botão de alternância
    if (botaoTema) {
        botaoTema.addEventListener("click", () => {
            body.classList.toggle("tema-claro");

            if (body.classList.contains("tema-claro")) {
                localStorage.setItem("tema", "claro");
                if (linkTemaClaro) linkTemaClaro.removeAttribute("disabled");
            } else {
                localStorage.setItem("tema", "escuro");
                if (linkTemaClaro) linkTemaClaro.setAttribute("disabled", "true");
            }
        });
    }
});
