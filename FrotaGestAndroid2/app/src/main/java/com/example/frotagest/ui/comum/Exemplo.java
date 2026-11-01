package com.example.frotagest.ui.comum;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.BaseAdapter;
import android.widget.TextView;

/**
 * Dados de exemplo para ver os ecrãs completos antes de existir a ligação à API.
 * Os itens mostram o texto de exemplo definido nos próprios layouts.
 * Quando a API (Volley) estiver pronta, estes métodos são substituídos por adaptadores reais.
 */
public final class Exemplo {

    private Exemplo() {
    }

    /** Adaptador que repete um layout de item N vezes (para ListView). */
    public static class Adaptador extends BaseAdapter {

        private final Context context;
        private final int layoutItem;
        private final int quantidade;
        private final Class<? extends Activity> destino;

        public Adaptador(Context context, int layoutItem, int quantidade,
                         Class<? extends Activity> destino) {
            this.context = context;
            this.layoutItem = layoutItem;
            this.quantidade = quantidade;
            this.destino = destino;
        }

        @Override
        public int getCount() {
            return quantidade;
        }

        @Override
        public Object getItem(int position) {
            return null;
        }

        @Override
        public long getItemId(int position) {
            return position;
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {
            View view = convertView;
            if (view == null) {
                view = LayoutInflater.from(context).inflate(layoutItem, parent, false);
            }
            if (destino != null) {
                view.setOnClickListener(v -> context.startActivity(new Intent(context, destino)));
            }
            return view;
        }
    }

    /** Acrescenta N cópias de um layout de item a um LinearLayout. */
    public static void preencher(ViewGroup contentor, int layoutItem, int quantidade) {
        LayoutInflater inflater = LayoutInflater.from(contentor.getContext());
        contentor.removeAllViews();
        for (int i = 0; i < quantidade; i++) {
            contentor.addView(inflater.inflate(layoutItem, contentor, false));
        }
    }

    /** Opções de uma caixa de seleção (AutoCompleteTextView do Material). */
    public static void opcoes(AutoCompleteTextView campo, String... valores) {
        campo.setAdapter(new ArrayAdapter<>(campo.getContext(),
                android.R.layout.simple_list_item_1, valores));
    }

    /** Mostra um texto que no layout está escondido (visibility="gone"). */
    public static void mostrar(View raiz, int id, String texto) {
        TextView tv = raiz.findViewById(id);
        if (texto != null) {
            tv.setText(texto);
        }
        tv.setVisibility(View.VISIBLE);
    }
}
