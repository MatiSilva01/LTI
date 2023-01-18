package business;


import org.junit.Assert;
import org.junit.Before;
import org.junit.Test;

import java.time.LocalDate;
import java.time.LocalDateTime;

public class LicitacaoTest {
    private Leilao leilao;
    private Licitacao licitacao;
    private Utilizador utilizador;

    @Before
    public void setup() {
        this.utilizador = new Utilizador("larman@ads.pt", "larman", "larman", LocalDate.of(1958, 1, 1));

        Artigo artigo = new Artigo("Batata Frita", "Batata frita pala pala");
        this.leilao = new Leilao("Batata Frita do Larman", artigo, Leilao.Tipo.COMIDA, 500, LocalDateTime.now().plusMonths(2), this.utilizador);
        this.leilao.publicar();

        this.licitacao = this.leilao.licitar(this.utilizador, 509);

    }

    @Test
    public void test_getLeilao() {
        Assert.assertEquals(this.licitacao.getLeilao(), this.leilao);
    }

    @Test
    public void test_getUtilizador() {
        Assert.assertEquals(this.licitacao.getUtilizador(), this.utilizador);
    }

    @Test
    public void test_getValor() {
        Assert.assertEquals(this.licitacao.getValor(), 509);
    }
}