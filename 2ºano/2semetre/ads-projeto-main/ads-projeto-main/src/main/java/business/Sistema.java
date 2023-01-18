package business;

import java.time.LocalDate;
import java.time.LocalDateTime;
import java.util.Arrays;
import java.util.HashMap;
import java.util.Map;
import java.util.stream.Collectors;

public class Sistema {
    private final Map<Integer, Leilao> leiloes;
    private final Map<Integer, Utilizador> utilizadores;
    private Utilizador utilizadorAutenticado;

    public Sistema() {
        this.utilizadorAutenticado = null;

        this.leiloes = new HashMap<>();
        this.utilizadores = new HashMap<>();

        // TODO testing
        Utilizador lucas = new Utilizador("lucas@ads.pt", "lucas", "lucas", LocalDate.now().minusYears(19));
        this.utilizadores.put(lucas.getId(), lucas);


        Utilizador rubenBranco = new Utilizador("ruben@ads.pt", "ruben", "ruben", LocalDate.now().minusYears(30));
        this.utilizadores.put(rubenBranco.getId(), rubenBranco);

        Artigo artigo = new Artigo("Ventoinha JDU2B47ASD", "Ventoinha 250W super poderosa dyson nft modelo junho 2022");
        Leilao leilao = new Leilao("Ventoinha", artigo, Leilao.Tipo.MOBILIA, 500, LocalDateTime.of(2022, 7, 12, 20, 0, 0), rubenBranco);
        leilao.publicar();

        lucas.licita(leilao, 503);

        this.leiloes.put(leilao.getId(), leilao);
    }

    public boolean autenticaUtilizador(String nomeEmail, String senha) {
        Utilizador utilizador = null;
        for (Utilizador u : this.utilizadores.values()) {
            if (u.getNome().equals(nomeEmail) || u.getEmail().equals(nomeEmail)) {
                utilizador = u;
                break;
            }
        }

        if (utilizador == null)
            return false;

        boolean confirma = utilizador.confirmaSenha(senha);
        if (confirma)
            this.utilizadorAutenticado = utilizador;

        return confirma;
    }

    public Utilizador getUtilizadorAutenticado() {
        return this.utilizadorAutenticado;
    }

    public void terminaSessaoUtilizador() {
        this.utilizadorAutenticado = null;
    }

    public Leilao criarLeilao(String nome, Artigo artigo, Leilao.Tipo tipoLeilao, int baseLicitacao, LocalDateTime deadline) {
        Leilao leilao = new Leilao(nome, artigo, tipoLeilao, baseLicitacao, deadline, this.utilizadorAutenticado);
        this.leiloes.put(leilao.getId(), leilao);

        return leilao;
    }

    /**
     * @param email
     * @param nome
     * @param senha
     * @param dataNascimento
     * @return
     * @requires this.utilizadores não conter um utilizador com o mesmo email ou nome
     */
    public Utilizador criarUtilizador(String email, String nome, String senha, LocalDate dataNascimento) {
        Utilizador utilizador = new Utilizador(email, nome, senha, dataNascimento);

        this.utilizadores.put(utilizador.getId(), utilizador);
        this.utilizadorAutenticado = utilizador;

        return utilizador;
    }

    public Map<Integer, Leilao> leiloesDisponiveisComprador() {
        return this.leiloes.entrySet().stream()
                .filter(l -> l.getValue().getEstado().equals(Leilao.Estado.EM_CURSO))
                .filter(l -> !l.getValue().getVendedor().equals(this.utilizadorAutenticado))
                .collect(Collectors.toMap(Map.Entry::getKey, Map.Entry::getValue));
    }

    public Map<Integer, Leilao> leiloesGanhos() {
        return this.leiloes.entrySet().stream()
                .filter(l -> Arrays.asList(Leilao.Estado.FINALIZADO, Leilao.Estado.ARQUIVADO).contains(l.getValue().getEstado()))
                .filter(l -> l.getValue().ultimaLicitacao() != null)
                .filter(l -> l.getValue().ultimaLicitacao().getUtilizador().equals(this.utilizadorAutenticado))
                .collect(Collectors.toMap(Map.Entry::getKey, Map.Entry::getValue));
    }

    public Map<Integer, Leilao> leiloesVendedor() {
        return this.leiloes.entrySet().stream()
                .filter(l -> l.getValue().getVendedor().equals(this.utilizadorAutenticado))
                .collect(Collectors.toMap(Map.Entry::getKey, Map.Entry::getValue));
    }

    public void cancelarLeilao(Leilao leilao) {
        this.leiloes.remove(leilao.getId());
    }
}
