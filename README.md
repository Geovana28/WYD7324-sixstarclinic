# Os 6 Fantásticos — SixStar Clinic

Projeto da disciplina **WYD7324 / ARA0062 · Desenvolvimento Web em HTML5, CSS, JavaScript e PHP** — Centro Universitário Newton Paiva, 2026/2.

**Assunto:** Portal institucional e sistema completo de agendamento de consultas médicas e gestão administrativa da SixStar Clinic, clínica médica de alto padrão em Belo Horizonte.

**Equipe:** Geovana Moreira, Gabriel Ferraz, Daniel Santos, Maria Eduarda Nascimento Silva, Angelina Damasceno, Gabrielle Goulart.

**Repositório GitHub:** [https://github.com/Geovana28/ara0062-sixstarclinic](https://github.com/Geovana28/ara0062-sixstarclinic)

---

## Sobre o projeto

A **SixStar Clinic** é uma clínica médica multidisciplinar de alto padrão voltada a pacientes que buscam atendimento médico humanizado aliado ao conforto, pontualidade e sofisticação de serviços seis estrelas. Localizada estrategicamente na Savassi, em Belo Horizonte, a clínica oferece atendimento em seis especialidades essenciais: Cardiologia, Dermatologia, Neurologia, Ortopedia, Cirurgia Plástica e Oftalmologia.

O sistema conta com:
- **Portal do Paciente:** Apresentação institucional de alto padrão, visualização de escala médica com tabela zebrada, filtro dinâmico de médicos por especialidade em tempo real (nos cards e no formulário — ao escolher a especialidade, só aparecem os médicos dela), validação inteligente de formulário com máscara de WhatsApp, rolagem suave com destaque do menu ativo e gravação segura no banco de dados MySQL via PHP PDO com Prepared Statements.
- **Área Administrativa Restrita:** Sistema de autenticação com senhas criptografadas e controle de sessão (`session_start()`), contadores estatísticos em tempo real (Total de Consultas, Pendentes, Confirmadas), tabela de agendamentos recebidos, fluxo de status da consulta (**Pendente → Confirmado → Concluído**) e cancelamento de consultas — todas as ações protegidas por login.
- **Identidade Visual Acessível:** Layout responsivo desenvolvido com escala em `rem`, dois temas (Dark Luxury e Light Executive) com alternância por botão e preferência salva no navegador, e índice de contraste auditado acima das diretrizes WCAG 2.1 (AA e AAA).

---

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

**Tipografia:** `Fonte: "Montserrat", Arial, sans-serif` para todo o corpo textual da página (pesos 300 a 700) aliada à família clássica `Cinzel, Georgia, serif` para títulos de prestígio, com terminação universal em família genérica (`sans-serif` e `serif`).

### Segundo tema — Light Executive (`tema-claro.css`)

Ativado pelo botão 🌙/☀️ do cabeçalho (`tema.js`). O arquivo redefine apenas as variáveis do `:root`, então toda a página muda de cor sem duplicar regras. A escolha fica salva no `localStorage`.

| Variável | Hex (claro) | Papel |
|---|---|---|
| `--principal` | `#8c680d` | Ouro bronze de alto contraste para fundo claro |
| `--sobre-principal` | `#ffffff` | Texto sobre o botão principal |
| `--fundo` | `#f4f5f8` | Fundo da página |
| `--superficie` | `#ffffff` | Cards, tabelas e cabeçalho |
| `--texto` | `#181c24` | Texto principal |

| Par de cores (tema claro) | Contraste | Nível WCAG |
|---|---|---|
| `--texto` sobre `--superficie` | **14,8:1** | AAA |
| `--principal` sobre `--superficie` | **6,9:1** | AA |
| `--texto-fraco` sobre `--fundo` | **5,2:1** | AA |
| `--sobre-principal` sobre `--principal` | **10,3:1** | AAA |

### Teste de Contraste (WebAIM Contrast Checker)

Todos os pares de cores cumprem com folga a exigência mínima de 4,5:1 (nível AA/AAA da WCAG 2.1):

| Par de cores | Contraste | Nível WCAG |
|---|---|---|
| `--texto` sobre `--superficie` | **12,8:1** | AAA (Excelente) |
| `--principal` sobre `--superficie` | **5,9:1** | AA (Conforme) |
| `--texto-fraco` sobre `--fundo` | **5,3:1** | AA (Conforme) |
| `--sobre-principal` sobre `--principal` | **9,8:1** | AAA (Excelente) |

---

## Equipe e Divisão de Responsabilidades

**Líder do Projeto:** Geovana Moreira

| Integrante | Matrícula | GitHub | Contribuição Principal no Projeto |
|---|---|---|---|
| **Geovana Moreira** | `202603656934` | [@Geovana28](https://github.com/Geovana28) | **Liderança, Backend Core & Integração do Formulário:** Arquitetura do sistema, estruturação e integração do formulário de agendamento no `index.html` (`action`, `method="post"`, mapeamento de `name`, `id` e `required`), conexão segura MySQL via PDO com tratamento de exceções (`conexao.php`), processamento do formulário com Prepared Statements (`processa-contato.php`), navegação fluida (*smooth scroll* em `script.js`), variáveis `:root` (`estilo.css`) e documentação geral. |
| **Daniel Santos** | `202602575281` | [@Daizen-Creator](https://github.com/Daizen-Creator) | **Banco de Dados & Autenticação:** Modelagem relacional do banco de dados com chaves e *seeds* de teste (`banco.sql`), tela de login administrativo (`login.php`), script de encerramento de sessão (`logout.php`) e trava de proteção de acesso restrito (`protecao.php`). |
| **Gabriel Ferraz** | `202601484478` | [@Devfrzz](https://github.com/Devfrzz) | **Painel Administrativo, Temas, Filtros & Formulário:** Estrutura da tabela de agendamentos no painel PHP com contadores de topo (`painel.php`), script de cancelamento/exclusão via PDO (`excluir.php`), atualização de status Confirmar/Concluir (`atualizar-status.php`), alternância de tema escuro/claro com persistência (`tema.js`), filtros dinâmicos de médicos nos cards e no formulário (`filtros.js`) e coautoria na estruturação e estilização do formulário (`index.html` e `estilo.css`). |
| **Maria Eduarda Nascimento Silva** | `202601547003` | [@Mariaeduarda137](https://github.com/Mariaeduarda137) | **Validações e Máscaras (Client-side):** Máscara dinâmica de WhatsApp em tempo real `(XX) XXXXX-XXXX`, validação completa do formulário de agendamento impedindo envio de campos vazios, e-mail inválido ou datas passadas com `event.preventDefault()` (`validacao.js`). |
| **Gabrielle Goulart** | `202603062007` | [@GabrielleGoulart](https://github.com/GabrielleGoulart) | **Interface do Usuário & Telas Extras:** Nova página semântica de confirmação de agendamento para o paciente (`sucesso.html`), folha de estilos exclusiva para a área administrativa (`style-admin.css`) e responsividade dos cards médicos. |
| **Angelina Damasceno** | `202602060418` | [@Angesty](https://github.com/Angesty) | **Acessibilidade Visual (Ciclo Inicial):** Ajuste de contorno de `:focus` acessível (`2px solid var(--realce)`) no `estilo.css` e revisão inicial da listagem de integrantes. |

---

## Estrutura do Repositório

```text
.
├── README.md                      # Documentação completa, equipe e guia de execução
├── frontend/                      # Camada de apresentação (Client-side)
│   ├── index.html                 # Página inicial institucional e formulário de agendamento
│   ├── sucesso.html               # Página de confirmação de agendamento solicitado
│   ├── css/
│   │   ├── estilo.css             # Folha de estilos principal (:root, rem, responsividade)
│   │   └── tema-claro.css         # Segundo tema (Light Executive)
│   ├── js/
│   │   ├── filtros.js             # Filtro de médicos por especialidade (cards e formulário)
│   │   ├── tema.js                # Alternância de tema com persistência no localStorage
│   │   ├── validacao.js           # Máscara de telefone e validações client-side
│   │   └── script.js              # Rolagem suave e destaque do menu ativo
│   └── img/                       # Identidade gráfica, logotipos e favicons
│       ├── favicon.png
│       ├── favicon.svg
│       └── logo-sixstar.jpg
└── backend/                       # Camada de servidor e banco de dados (Server-side)
    ├── config/
    │   └── conexao.php            # Conexão segura MySQL com PDO e charset utf8mb4
    ├── sql/
    │   └── banco.sql              # Script DDL/DML de criação do banco e dados de teste (seeds)
    ├── processa-contato.php       # Recebimento do formulário via POST e INSERT no banco
    └── admin/                     # Área restrita da clínica (Backoffice)
        ├── login.php              # Autenticação de usuários administrativos com hash
        ├── logout.php             # Encerramento de sessão
        ├── protecao.php           # Middleware de proteção contra acesso não autorizado
        ├── painel.php             # Dashboard de contadores e listagem de agendamentos
        ├── atualizar-status.php   # Confirmar / concluir agendamentos (UPDATE com lista branca)
        ├── excluir.php            # Ação de cancelamento/exclusão de agendamentos
        ├── admin.js               # Confirmação client-side antes de cancelar agendamento
        └── style-admin.css        # Folha de estilos exclusiva da área administrativa
```

---

## Como executar o projeto localmente (XAMPP)

1. **Clonar o repositório:**
   Coloque a pasta do projeto dentro do diretório `htdocs` do seu XAMPP (ex.: `C:\xampp\htdocs\sixstar-clinic`).
2. **Iniciar os serviços:**
   Abra o **XAMPP Control Panel** e inicie o **Apache** e o **MySQL**.
3. **Importar o Banco de Dados:**
   - Acesse o phpMyAdmin: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
   - Vá na aba **Importar** e selecione o arquivo `backend/sql/banco.sql`.
   - Clique em **Executar** (o banco `sixstar_clinic` será criado com tabelas e dados de teste).
4. **Acessar a aplicação no navegador:**
   - 🌐 **Portal do Paciente:** [http://localhost/sixstar-clinic/frontend/index.html](http://localhost/sixstar-clinic/frontend/index.html)
   - 🔐 **Painel Administrativo:** [http://localhost/sixstar-clinic/backend/admin/login.php](http://localhost/sixstar-clinic/backend/admin/login.php)
     - **Usuário:** `admin`
     - **Senha:** `admin123`

---

## Andamento por Ciclo Acadêmico

- [x] **Ciclo 3** — Planejamento, repositório Git, equipe e estrutura do projeto
- [x] **Ciclo 3** — `frontend/`: Página institucional com listas, tabela zebrada e formulário
- [x] **Ciclos 4 e 5** — `frontend/css/`: Identidade visual completa, variáveis `:root`, unidades `rem`, 2 temas e WCAG
- [x] **Ciclos 6 e 7** — `frontend/js/`: Validações inteligentes, máscara em tempo real e filtros de médicos
- [x] **Ciclos 8 a 10** — `backend/`: Conexão PDO segura, inserção com Prepared Statements, CRUD administrativo e autenticação
