package business;

import java.time.LocalDate;
import java.time.Period;
import java.util.ArrayList;
import java.util.concurrent.atomic.AtomicInteger;

public class Utilizador {
    private static final AtomicInteger contador = new AtomicInteger(0);
    private final int id;
    public String nome;
    private String senha;
    private LocalDate dataNascimento;
    private String email;
    private float reputacao;
    private ArrayList<Float> formsReputacao;
    private int saldo;

    public Utilizador(String email, String nome, String senha, LocalDate dataNascimento) {
        this.id = contador.incrementAndGet();
        this.email = email;
        this.nome = nome;
        this.senha = senha;
        this.dataNascimento = dataNascimento;
        this.reputacao = -1;
    }

    /**
     * Retorna o nome do utilizador
     *
     * @return nome
     */
    public String getNome() {
        return this.nome;
    }

    /**
     * Define o nome do utilizador
     *
     * @param nome
     */
    public void setNome(String nome) {
        this.nome = nome;
    }

    public boolean eVendedor(Leilao leilao) {
        return leilao.getVendedor().equals(this);
    }

    public boolean podeLicitar(Leilao leilao) {
        Licitacao ultimaLicitacao = leilao.ultimaLicitacao();

        return !this.eVendedor(leilao) && (ultimaLicitacao == null || !ultimaLicitacao.getUtilizador().equals(this));
    }
    
    /**
     * Retorna o id do utilizador
     *
     * @return id
     */
    public int getId() {
        return this.id;
    }

    /**
     * Retorna a idade do utilizador
     *
     * @return idade
     */
    public int getIdade() {
        return Period.between(LocalDate.from(this.dataNascimento), LocalDate.now()).getYears();
    }

    /**
     * Retorna a data de nascimento do utilizador
     *
     * @return data de nascimento
     */
    public LocalDate getDataNascimento() {
        return this.dataNascimento;
    }

    /**
     * Define a data de nascimento do utilizador
     *
     * @param dataNascimento
     */
    public void setDataNascimento(LocalDate dataNascimento) {
        this.dataNascimento = dataNascimento;
    }

    /**
     * Retorna o email do utilizador
     *
     * @return email
     */
    public String getEmail() {
        return this.email;
    }

    /**
     * Define o email do utilizador
     *
     * @param email
     */
    public void setEmail(String email) {
        this.email = email;
    }

    /**
     * Retorna a reputacao do utilizador
     *
     * @return reputacao
     */
    public float getReputacao() {
        return this.reputacao;
    }

    /**
     * Retorna o saldo do utilizador
     * 
     * @return saldo
     */
    public int getSaldo() {
    	return this.saldo;
    }
    
    /**
     * Define a reputacao do utilizador
     *
     * @param reputacao
     */
    public void setReputacao(float reputacao) {
        this.reputacao = reputacao;
    }
    
    /**
     * Adicionar uma avaliaÁ„o
     * 
     * @param reputacao
     */
    public void addReputacao(float reputacao) {
        if (reputacao>=0 && reputacao<=5) {
        	this.formsReputacao.add(reputacao);
        	mediaReputacao();
        }
    }

    /**
     * Faz a mÈdia e atualiza o valor da reputacao para a
     * nova mÈdia
     */
    public void mediaReputacao() {
    	float sum=0,avg=0;
    	for(int i = 0; i < this.formsReputacao.size(); i++) {
    		sum = sum + this.formsReputacao.get(i);   
    		avg = sum / this.formsReputacao.size();
    	}
    	this.reputacao = avg;
    }
    
    /**
     * Define a pass do utilizador
     *
     * @param senha
     */
    public void setSenha(String senha) {
        this.senha = senha;
    }

    /**
     * Verifica as credenciais do utilizador
     *
     * @param senha - A senha
     */
    public boolean confirmaSenha(String senha) {
        return senha.equals(this.senha);
    }

    /**
     * Faz uma licitacao em determinado leilao
     *
     * @param leilao - o leilao
     * @param valor  - o valor da licitacao
     */
    public Licitacao licita(Leilao leilao, int valor) {
    							 // TODO: Arranjar isto das reputaÁıes para se comparar com ints
    	if (valor <= this.saldo) { //  && this.reputacao > 3 && leilao.getVendedor().getReputacao() >= 4) {
    		return leilao.licitar(this, valor);
    	} else {
    		return null ;
    	}
    		
    }

    public boolean dividasFisco() {
        // M√©todo mock para ver se um utilizador tem d√≠vidas com o fisco
        return false;
    }

    public void putSaldo(int deposito) {
    	this.saldo = this.saldo + deposito;
    }

    @Override
    public String toString() {
        return this.nome + " (" + this.email + ")" + " [" + this.reputacao + "]";
    }
}