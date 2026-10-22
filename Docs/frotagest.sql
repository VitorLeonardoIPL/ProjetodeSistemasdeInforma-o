-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 22-Out-2026 às 18:36
-- Versão do servidor: 8.4.7
-- versão do PHP: 8.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dados: `frotagest`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alerta`
--

DROP TABLE IF EXISTS `alerta`;
CREATE TABLE IF NOT EXISTS `alerta` (
  `id` int NOT NULL AUTO_INCREMENT,
  `viatura_id` int NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_limite` date DEFAULT NULL,
  `data_geracao` datetime NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-alerta-viatura_id` (`viatura_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `anexo`
--

DROP TABLE IF EXISTS `anexo`;
CREATE TABLE IF NOT EXISTS `anexo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `viatura_id` int NOT NULL,
  `checklist_id` int DEFAULT NULL,
  `categoria` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ficheiro` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_validade` date DEFAULT NULL,
  `risco` tinyint(1) NOT NULL DEFAULT '0',
  `data_registo` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-anexo-viatura_id` (`viatura_id`),
  KEY `idx-anexo-checklist_id` (`checklist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atribuicao`
--

DROP TABLE IF EXISTS `atribuicao`;
CREATE TABLE IF NOT EXISTS `atribuicao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `requisicao_id` int NOT NULL,
  `viatura_id` int NOT NULL,
  `condutor_id` int NOT NULL,
  `aprovada_por` int NOT NULL,
  `data_atribuicao` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-atribuicao-requisicao_id` (`requisicao_id`),
  KEY `idx-atribuicao-viatura_id` (`viatura_id`),
  KEY `idx-atribuicao-condutor_id` (`condutor_id`),
  KEY `idx-atribuicao-aprovada_por` (`aprovada_por`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ausencia_condutor`
--

DROP TABLE IF EXISTS `ausencia_condutor`;
CREATE TABLE IF NOT EXISTS `ausencia_condutor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `condutor_id` int NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `motivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-ausencia_condutor-condutor_id` (`condutor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('acederApp', 2, 'Login na app (API)', NULL, NULL, 1792525034, 1792525034),
('acederBackoffice', 2, 'Aceder ao back-office', NULL, NULL, 1792525034, 1792525034),
('acederFrontoffice', 2, 'Aceder ao front-office', NULL, NULL, 1792525034, 1792525034),
('administrador', 1, NULL, NULL, NULL, 1792525034, 1792525034),
('anexarFatura', 2, 'Anexar fatura de combustivel', 'isRequisicaoOwner', NULL, 1792525034, 1792525034),
('aprovarRequisicao', 2, 'Ver pendentes e aprovar', NULL, NULL, 1792525034, 1792525034),
('assinalarRisco', 2, 'Marcar risco nas fotos', NULL, NULL, 1792525034, 1792525034),
('atribuirViatura', 2, 'Atribuir viatura e condutor', NULL, NULL, 1792525034, 1792525034),
('cancelarRequisicao', 2, 'Cancelar um pedido proprio pendente', 'isRequisicaoOwner', NULL, 1792525034, 1792525034),
('colaborador', 1, NULL, NULL, NULL, 1792525034, 1792525034),
('concluirManutencao', 2, 'Concluir manutencao (viatura fica disponivel)', NULL, NULL, 1792525034, 1792525034),
('configurarAlertas', 2, 'Antecedencia dos alertas', NULL, NULL, 1792525034, 1792525034),
('configurarParametros', 2, 'Parametros do sistema', NULL, NULL, 1792525034, 1792525034),
('coordenador', 1, NULL, NULL, NULL, 1792525034, 1792525034),
('criarRequisicao', 2, 'Submeter pedido (inclui sugestao de periodo)', NULL, NULL, 1792525034, 1792525034),
('editarManutencao', 2, 'Editar pecas e custos', NULL, NULL, 1792525034, 1792525034),
('enviarLocalizacao', 2, 'Enviar localizacao em viagem', 'isRequisicaoOwner', NULL, 1792525034, 1792525034),
('gerirCondutores', 2, 'CRUD de condutores', NULL, NULL, 1792525034, 1792525034),
('gerirDocumentos', 2, 'Seguro, inspecao, IUC e documentos a expirar', NULL, NULL, 1792525034, 1792525034),
('gerirIndisponibilidades', 2, 'Ferias e baixas dos condutores', NULL, NULL, 1792525034, 1792525034),
('gerirOrcamentos', 2, 'Criar, submeter e mudar estado de orcamentos', NULL, NULL, 1792525034, 1792525034),
('gerirPermissoes', 2, 'Permissoes por role', NULL, NULL, 1792525034, 1792525034),
('gerirServicosExternos', 2, 'Google Calendar e FCM, testar ligacao', NULL, NULL, 1792525034, 1792525034),
('gerirUtilizadores', 2, 'Criar, editar, desativar/reativar contas e atribuir role', NULL, NULL, 1792525034, 1792525034),
('gerirViaturas', 2, 'CRUD de viaturas e codigo QR', NULL, NULL, 1792525034, 1792525034),
('recusarRequisicao', 2, 'Recusar com motivo', NULL, NULL, 1792525034, 1792525034),
('redefinirPassword', 2, 'Enviar reset de palavra-passe', NULL, NULL, 1792525034, 1792525034),
('registarChecklist', 2, 'Check-in/out, km, fotos, QR', 'isRequisicaoOwner', NULL, 1792525034, 1792525034),
('registarManutencao', 2, 'Registar intervencao, pecas e custos', NULL, NULL, 1792525034, 1792525034),
('registarNecessidade', 2, 'Necessidades de manutencao', NULL, NULL, 1792525034, 1792525034),
('tecnico', 1, NULL, NULL, NULL, 1792525034, 1792525034),
('verCatalogo', 2, 'Catalogo e calendario de disponibilidade', NULL, NULL, 1792525034, 1792525034),
('verCondutoresDisponiveis', 2, 'Condutores livres num periodo', NULL, NULL, 1792525034, 1792525034),
('verDashboard', 2, 'Ocupacao e viaturas paradas', NULL, NULL, 1792525034, 1792525034),
('verEstadoSistema', 2, 'Estado dos servicos', NULL, NULL, 1792525034, 1792525034),
('verFaturas', 2, 'Faturas de combustivel', NULL, NULL, 1792525034, 1792525034),
('verHistoricoManutencoes', 2, 'Historico por viatura', NULL, NULL, 1792525034, 1792525034),
('verLogs', 2, 'Logs de auditoria e erros', NULL, NULL, 1792525034, 1792525034),
('verMapa', 2, 'Mapa e rotas', NULL, NULL, 1792525034, 1792525034),
('verNotificacoes', 2, 'Proprias notificacoes', NULL, NULL, 1792525034, 1792525034),
('verPropriaRequisicao', 2, 'Ver os proprios pedidos e o detalhe', 'isRequisicaoOwner', NULL, 1792525034, 1792525034),
('verRequisicao', 2, 'Lista e detalhe de todas as requisicoes', NULL, NULL, 1792525034, 1792525034),
('verTrilhaAprovacoes', 2, 'Quem aprovou ou recusou cada pedido', NULL, NULL, 1792525034, 1792525034);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('administrador', 'acederApp'),
('colaborador', 'acederApp'),
('coordenador', 'acederApp'),
('administrador', 'acederBackoffice'),
('coordenador', 'acederBackoffice'),
('tecnico', 'acederBackoffice'),
('colaborador', 'acederFrontoffice'),
('colaborador', 'anexarFatura'),
('coordenador', 'aprovarRequisicao'),
('coordenador', 'assinalarRisco'),
('coordenador', 'atribuirViatura'),
('colaborador', 'cancelarRequisicao'),
('tecnico', 'concluirManutencao'),
('coordenador', 'configurarAlertas'),
('administrador', 'configurarParametros'),
('colaborador', 'criarRequisicao'),
('tecnico', 'editarManutencao'),
('colaborador', 'enviarLocalizacao'),
('coordenador', 'gerirCondutores'),
('coordenador', 'gerirDocumentos'),
('coordenador', 'gerirIndisponibilidades'),
('coordenador', 'gerirOrcamentos'),
('administrador', 'gerirPermissoes'),
('administrador', 'gerirServicosExternos'),
('administrador', 'gerirUtilizadores'),
('coordenador', 'gerirViaturas'),
('coordenador', 'recusarRequisicao'),
('administrador', 'redefinirPassword'),
('colaborador', 'registarChecklist'),
('tecnico', 'registarManutencao'),
('coordenador', 'registarNecessidade'),
('tecnico', 'registarNecessidade'),
('colaborador', 'verCatalogo'),
('coordenador', 'verCondutoresDisponiveis'),
('coordenador', 'verDashboard'),
('administrador', 'verEstadoSistema'),
('coordenador', 'verFaturas'),
('tecnico', 'verHistoricoManutencoes'),
('administrador', 'verLogs'),
('coordenador', 'verMapa'),
('administrador', 'verNotificacoes'),
('colaborador', 'verNotificacoes'),
('coordenador', 'verNotificacoes'),
('tecnico', 'verNotificacoes'),
('colaborador', 'verPropriaRequisicao'),
('coordenador', 'verRequisicao'),
('coordenador', 'verTrilhaAprovacoes');

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isRequisicaoOwner', 0x4f3a33333a22636f6d6d6f6e5c726261635c49735265717569736963616f4f776e657252756c65223a333a7b733a343a226e616d65223b733a31373a2269735265717569736963616f4f776e6572223b733a393a22637265617465644174223b693a313739323532353033343b733a393a22757064617465644174223b693a313739323532353033343b7d, 1792525034, 1792525034);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `checklist`
--

DROP TABLE IF EXISTS `checklist`;
CREATE TABLE IF NOT EXISTS `checklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `atribuicao_id` int NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `km` int NOT NULL,
  `data_hora` datetime NOT NULL,
  `estado_geral` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `docs_a_bordo` tinyint(1) NOT NULL DEFAULT '0',
  `observacoes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-checklist-atribuicao_id` (`atribuicao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `condutor`
--

DROP TABLE IF EXISTS `condutor`;
CREATE TABLE IF NOT EXISTS `condutor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `n_carta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validade_carta` date NOT NULL,
  `telefone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fatura_combustivel`
--

DROP TABLE IF EXISTS `fatura_combustivel`;
CREATE TABLE IF NOT EXISTS `fatura_combustivel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `atribuicao_id` int NOT NULL,
  `fotografia` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `litros` float DEFAULT NULL,
  `valor` float DEFAULT NULL,
  `data_registo` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-fatura_combustivel-atribuicao_id` (`atribuicao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_orcamento`
--

DROP TABLE IF EXISTS `item_orcamento`;
CREATE TABLE IF NOT EXISTS `item_orcamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `orcamento_id` int NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantidade` int NOT NULL DEFAULT '1',
  `preco_unitario` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-item_orcamento-orcamento_id` (`orcamento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `localizacao`
--

DROP TABLE IF EXISTS `localizacao`;
CREATE TABLE IF NOT EXISTS `localizacao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `atribuicao_id` int NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `data_hora` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-localizacao-atribuicao_id` (`atribuicao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `log_auditoria`
--

DROP TABLE IF EXISTS `log_auditoria`;
CREATE TABLE IF NOT EXISTS `log_auditoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilizador_id` int DEFAULT NULL,
  `canal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tabela_afetada` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registo_id` int DEFAULT NULL,
  `detalhe` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_hora` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-log_auditoria-utilizador_id` (`utilizador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `manutencao`
--

DROP TABLE IF EXISTS `manutencao`;
CREATE TABLE IF NOT EXISTS `manutencao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `viatura_id` int NOT NULL,
  `tecnico_id` int DEFAULT NULL,
  `orcamento_id` int DEFAULT NULL,
  `data` date NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `km` int DEFAULT NULL,
  `horas_trabalho` float DEFAULT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-manutencao-viatura_id` (`viatura_id`),
  KEY `idx-manutencao-tecnico_id` (`tecnico_id`),
  KEY `idx-manutencao-orcamento_id` (`orcamento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1792519570),
('m130524_201442_init', 1792519573),
('m140506_102106_rbac_init', 1792521608),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1792521608),
('m180523_151638_rbac_updates_indexes_without_prefix', 1792521608),
('m190124_110200_add_verification_token_column_to_user_table', 1792519573),
('m200409_110543_rbac_update_mssql_trigger', 1792521608),
('m261020_194049_create_categoria_table', 1792525489),
('m261020_194339_create_viatura_table', 1792525489),
('m261020_194635_create_condutor_table', 1792525660),
('m261020_194711_create_ausencia_condutor_table', 1792525661),
('m261020_194759_create_requisicao_table', 1792525724),
('m261020_194816_create_atribuicao_table', 1792525724),
('m261020_195003_create_checklist_table', 1792525879),
('m261020_195019_create_anexo_table', 1792525879),
('m261020_195041_create_fatura_combustivel_table', 1792525879),
('m261020_195057_create_localizacao_table', 1792525879),
('m261020_195135_create_alerta_table', 1792525928),
('m261020_195150_create_notificacao_table', 1792525928),
('m261020_195320_create_orcamento_compra_table', 1792526492),
('m261020_195521_create_item_orcamento_table', 1792526492),
('m261020_195535_create_necessidade_manutencao_table', 1792526492),
('m261020_200055_create_manutencao_table', 1792526492),
('m261020_200111_create_peca_table', 1792526492),
('m261020_200624_create_perfil_table', 1792526916),
('m261020_200637_create_log_auditoria_table', 1792526917),
('m261020_200705_create_parametro_table', 1792526917),
('m261020_200817_create_servico_externo_table', 1792526917),
('m261020_200907_seed_parametro', 1792527096);

-- --------------------------------------------------------

--
-- Estrutura da tabela `necessidade_manutencao`
--

DROP TABLE IF EXISTS `necessidade_manutencao`;
CREATE TABLE IF NOT EXISTS `necessidade_manutencao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `viatura_id` int NOT NULL,
  `orcamento_id` int DEFAULT NULL,
  `registada_por` int NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-necessidade_manutencao-viatura_id` (`viatura_id`),
  KEY `idx-necessidade_manutencao-orcamento_id` (`orcamento_id`),
  KEY `idx-necessidade_manutencao-registada_por` (`registada_por`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacao`
--

DROP TABLE IF EXISTS `notificacao`;
CREATE TABLE IF NOT EXISTS `notificacao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilizador_id` int NOT NULL,
  `requisicao_id` int DEFAULT NULL,
  `alerta_id` int DEFAULT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensagem` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lida` tinyint(1) NOT NULL DEFAULT '0',
  `data_envio` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-notificacao-utilizador_id` (`utilizador_id`),
  KEY `idx-notificacao-requisicao_id` (`requisicao_id`),
  KEY `idx-notificacao-alerta_id` (`alerta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento_compra`
--

DROP TABLE IF EXISTS `orcamento_compra`;
CREATE TABLE IF NOT EXISTS `orcamento_compra` (
  `id` int NOT NULL AUTO_INCREMENT,
  `viatura_id` int NOT NULL,
  `criado_por` int NOT NULL,
  `fornecedor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rascunho',
  `data` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-orcamento_compra-viatura_id` (`viatura_id`),
  KEY `idx-orcamento_compra-criado_por` (`criado_por`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `parametro`
--

DROP TABLE IF EXISTS `parametro`;
CREATE TABLE IF NOT EXISTS `parametro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `atualizado_por` int DEFAULT NULL,
  `chave` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `atualizado_em` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chave` (`chave`),
  KEY `idx-parametro-atualizado_por` (`atualizado_por`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `parametro`
--

INSERT INTO `parametro` (`id`, `atualizado_por`, `chave`, `valor`, `atualizado_em`) VALUES
(1, NULL, 'alerta_dias_seguro', '30', '2026-10-20 20:11:36'),
(2, NULL, 'alerta_dias_inspecao', '30', '2026-10-20 20:11:36'),
(3, NULL, 'alerta_dias_iuc', '30', '2026-10-20 20:11:36'),
(4, NULL, 'alerta_dias_revisao', '30', '2026-10-20 20:11:36'),
(5, NULL, 'requisicao_antecedencia_min_dias', '1', '2026-10-20 20:11:36'),
(6, NULL, 'requisicao_duracao_max_dias', '15', '2026-10-20 20:11:36'),
(7, NULL, 'viatura_parada_dias', '30', '2026-10-20 20:11:36'),
(8, NULL, 'localizacao_intervalo_seg', '60', '2026-10-20 20:11:36'),
(9, NULL, 'sessao_expiracao_min', '60', '2026-10-20 20:11:36'),
(10, NULL, 'logs_retencao_dias', '90', '2026-10-20 20:11:36');

-- --------------------------------------------------------

--
-- Estrutura da tabela `peca`
--

DROP TABLE IF EXISTS `peca`;
CREATE TABLE IF NOT EXISTS `peca` (
  `id` int NOT NULL AUTO_INCREMENT,
  `manutencao_id` int NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantidade` int NOT NULL DEFAULT '1',
  `custo` float NOT NULL,
  `fotografia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-peca-manutencao_id` (`manutencao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil`
--

DROP TABLE IF EXISTS `perfil`;
CREATE TABLE IF NOT EXISTS `perfil` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telemovel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departamento` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `n_carta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validade_carta` date DEFAULT NULL,
  `token_push` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `idx-perfil-user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `requisicao`
--

DROP TABLE IF EXISTS `requisicao`;
CREATE TABLE IF NOT EXISTS `requisicao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilizador_id` int NOT NULL,
  `categoria_id` int NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `destino` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendente',
  `motivo_recusa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_pedido` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-requisicao-utilizador_id` (`utilizador_id`),
  KEY `idx-requisicao-categoria_id` (`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico_externo`
--

DROP TABLE IF EXISTS `servico_externo`;
CREATE TABLE IF NOT EXISTS `servico_externo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `atualizado_por` int DEFAULT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credenciais` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '0',
  `atualizado_em` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-servico_externo-atualizado_por` (`atualizado_por`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'Admin', 'YgPzYuX0bDXZdPu8IsTddEO72HW0Z3en', '$2y$13$Iid0nhJYQyQwdNI/WORZ8.y01pTPzgu8Xl9iSE9ASLyztStO56MWG', NULL, 'admin@ulo.pt', 10, 1792528128, 1792528128, '2JkASI0D7Q1paBQbWVOawRLonVDrefXT_1792528128');

-- --------------------------------------------------------

--
-- Estrutura da tabela `viatura`
--

DROP TABLE IF EXISTS `viatura`;
CREATE TABLE IF NOT EXISTS `viatura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria_id` int NOT NULL,
  `matricula` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `combustivel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caracteristicas` text COLLATE utf8mb4_unicode_ci,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'disponivel',
  `km_atual` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricula` (`matricula`),
  KEY `idx-viatura-categoria_id` (`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `alerta`
--
ALTER TABLE `alerta`
  ADD CONSTRAINT `fk-alerta-viatura_id` FOREIGN KEY (`viatura_id`) REFERENCES `viatura` (`id`);

--
-- Limitadores para a tabela `anexo`
--
ALTER TABLE `anexo`
  ADD CONSTRAINT `fk-anexo-checklist_id` FOREIGN KEY (`checklist_id`) REFERENCES `checklist` (`id`),
  ADD CONSTRAINT `fk-anexo-viatura_id` FOREIGN KEY (`viatura_id`) REFERENCES `viatura` (`id`);

--
-- Limitadores para a tabela `atribuicao`
--
ALTER TABLE `atribuicao`
  ADD CONSTRAINT `fk-atribuicao-aprovada_por` FOREIGN KEY (`aprovada_por`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk-atribuicao-condutor_id` FOREIGN KEY (`condutor_id`) REFERENCES `condutor` (`id`),
  ADD CONSTRAINT `fk-atribuicao-requisicao_id` FOREIGN KEY (`requisicao_id`) REFERENCES `requisicao` (`id`),
  ADD CONSTRAINT `fk-atribuicao-viatura_id` FOREIGN KEY (`viatura_id`) REFERENCES `viatura` (`id`);

--
-- Limitadores para a tabela `ausencia_condutor`
--
ALTER TABLE `ausencia_condutor`
  ADD CONSTRAINT `fk-ausencia_condutor-condutor_id` FOREIGN KEY (`condutor_id`) REFERENCES `condutor` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `checklist`
--
ALTER TABLE `checklist`
  ADD CONSTRAINT `fk-checklist-atribuicao_id` FOREIGN KEY (`atribuicao_id`) REFERENCES `atribuicao` (`id`);

--
-- Limitadores para a tabela `fatura_combustivel`
--
ALTER TABLE `fatura_combustivel`
  ADD CONSTRAINT `fk-fatura_combustivel-atribuicao_id` FOREIGN KEY (`atribuicao_id`) REFERENCES `atribuicao` (`id`);

--
-- Limitadores para a tabela `item_orcamento`
--
ALTER TABLE `item_orcamento`
  ADD CONSTRAINT `fk-item_orcamento-orcamento_id` FOREIGN KEY (`orcamento_id`) REFERENCES `orcamento_compra` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `localizacao`
--
ALTER TABLE `localizacao`
  ADD CONSTRAINT `fk-localizacao-atribuicao_id` FOREIGN KEY (`atribuicao_id`) REFERENCES `atribuicao` (`id`);

--
-- Limitadores para a tabela `log_auditoria`
--
ALTER TABLE `log_auditoria`
  ADD CONSTRAINT `fk-log_auditoria-utilizador_id` FOREIGN KEY (`utilizador_id`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `manutencao`
--
ALTER TABLE `manutencao`
  ADD CONSTRAINT `fk-manutencao-orcamento_id` FOREIGN KEY (`orcamento_id`) REFERENCES `orcamento_compra` (`id`),
  ADD CONSTRAINT `fk-manutencao-tecnico_id` FOREIGN KEY (`tecnico_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk-manutencao-viatura_id` FOREIGN KEY (`viatura_id`) REFERENCES `viatura` (`id`);

--
-- Limitadores para a tabela `necessidade_manutencao`
--
ALTER TABLE `necessidade_manutencao`
  ADD CONSTRAINT `fk-necessidade_manutencao-orcamento_id` FOREIGN KEY (`orcamento_id`) REFERENCES `orcamento_compra` (`id`),
  ADD CONSTRAINT `fk-necessidade_manutencao-registada_por` FOREIGN KEY (`registada_por`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk-necessidade_manutencao-viatura_id` FOREIGN KEY (`viatura_id`) REFERENCES `viatura` (`id`);

--
-- Limitadores para a tabela `notificacao`
--
ALTER TABLE `notificacao`
  ADD CONSTRAINT `fk-notificacao-alerta_id` FOREIGN KEY (`alerta_id`) REFERENCES `alerta` (`id`),
  ADD CONSTRAINT `fk-notificacao-requisicao_id` FOREIGN KEY (`requisicao_id`) REFERENCES `requisicao` (`id`),
  ADD CONSTRAINT `fk-notificacao-utilizador_id` FOREIGN KEY (`utilizador_id`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `orcamento_compra`
--
ALTER TABLE `orcamento_compra`
  ADD CONSTRAINT `fk-orcamento_compra-criado_por` FOREIGN KEY (`criado_por`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk-orcamento_compra-viatura_id` FOREIGN KEY (`viatura_id`) REFERENCES `viatura` (`id`);

--
-- Limitadores para a tabela `parametro`
--
ALTER TABLE `parametro`
  ADD CONSTRAINT `fk-parametro-atualizado_por` FOREIGN KEY (`atualizado_por`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `peca`
--
ALTER TABLE `peca`
  ADD CONSTRAINT `fk-peca-manutencao_id` FOREIGN KEY (`manutencao_id`) REFERENCES `manutencao` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `perfil`
--
ALTER TABLE `perfil`
  ADD CONSTRAINT `fk-perfil-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `requisicao`
--
ALTER TABLE `requisicao`
  ADD CONSTRAINT `fk-requisicao-categoria_id` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `fk-requisicao-utilizador_id` FOREIGN KEY (`utilizador_id`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `servico_externo`
--
ALTER TABLE `servico_externo`
  ADD CONSTRAINT `fk-servico_externo-atualizado_por` FOREIGN KEY (`atualizado_por`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `viatura`
--
ALTER TABLE `viatura`
  ADD CONSTRAINT `fk-viatura-categoria_id` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
