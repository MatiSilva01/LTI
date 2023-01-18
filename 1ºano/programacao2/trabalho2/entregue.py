# -*- coding: utf-8 -*-
"""
Created on Mon Mar 22 21:37:08 2021

@author: Matilde Silva
"""
"""
1A
A complexidade da função f1 é O(n). 
Cálculos:
linha 1: O(1), visto que apenas se está a definir a função.
linha 2: O(1), visto que é realizada uma multiplicação entre duas constantes 
("n * n") -> O(1), e também se define b -> O(1).
linha 3: O(1), visto que apenas se está a definir s, ou seja, é uma operação 
que não depende do tamanho do argumento de entrada da função.
linha 4: O(n), visto que as operações que se realizam no interior do ciclo while 
(linhas 5,6 e 7) são somas e subtrações. 
linha 5: O(1), visto que são realizadas duas operações de complexidade O(1).São elas:
aceder a um elemento de uma lista através do índice (acesso indexado) -> O(1);
E de seguida é realizada uma operação elementar (somar) -> O(1).
linha 6: O(1), visto que é uma operação elementar (somar).
linha 7: O(1), visto que é uma operação elementar (subtrair).
linha 8: O(1), visto que é uma operação que apenas devolve o resultado.
Assim, concluo que a função f1 tem uma complexidade assintótica de O(n), visto que
para o cálculo da complexidade, as constantes são desprezáveis.
2A
A complexidade assintótica da função f2 é O(n).
Cálculos:
linha 1: O(1), visto que apenas se está a definir a função.
linha 2: O(1), visto que se está a definir r, assim, independentemente de o valor 
passado à função ser grande ou não, o tempo de execução desta linha será sempre 
o mesmo.
linha 3: O(n), sendo n o tamanho da lista l (len(l)), visto que, o x vai ter de
percorrer todos os elementos da lista l. 
linha 4: O(1), visto que nos dicionários verificar se determinado elemento 
(no caso x) é membro do dicionário (d), tem O(1) como complexidade assintótica.
linha 5: O(1), Visto que a operação de concatenação tem complexidade O(1).
linha 6: O(1), visto que é uma operação que apenas devolve o resultado, no caso r.
Assim, concluo que a função f2 tem complexidade assintótica de O(n), sendo n o 
tamanho da lista l(len(l)). Visto que, para o cálculo da complexidade assintótica, 
as constantes são descartadas.
3B
"""
#: __author__ = Matilde Ferreira da Silva, 56895.
def busca_lista_dupla(lista, x):
    """Procura um elemento numa lista composta por sublistas.
    Pre:
        A lista de sublistas está ordenada por ordem crescente;
        Os elementos que ocorrem nas sublistas são valores inteiros;
        Nenhuma sublista de lista é vazia (no entanto, a própria lista poderá ser vazia).
    Args:
        lista (list): A lista de sublistas.
        x (any): O elemento.
    Returns:
        bool: True se o elemento está na lista de sublistas;
               False caso contrário.
    """
    listaAchatada=achatarLista(lista)
    def busca(primeiro, ultimo):
        if primeiro > ultimo:
            return False
        meio = (primeiro + ultimo) // 2
        if listaAchatada[meio] == x:
            return True
        if listaAchatada[meio] < x:
            return busca(meio + 1, ultimo)
        return busca(primeiro, meio - 1)
    return busca(0, len(listaAchatada) - 1)
    
def achatarLista(listaDeListas):
    """Transforma uma lista composta com várias sublistas, em uma lista simples 
    (sem sublistas), preservando a ordem dos elementos da lista inicial.
    Args:
        listaDeListas (list): A lista de sublistas.
    Returns:
        listaSimples (list): Devolve uma lista composta pelos elementos que estavam
        contidos nas várias sublistas da lista.
    """
    listaSimples=[]       
    for x in listaDeListas:   
        listaSimples+=x 
    return listaSimples
