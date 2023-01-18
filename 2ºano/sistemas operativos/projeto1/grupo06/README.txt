Grupo 6- Matilde Silva nº56895, Sónia Sousa nº56898, Diogo Esteves nº56927

Como executar ambos os ficheiros .py:
A sintaxe para o pgrepwc.py:
python pgrepwc.py [-a] [-c|-l] [-p n] palavras -f ficheiros
A sintaxe para o pgrepwc_threads.py:
python pgrepwc_threads.py [-a] [-c|-l] [-p n] palavras -f ficheiros

Limitações/ informações pertinentes:
Para passar os ficheiros a analisar é necessário por a opção -f antes dos nomes ficheiros. Caso contrário, irão ser pedidos os ficheiros a analisar. Caso isso aconteça, estes devem ser colocados no seguinte formato: 'file.txt file2.txt ..'. Ou seja, quando se quer passar mais do que um, o ficheiros devem estar separados apenas por um espaço.
Tem de ser sempre passada pelo menos uma opção (-c ou -a -l ou -l).
O número de processos filhos/threads a criar tem de ser sempre superior a 0. Caso a opção -p n, não seja dada pelo utilizador o número de processos filhos/threads será igual a 1.
Têm de ser sempre introduzida, no mínimo, uma palavra e no máximo 3 palavras. Já o número de ficheiros sobre os quais vai ser realizada a análise, tem de ser apenas no mínimo 1.

