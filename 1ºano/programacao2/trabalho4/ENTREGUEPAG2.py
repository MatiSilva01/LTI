# -*- coding: utf-8 -*-
"""
Created on Mon Apr 26 23:14:42 2021

@author: Matilde Silva
"""
import numpy as np
#__author__ = Matilde Ferreira da Silva, Nº56895.
def converte(iteravel, iteravel_de_funcoes):
    """iterável cujos elementos são obtidos por aplicação de cada função a cada elemento
    
    Args:
        iteravel (iter): iterável de valores
        iteravel_de_funcoes (iter): iterável de funções
    
    Returns:
        iter: novo iterável de valores
    """
    return list(func(el) for el, func in zip(iteravel, iteravel_de_funcoes))

def encontraChave(filtra):
    """
    Dada uma lista de dicionários, devolve uma lista com as chaves.

    Parameters
    ----------
    filtra : list[dict]
       Lista de dicionários

    Returns
    -------
    chaves : list
        Lista com as chaves.

    """
    chaves=[]
    for x in filtra:
        for chave in x.keys():
            chaves.append(chave)
    return chaves
   
def encontraValores(filtra):
    """
    Dada uma lista de dicionários, devolve uma lista com os valores

    Parameters
    ----------
    filtra : list[dict]
        Lista de dicionários

    Returns
    -------
    valores : list
        Lista com os valores

    """
    valores=[]
    for filtra2 in filtra:
        for x in filtra2.values():
            valores.append(x)
    return valores

def limpa_converte(dados, columns, pred_filtragem, fun_conv):
    """ 
    Função que recebe dados, converte-os e filtra,
    de modo a devolver apenas os dados revelantes.
    
    Parameters
    ----------
    dados : list[dict]
        Conjunto de dados que a função irá tratar.
    columns : list(str)
        Lista com os nomes dos cabeçalhos das colunas revelantes.
    pred_filtragem : function
        Predicado a aplicar para filtrar os dados.
    fun_conv : list[function]
        Lista de funções a utilizar para conversão de dados.

    Returns
    -------
    list[dict]
        Lista de dicionários resultante das conversões e da filtragem.
        
    >>> limpa_converte([{'colA':'', 'colB':'b', 'colC':''}, {'colA':'1', 'colB':'2', 'colC':'3'}, {'colA':'4', 'colB':'5', 'colC':'6'}],['colA', 'colC'],lambda d: d['colC'] != '', [str, lambda x: 2*int(x)])
    [{'colA': '1', 'colC': 6}, {'colA': '4', 'colC': 12}]
    >>> limpa_converte([{'colA':'0', 'colB':'9', 'colC': 4}, {'colA':'4', 'colB':'5', 'colC':'6'}], ['colA', 'colC'], lambda d: d['colC'] != '6', [lambda x: int(x)**2, str])
    [{'colA': 0, 'colC': '4'}]
    >>> limpa_converte([{'colA':'0', 'colB':'9', 'colC': '6'}], ['colA', 'colC'], lambda d: d['colC'] != '6', [lambda x: int(x)**2, str])
    []
    
    """
    colunasInteresse=list(map(lambda dicionarios: {x:dicionarios[x] for x in columns}, dados))
    filtra=list(filter(pred_filtragem, colunasInteresse)) 
    valores=encontraValores(filtra)
    chaves=encontraChave(filtra)
    convertidos=converte(valores, fun_conv *(len(valores)))
    listaTuplos = list(zip(chaves, convertidos))
    listaTuploConv = [listaTuplos[i * (len(fun_conv)):(i + 1) * (len(fun_conv))] for i in range((len(listaTuplos) + len(fun_conv) - 1) // len(fun_conv) )] 
    return (list(map(lambda x: dict(x), listaTuploConv)))



def media_movel(yy, janela):
    """
    Calcula a média móvel de uma lista de valores.
    
    Pre:
    --------
    O valor da janela tem de ser superior a zero e inteiro.
        
    
    Parameters
    ----------
    yy : list
        Lista de valores.
    janela : int
        Dimensão da janela.

    Returns
    -------
    lista: list
        Lista com média móvel da lista em cada valor da lista.

    >>> media_movel([], 2)
    []
    >>> media_movel([20], 2)
    [20.0]
    >>> media_movel([20, 4], 1)
    [20.0, 4.0]
    >>> media_movel([20, 13], 2)
    [20.0, 16.5]
    >>> media_movel([92, 105, 96, 108, 104, 100],2)
    [92.0, 98.5, 100.5, 102.0, 106.0, 102.0]
    """
    soma=np.cumsum(yy) 
    if len(yy)<=janela:  
        intervaloPequena=[x for x in range(1,janela+1)] 
        return(list(map(lambda x, y: x/y, soma, intervaloPequena)))
    intervalo=[x for x in range(1,janela)]
    lista=(list(map(lambda x, y: x/y, soma, intervalo))) 
    soma[janela:] = soma[janela:] - soma[:-janela] 
    finais=soma[janela - 1:] / janela 
    for x in finais:
        lista.append(x) 
    return lista



def desvio_padrao_inicial(yy, janela):
    """
    Calcula o desvio padrão para os x primeiros elementos da lista, sendo x o valor da janela.
    
    Pre:
    -----
    O valor da janela tem ser maior do que zero e inteiro.

    Parameters
    ----------
    yy : list
        Lista de valores.
    janela : int
        Valor da janela.

    Returns
    -------
    iniciais : list
        Lista com o desvio padra para cada valor da lista até ao indice(exclusivé).
        
    >>> desvio_padrao_inicial([1], 2)
    []
    >>> desvio_padrao_inicial([1, 2, 3, 4, 5], 3)
    [0.0, 0.5]
    >>> desvio_padrao_inicial([1, 2, 3, 4, 5], 2)
    [0.0]
    >>> desvio_padrao_inicial([92, 105, 96], 3)
    [0.0, 6.5]
    >>> desvio_padrao_inicial([92, 105, 96, 108, 104, 100, 106, 95, 104, 109], 3)
    [0.0, 6.5]
    >>> desvio_padrao_inicial([92, 105, 96, 108, 104, 100, 106, 95, 104, 109], 5)
    [0.0, 6.5, 5.436502143433364, 6.49519052838329]
    >>> desvio_padrao_inicial([92, 105, 96, 108, 104, 100, 106, 95, 104, 109], 0)
    []
        
    """
    inicio=yy[:janela]
    resultados=[]
    iniciais=[]
    for x in range(1,len(inicio)):
        valores=[] 
        for y in range(x): 
            valores.append(inicio[y])
        resultados.append(valores) 
    iniciais=list(map(lambda x: (np.std(x)), resultados)) 
    return iniciais
    
def desvio_padrao(yy, janela):
    """
    Calcula o desvio padrão em cada elemento de uma lista com base no valor da janela.
    
    Pre:
    -----
    O valor da janela tem ser maior do que zero e inteiro.

    Parameters
    ----------
    yy : list
        Lista de valores.
    janela : int
        Valor da janela.

    Returns
    -------
    list
        Lista com o desvio padra para cada valor da lista.
        
   
    >>> desvio_padrao([1], 1)
    [0.0]
    >>> desvio_padrao([92, 105, 96, 108, 104, 100, 106, 95, 104, 109], 1)
    [0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0]
    >>> desvio_padrao([92, 105], 2)
    [0.0, 6.5]
    >>> desvio_padrao([92, 105, 96, 108, 104, 100, 106, 95, 104, 109], 3)
    [0.0, 6.5, 5.436502143433364, 5.0990195135927845, 4.988876515698588, 3.265986323710904, 2.494438257849294, 4.496912521077347, 4.784233364802441, 5.792715732327588]
    >>> desvio_padrao([92, 105, 89], 5)
    [0.0, 6.5]
    """
    i=0
    janelas=[]
    iniciais=desvio_padrao_inicial(yy, janela) 
    while i < len(yy) - janela +1:
        janelaAtual = yy[i : i + janela]
        i+=1
        janelas.append(janelaAtual)
    fim=list(map(lambda x: (np.std(x)), janelas)) 
    return iniciais+fim 

if __name__ == '__main__':
    import doctest
    doctest.testmod()