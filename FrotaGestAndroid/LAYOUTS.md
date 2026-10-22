# FrotaGest · Layouts da app Android (AMSI)

Layouts XML de todos os ecrãs da app móvel, feitos a partir dos mockups
(`mockups-png/app-movel`) e do enunciado de AMSI 2026/27. Só usam as bibliotecas
que o projeto já tinha (`appcompat`, `material`, `constraintlayout`): nenhuma
dependência nova no `build.gradle.kts`.

- Listas principais em **ListView** (para um adaptador `BaseAdapter`), com o espaço
  entre cartões dado por `android:dividerHeight`.
- Listas pequenas dentro de ecrãs com scroll (faturas, serviços, condutores) são um
  `LinearLayout` vazio onde o código acrescenta os itens (`inflate(item, container, false)`).
- Ecrãs de detalhe com `android:fitsSystemWindows="true"` por causa do edge-to-edge
  (targetSdk 37). O `activity_main` mantém o id `main` usado em `MainActivity`.
- O espaço do mapa é um `FrameLayout` (`map_container`); a biblioteca de mapas fica por escolher.

## Ecrãs → layouts

| Mockup | Layout | Tipo | Perfil |
|---|---|---|---|
| 01 M-Login | `activity_login` | Activity | todos |
| — (contentor + barra inferior) | `activity_main` | Activity | todos |
| 02 M-Requisicoes | `fragment_requisicoes` + `item_requisicao` | Fragment (Pedidos) | Colaborador |
| 03 M-NovoPedido | `activity_novo_pedido` | Activity (botão flutuante) | Colaborador |
| 04 M-Detalhe | `activity_requisicao_detalhe` | Activity | Colaborador |
| 05 M-Checklist | `activity_checklist` + `view_foto_slot` | Activity | Colaborador |
| 06 M-Viagem | `fragment_viagem` + `item_fatura` | Fragment (Viagem) | Colaborador |
| 07 M-NotifColab / 09 M-Notificacao | `activity_notificacoes` + `item_notificacao` + `item_notificacao_seccao` | Activity (sino) | Colaborador, Coordenador |
| 08 M-PedidosCoord | `fragment_pedidos_coord` + `item_pedido_coord` | Fragment (Pedidos) | Coordenador |
| 10 M-PedidoCoord | `activity_pedido_coord` | Activity | Coordenador |
| 11 M-CondutoresDisp | `activity_condutores_disponiveis` + `item_condutor` | Activity | Coordenador |
| 12 M-Mapa | `fragment_mapa` + `view_map_pin` | Fragment (Mapa) | Coordenador |
| 13 M-Perfil | `fragment_perfil` | Fragment (Perfil) | todos |
| — (enunciado AMSI) | `activity_configuracao` | Activity (engrenagem no Login, "Servidor da API" no Perfil) | todos |
| 14 M-AdminSistema | `fragment_admin_sistema` + `item_servico_estado` + `item_notificacao_sistema` | Fragment (Sistema) | Administrador |

Cabeçalhos reutilizáveis (via `<include>`):
- `layout_top_bar` — título, subtítulo, etiqueta de estado opcional e **sino de notificações** com contador (ecrãs com barra inferior).
- `layout_top_bar_back` — seta de voltar, título, subtítulo e, à direita, etiqueta de estado ou ação de texto (ex.: "Marcar lidas").

Barra inferior por perfil (sem ações repetidas):
- Colaborador `menu_bottom_colaborador`: Pedidos · Viagem · Perfil
- Coordenador `menu_bottom_coordenador`: Pedidos · Mapa · Perfil
- Administrador `menu_bottom_admin`: Sistema · Perfil

"Novo pedido" existe só no botão flutuante de `fragment_requisicoes`.

## Requisitos do enunciado de AMSI que afetam a interface

- **Menu de configuração do servidor da API** (obrigatório): `activity_configuracao`, guardado em SharedPreferences.
- **6 a 10 atividades (máximo recomendado)**: o desenho atual tem 9 Activities + 6 Fragments.
- **Algumas funcionalidades em Fragments**: os separadores da barra inferior.
- **Ecrãs dinâmicos com dados do webservice**: as listas (ListView) de requisições, pedidos, notificações e condutores.
- **Master/detail**: requisições → detalhe; pedidos → pedido do coordenador.
- **Volley, SQLite e SharedPreferences** são obrigatórios na lógica (próximo passo), não nos layouts.

## Recursos

- `values/colors.xml` — paleta dos mockups (`fg_primary #2457D6`, `fg_ink #0F172A`, estados…)
- `values/themes.xml` — `Theme.FrotaGest` (Material3 Light) com estilos por omissão para botões, campos, cartões, barra inferior e interruptor
- `values/styles.xml` — tipografia (`TextAppearance.FrotaGest.*`), botões (`Widget.FrotaGest.Button[.Outlined|.Danger|.DangerFilled|.Text|.Toggle|.Segment|.Tab]`), chips de filtro, cartões, etiquetas de estado (`Widget.FrotaGest.Status.Aprovada|Pendente|Recusada|Disponivel|Neutro`)
- `values/strings.xml` — todos os textos fixos em PT-PT; os dados de exemplo dos mockups estão só em `tools:text` (aparecem na pré-visualização, não na app)
- `drawable/` — ícones vetoriais (traço 2 px), logótipo, fundos das etiquetas e do mapa
- `color/` — seletores de estado (chips, barra inferior, toggles, botões desativados)

## Etiquetas de estado

| Estado | Estilo |
|---|---|
| Aprovada, Em curso, "N livres", OK | `Widget.FrotaGest.Status.Aprovada` |
| Pendente | `Widget.FrotaGest.Status.Pendente` |
| Recusada, Sem viaturas, Falha | `Widget.FrotaGest.Status.Recusada` |
| Disponível | `Widget.FrotaGest.Status.Disponivel` |

Em código, trocar com `TextViewCompat.setTextAppearance` + `setBackgroundResource(R.drawable.bg_status_…)`.

## Navegação provisória (para ver os ecrãs a correr)

- A app abre no `LoginActivity`. O botão **Entrar** ainda não fala com a API:
  escolhe o perfil pelo email (com `coord` → Coordenador, com `admin` → Administrador,
  qualquer outro → Colaborador) e abre o `MainActivity` com a barra inferior desse perfil.
- Todos os ecrãs aparecem completos com **dados de exemplo** (os textos de exemplo estão
  nos próprios layouts e as listas usam `ui/comum/Exemplo.java`, que repete o item N vezes).
  Quando a API (Volley) estiver pronta, troca-se `Exemplo` por adaptadores com os dados reais.
- Ligações já feitas: requisição → Detalhe → Checklist, pedido → Pedido do coordenador
  (Recusar troca para o modo recusa) → Condutores disponíveis, sino → Notificações, "+ Novo pedido" → Novo pedido,
  "Entregar viatura" → Checklist, engrenagem do Login e "Servidor da API" → Configuração,
  "Terminar sessão" → Login.
