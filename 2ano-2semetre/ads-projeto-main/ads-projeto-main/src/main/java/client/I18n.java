package client;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.util.HashMap;
import java.util.Map;

public class I18n {
    private static Map<String, String> ingles;
    private Lingua lingua;

    public I18n() {
        ingles = leFicheiro("src/main/resources/ingles.txt");
    }

    /** Read a translations file
     * @source https://www.javacodeexamples.com/read-text-file-into-hashmap-in-java-example/2333
     * @param filePath path to the file
     * @return Map of the file contents
     */
    private static Map<String, String> leFicheiro(String filePath) {

        Map<String, String> content = new HashMap<>();
        BufferedReader br = null;

        try {
            File file = new File(filePath);
            br = new BufferedReader(new FileReader(file));

            String line = null;
            while ((line = br.readLine()) != null) {

                //split the line by =>
                String[] parts = line.split("=>");

                String key = parts[0];
                String translation = parts[1];

                //put keu, translation in HashMap if they are not empty
                if (!key.equals("") && !translation.equals(""))
                    content.put(key, translation);
            }
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            //Always close the BufferedReader
            if (br != null) {
                try {
                    br.close();
                } catch (Exception ignored) {
                }
            }
        }

        return content;
    }

    public String traduz(String key) {
        if (lingua.equals(Lingua.INGLES)) {
            if (!ingles.containsKey(key))
                return key;

            return ingles.get(key);
        }

        if (lingua.equals(Lingua.CESAR)) {
            char[] chars = key.toCharArray();
            StringBuilder out = new StringBuilder();

            for (char c : chars) {
                boolean lower = false;
                if (c > 'a' && c < 'z')
                    lower = true;
                else if (c < 'A' || c > 'Z') {
                    out.append(c);
                    continue;
                }

                int offset = lower ? 'a' : 'A';

                out.append((char) ((c + 1 - offset) % 26 + offset));
            }

            return out.toString();
        }

        return key;
    }

    public Lingua getLingua() {
        return lingua;
    }

    public void setLingua(Lingua lingua) {
        this.lingua = lingua;
    }

    public enum Lingua {
        PORTUGUES,
        INGLES,
        CESAR
    }
}
