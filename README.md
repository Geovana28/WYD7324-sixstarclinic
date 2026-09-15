# Os 6 Fantásticos — SixStar Clinic

Projeto da disciplina **ARA0062 · Desenvolvimento Web em HTML5, CSS, JavaScript e PHP** — Centro Universitário Newton Paiva, 2026/2.

**Assunto:** Portal institucional e sistema de agendamento de consultas médicas da SixStar Clinic, clínica de excelência e alto padrão em Belo Horizonte.

**Equipe:** Geovana Moreira, Gabriel Ferraz, Daniel Santos, Maria Eduarda Nascimento Silva, Angelina Damasceno

## Sobre o projeto

A SixStar Clinic é uma clínica médica multidisciplinar de alto padrão voltada a pacientes que buscam atendimento médico humanizado aliado ao conforto, pontualidade e sofisticação dos melhores serviços seis estrelas. Localizada estrategicamente na Savassi, em Belo Horizonte, a clínica oferece consultas em seis especialidades essenciais: Cardiologia, Dermatologia, Neurologia, Ortopedia, Cirurgia Plástica e Oftalmologia, com equipamentos diagnósticos de última geração e corpo clínico formado por mestres e doutores com experiência internacional.

Até o final do semestre, o site contará com sistema completo de consulta de escalas em tempo real, agendamento de consultas com envio e gravação segura em banco de dados relacional via PHP e MySQL, validação dinâmica de formulários com JavaScript, filtro instantâneo de médicos por especialidade e suporte nativo à alternância de temas visuais com acessibilidade plena e contraste rigorosamente auditado.

## Identidade visual

A identidade visual foi concebida para transmitir sobriedade médica, sofisticação e máxima legibilidade. As cores principais utilizam tons de ouro nobre e grafite profundo, estabelecendo distinção estética em relação a clínicas convencionais sem abrir mão dos princípios rigorosos de acessibilidade e contraste da Web.

### Paleta de cores principal

| Variável | Hex | Papel na interface | Justificativa |
|---|---|---|---|
| `--principal` | `#d8a72b` | Cabeçalho, títulos, destaques e botão principal | Ouro nobre que remete ao padrão seis estrelas e à exclusividade dos serviços de saúde da clínica |
| `--sobre-principal` | `#0d1017` | Texto em cima do botão principal e elementos de destaque | Grafite escuro para gerar contraste absoluto (9,8:1) sobre a tonalidade dourada |
| `--fundo` | `#0d1017` | Cor de fundo da página inteira | Tom escuro sofisticado e sereno que diminui o cansaço visual e valoriza os conteúdos em destaque |
| `--superficie` | `#171c26` | Fundo dos cards, painéis, tabelas e cabeçalho | Superfície grafite elevada com respiro visual, garantindo hierarquia e organização limpa |
| `--texto` | `#f2f4f8` | Texto principal, parágrafos de destaque e legendas | Branco suave de alta luminosidade para leitura nítida e confortável sem ofuscar a visão |
| `--apoio` | `#1f7b94` | Destaques clínicos e links informativos complementares | Azul petróleo médico que reforça credibilidade científica, serenidade e saúde |
| `--realce` | `#e0b441` | Contorno de foco `:focus` e estados ativos | Dourado vibrante de alta visibilidade para navegação acessível por teclado |
| `--linha` | `#2b3445` | Bordas e divisores de conteúdo | Cinza ardósia sutil que delimita cards e tabelas sem poluição visual |

**Fonte:** `Fonte: "Montserrat", Arial, sans-serif` para todo o corpo textual da página (pesos 400, 500 e 600) aliada à família clássica `Cinzel, Georgia, serif` para títulos de prestígio, com terminação universal em família genérica (`sans-serif` e `serif`) garantindo robustez caso ocorram falhas de conexão.

### Teste de Contraste (WebAIM Contrast Checker)

Todos os pares de cores cumprem com folga a exigência mínima de 4,5:1 (nível AA/AAA da WCAG 2.1):

| Par de cores | Contraste | Nível WCAG |
|---|---|---|
| `--texto` sobre `--superficie` | **12,8:1** | AAA (Excelente) |
| `--principal` sobre `--superficie` | **5,9:1** | AA (Conforme) |
| `--texto-fraco` sobre `--fundo` | **5,3:1** | AA (Conforme) |
| `--sobre-principal` sobre `--principal` | **9,8:1** | AAA (Excelente) |

### Segundo tema (`frontend/css/tema-claro.css`)

O segundo tema é o modo diurno (**Light Executive**), desenvolvido para pacientes que acessam o portal em ambientes de alta luminosidade ambiente ou em telas com reflexo durante o dia. Nele, a superfície torna-se branca pura (`#ffffff`), o fundo adota um tom platina suave (`#f4f5f8`), o texto passa a ser grafite escuro (`#181c24`), e o dourado principal é ajustado para um tom bronze de maior contraste (`#8c680d`), mantendo o índice de legibilidade em 14,8:1.

## Equipe e divisão de trabalho

**Líder:** Geovana Moreira

| Integrante | Matrícula | GitHub | Parte no estilo.css | Descrição da responsabilidade |
|---|---|---|---|---|
| Geovana Moreira | `202603656934` | [@Geovana28](https://github.com/Geovana28) | **Parte 1** | O `:root` e o tema: variáveis globais, box-sizing, contraste conferido e `tema-claro.css` |
| Gabriel Ferraz | `202601484478` | [@Devfrzz](https://github.com/Devfrzz) | **Partes 2 e 3** | Tipografia e Página: web font, escala `rem`, `body`, `main`, contêiner e cards |
| Daniel Santos | `202602575281` | [@Daizen-Creator](https://github.com/Daizen-Creator) | **Parte 4** | Cabeçalho e menu: `header`, logotipo, menu de navegação e botões |
| Maria Eduarda Nascimento Silva | `202601547003` | [@Mariaeduarda137](https://github.com/Mariaeduarda137) | **Parte 5** | Tabela: `border-collapse`, `caption`, cabeçalho temático, listras zebra e hover |
| Angelina Damasceno | `202602060418` | [@Angesty](https://github.com/Angesty) | **Parte 6** | Formulário e rodapé: `fieldset`, `legend`, `label`, inputs por `type`, `:focus`, botões e `footer` |

## Estrutura do repositório

```
.
├─ README.md               folha de rosto e documentação da identidade visual
├─ frontend/               arquivos de apresentação do cliente
│   ├─ index.html          página principal sem nenhum style inline
│   ├─ css/
│   │   ├─ estilo.css      estilos principais com :root, rem e seções 1 a 6
│   │   └─ tema-claro.css  segundo tema com regra única :root
│   ├─ js/
│   │   └─ script.js       scripts interativos (ciclos seguintes)
│   └─ img/
│       └─ .gitkeep        diretório para fotos dos profissionais
└─ backend/                recursos de servidor
    ├─ config/
    │   └─ conexao.php     conexão ao banco de dados MySQL
    └─ processa-contato.php recebimento de agendamentos
```

## Andamento por ciclo

- [x] Ciclo 3 — repositório, equipe e estrutura do projeto
- [x] Ciclo 3 — `frontend/`: página com listas, tabela e formulário de agendamento
- [x] Ciclos 4 e 5 — `frontend/css/`: identidade visual completa, `:root`, `rem`, acessibilidade e 2 temas
- [ ] Ciclos 6 e 7 — `frontend/js/`: interatividade e integração de dados
- [ ] Ciclos 8 a 10 — `backend/`: processamento e persistência em banco de dados
