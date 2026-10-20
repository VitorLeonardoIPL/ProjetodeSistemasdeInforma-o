<?php


namespace console\controllers;

use common\rbac\IsRequisicaoOwnerRule;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    // php yii rbac/init
    public function actionInit()
    {
        //ponto de acesso ao RBAC: o componente authManager (common/config/main.php)
        $auth = Yii::$app->authManager;

        //regra do dono: so a requisicao do proprio utilizador
        $rule = new IsRequisicaoOwnerRule();
        $auth->add($rule);

        //permissoes: acesso aos canais
        $acederFrontoffice = $auth->createPermission('acederFrontoffice');
        $acederFrontoffice->description = 'Aceder ao front-office';
        $auth->add($acederFrontoffice);

        $acederBackoffice = $auth->createPermission('acederBackoffice');
        $acederBackoffice->description = 'Aceder ao back-office';
        $auth->add($acederBackoffice);

        $acederApp = $auth->createPermission('acederApp');
        $acederApp->description = 'Login na app (API)';
        $auth->add($acederApp);

        //permissoes: colaborador
        $verCatalogo = $auth->createPermission('verCatalogo');
        $verCatalogo->description = 'Catalogo e calendario de disponibilidade';
        $auth->add($verCatalogo);

        $criarRequisicao = $auth->createPermission('criarRequisicao');
        $criarRequisicao->description = 'Submeter pedido (inclui sugestao de periodo)';
        $auth->add($criarRequisicao);

        //as permissoes [dono] usam a regra isRequisicaoOwner
        $verPropriaRequisicao = $auth->createPermission('verPropriaRequisicao');
        $verPropriaRequisicao->description = 'Ver os proprios pedidos e o detalhe';
        $verPropriaRequisicao->ruleName = $rule->name;
        $auth->add($verPropriaRequisicao);

        $cancelarRequisicao = $auth->createPermission('cancelarRequisicao');
        $cancelarRequisicao->description = 'Cancelar um pedido proprio pendente';
        $cancelarRequisicao->ruleName = $rule->name;
        $auth->add($cancelarRequisicao);

        $registarChecklist = $auth->createPermission('registarChecklist');
        $registarChecklist->description = 'Check-in/out, km, fotos, QR';
        $registarChecklist->ruleName = $rule->name;
        $auth->add($registarChecklist);

        $anexarFatura = $auth->createPermission('anexarFatura');
        $anexarFatura->description = 'Anexar fatura de combustivel';
        $anexarFatura->ruleName = $rule->name;
        $auth->add($anexarFatura);

        $enviarLocalizacao = $auth->createPermission('enviarLocalizacao');
        $enviarLocalizacao->description = 'Enviar localizacao em viagem';
        $enviarLocalizacao->ruleName = $rule->name;
        $auth->add($enviarLocalizacao);

        //permissoes: coordenador de frota
        $verRequisicao = $auth->createPermission('verRequisicao');
        $verRequisicao->description = 'Lista e detalhe de todas as requisicoes';
        $auth->add($verRequisicao);

        $aprovarRequisicao = $auth->createPermission('aprovarRequisicao');
        $aprovarRequisicao->description = 'Ver pendentes e aprovar';
        $auth->add($aprovarRequisicao);

        $recusarRequisicao = $auth->createPermission('recusarRequisicao');
        $recusarRequisicao->description = 'Recusar com motivo';
        $auth->add($recusarRequisicao);

        $atribuirViatura = $auth->createPermission('atribuirViatura');
        $atribuirViatura->description = 'Atribuir viatura e condutor';
        $auth->add($atribuirViatura);

        $assinalarRisco = $auth->createPermission('assinalarRisco');
        $assinalarRisco->description = 'Marcar risco nas fotos';
        $auth->add($assinalarRisco);

        $gerirViaturas = $auth->createPermission('gerirViaturas');
        $gerirViaturas->description = 'CRUD de viaturas e codigo QR';
        $auth->add($gerirViaturas);

        $gerirCondutores = $auth->createPermission('gerirCondutores');
        $gerirCondutores->description = 'CRUD de condutores';
        $auth->add($gerirCondutores);

        $gerirIndisponibilidades = $auth->createPermission('gerirIndisponibilidades');
        $gerirIndisponibilidades->description = 'Ferias e baixas dos condutores';
        $auth->add($gerirIndisponibilidades);

        $verCondutoresDisponiveis = $auth->createPermission('verCondutoresDisponiveis');
        $verCondutoresDisponiveis->description = 'Condutores livres num periodo';
        $auth->add($verCondutoresDisponiveis);

        $gerirDocumentos = $auth->createPermission('gerirDocumentos');
        $gerirDocumentos->description = 'Seguro, inspecao, IUC e documentos a expirar';
        $auth->add($gerirDocumentos);

        $configurarAlertas = $auth->createPermission('configurarAlertas');
        $configurarAlertas->description = 'Antecedencia dos alertas';
        $auth->add($configurarAlertas);

        $gerirOrcamentos = $auth->createPermission('gerirOrcamentos');
        $gerirOrcamentos->description = 'Criar, submeter e mudar estado de orcamentos';
        $auth->add($gerirOrcamentos);

        $verFaturas = $auth->createPermission('verFaturas');
        $verFaturas->description = 'Faturas de combustivel';
        $auth->add($verFaturas);

        $verDashboard = $auth->createPermission('verDashboard');
        $verDashboard->description = 'Ocupacao e viaturas paradas';
        $auth->add($verDashboard);

        $verTrilhaAprovacoes = $auth->createPermission('verTrilhaAprovacoes');
        $verTrilhaAprovacoes->description = 'Quem aprovou ou recusou cada pedido';
        $auth->add($verTrilhaAprovacoes);

        $verMapa = $auth->createPermission('verMapa');
        $verMapa->description = 'Mapa e rotas';
        $auth->add($verMapa);

        //permissoes: coordenador + tecnico
        $registarNecessidade = $auth->createPermission('registarNecessidade');
        $registarNecessidade->description = 'Necessidades de manutencao';
        $auth->add($registarNecessidade);

        //permissoes: tecnico de manutencao
        $registarManutencao = $auth->createPermission('registarManutencao');
        $registarManutencao->description = 'Registar intervencao, pecas e custos';
        $auth->add($registarManutencao);

        $editarManutencao = $auth->createPermission('editarManutencao');
        $editarManutencao->description = 'Editar pecas e custos';
        $auth->add($editarManutencao);

        $concluirManutencao = $auth->createPermission('concluirManutencao');
        $concluirManutencao->description = 'Concluir manutencao (viatura fica disponivel)';
        $auth->add($concluirManutencao);

        $verHistoricoManutencoes = $auth->createPermission('verHistoricoManutencoes');
        $verHistoricoManutencoes->description = 'Historico por viatura';
        $auth->add($verHistoricoManutencoes);

        //permissoes: administrador de sistemas
        $gerirUtilizadores = $auth->createPermission('gerirUtilizadores');
        $gerirUtilizadores->description = 'Criar, editar, desativar/reativar contas e atribuir role';
        $auth->add($gerirUtilizadores);

        $redefinirPassword = $auth->createPermission('redefinirPassword');
        $redefinirPassword->description = 'Enviar reset de palavra-passe';
        $auth->add($redefinirPassword);

        $gerirPermissoes = $auth->createPermission('gerirPermissoes');
        $gerirPermissoes->description = 'Permissoes por role';
        $auth->add($gerirPermissoes);

        $configurarParametros = $auth->createPermission('configurarParametros');
        $configurarParametros->description = 'Parametros do sistema';
        $auth->add($configurarParametros);

        $gerirServicosExternos = $auth->createPermission('gerirServicosExternos');
        $gerirServicosExternos->description = 'Google Calendar e FCM, testar ligacao';
        $auth->add($gerirServicosExternos);

        $verLogs = $auth->createPermission('verLogs');
        $verLogs->description = 'Logs de auditoria e erros';
        $auth->add($verLogs);

        $verEstadoSistema = $auth->createPermission('verEstadoSistema');
        $verEstadoSistema->description = 'Estado dos servicos';
        $auth->add($verEstadoSistema);

        //permissoes: comum
        $verNotificacoes = $auth->createPermission('verNotificacoes');
        $verNotificacoes->description = 'Proprias notificacoes';
        $auth->add($verNotificacoes);

        //roles e as permissoes de cada um (a tabela do PDF)
        //o administrador nao herda os outros roles
        $colaborador = $auth->createRole('colaborador');
        $auth->add($colaborador);
        $auth->addChild($colaborador, $acederFrontoffice);
        $auth->addChild($colaborador, $acederApp);
        $auth->addChild($colaborador, $verCatalogo);
        $auth->addChild($colaborador, $criarRequisicao);
        $auth->addChild($colaborador, $verPropriaRequisicao);
        $auth->addChild($colaborador, $cancelarRequisicao);
        $auth->addChild($colaborador, $registarChecklist);
        $auth->addChild($colaborador, $anexarFatura);
        $auth->addChild($colaborador, $enviarLocalizacao);
        $auth->addChild($colaborador, $verNotificacoes);

        $coordenador = $auth->createRole('coordenador');
        $auth->add($coordenador);
        $auth->addChild($coordenador, $acederBackoffice);
        $auth->addChild($coordenador, $acederApp);
        $auth->addChild($coordenador, $verRequisicao);
        $auth->addChild($coordenador, $aprovarRequisicao);
        $auth->addChild($coordenador, $recusarRequisicao);
        $auth->addChild($coordenador, $atribuirViatura);
        $auth->addChild($coordenador, $assinalarRisco);
        $auth->addChild($coordenador, $gerirViaturas);
        $auth->addChild($coordenador, $gerirCondutores);
        $auth->addChild($coordenador, $gerirIndisponibilidades);
        $auth->addChild($coordenador, $verCondutoresDisponiveis);
        $auth->addChild($coordenador, $gerirDocumentos);
        $auth->addChild($coordenador, $configurarAlertas);
        $auth->addChild($coordenador, $gerirOrcamentos);
        $auth->addChild($coordenador, $verFaturas);
        $auth->addChild($coordenador, $verDashboard);
        $auth->addChild($coordenador, $verTrilhaAprovacoes);
        $auth->addChild($coordenador, $verMapa);
        $auth->addChild($coordenador, $registarNecessidade);
        $auth->addChild($coordenador, $verNotificacoes);

        $tecnico = $auth->createRole('tecnico');
        $auth->add($tecnico);
        $auth->addChild($tecnico, $acederBackoffice);
        $auth->addChild($tecnico, $registarNecessidade);
        $auth->addChild($tecnico, $registarManutencao);
        $auth->addChild($tecnico, $editarManutencao);
        $auth->addChild($tecnico, $concluirManutencao);
        $auth->addChild($tecnico, $verHistoricoManutencoes);
        $auth->addChild($tecnico, $verNotificacoes);

        $administrador = $auth->createRole('administrador');
        $auth->add($administrador);
        $auth->addChild($administrador, $acederBackoffice);
        $auth->addChild($administrador, $acederApp);
        $auth->addChild($administrador, $gerirUtilizadores);
        $auth->addChild($administrador, $redefinirPassword);
        $auth->addChild($administrador, $gerirPermissoes);
        $auth->addChild($administrador, $configurarParametros);
        $auth->addChild($administrador, $gerirServicosExternos);
        $auth->addChild($administrador, $verLogs);
        $auth->addChild($administrador, $verEstadoSistema);
        $auth->addChild($administrador, $verNotificacoes);

        echo "RBAC criado: 4 roles e 39 permissoes.\n";
    }
}
