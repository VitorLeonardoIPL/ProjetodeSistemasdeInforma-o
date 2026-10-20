package com.example.frotagest.ui.colaborador;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.example.frotagest.R;
import com.example.frotagest.ui.comum.Exemplo;
import com.example.frotagest.ui.comum.TopBar;

public class RequisicoesFragment extends Fragment {

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_requisicoes, container, false);
        TopBar.configurar(view, getString(R.string.req_titulo), null);
        Exemplo.mostrar(view, R.id.tv_badge_notificacoes, "2");

        // Exemplo: 4 requisições (substituir pelos dados da API)
        ListView lvRequisicoes = view.findViewById(R.id.lv_requisicoes);
        lvRequisicoes.setAdapter(new Exemplo.Adaptador(requireContext(),
                R.layout.item_requisicao, 4, RequisicaoDetalheActivity.class));

        view.findViewById(R.id.fab_novo_pedido).setOnClickListener(v ->
                startActivity(new Intent(requireContext(), NovoPedidoActivity.class)));
        return view;
    }
}
