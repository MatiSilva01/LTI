package business;


import java.time.LocalDateTime;

public class Licitacao {
    private final Leilao leilao;
    private final Utilizador utilizador;
    private final int valor;
    private final LocalDateTime timestamp;

    public Licitacao(Leilao leilao, Utilizador utilizador, int valor) {
        this.leilao = leilao;
        this.utilizador = utilizador;
        this.valor = valor;
        this.timestamp = LocalDateTime.now();
    }

    //-------------------Return Variáveis-------------------

    /**
     * Retorna o leilao a licitar
     *
     * @return leilao
     */
    public Leilao getLeilao() {
        return this.leilao;
    }

    /**
     * Retorna o cliente que faz a licitacao
     *
     * @return cliente
     */
    public Utilizador getUtilizador() {
        return this.utilizador;
    }

    /**
     * Retorna o valor da licitacao
     *
     * @return valor
     */
    public int getValor() {
        return this.valor;
    }

    public LocalDateTime getTimestamp() {
        return this.timestamp;
    }

    @Override
    public String toString() {
        return this.getUtilizador() + " - " +
                this.getValor() + "EUR " +
                "(" + this.getTimestamp() + ")";
    }
}