package client;

import business.Leilao;
import business.Licitacao;
import business.Sistema;

import java.time.LocalDate;
import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;
import java.util.Scanner;
import java.util.stream.Collectors;

/**
 * Cliente simples
 *
 * @author ...
 * @version ...
 */
public class SimpleClient {
    private static final String separator = "------------------------------";
    private static I18n i18n;

    /**
     * A simple interaction with the application services
     *
     * @param args Command line parameters
     */
    public static void main(String[] args) {
        i18n = new I18n();
        i18n.setLingua(I18n.Lingua.INGLES);

        Sistema sistema = new Sistema();
        Scanner scanner = new Scanner(System.in);
        String[] opcoesPrincipal = {i18n.traduz("Iniciar sessão"), i18n.traduz("Criar utilizador"), i18n.traduz("Sair")};


        // Ciclo principal
        while (true) {
            int escolha = menu(scanner, i18n.traduz("Menu Principal"), opcoesPrincipal);

            System.out.println("\n\n" + separator + "\n" + opcoesPrincipal[escolha]);
            switch (escolha) {
                case 0:
                    // Iniciar Sessão
                    boolean autenticado = menuIniciaSessao(scanner, sistema);
                    if (!autenticado) continue;

                    menuUtilizador(scanner, sistema);
                    break;
                case 1:
                    // Registar Utilizador
                    // TODO
                    String email = IO.lerString(scanner, i18n.traduz("Insira o seu email:"), false);
                    String nome = IO.lerString(scanner, i18n.traduz("Insira o seu nome:"), false);
                    String senha = IO.lerString(scanner, i18n.traduz("Insira a sua senha:"), false);
                    LocalDate dataNascimento = IO.lerData(scanner, i18n.traduz("Insira a sua data de nascimento:"), false);
                    
                    /* if (sistema.utilizadorValido(nome, email)){
                        if (!email.contains("@")){
                             System.out.println("Insira um email válido para continuar");
                             imprimeComando("Insira o seu email:");
                             String email = scanner.nextLine();
                        } else {

                            try {
                                sistema.criarUtilizador(email, nome, senha, dataNascimento);
                                System.out.println("Utilizador criado com sucesso!");
                            } catch (Exception e) {
                                System.out.println("Não foi possível registar");
                            }
                        }
                    } */
                    
                    //sistema.criarUtilizador(email, nome, senha, dataNascimento);
                    //System.out.println(i18n.traduz("Utilizador criado com sucesso!"));

                    menuUtilizador(scanner, sistema);
                    break;
                case 2:
                    // Alterar idioma
                    break;
                case 3:
                    System.exit(0);
            }
        }
    }

    public static Leilao menuLeiloes(Scanner scanner, String titulo, List<Leilao> leiloes) {
        List<String> opcoes = leiloes.stream().map(Leilao::toString).collect(Collectors.toList());
        opcoes.add("Voltar atrás");

        int escolha = menu(scanner, titulo, opcoes.toArray(new String[0]));
        if (escolha == opcoes.size() - 1) return null;

        return leiloes.get(escolha);
    }

    /**
     * @param scanner
     * @param sistema
     * @param leilao
     * @return true se continuar menu anterior, false se saltar menu anterior
     */
    public static boolean menuEditarLeilao(Scanner scanner, Sistema sistema, Leilao leilao) {
        String[] opcoes = {i18n.traduz("Nome"), i18n.traduz("Base licitação"), i18n.traduz("Deadline"), i18n.traduz("Publicar leilão"), i18n.traduz("Cancelar leilão"), i18n.traduz("Voltar atrás")};

        while (true) {
            int escolha = menu(scanner, "Editar " + leilao.toString(), opcoes);
            switch (escolha) {
                case 0: {
                    // Nome
                    String nome = IO.lerString(scanner, i18n.traduz("Insira o novo nome do leilão. Deixe vazio para cancelar."), true);

                    if (nome.equals("")) {
                        System.out.println(i18n.traduz("Edição de nome cancelada."));
                        continue;
                    }

                    leilao.setNome(nome);
                    System.out.println(i18n.traduz("Novo nome do leilão: ") + leilao.getNome());
                    break;
                }
                case 1: {
                    // Base Licitacao
                    boolean erro = true;
                    do {
                        int baseLicitacao = IO.lerInteiro(scanner, i18n.traduz("Insira a base de licitacao. Insira -1 para cancelar."));

                        if (baseLicitacao == -1) {
                            System.out.println(i18n.traduz("Edição de base de licitação cancelada."));
                            erro = false;
                        } else {
                            if (baseLicitacao < 1)
                                System.out.println(i18n.traduz("Número inválido. Deve ser um número inteiro positivo, ou -1 para cancelar"));
                            else {
                                leilao.setBaseLicitacao(baseLicitacao);
                                System.out.println(i18n.traduz("Nova base de licitação do leilão: ") + leilao.getBaseLicitacao());
                                erro = false;
                            }
                        }
                    } while (erro);

                    break;
                }
                case 2: {
                    // Deadline
                    boolean erro = true;
                    do {
                        LocalDateTime deadline = IO.lerDataHora(scanner, i18n.traduz("Insira a nova deadline do leilão. Use o formato dia-mês-ano hora:minuto. Deixe vazio para cancelar."), true);

                        if (deadline == null) {
                            System.out.println(i18n.traduz("Edição de deadline cancelada."));
                            erro = false;
                        } else if (deadline.isBefore(LocalDateTime.now().plusDays(5)))
                            System.out.println(i18n.traduz("O leilão deve durar pelo menos 5 dias."));
                        else {
                            leilao.setDeadline(deadline);

                            System.out.println(i18n.traduz("Nova deadline do leilão: ") + leilao.getDeadline());
                            erro = false;
                        }
                    } while (erro);

                    break;
                }
                case 3: {
                    // Publicar Leilao
                    boolean publicar = IO.confirm(scanner, i18n.traduz("Deseja publicar o leilão ") + leilao + "?");

                    if (!publicar) System.out.println(i18n.traduz("Publicação do leilão cancelada."));
                    else {
                        leilao.publicar();
                        System.out.println(i18n.traduz("Leilão publicado."));
                    }

                    break;
                }
                case 4: {
                    // Cancelar leilao
                    boolean cancelar = IO.confirm(scanner, i18n.traduz("Deseja cancelar o leilão ") + leilao + "?");

                    if (!cancelar) System.out.println(i18n.traduz("Cancelamento do leilão cancelado."));
                    else {
                        sistema.cancelarLeilao(leilao);
                        System.out.println(i18n.traduz("Leilão cancelado."));
                        return false;
                    }

                    break;
                }
                case 5:
                    // Voltar atrás
                    return true;
            }
        }

    }

    public static void menuLeilao(Scanner scanner, Sistema sistema, Leilao leilao) {
        boolean isVendedor = sistema.getUtilizadorAutenticado().eVendedor(leilao);
        boolean podeLicitar = sistema.getUtilizadorAutenticado().podeLicitar(leilao);

        List<String> opcoes = new ArrayList<>();
        if (isVendedor) {
            opcoes.add(i18n.traduz("Editar leilão"));
            opcoes.add(i18n.traduz("Ver licitações"));
        } else if (podeLicitar) opcoes.add(i18n.traduz("Licitar"));

        opcoes.add(i18n.traduz("Voltar atrás"));

        int escolha = menu(scanner, i18n.traduz("Leilão ") + leilao, opcoes.toArray(new String[0]));
        if (isVendedor) {
            switch (escolha) {
                case 0:
                    // Editar leilão
                    if (!leilao.getEstado().equals(Leilao.Estado.PENDENTE))
                        System.out.println(i18n.traduz("Este leilão já foi publicado, impossibilitando que seja alterado."));
                    else {
                        if (!menuEditarLeilao(scanner, sistema, leilao)) return;
                    }

                    break;
                case 1:
                    // Ver licitações
                    List<String> licitacoes = leilao.licitacoesOrdenadas().stream().map(Licitacao::toString).collect(Collectors.toList());

                    if (licitacoes.size() == 0) System.out.println(i18n.traduz("Não existem licitações neste leilão."));
                    else System.out.println(i18n.traduz("Licitações:\n") + String.join("\n", licitacoes));

                    break;
            }
        } else if (podeLicitar) {
            if (escolha == 0) {
                // Licitar
                // TODO utilizador só pode licitar se tiver < 3 forms reputação por preencher
                // TODO vendedor só pode receber licitações (limitar aqui!!) se tiver < 5 forms reputação por preencher
                // TODO ver se ainda não acabou (se sim, marcar como terminado)
            }
        }
    }

    /**
     * @param scanner
     * @param sistema
     * @return se deve terminar ou continuar o ciclo principal
     */
    public static void menuUtilizador(Scanner scanner, Sistema sistema) {
        String[] opcoes = {i18n.traduz("Leilões disponíveis"), i18n.traduz("Os seus leilões"), i18n.traduz("Criar leilão"), i18n.traduz("Perfil"), i18n.traduz("Terminar sessão"), i18n.traduz("Sair")};

        while (true) {
            int escolha = menu(scanner, i18n.traduz("Bem vindo, ") + sistema.getUtilizadorAutenticado().getNome(), opcoes);

            switch (escolha) {
                case 0:
                    // Leilões disponíveis
                    if (sistema.leiloesDisponiveisComprador().size() == 0)
                        System.out.println(i18n.traduz("Sem leilões disponíveis."));
                    else {
                        List<Leilao> disponiveis = sistema.leiloesDisponiveisComprador().values().stream()
                                // TODO confirmar se é 1 : 0 ou 0 :1
                                .sorted((e1, e2) -> e1.ultimaInteracao().isAfter(e2.ultimaInteracao()) ? 1 : 0).collect(Collectors.toList());

                        Leilao leilao = menuLeiloes(scanner, i18n.traduz("Leilões Disponíveis"), disponiveis);
                        if (leilao == null) continue;

                        menuLeilao(scanner, sistema, leilao);
                    }
                    break;
                case 1:
                    // Os seus leilões
                    if (sistema.leiloesVendedor().size() == 0)
                        System.out.println(i18n.traduz("Não possui leilões. Crie um primeiro."));
                    else {
                        List<Leilao> leiloes = sistema.leiloesVendedor().values().stream()
                                // TODO confirmar se é 1 : 0 ou 0 :1
                                .sorted((e1, e2) -> e1.ultimaInteracao().isAfter(e2.ultimaInteracao()) ? 1 : 0).collect(Collectors.toList());

                        Leilao leilao = menuLeiloes(scanner, i18n.traduz("Leilões Vendedor"), leiloes);
                        if (leilao == null) continue;

                        menuLeilao(scanner, sistema, leilao);
                    }
                    break;
                case 2:
                    // Criar leilão
                    break;
                case 3:
                    // Perfil
                    break;
                case 4:
                    // Terminar Sessão
                    sistema.terminaSessaoUtilizador();
                    System.out.println(i18n.traduz("Sessão terminada com sucesso."));
                    return;
                case 5:
                    // Sair
                    System.exit(0);
            }
        }
    }

    public static boolean menuIniciaSessao(Scanner scanner, Sistema sistema) {
        boolean autenticado = false;
        while (!autenticado) {
            String nomeEmail = IO.lerString(scanner, i18n.traduz("Insira o nome ou email de utilizador:"), false);
            String senha = IO.lerString(scanner, i18n.traduz("Insira a senha de utilizador:"), false);

            autenticado = sistema.autenticaUtilizador(nomeEmail, senha);
            if (!autenticado) {
                if (!IO.confirm(scanner, i18n.traduz("Nome ou senha de utilizador errado. Tentar novamente?")))
                    return false;
            }
        }

        return autenticado;
    }

    public static int menu(Scanner scanner, String titulo, String[] opcoes) {
        // Build output
        StringBuilder sb = new StringBuilder("\n");

        sb.append(separator).append("\n").append(titulo).append("\n");

        for (int idx = 0; idx < opcoes.length; idx++)
            sb.append(idx + 1).append("- ").append(opcoes[idx]).append("\n");

        sb.append(separator).append("\n");
        System.out.println(sb);

        // Get input
        while (true) {
            int opcao = IO.lerInteiro(scanner, i18n.traduz("Insira o número da opção:"));

            if (opcao > 0 && opcao <= opcoes.length) return opcao - 1;
            else System.out.println(i18n.traduz("Número inválido. Deve ser um número inteiro entre 1 e ") + opcoes.length);
        }
    }
}
