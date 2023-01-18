package business;

public class Artigo {
    private final String nome;
    private final String descricao;

    public Artigo(String nome, String descricao) {
        this.nome = nome;
        this.descricao = descricao;
    }

    /**
     * Retorna a descricao do artigo a leiloar
     *
     * @return descricao
     */
    public String getDescricao() {
        return this.descricao;
    }

    /**
     * Retorna o nome do artigo a leiloar
     *
     * @return nome
     */
    public String getNome() {
        return this.nome;
    }
}
