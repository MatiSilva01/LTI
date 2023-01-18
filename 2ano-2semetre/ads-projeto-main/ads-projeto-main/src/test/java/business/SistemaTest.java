package business;

import org.junit.Assert;
import org.junit.Before;
import org.junit.Test;

import java.time.LocalDate;
import java.time.LocalDateTime;

public class SistemaTest {
    private Sistema sistema;

    @Before
    public void setup() {
        this.sistema = new Sistema();

        // -----
        this.sistema.criarUtilizador("bruno@ads.pt", "bruno", "bruno", LocalDate.now().minusYears(30));
        this.sistema.autenticaUtilizador("bruno", "bruno");

        Artigo polestar = new Artigo("Polestar 2", "Carro não sei mas é fixe");
        this.sistema.criarLeilao("Carro amarelo!!", polestar, Leilao.Tipo.AUTOMOVEL, 53000, LocalDateTime.now().plusDays(30));
        Artigo tesla = new Artigo("Tesla elano muscano", "carro vrum vrum");
        this.sistema.criarLeilao("Tesla elano musk", tesla, Leilao.Tipo.AUTOMOVEL, 153000, LocalDateTime.now().plusMonths(3));
        Artigo ikea = new Artigo("IKEA MALM", "Movel top de gama ikea cada um monta em casa");
        this.sistema.criarLeilao("Movel ikea", ikea, Leilao.Tipo.MOBILIA, 169, LocalDateTime.now().plusMonths(3));

        // -----
        this.sistema.criarUtilizador("lucas@ads.pt", "lucas", "lucas", LocalDate.now().minusYears(19));
        this.sistema.autenticaUtilizador("lucas", "lucas");

        Artigo mc = new Artigo("McDonald's Big Tasty", "hamburger delicioso  o melhor deles todos");
        this.sistema.criarLeilao("Hamburger McDonald's", mc, Leilao.Tipo.COMIDA, 23, LocalDateTime.now().plusDays(7));
        Artigo bk = new Artigo("Burger King Steakhouse", "é bonzinho mas quando ha descontos o big king apetece mais");
        this.sistema.criarLeilao("HamBurger King", bk, Leilao.Tipo.COMIDA, 19, LocalDateTime.now().plusDays(2));
        Artigo pao = new Artigo("Pão com Molhos", "O MELHOR PÃO COM MUNDO TEM PÃO, QUEIJO, BIFE, MOSTARDA, KETCHUP, MAIONESE, TUDO TUDO E PICKLES!!!");
        this.sistema.criarLeilao("MELHOR PÃO", pao, Leilao.Tipo.COMIDA, 63218146, LocalDateTime.now().plusMonths(1));

        // -----
        this.sistema.criarUtilizador("matilde@ads.pt", "matilde", "matilde", LocalDate.now().minusYears(21));
        this.sistema.autenticaUtilizador("matilde", "matilde");

        Artigo maquina = new Artigo("SAMSUNG WW90TA026TE (9 kg - 1200 rpm - Rosa)", "you spin my head right round right round");
        this.sistema.criarLeilao("Máquina de Lavar Roupa", maquina, Leilao.Tipo.ELETRODOMESTICO, 420, LocalDateTime.now().plusDays(24));
        Artigo frigo = new Artigo("BECKEN BSBS8027 (No Frost - 177 cm - 529 L - Inox)", "faz um briolo la dentro!!!");
        this.sistema.criarLeilao("Frigorífico Americano", frigo, Leilao.Tipo.ELETRODOMESTICO, 650, LocalDateTime.now().plusWeeks(9));
        Artigo ketchup = new Artigo("Ketchup Heinz", "melhor substância");
        this.sistema.criarLeilao("Ketchup Leiria", ketchup, Leilao.Tipo.COMIDA, 29, LocalDateTime.now().plusWeeks(3));
    }

    @Test
    public void test_autenticaUtilizador() {
        Assert.assertTrue(this.sistema.autenticaUtilizador("matilde", "matilde"));
    }

    @Test
    public void test_getUtilizadorAutenticado() {
        Utilizador andre = this.sistema.criarUtilizador("andre@ads.pt", "andre", "andre", LocalDate.now().minusYears(23));

        Assert.assertEquals(this.sistema.getUtilizadorAutenticado(), andre);
    }

    @Test
    public void test_leiloesDisponiveisComprador() {
        this.sistema.autenticaUtilizador("bruno", "bruno");
        Artigo pao = new Artigo("Pão com Molhos", "O MELHOR PÃO COM MUNDO TEM PÃO, QUEIJO, BIFE, MOSTARDA, KETCHUP, MAIONESE, TUDO TUDO E PICKLES!!!");
        Leilao leilao = this.sistema.criarLeilao("Pão com Molhos", pao, Leilao.Tipo.COMIDA, 63218146, LocalDateTime.now().plusMonths(1));
        leilao.publicar();

        this.sistema.autenticaUtilizador("lucas", "lucas");

        Assert.assertTrue(this.sistema.leiloesDisponiveisComprador().containsValue(leilao));
    }

    @Test
    public void test_leiloesGanhos() {
        this.sistema.autenticaUtilizador("lucas", "lucas");
        Artigo chaves = new Artigo("Chaves", "canivete suiço");
        Leilao leilao = this.sistema.criarLeilao("Chave de Fendas do Larman", chaves, Leilao.Tipo.FERRAMENTA, 30, LocalDateTime.now().plusMonths(2));
        leilao.publicar();

        Utilizador antonio = this.sistema.criarUtilizador("antonio@ads.pt", "antonio", "antonio", LocalDate.now().minusYears(59));
        antonio.licita(leilao, 80);

        leilao.finalizar();

        Assert.assertTrue(this.sistema.leiloesGanhos().containsValue(leilao));
    }

    @Test
    public void test_leiloesVendedor() {
        this.sistema.autenticaUtilizador("matilde", "matilde");
        Artigo bolacha = new Artigo("Oreo", "oreo amarela do larman");
        Leilao leilao = this.sistema.criarLeilao("Bolacha do Larman", bolacha, Leilao.Tipo.COMIDA, 30, LocalDateTime.now().plusMonths(3));

        Assert.assertTrue(this.sistema.leiloesVendedor().containsValue(leilao));
    }

}
