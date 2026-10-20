package com.example.frotagest.ui.coordenador;

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

public class PedidosCoordFragment extends Fragment {

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_pedidos_coord, container, false);
        TopBar.configurar(view, getString(R.string.coord_titulo), "Coordenador de Frota · Rui Matos");
        Exemplo.mostrar(view, R.id.tv_badge_notificacoes, "3");

        // Exemplo: 3 pedidos pendentes (substituir pelos dados da API)
        ListView lvPedidos = view.findViewById(R.id.lv_pedidos);
        lvPedidos.setAdapter(new Exemplo.Adaptador(requireContext(),
                R.layout.item_pedido_coord, 3, PedidoCoordActivity.class));
        return view;
    }
}
