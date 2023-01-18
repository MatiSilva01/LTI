# -*- coding: utf-8 -*-
"""
Created on Mon Apr  5 20:03:19 2021

@author: Matilde Silva
"""
### Dicionário com as cidades - NÃO ALTERAR!
cidades = {'Lisboa': (38.7452, -9.1604), 
           'Vila Nova de Gaia': (41.1333, -8.6167),
           'Porto': (41.1495, -8.6108),
           'Braga': (41.5333, -8.4167),
           'Matosinhos': (41.2077, -8.6674),
           'Amadora': (38.75, -9.2333),
           'Almada': (38.6803, -9.1583),
           'Oeiras': (38.697, -9.3017),
           'Gondomar': (41.15, -8.5333),
           'Guimarães': (41.445, -8.2908),
           'Odivelas': (38.8, -9.1833),
           'Coimbra': (40.2111, -8.4291),
           'Vila Franca de Xira': (38.95, -8.9833),
           'Maia': (41.2333, -8.6167),
           'Leiria': (39.7431, -8.8069),
           'Setúbal': (38.5243, -8.8926),
           'Viseu': (40.6667, -7.9167),
           'Valongo': (41.1833, -8.5),
           'Viana do Castelo': (41.7, -8.8333),
           'Paredes': (41.2, -8.3333),
           'Vila do Conde': (41.35, -8.75),
           'Torres Vedras': (39.0833, -9.2667),
           'Barreiro': (38.6609, -9.0733),
           'Aveiro': (40.6389, -8.6553),
           'Queluz': (38.7566, -9.2545),
           'Mafra': (38.9333, -9.3333),
           'Penafiel': (41.2, -8.2833),
           'Loulé': (37.144, -8.0235)}
#__author__ = Matilde Ferreira da Silva, 56895.
import math
import functools
import operator


def pontos(coordenadas):
    """
    Função que dadas coordenadas de pontos, devolve essas mesmas coordenadas
    atualizadas para Portugal continental.

    Parameters
    ----------
    coordenadas : tuple
        Coordenada em formato GPS.

    Returns
    -------
    coordenadaAtualizada: tuple
        coordenada atualizada para Portugal continental.
    """
    latitude=(operator.mul(coordenadas[0],111.1949))
    longitude=(operator.mul(coordenadas[1],85.1102))
    coordenadaAtualizada=(latitude, longitude)
    return (coordenadaAtualizada)


def distancia(ponto1, ponto2):
    """
     Calcula a distância entre dois locais através de coordenadas GPS utilizando a fórmula cartesiana.
    ----------
    ponto1 : tuple
        primeira coordenada
    ponto2 : tuple
        segunda coordenada

    Returns
    -------
    distancia : float
        distância entre o ponto1 e o ponto2

    """
    ponto1Atual=pontos(ponto1) 
    ponto2Atual=pontos(ponto2)
    latitude=(float(ponto1Atual[0]-ponto2Atual[0]))**2 
    longitude=(float(ponto1Atual[1]-ponto2Atual[1]))**2
    distancia=math.sqrt(latitude + longitude) 
    return distancia

def levanta_excessao(itinerario):
    """
    Levanta exceção caso alguma cidade do itinerario não pertença ao dicionário "cidades".

    Parameters
    ----------
    itinerario : list
        Lista de cidades

    Raises
    ------
    KeyError: caso alguma cidade do itinerario não pertença ao dicionário "cidades".

    Returns
    -------
    None.

    """
    
    naoPertence=(list(map(lambda x: x not in iter(cidades), itinerario))) 
    if any(naoPertence)==True: 
        indice=naoPertence.index(True)   
        raise KeyError(itinerario[indice]) 


def distancia_itinerario(itinerario): 
    """
    Calcula a distância total de um itinerario, ou seja, a soma das
    distâncias entre duas cidades consecutivas.
    
    Pre
    ---------
    O itinerário recebe no mínimo duas cidades.
    O itinerário é uma lista composta por strings.

    Parameters
    ----------
    itinerario : list
        lista composta por strings, que são as cidades.
    
    Raises
    --------
        KeyError: caso alguma cidade do itinerario nao pertença ao dicionario cidades.
        
    Returns
    -------
    distanciaTotal : float
        Distancia total, em km, do itinerario.
        
        
    >>> distancia_itinerario(['Leiria', 'Leiria'])
    0.0
    >>> distancia_itinerario(['Leiria', 'Coimbra'])
    61.17189035703412
    >>> distancia_itinerario(['Leiria', 'Leiria', 'Coimbra'])
    61.17189035703412
    >>> distancia_itinerario(['Leiria', 'Leiria', 'Leiria'])
    0.0
    >>> distancia_itinerario(['Leiria','Braga', 'Aveiro'])
    303.3171869307044

  

    """
#   _________________________________________________________________________________________________________
#   |                 CARACTERISTICAS                |                        TESTES                        |
#   |________________________________________________|______________________________________________________|
#   | Nº elementos  | Elementos   |Todos os elementos|             Entrada           |         Saída        |
#   |do itinerario  | repetidos   |   do itinerario  |                               |                      |
#   |               |em itinerario|  são iguais      |                               |                      |
#   |---------------+-------------+------------------+------------------------------+-----------------------|
#   | <2            |   True      |      True        |                           INVIAVEL                   |
#   | <2            |   True      |      False       |                           INVIAVEL                   |
#   | <2            |   False     |      True        |                           INVIAVEL                   |                 
#   | <2            |   False     |      False       |                           INVIAVEL                   |    
#   |---------------+-------------+------------------+-------------------------------+----------------------|
#   | 2             |   True      |      True        |['Leiria', 'Leiria']           |          0.0         |   
#   | 2             |   True      |      False       |                            INVIAVEL                  |
#   | 2             |   False     |      True        |                            INVIAVEL                  |
#   | 2             |   False     |      False       |['Leiria', 'Coimbra']          |         61.172       |
#   |---------------+-------------+------------------+-------------------------------+----------------------|
#   | >2            |   True      |      False       |['Leiria', 'Leiria', 'Coimbra']|          61.172      |
#   | >2            |   True      |      True        |['Leiria', 'Leiria', 'Leiria'] |           0.0        |
#   | >2            |   False     |      True        |                            INVIAVEL                  |
#   | >2            |   False     |      False       |['Leiria', 'Braga', 'Aveiro']  |        303.317       |
#   |_______________|_____________|__________________|_______________________________|______________________|
    invalida=levanta_excessao(itinerario)
    lugaresItinerario=list(map(lambda x: cidades[x], itinerario)) 
    listaDeListas=list(map(list, lugaresItinerario)) 
    distanciaTotal = functools.reduce(operator.add, (map(lambda i: distancia(listaDeListas[i],listaDeListas[i+1]), range(len(listaDeListas)-1))))
    return distanciaTotal

def distanciaEntreCidades(distCidade):
    """
    Calcula a soma da distancia entre pontos consecutivos de uma lista 

    Parameters
    ----------
    distCidade : list
        distancias entre cidades
        
    Returns
    -------
    listaDistCidade : list
        lista com a soma das distâncias entre as cidades consecutivas

    """
    distConsecutiva=zip(distCidade, distCidade[1:]) 
    listaDistCidade=list(map(lambda x : sum(x), distConsecutiva)) 
    return listaDistCidade
    

def adicionar_cidade(itinerario, cidade):
    """
    Adiciona uma cidade a um itinerario já existente, colocando-a
    entre duas cidades do itinerario original, de modo a minimizar o desvio adicional.
    
     Pre
     ---------
    As cidades inicial e final do itinerario final serão as mesmas que foram passadas no itinerario original.
    O itinerario é uma lista composta por strings.
    O input cidade tem de ser do tipo string, e esta não pode ser vazia.
    O itinerario tem sempre pelo menos duas cidades.

    Parameters
    ----------
    itinerario : list
        Lista composta pelas cidades do itinerario original.
    cidade : string
        cidade a adicionar ao itinerario.
        
    Raises
    --------
        KeyError: caso alguma cidade do itinerario não pertença ao dicionário "cidades".

    Returns
    -------
    itinerario : list
        itinerario atualizado, contendo a cidade.  
        
    >>> adicionar_cidade(['Leiria', 'Leiria'], 'Leiria')
    ['Leiria', 'Leiria', 'Leiria']
    >>> adicionar_cidade(['Leiria', 'Leiria'], 'Coimbra' )
    ['Leiria', 'Coimbra', 'Leiria']
    >>> adicionar_cidade(['Leiria', 'Lisboa'], 'Coimbra')
    ['Leiria', 'Coimbra', 'Lisboa']
    >>> adicionar_cidade(['Leiria', 'Lisboa'], 'Leiria')
    ['Leiria', 'Leiria', 'Lisboa']
    >>> adicionar_cidade(['Leiria', 'Coimbra', 'Leiria'], 'Coimbra' )
    ['Leiria', 'Coimbra', 'Coimbra', 'Leiria']
    >>> adicionar_cidade(['Leiria', 'Coimbra', 'Leiria'], 'Aveiro')
    ['Leiria', 'Aveiro', 'Coimbra', 'Leiria']
    >>> adicionar_cidade(['Leiria', 'Porto', 'Coimbra'], 'Aveiro' )
    ['Leiria', 'Aveiro', 'Porto', 'Coimbra']
    >>> adicionar_cidade(['Leiria', 'Lisboa', 'Coimbra'], 'Lisboa' )
    ['Leiria', 'Lisboa', 'Lisboa', 'Coimbra']
    
        
    """
#   ________________________________________________________________________________________________________________________________________
#   |                CARACTERISTICAS                 |                                        TESTES                                        |
#   |________________________________________________|______________________________________________________________________________________|
#   | Nº elementos  | Elementos   |Cidade a adicionar|                Entrada                  |                     Saída                  |
#   |do itinerario  | repetidos   |já se encontra no |                                         |                                            |
#   |               |em itinerario|    itinerario    |                                         |                                            |
#   |---------------+-------------+------------------+-----------------------------------------+--------------------------------------------|
#   | <2            |   True      |      True        |                                      INVIAVEL                                        |
#   | <2            |   True      |      False       |                                      INVIAVEL                                        |
#   | <2            |   False     |      False       |                                      INVIAVEL                                        |
#   | <2            |   False     |      True        |                                      INVIAVEL                                        |
#   |---------------+-------------+------------------+------------------------------------------+-------------------------------------------|    
#   | 2             |   True      |      True        |['Leiria', 'Leiria'], 'Leiria'            |['Leiria', 'Leiria', 'Leiria']             |
#   | 2             |   True      |      False       |['Leiria', 'Leiria'], 'Coimbra'           |['Leiria', 'Coimbra', 'Leiria']            |
#   | 2             |   False     |      False       |['Leiria', 'Lisboa'], 'Coimbra'           |['Leiria', 'Coimbra', 'Lisboa']            |
#   | 2             |   False     |      True        |['Leiria', 'Lisboa'], 'Leiria'            |['Leiria', 'Leiria', 'Lisboa']             |
#   |---------------+-------------+------------------+-------------------+----------------------+-------------------------------------------| 
#   |>2             |   True      |      True        |['Leiria', 'Coimbra', 'Leiria], 'Coimbra' |['Leiria', 'Coimbra', 'Coimbra', 'Leiria'] |
#   |>2             |   True      |      False       |['Leiria', 'Coimbra', 'Leiria], 'Aveiro'  |['Leiria', 'Aveiro', 'Coimbra', 'Leiria']  |
#   |>2             |   False     |      False       |['Leiria', 'Porto', 'Coimbra'], 'Aveiro'  |['Leiria', 'Aveiro', 'Porto', 'Coimbra']   |
#   |>2             |   False     |      True        |['Leiria', 'Lisboa', 'Coimbra'], 'Lisboa' |['Leiria', 'Lisboa', 'Lisboa', 'Coimbra']  |   
#   |_______________|_____________|__________________|__________________________________________|___________________________________________|
    invalida=levanta_excessao(itinerario)
    pontosLista=list(map(lambda lugar: cidades[lugar], itinerario))  
    distanciaAPares =(map(lambda x: distancia(pontosLista[x], pontosLista[x+1]), range(len(pontosLista)-1))) 
    distanciaACidade=list(map(lambda x: distancia(pontosLista[x], cidades[cidade]), range(len(pontosLista))))  
    distanciaA3=distanciaEntreCidades(distanciaACidade) 
    diferencaComCidade=list(map(lambda x,y: x-y, distanciaA3, distanciaAPares)) 
    itinerario.insert((diferencaComCidade.index(min(diferencaComCidade))+1), cidade) 
    return itinerario

def construir_itinerario(origem, destino, lista_cidades):

    """
    Constrói um itinerario a partir de uma lista de cidades, de uma origem e de um destino, minimizando a distância total.
    
    Pre
    ---------
    Os argumentos origem e destino tem de ser strings, e estas não podem ser strings vazias.
   
    Parameters
    ----------
    origem : string
        Cidade onde vai começar o itinerario
    destino : string
        Última cidade do itinerario
    lista_cidades : list
        Cidades que o itinerario deve conter
    
    Raises
    --------
        KeyError: caso alguma cidade da lista de cidades, ou a origem/destino nao pertença ao dicionario "cidades".
    
    Returns
    -------
    itinerario : list
        itinerario atualizado
    
    >>> construir_itinerario('Lisboa', 'Lisboa', [])
    ['Lisboa', 'Lisboa']
    >>> construir_itinerario('Lisboa', 'Aveiro', [])
    ['Lisboa', 'Aveiro']
    >>> construir_itinerario('Lisboa','Lisboa', ['Lisboa'] )
    ['Lisboa', 'Lisboa', 'Lisboa']
    >>> construir_itinerario('Lisboa', 'Lisboa', ['Porto'])
    ['Lisboa', 'Porto', 'Lisboa']
    >>> construir_itinerario('Lisboa', 'Porto', ['Porto'])
    ['Lisboa', 'Porto', 'Porto']
    >>> construir_itinerario('Lisboa', 'Aveiro', ['Leiria'])
    ['Lisboa', 'Leiria', 'Aveiro']
    >>> construir_itinerario('Lisboa','Lisboa',['Leiria', 'Lisboa'])
    ['Lisboa', 'Lisboa', 'Leiria', 'Lisboa']
    >>> construir_itinerario('Lisboa','Lisboa',['Leiria', 'Aveiro'])
    ['Lisboa', 'Aveiro', 'Leiria', 'Lisboa']
    >>> construir_itinerario('Lisboa','Porto',['Leiria', 'Porto'])
    ['Lisboa', 'Leiria', 'Porto', 'Porto']
    >>> construir_itinerario('Lisboa','Leiria',['Setúbal', 'Aveiro'])
    ['Lisboa', 'Setúbal', 'Aveiro', 'Leiria']
    """
#   _________________________________________________________________________________________________________________________________________
#   |       CARACTERISTICAS                           |                                        TESTES                                        |
#   |_________________________________________________|______________________________________________________________________________________|
#   |Nº elementos da| Origem igual |Origem ou destino |                       Entrada          |                     Saída                   |
#   | lista_cidades | ao destino   |pertencem à lista |                                        |                                             |
#   |---------------+--------------+------------------+----------------------------------------+---------------------------------------------|
#   | 0             |   True       |     True         |                                     INVIAVEL                                         |
#   | 0             |   True       |     False        |'Lisboa', 'Lisboa', []                  |['Lisboa', 'Lisboa']                         |
#   | 0             |   False      |     True         |                                      INVIAVEL                                        |
#   | 0             |   False      |     False        |'Lisboa', 'Aveiro', []                  |['Lisboa', 'Aveiro']                         |
#   |---------------+--------------+------------------+----------------------------------------+---------------------------------------------|
#   | 1             |   True       |     True         |'Lisboa','Lisboa', ['Lisboa']           |['Lisboa', 'Lisboa', 'Lisboa']               |     
#   | 1             |   True       |     False        |'Lisboa','Lisboa', ['Porto']            |['Lisboa', 'Porto', 'Lisboa']                |                                 
#   | 1             |   False      |     True         |'Lisboa', 'Porto', ['Porto']            |['Lisboa', 'Porto', 'Porto']                 |     
#   | 1             |   False      |     False        |'Lisboa', 'Aveiro', ['Leiria']          |['Lisboa', 'Leiria', 'Aveiro']               |     
#   |---------------+--------------+------------------+----------------------------------------+---------------------------------------------|
#   | >1            |   True       |      True        |'Lisboa','Lisboa',['Leiria', 'Lisboa']  |['Lisboa', 'Lisboa', 'Leiria', 'Lisboa']     |
#   | >1            |   True       |      False       |'Lisboa','Lisboa',['Leiria', 'Aveiro']  |['Lisboa', 'Aveiro', 'Leiria', 'Lisboa']     |   
#   | >1            |   False      |      True        |'Lisboa','Porto',['Leiria', 'Porto']    |['Lisboa', 'Leiria', 'Porto', 'Porto']       |
#   | >1            |   False      |      False       |'Lisboa','Leiria',['Setúbal', 'Aveiro'] |['Lisboa', 'Setúbal', 'Aveiro', 'Leiria']    |
#   |_______________|______________|__________________|________________________________________|_____________________________________________|
    itinerario=[origem, destino] 
    levanta_excessao(itinerario)
    levanta_excessao(lista_cidades)       
    lugaresItinerario=list(map(lambda lugar: adicionar_cidade(itinerario,lugar), lista_cidades))
    return itinerario
# testes
if __name__ == '__main__':
    import doctest
    doctest.testmod()