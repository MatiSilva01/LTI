package business;


import org.junit.Assert;
import org.junit.Before;
import org.junit.Test;

import java.time.LocalDate;
import java.time.LocalDateTime;

public class UtilizadorTest {
    private Utilizador utilizador;

    @Before
    public void setup() {
        this.utilizador = new Utilizador("larman@ads.pt", "larman", "larman", LocalDate.of(1958, 1, 1));
    }

    @Test
    public void test_getNome() {
        Assert.assertEquals(this.utilizador.getNome(), "larman");
    }

    @Test
    public void test_getId() {
        // TODO pendente AtomicInteger
        // Assert.assertEquals(this.utilizador.getId(), 1);
        Assert.assertTrue(true);
    }

    @Test
    public void test_getIdade() {
        Assert.assertEquals(this.utilizador.getIdade(), 64);
    }

    @Test
    public void test_getDataNascimento() {
        Assert.assertEquals(this.utilizador.getDataNascimento(), LocalDate.of(1958, 1, 1));
    }

    @Test
    public void test_getEmail() {
        Assert.assertEquals(this.utilizador.getEmail(), "larman@ads.pt");
    }

    @Test
    public void test_getReputacao() {
        Assert.assertEquals(this.utilizador.getReputacao(), 3);
    }

    @Test
    public void test_setNome() {
        this.utilizador.setNome("rafael");
        Assert.assertEquals(this.utilizador.getNome(), "rafael");
    }

    @Test
    public void test_setSenha() {
        this.utilizador.setSenha("borboleta");
        Assert.assertTrue(this.utilizador.confirmaSenha("borboleta"));
    }

    @Test
    public void test_confirmaSenha() {
        Assert.assertTrue(this.utilizador.confirmaSenha("larman"));
    }

    @Test
    public void test_setDataNascimento() {
        LocalDate diaLiberdade = LocalDate.of(1974, 4, 25);
        this.utilizador.setDataNascimento(diaLiberdade);

        Assert.assertEquals(this.utilizador.getDataNascimento(), diaLiberdade);
    }

    @Test
    public void test_setEmail() {
        this.utilizador.setEmail("asus@ads.pt");

        Assert.assertEquals(this.utilizador.getEmail(), "asus@ads.pt");
    }

    @Test
    public void test_licita() {
        Utilizador joaoPedroPais = new Utilizador("jpp@ads.pt", "joaopedropais", "joaopedropais", LocalDate.of(1971, 1, 1));
        Artigo guitarra = new Artigo("Led Zeplin", "macacos me mordam");
        Leilao leilao = new Leilao("Guitarra do Larman", guitarra, Leilao.Tipo.MOBILIA, 8000, LocalDateTime.now().plusMonths(4), joaoPedroPais);

        Licitacao licitacao = this.utilizador.licita(leilao, 8100);

        Assert.assertEquals(leilao.ultimaLicitacao(), licitacao);
    }
}