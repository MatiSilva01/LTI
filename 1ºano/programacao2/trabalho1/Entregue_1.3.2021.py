# -*- coding: utf-8 -*-
"""
Created on Mon Mar  1 15:40:25 2021

@author: Matilde Silva
"""

"""
 __author__ = Matilde Ferreira da Silva, 56895
"""
def encontrar_palavras(ficheiroAnalise, palavrasInteresse): 
    """ 
    Função encontra as frequências de certas palavras no corpo de um 
    texto e anota as linhas em que as palavras ocorrem.
    Args:
        ficheiroAnalise(str): ficheiro de texto(.txt). (com o texto a ser analisado)
        palavrasInteresse(str): ficheiro de texto(.txt). (palavras utilizadas 
        na análise do texto)
    Returns:
        dicionario(dic): As chaves são as palavras que se encontram em
        palavrasInteresse. Os valores são pares onde o primeiro elemento é o 
        número de vezes que a palavra aparece no texto do ficheiroAnalise,
        e o segundo elemento é o conjunto dos números das linhas onde a palavra 
        aparece, novamente no ficheiroAnalise. Caso palavrasInteresse 
        não tenha conteúdo, devolve um dicionário vazio.
    """
    dicionario={} 
    for palavra in ler_palavras(palavrasInteresse):
        dicionario[palavra]=(ocorrenciasPalavra(ficheiroAnalise, palavra),
        linhas(palavra, ficheiroAnalise))
    return dicionario


def ler_palavras(nome_ficheiro):
    """
    Função que o que lê todas as palavras constantes num ficheiro e devolve-as
    em forma de conjunto (ou seja, sem repetições).
    Args:
        nome_ficheiro(str): ficheiro de texto(.txt)
    Returns:
        conjunto(set): retorna o conjunto das palavras do ficheiro passado 
        como argumento à função. Caso o ficheiro não tenha conteúdo devolve um 
        conjunto vazio (set()).
    """
    conjunto=set()
    with open(nome_ficheiro,'r',encoding="utf8") as f:
        for linhas in f:
            parte=linhas.split()
            for palavra in parte:
                conjunto.add(palavra)
        return(conjunto)


def ocorrenciasPalavra(ficheiroAnalise, palavraAnalise):
    """
    Função que devolve o número de ocorrências de uma palavra em determinado 
    texto.
    Args:
        ficheiroAnalise(str): ficheiro de texto(.txt)
        palavraAnalise(str): palavra(str)
    Returns:
        numeroDeOcorrencias(int): número de vezes que a palavraAnalise
        aparece no conteúdo do ficheiroAnalise.
    """
    numeroDeOcorrencias=0
    with open(ficheiroAnalise,'r', encoding="utf8") as f:
        for linhas in f:
            parte=linhas.split()
            for palavra in parte:
                if palavra==palavraAnalise:
                    numeroDeOcorrencias+=1
        return(numeroDeOcorrencias)


def linhas(palavraAnalisar, ficheiroAnalisar):
    """
    Função que devolve um conjunto com o número das linhas de um ficheiro de 
    texto em que aparece a palavra passada como argumento à função.
    Args:
        palavraAnalisar(str): palavra(str)
        ficheiroAnalisar(str): ficheiro de texto (.txt)
    Returns:
        conjunto(set): conjunto das linhas em que a palavraAnalisar aparece no 
    ficheiroAnalisar. Se a palavraAnalisar não aparecer no texto do 
    ficheiroAnalisar, devolve um conjunto vazio (set()).

    """
    contaLinhas=0
    conjunto=set()
    with open(ficheiroAnalisar,'r', encoding="utf8") as f:
        for linha in f:
            parte=linha.split()
            contaLinhas=contaLinhas+1
            if palavraAnalisar in parte:
                conjunto.add(contaLinhas)
    return conjunto
print(encontrar_palavras('turing.txt', 'palavras.txt'))