package business;


import org.junit.Assert;
import org.junit.Before;
import org.junit.Test;

import java.time.LocalDate;
import java.time.LocalDateTime;
import java.util.List;

public class LeilaoTest {
    private Leilao leilao;
    private Utilizador utilizador;
    private Artigo artigo;
    private List<Licitacao> licitacoes;

    @Before
    public void setup() {
        Utilizador matilde = new Utilizador("matilde@ads.pt", "matilde", "matilde", LocalDate.now().minusYears(21));
        Utilizador lucas = new Utilizador("lucas@ads.pt", "lucas", "lucas", LocalDate.now().minusYears(19));
        Utilizador bruno = new Utilizador("bruno@ads.pt", "bruno", "bruno", LocalDate.now().minusYears(23));
        Utilizador ruben = new Utilizador("ruben@ads.pt", "ruben", "ruben", LocalDate.now().minusYears(30));

        this.utilizador = new Utilizador("larman@ads.pt", "larman", "larman", LocalDate.of(1958, 1, 1));

        this.artigo = new Artigo("Batata Pala Pala do Larman", "Melhor batata frita do mundo e de origem portuguesa. Esta batata esteve a 3 centímetros da boca do larman, mas este foi intercetado antes de a devorar por um cão chamado Twix. Ao que a CM apurou, a batata caiu na mesa e foi depois encontrada pela PJ numa busca por pensarem que larman usava o unified process para libertar o mal pelas crianças.");
        this.leilao = new Leilao("Frita do Larman", this.artigo, Leilao.Tipo.COMIDA, 500, LocalDateTime.now().plusMonths(2), this.utilizador);
        this.leilao.publicar();

        this.licitacoes.set(0, this.leilao.licitar(bruno, 502));
        this.licitacoes.set(0, this.leilao.licitar(lucas, 510));
        this.licitacoes.set(0, this.leilao.licitar(ruben, 680));
        this.licitacoes.set(0, this.leilao.licitar(matilde, 682));
        this.licitacoes.set(0, this.leilao.licitar(bruno, 687));
        this.licitacoes.set(0, this.leilao.licitar(this.utilizador, 700));


    }

    @Test
    public void test_getNome() {
        Assert.assertEquals(this.leilao.getNome(), "Frita do Larman");
    }

    @Test
    public void test_setNome() {
        this.leilao.setNome("Hamburger do Larman");
        Assert.assertEquals(this.leilao.getNome(), "Hamburger do Larman");
    }

    @Test
    public void test_getArtigo() {
        Assert.assertEquals(this.leilao.getArtigo(), this.artigo);
    }

    @Test
    public void test_getBaseLicitacao() {
        Assert.assertEquals(this.leilao.getBaseLicitacao(), 500);
    }

    @Test
    public void test_setBaseLicitacao() {
        this.leilao.setBaseLicitacao(1);
        Assert.assertEquals(this.leilao.getBaseLicitacao(), 1);
    }

    @Test
    public void test_ultimaLicitacao() {
        Licitacao licitacao = this.leilao.licitar(this.utilizador, 700);
        Assert.assertEquals(this.leilao.ultimaLicitacao(), licitacao);
    }

    @Test
    public void test_ultimaInteracao() {
        Licitacao licitacao = this.leilao.licitar(this.utilizador, 701);
        Assert.assertEquals(this.leilao.ultimaInteracao(), licitacao.getTimestamp());
    }

    @Test
    public void test_licitacoesOrdenadas() {
        Assert.assertArrayEquals(this.leilao.licitacoesOrdenadas().toArray(new Licitacao[0]), this.licitacoes.toArray(new Licitacao[0]));
    }

    @Test
    public void test_getEstado() {
        Assert.assertEquals(this.leilao.getEstado(), Leilao.Estado.EM_CURSO);
    }

    @Test
    public void test_arquivar() {
        this.leilao.arquivar();
        Assert.assertEquals(this.leilao.getEstado(), Leilao.Estado.ARQUIVADO);
    }


    @Test
    public void test_finalizar() {
        this.leilao.finalizar();
        Assert.assertEquals(this.leilao.getEstado(), Leilao.Estado.FINALIZADO);
    }


    @Test
    public void test_publicar() {
        this.leilao.publicar();
        Assert.assertEquals(this.leilao.getEstado(), Leilao.Estado.EM_CURSO);
    }

    @Test
    public void test_getTipoLeilao() {
        Assert.assertEquals(this.leilao.getTipoLeilao(), Leilao.Tipo.COMIDA);
    }

    @Test
    public void test_setTipoLeilao() {
        this.leilao.setTipoLeilao(Leilao.Tipo.ELETRODOMESTICO);
        Assert.assertEquals(this.leilao.getTipoLeilao(), Leilao.Tipo.ELETRODOMESTICO);
    }

    @Test
    public void test_licitar() {
        Licitacao licitacao = this.leilao.licitar(this.utilizador, 900);
        Assert.assertEquals(this.leilao.ultimaLicitacao(), licitacao);
    }

    @Test
    public void test_getVendedor() {
        Assert.assertEquals(this.leilao.getVendedor(), this.utilizador);
    }

    @Test
    public void test_getVencedor() {
        Assert.assertEquals(this.leilao.getVencedor(), this.utilizador);
    }

    @Test
    public void test_getValor() {
        Assert.assertEquals(this.leilao.getValor(), 700);
    }

    @Test
    public void test_toString() {
        Assert.assertEquals(this.leilao.toString(), "Batata Frita do Larman (COMIDA) 700EUR Acaba: " + this.leilao.getDeadline() + " Vendedor: larman");
    }


}