package com.example.frotagest.ui.coordenador;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.example.frotagest.R;
import com.example.frotagest.ui.comum.Exemplo;
import com.example.frotagest.ui.comum.TopBar;

public class MapaFragment extends Fragment {

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_mapa, container, false);
        TopBar.configurar(view, getString(R.string.mapa_titulo), "3 viaturas em utilização");
        Exemplo.mostrar(view, R.id.tv_badge_notificacoes, "3");
        view.findViewById(R.id.card_viatura).setVisibility(View.VISIBLE);
        view.findViewById(R.id.tv_ver_requisicao).setOnClickListener(v ->
                startActivity(new Intent(requireContext(), PedidoCoordActivity.class)));
        return view;
    }
}
