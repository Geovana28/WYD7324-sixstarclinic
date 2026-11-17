/* ===========================================================================
   SixStar Clinic — Modelagem do Banco de Dados (MySQL)
   Disciplina: ARA0062 / WYD7324 · Desenvolvimento Web
   Como importar: phpMyAdmin > Importar > escolher este arquivo
                  (ou: mysql -u root < backend/sql/banco.sql)
   =========================================================================== */

CREATE DATABASE IF NOT EXISTS sixstar_clinic
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE sixstar_clinic;

/* Recria as tabelas na ordem correta (filhas antes das pais) */
DROP TABLE IF EXISTS agendamentos;
DROP TABLE IF EXISTS medicos;
DROP TABLE IF EXISTS especialidades;
DROP TABLE IF EXISTS usuarios_admin;

/* ---------------------------------------------------------------------------
   1. Especialidades médicas
   --------------------------------------------------------------------------- */
CREATE TABLE especialidades (
  id        INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nome      VARCHAR(60)  NOT NULL,
  descricao VARCHAR(255) NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_especialidades_nome (nome)
) ENGINE=InnoDB;

/* ---------------------------------------------------------------------------
   2. Corpo clínico
   --------------------------------------------------------------------------- */
CREATE TABLE medicos (
  id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nome             VARCHAR(100) NOT NULL,
  crm              VARCHAR(20)  NOT NULL,
  especialidade_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_medicos_crm (crm),
  CONSTRAINT fk_medicos_especialidade
    FOREIGN KEY (especialidade_id) REFERENCES especialidades (id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

/* ---------------------------------------------------------------------------
   3. Agendamentos
   As colunas "especialidade" e "medico" guardam o texto enviado pelo formulário
   (é o que backend/processa-contato.php já grava). Os campos *_id são opcionais
   e ligam o agendamento às tabelas acima por chave estrangeira.
   --------------------------------------------------------------------------- */
CREATE TABLE agendamentos (
  id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nome             VARCHAR(100) NOT NULL,
  telefone         VARCHAR(25)  NOT NULL,
  email            VARCHAR(120) NOT NULL,
  especialidade    VARCHAR(60)  NOT NULL,
  medico           VARCHAR(100) NOT NULL,
  data_consulta    DATE         NOT NULL,
  horario          VARCHAR(5)   NOT NULL,
  observacoes      TEXT         NULL,
  status           ENUM('Pendente','Confirmado','Concluído') NOT NULL DEFAULT 'Pendente',
  especialidade_id INT UNSIGNED NULL,
  medico_id        INT UNSIGNED NULL,
  criado_em        TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  CONSTRAINT fk_agendamentos_especialidade
    FOREIGN KEY (especialidade_id) REFERENCES especialidades (id)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT fk_agendamentos_medico
    FOREIGN KEY (medico_id) REFERENCES medicos (id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

/* ---------------------------------------------------------------------------
   4. Usuários do painel administrativo (senha guardada como hash)
   --------------------------------------------------------------------------- */
CREATE TABLE usuarios_admin (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario    VARCHAR(50)  NOT NULL,
  senha_hash VARCHAR(255) NOT NULL,
  criado_em  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_usuarios_admin_usuario (usuario)
) ENGINE=InnoDB;

/* ===========================================================================
   DADOS DE TESTE (seeds)
   =========================================================================== */

/* 6 especialidades da SixStar */
INSERT INTO especialidades (id, nome, descricao) VALUES
  (1, 'Cardiologia',       'Saúde do coração e do sistema circulatório'),
  (2, 'Dermatologia',      'Cuidados com a pele, cabelos e unhas'),
  (3, 'Neurologia',        'Sistema nervoso central e periférico'),
  (4, 'Ortopedia',         'Ossos, articulações, músculos e ligamentos'),
  (5, 'Cirurgia Plástica', 'Cirurgia estética e reparadora'),
  (6, 'Oftalmologia',      'Saúde dos olhos e correção da visão');

/* Corpo clínico (mesmos nomes e CRMs exibidos em frontend/index.html) */
INSERT INTO medicos (id, nome, crm, especialidade_id) VALUES
  (1, 'Dra. Helena Valença',   'CRM/MG 48.920', 1),
  (2, 'Dr. Alexandre Fontoura','CRM/MG 62.304', 2),
  (3, 'Dra. Beatriz Sartori',  'CRM/MG 39.771', 3),
  (4, 'Dr. Rodrigo Castilho',  'CRM/MG 55.498', 4),
  (5, 'Dra. Camilla Meireles', 'CRM/MG 73.811', 5),
  (6, 'Dr. Marcus Vinícius',   'CRM/MG 28.445', 6);

/* Administrador de teste -> usuário: admin | senha: admin123
   (hash bcrypt gerado com o mesmo algoritmo do password_hash() do PHP) */
INSERT INTO usuarios_admin (usuario, senha_hash) VALUES
  ('admin', '$2y$10$2LWMXBCq3QvIekqMWfalue0TZLd4Gs4LdQSV1uzvZ1dutdkg3/832');

/* 3 agendamentos simulados para o painel já abrir com dados */
INSERT INTO agendamentos
  (nome, telefone, email, especialidade, medico, data_consulta, horario, observacoes, status, especialidade_id, medico_id)
VALUES
  ('Mariana Albuquerque', '(31) 99812-4455', 'mariana.albuquerque@exemplo.com',
   'Cardiologia', 'Dra. Helena Valença', DATE_ADD(CURDATE(), INTERVAL 3 DAY), '09:00',
   'Check-up anual e avaliação de pressão arterial.', 'Pendente', 1, 1),
  ('Ricardo Tavares', '(31) 98877-1020', 'ricardo.tavares@exemplo.com',
   'Ortopedia', 'Dr. Rodrigo Castilho', DATE_ADD(CURDATE(), INTERVAL 5 DAY), '14:00',
   'Dor no joelho direito após corrida.', 'Confirmado', 4, 4),
  ('Patrícia Nogueira', '(31) 99234-7788', 'patricia.nogueira@exemplo.com',
   'Dermatologia', 'Dr. Alexandre Fontoura', DATE_ADD(CURDATE(), INTERVAL 7 DAY), '10:30',
   NULL, 'Pendente', 2, 2);
