package business;

import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.Collections;
import java.util.List;
import java.util.concurrent.atomic.AtomicInteger;
import java.util.stream.Collectors;

public class Leilao {
    private static final AtomicInteger contador = new AtomicInteger(0);
    private final int id;
    private final Utilizador vendedor;
    private final ArrayList<Licitacao> licitacoes;
    private final LocalDateTime timestamp;
    private final Artigo artigo;
    private String nome;
    private int baseLicitacao;
    private Tipo tipoLeilao;
    private Estado estado;
    private LocalDateTime deadline;


    public Leilao(String nome, Artigo artigo, Tipo tipoLeilao, int baseLicitacao, LocalDateTime deadline, Utilizador vendedor) {
        this.id = contador.incrementAndGet();
        this.nome = nome;
        this.artigo = artigo;
        this.tipoLeilao = tipoLeilao;
        this.baseLicitacao = baseLicitacao;
        this.deadline = deadline;
        this.estado = Estado.PENDENTE;
        this.vendedor = vendedor;
        // Não percebo pq não passa nos testes, this.licitações só é atribuido aqui e não é com valor null
        this.licitacoes = new ArrayList<>();
        this.timestamp = LocalDateTime.now();
    }

    /**
     * Retorna o id do leilao
     *
     * @return id
     */
    public int getId() {
        return this.id;
    }

    /**
     * Retorna o nome do leilao
     *
     * @return nome
     */
    public String getNome() {
        return this.nome;
    }

    /**
     * Define nome do leilao
     *
     * @param nome - o nome do leilao
     */
    public void setNome(String nome) {
        this.nome = nome;
    }

    //------------------------------------------------------
    
    /**
     * Retorna artigo
     *
     * @return artigo
     */
    public Artigo getArtigo() {
        return this.artigo;
    }


    //-------------------Return Variáveis-------------------

    /**
     * Retorna o valor base de licitacao do leilao
     *
     * @return o valor base
     */
    public int getBaseLicitacao() {
        return this.baseLicitacao;
    }

    /**
     * Define o valor minimo de licitacao do leilão
     *
     * @baseLicitacao - o valor
     */
    public void setBaseLicitacao(int baseLicitacao) {
        this.baseLicitacao = baseLicitacao;
    }

    /**
     * Retorna a maior licitacao do leilao até ao momento
     *
     * @return licitacao maior
     */
    public Licitacao ultimaLicitacao() {
        int size = this.licitacoes.size();
        if (size == 0) return null;

        return this.licitacoes.get(size - 1);
    }

    public LocalDateTime ultimaInteracao() {
        Licitacao ultimaLicitacao = this.ultimaLicitacao();

        if (ultimaLicitacao == null) return this.timestamp;

        return ultimaLicitacao.getTimestamp();
    }

    public List<Licitacao> licitacoesOrdenadas() {
        return this.licitacoes.stream()
                .sorted(Collections.reverseOrder())
                .collect(Collectors.toList());
    }

    /**
     * Retorna o estado do leilao
     *
     * @return Estado do leilão
     */
    public Estado getEstado() {
        return this.estado;
    }
    
    /**
     * Altera o estado do leilao para 'ARQUIVADO'
     *
     */

    public void arquivar() {
        this.estado = Estado.ARQUIVADO;
    }
    
    /**
     * Altera o estado do leilao para 'FINALIZADO'
     *
     */

    public void finalizar() {
        this.estado = Estado.FINALIZADO;
    }
    
    /**
     * Altera o estado do leilao para 'EM_CURSO'
     *
     */

    public void publicar() {
        this.estado = Estado.EM_CURSO;
    }


    /**
     * Retorna o tipo de leilao
     *
     * @return Tipo do leilão
     */
    public Tipo getTipoLeilao() {
        return this.tipoLeilao;
    }

    /**
     * Define o tipo de leilao
     *
     * @param tipoLeilao Novo tipo do leilão
     */
    public void setTipoLeilao(Tipo tipoLeilao) {
        this.tipoLeilao = tipoLeilao;
    }

    /**
     * Faz uma licitação
     *
     * @requires licitacao.getValor() >= this.baseLicitacao && licitacao.getValor() > this.getMaiorLicitacao().getValor()
     */
    public Licitacao licitar(Utilizador utilizador, int valor) {
        // TODO programacao por contrato
        // Licitacao ultima = this.ultimaLicitacao();
        // if (ultima != null && (valor < this.baseLicitacao || valor <= ultima.getValor() || utilizador.equals(ultima.getUtilizador())))
        //      return;
        Licitacao licitacao = new Licitacao(this, utilizador, valor);
        this.licitacoes.add(licitacao);

        return licitacao;
    }

    public LocalDateTime getDeadline() {
        return this.deadline;
    }

    //-------------------Funções-------------------

    /**
     * Altera o tempo do leilao
     *
     * @param deadline - a nova data do leilao
     */
    public void setDeadline(LocalDateTime deadline) {
        this.deadline = deadline;
    }

    /**
     * Retorna o utilizador que criou o leilao
     * @return o vendedor do leilao
     */
    public Utilizador getVendedor() {
        return this.vendedor;
    }

    /**
     * @return
     * @requires this.getMaiorLicitacao() != null
     */
    public Utilizador getVencedor() {
        return this.ultimaLicitacao().getUtilizador();
    }

    public int getValor() {
        int valor = this.baseLicitacao;

        Licitacao maiorLicitacao = this.ultimaLicitacao();
        if (maiorLicitacao != null) valor = maiorLicitacao.getValor();

        return valor;
    }

    @Override
    public String toString() {
        return this.getNome() + " - " + this.getArtigo().getNome() + " (" + this.tipoLeilao + ") " + this.getValor() + "EUR " + "Acaba: " + this.deadline.toString() + " Vendedor: " + this.vendedor.getNome() + " [" + this.estado + "]";
    }

    public enum Tipo {
        MOBILIA, AUTOMOVEL, ELETRODOMESTICO, COMIDA, FERRAMENTA, ARTE, COLECIONAVEL, OUTRO
    }

    public enum Estado {
        PENDENTE, EM_CURSO, FINALIZADO, ARQUIVADO
    }
}
