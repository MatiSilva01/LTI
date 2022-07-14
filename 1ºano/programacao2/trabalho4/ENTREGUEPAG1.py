# -*- coding: utf-8 -*-
"""
Created on Mon Apr 26 23:13:52 2021

@author: Matilde Silva
"""
#__author__ = Matilde Ferreira da Silva, Nº56895
import numpy as np
from datetime import datetime
import csv
import matplotlib.pyplot as plt 
 
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
    listaTuploConv = [listaTuplos[i * (len(fun_conv)):(i + 1) * (len(fun_conv))] 
                      for i in range((len(listaTuplos) + len(fun_conv) - 1) // len(fun_conv) )] 
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


def ler_csv_dicionario(nome_ficheiro, cabecalho=None):
    """Ler um ficheiro CSV. O ficheiro pode ou não ter cabeçalho.
    
    Pre
    ------
    O conteúdo do ficheiro tem estar separado por ";"
    
    Parameters
    -------
    nome_ficheiro (str): O nome do ficheiro
    fieldnames (list[str], optional):  A lista com o nomes das colunas.
    Defaults: None.

    Returns
    -------
    list[dict]: Uma lista de dicionarios com o conteúdo do ficheiro;
            as chaves do dicionário são lidas da primeira linha do ficheiro
            ou tiradas da lista cabeçalho.
    """
    with open(nome_ficheiro, encoding="utf8") as ficheiro_csv:
        leitor = csv.DictReader(ficheiro_csv, fieldnames=cabecalho, delimiter=";")
        return list(leitor)
    
def ler_csv_dicionario2(nome_ficheiro, cabecalho=None):
    """
    Ler um ficheiro CSV. O ficheiro pode ou não ter cabeçalho.
    
    Pre
    ------
    O conteúdo do ficheiro tem estar separado por ",".
    
    Parameters
    ---------
    nome_ficheiro (str): O nome do ficheiro
    fieldnames (list[str], optional):  A lista com o nomes das colunas.
    Defaults: None.

    Returns:
    ---------
    list[dict]: Uma lista de dicionarios com o conteúdo do ficheiro;
            as chaves do dicionário são lidas da primeira linha do ficheiro
            ou tiradas da lista cabeçalho.
    """
    with open(nome_ficheiro, encoding="utf8") as ficheiro_csv:
        leitor = csv.DictReader(ficheiro_csv, fieldnames=cabecalho, delimiter=",")
        return list(leitor)


def tracar(abcissas, ordenadas, parametros, janela=30):
    """
    É responsável por chamar a função que calcula a média móvel e o desvio padrão, e desenhar os três gráficos. 

    Pre:
    --------
    O dicionario "parametros" deve conter as seguintes chaves: "colorPlot", "colorScatter", "tamanhoScatter", "title", "etiquetaX", "etiquetaY" e "gradiente",
    Os valores correspondentes a cada chave ficam à escolha, no entanto devem ser valores que façam sentido, isto é, ser dos seguintes tipos:
    "colorPlot", "colorScatter": type(str), no entanto, estas strings devem corresponder ao nome de uma cor em inglês;
    "tamanhoScatter": type(int)
    "title", "etiquetaX", "etiquetaY": type(str)
    "gradiente": type(float)
    
    Parameters
    ----------
    abcissas : list
        Lista de valores para abcissas.
    ordenadas : list
        Lista de valores para ordenadas.
    parametros : dict
        Dicionario que recebe elementos adicionais a colocar no gáfico, como título, cores, etc.
    janela : int, optional
        Valor da janela. O valor por default é 30.

    Returns
    -------
    None.

    """
    
    MM=media_movel(ordenadas, janela)
    plt.plot(abcissas, MM, color=parametros["colorPlot"])
    L1=media_movel(ordenadas, janela)
    L2= (list(map(lambda x: 2*x, desvio_padrao(ordenadas, janela))))
    LinhaSup=list(map(lambda x,y: x+y, L1, L2)) 
    LinhaInf=list(map(lambda x,y: x-y, L1, L2)) 
    plt.scatter(abcissas, ordenadas, color=parametros["colorScatter"], s=parametros["tamanhoScatter"])
    plt.title(parametros["title"])     
    plt.xlabel(parametros["etiquetaX"])
    plt.ylabel(parametros["etiquetaY"]) 
    plt.fill_between(abcissas, LinhaSup, LinhaInf, alpha=parametros["gradiente"]) 


def ConverteSegundos(abcissasConv):
    """
    Dada uma lista de datas em formato "Ano-Mes-DiaT%Horas:%Minutos", devolve quantos minutos 
    decorreram desde o início do mês de março de 2021.

    Parameters
    ----------
    abcissasConv : list
        Lista com as datas.

    Returns
    -------
    abcissasMin : list
        Lista com minutos decorridos de cada data.

    """
    abcissasFinaisSeg=[]
    for converter in abcissasConv:
        atual = datetime.strptime(converter, '%Y-%m-%dT%H:%M')
        tempo = (atual - datetime(2021, 3, 1)).total_seconds() 
        abcissasFinaisSeg.append(tempo)
    abcissasMin=list(map(lambda x: int(x/60), abcissasFinaisSeg))
    return abcissasMin

def sakura(nome_ficheiro):
    """
    Lê dados de um ficheiro CSV correspondente aos sismos no mês de março no
    mundo. Estes dados são limpos e convertidos de modo a traçar um gráfico
    com base nos minutos decorridos desde o inicio do mês de março e as magnitudes
    dos mesmos.

    Pre
    -----
    O conteúdo do ficheiro tem de estar separado por ";"
    O ficheiro passado à função deve ser o "kyoto.csv", ou outro com o mesmo
    contúdo que este para obter a vizualização correta do gráfico.
    
    Parameters
    ----------
    nome_ficheiro : str
        Nome do ficheiro csv.

    Returns
    -------
    None.

    """
    dados=ler_csv_dicionario(nome_ficheiro)
    colunas=['AD', 'Full-flowering date (DOY)']
    pred_filtragem = lambda d: d['Full-flowering date (DOY)'] != ''
    funConverte=[str, lambda x: int(x)]
    chama=limpa_converte(dados, colunas, pred_filtragem, funConverte)
    abcissas=list(map(lambda x: x['AD'], chama))
    ordenadas=list(map(lambda x: x['Full-flowering date (DOY)'], chama))
    abcissasF=list(map(lambda x: int(x), abcissas))
    tracar(abcissasF, ordenadas, {"colorPlot":"red", "colorScatter":"green", "tamanhoScatter":1, "title":"Registo Histórico da Data de Florescimento das Cerejeiras em Quioto", "etiquetaX":"Ano DC",
    "etiquetaY":"Dias a partir do ínicio do ano", "xtitlecolor":"green", "gradiente":0.4})
#print(sakura('kyoto.csv'))
def sismos(nome_ficheiro):
    """
     Lê dados de um ficheiro CSV correspondente aos sismos no mês de março no
     mundo. Estes dados são limpos e convertidos de modo a traçar um gráfico
     com base nos minutos decorridos desde o inicio do mês de março e as magnitudes
     dos mesmos.

    Pre
    -------
    O ficheiro passado à função deve ser o "all_month.csv", ou outro com o mesmo
    contúdo que este para obter a vizualização correta do gráfico.
    O conteúdo do ficheiro tem estar separado por virgulas.
    
    Parameters
    ----------
    nome_ficheiro : str
    Nome do ficheiro csv.

    Returns
    -------
    None.


    """
    dados=ler_csv_dicionario2(nome_ficheiro)
    colunas=['time', 'mag']
    pred_filtragem = lambda d: d['mag'] != ''
    funConverte=[str, lambda x: float(x)]
    chama=limpa_converte(dados, colunas, pred_filtragem, funConverte)
    abcissasInicio=list(map(lambda x: x['time'], chama))
    ordenadas=list(map(lambda x: x['mag'], chama))
    abcissasStr=list(map(lambda x: str(x), abcissasInicio))
    abcissasConv=list(map(lambda x: x[:16], abcissasStr))
    print(abcissasConv)
    abcissasFinais=ConverteSegundos(abcissasConv)
    tracar(abcissasFinais, ordenadas, {"colorPlot":"red", "colorScatter":"green", "tamanhoScatter":1, "title":"Registo sísmico do mês de Março de 2021 no mundo", "etiquetaX":"Minutos passados desde o inicio do mês", "etiquetaY":"Média das magnitudes por minuto", "xtitlecolor":"green", "gradiente":0.4})
print(sismos('all_month.csv'))
if __name__ == '__main__':
    import doctest
    doctest.testmod()