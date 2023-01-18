package business;


import org.junit.Assert;
import org.junit.Before;
import org.junit.Test;

public class ArtigoTest {
    private Artigo artigo;

    @Before
    public void setup() {
        this.artigo = new Artigo("Pipoca do Larman", "Pipoca doce e salgada do Larman só as melhores aqui ui ui ui !!");
    }

    @Test
    public void test_getNome() {
        Assert.assertEquals(this.artigo.getNome(), "Pipoca do Larman");
    }

    @Test
    public void test_getDescricao() {
        Assert.assertEquals(this.artigo.getDescricao(), "Pipoca doce e salgada do Larman só as melhores aqui ui ui ui !!");
    }
}