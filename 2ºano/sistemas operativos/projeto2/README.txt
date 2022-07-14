Grupo 6- Matilde Silva nº56895, Sónia Sousa nº56898, Diogo Esteves nº56927

Como executar ambos os ficheiros .py:
A sintaxe para o pgrepwc.py:
python pgrepwc [-a] [-c|-l] [-p n] [-w s] [-o file] {palavras} [-f ficheiros]

A sintaxe para o pgrepwc_threads.py:
python hpgrepwc file

Limitações/ informações pertinentes:
Para passar os ficheiros a analisar é necessário colocar a opção -f antes dos nomes ficheiros. Caso contrário, irão ser pedidos os ficheiros a analisar. Caso isso aconteça, estes devem ser colocados no seguinte formato: 'file.txt file2.txt' (caso sejam apenas dois os ficheiros a analisar). Ou seja, quando se quer passar mais do que um ficheiro, estes devem estar separados apenas por um espaço e entre plicas.
Tem de ser sempre passada pelo menos uma opção (-c ou -a -l ou -l), não sendo possível utilizar a opção -c e -l em simultâneo. Já as opções -w e -o são opcionais. A ordem dos argumentos não pode ser alterada.
Têm de ser sempre introduzida, no mínimo, uma palavra e no máximo 3 palavras. Já o número de ficheiros sobre os quais vai ser realizada a análise, tem de ser apenas no mínimo 1.
Quando se quer procurar uma palavra que tem algum tipo de acento, esta deve ser dada com esse acento, pois o programa é sensivel a acentuação. O mesmo acontece com letras maiúscula/minúscula.