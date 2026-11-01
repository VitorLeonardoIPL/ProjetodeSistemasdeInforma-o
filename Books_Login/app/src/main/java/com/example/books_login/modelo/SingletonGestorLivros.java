package com.example.books_login.modelo;

import com.example.books_login.R;

import java.util.ArrayList;

public class SingletonGestorLivros {

    private ArrayList<Livro> livros;
    private static  SingletonGestorLivros instance;

    //Garante uma unica instancia
    //synchoronized: para ser thread safe (conceito de prg assincrona)

    public static synchronized SingletonGestorLivros getInstance(){
        if(instance==null)
            instance=new SingletonGestorLivros();
        return  instance;
    }

    //Como o construtor é private, não posso fazer o new fora desta classe

    //Estou a criar dados Dumy - instaciar Livros com l
    private SingletonGestorLivros(){
        livros = new ArrayList<>();
        Livro l=new Livro(1, 2019, R.drawable.programarandroid2, "Programar em android", "Segunda tempoerada", "AMSI");
        livros.add(l);
    }

    // Em vez de devolver os livros, envio uma copia
    // Assim não posso eliminar nem alterar os livros fora desta classe
    public ArrayList<Livro> getLivros() {
        return new ArrayList<>(livros);
    }
}
