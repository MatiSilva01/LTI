package client;

import java.time.LocalDate;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.time.format.DateTimeParseException;
import java.util.Locale;
import java.util.Scanner;

public class IO {
    public static void imprimeComando(String comando) {
        System.out.print(comando + "\n>>> ");
    }

    public static int lerInteiro(Scanner scanner, String msg) {
        int valor = 0;
        boolean erro = true;

        do {
            imprimeComando(msg);

            if (!scanner.hasNextInt()) {
                scanner.next();
                System.out.println("Caracter inválido.");
            } else {
                valor = scanner.nextInt();
                scanner.nextLine(); // Ler line break
                erro = false;
            }
        } while (erro);

        return valor;
    }

    public static String lerString(Scanner scanner, String msg, boolean aceitaVazio) {
        boolean erro = true;
        String txt = null;

        do {
            imprimeComando(msg);
            txt = scanner.nextLine();

            if (txt.equals("") && !aceitaVazio)
                System.out.println("O texto não pode ser vazio.");
            else
                erro = false;
        } while (erro);

        return txt;
    }

    public static LocalDate lerData(Scanner scanner, String msg, boolean aceitaVazio) {
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("dd-MM-yyyy");

        boolean erro = true;
        LocalDate data = null;
        do {
            String dataStr = lerString(scanner, msg, false);

            if (dataStr.equals("") && aceitaVazio)
                erro = false;
            else {
                try {
                    data = LocalDate.parse(dataStr, formatter);
                    erro = false;
                } catch (DateTimeParseException exception) {
                    System.out.println("Erro no formato da data. Certifique-se que tem 0s à esquerda.");
                }
            }
        } while (erro);

        return data;
    }

    public static LocalDateTime lerDataHora(Scanner scanner, String msg, boolean aceitaVazio) {
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("dd-MM-yyyy HH:mm");

        boolean erro = true;
        LocalDateTime data = null;

        do {
            String dataStr = lerString(scanner, msg, true);

            if (dataStr.equals("") && aceitaVazio)
                erro = false;
            else {
                try {
                    data = LocalDateTime.parse(dataStr, formatter);
                    erro = false;
                } catch (DateTimeParseException exception) {
                    System.out.println("Erro no formato da data. Certifique-se que tem 0s à esquerda.");
                }
            }
        } while (erro);

        return data;
    }

    public static boolean confirm(Scanner scanner, String mensagem) {
        while (true) {
            imprimeComando(mensagem + " [Y/n]");
            String next = scanner.nextLine();

            if (next.equals("") || next.toLowerCase(Locale.ROOT).equals("y")) return true;
            else if (next.toLowerCase(Locale.ROOT).equals("n")) return false;
            else System.out.println("Caracter não reconhecido.");
        }
    }

}
