# -*- coding: utf-8 -*-
"""
Created on Tue May  4 20:27:59 2021

@author: Matilde Silva nº56895; Carolina Salvado nº56885
"""
import re
import sys
from matplotlib import pyplot as plt
import csv
import numpy as np
from itertools import groupby
import sys

def ler_csv_dicionario (nome_ficheiro, cabecalho = None):
    """Ler um ficheiro CSV. O ficheiro pode ou não ter cabeçalho.

    Args:
        nome_ficheiro (str): O nome do ficheiro.
        fieldnames (list[str], optional):  A lista com o nomes das colunas.
            Utilizar quando o ficheiro não tiver cabeçalho. Defaults to None.

    Returns:
        list[dict]: Uma lista de dicionarios com o conteúdo do ficheiro;
            as chaves do dicionário são lidas da primeira linha do ficheiro
            ou tiradas da lista cabeçalho.
    """
    with open(nome_ficheiro, encoding='UTF-8') as ficheiro_csv:
        leitor = csv.DictReader(ficheiro_csv, fieldnames = cabecalho)
        return list(leitor)


def limpa_converter(dados, lista_colunas, funs_converter):
    """A função deve devolver o conjunto de dados, isto é, uma lista de dicionários, contendo apenas as
    colunas que interessam para o desenho dos gráficos. Deve também converter as colunas para os valores convenientes. Ou seja,
    a lista de funções funs_converter deve ter uma função para cada coluna escolhida (isto
    é, as listas lista_colunas e funs_converter devem ter o mesmo comprimento) de forma a converter as colunas para os valores convenientes.

    Pre: A lista_colunas e o funs_converter devem ter o mesmo comprimento.

    Args:
        dados (list): Conjunto de dados em forma de lista de dicionários.
        lista_colunas (list): Lista de strings referente ao cabeçalho das colunas que interessam.
        funs_converter (list): Lista de funções para conversão de dados.

    Returns:
        list: Conjunto de dados, ou seja, lista de dicionários, contendo apenas as colunas que interessam para o desenho dos gráficos já convertidas. 
    """
    dictfilt = lambda x, y: dict([(i, x[i]) for i in x if i in y])
    colunas_desejadas = list(map(lambda dic: dictfilt(dic, lista_colunas), dados))
    for dic in colunas_desejadas:
            for index, x in enumerate(dic):
                dic[x]= funs_converter[index](dic[x])
    return colunas_desejadas


def string_para_ano(data_tempo):
    """Esta função converte uma string do tipo "2020-07-07 23:26:58" apenas para o ano com que a string começa.

    Args:
        data_tempo (str): String no formato "ano-mês-dia hora-minuto-segundo".

    Returns:
        int: Ano que corresponde ao primeiro parâmetro do formato da data que está em string.
    """
    lista_Data_Tempo = data_tempo.split(" ", 1)
    lista_Data = lista_Data_Tempo[0].split("-")
    return lista_Data[0]


def auxiliar(lista, coluna, resultado, lista_nova = []):
    """Esta função recebe uma lista, o nome de uma coluna de um ficheiro, e o valor que se quer correspondente
    a essa coluna. Devolve uma lista com o numero de ocorrências da coluna com o respetivo resultado.

    Args:
        lista (list): Lista com os nomes dos jogadores e os jogos onde estes participaram.
        coluna (str): Coluna dos jogos pertencentes à lista.
        resultado (str): Valor que se quer ver filtrado.
        lista_nova (list, optional): Lista vazia onde irão estar o número de ocorrências das colunas com o resultado pretendido. Defaults to [].

    Returns:
        list: Lista com o número de ocorrências das colunas com o resultado pretendido.
    """
    for listas_jogo in lista:
        contador = 0
        for jogo in listas_jogo[1]:
            if jogo[coluna] == resultado:
                contador += 1
        lista_nova.append((listas_jogo[0], contador))
    return lista_nova


def auxiliar2(nome_ficheiro):
    """Função auxiliar que recebe o nome de um ficheiro csv e devolve uma lista com as informações das jogadoras que jogam com 
    peças brancas, as jogadoras que jogam com peças pretas, a lista de jogos com peças brancas a lista de jogos com peças pretas, 
    e o nome de todos os jogadores.

    Args:
        nome_ficheiro (str): Nome do ficheiro.

    Returns:
        list: lista com as jogadoras que jogam com peças brancas, as jogadoras que jogam com peças pretas, a lista de jogos com peças
    brancas a lista de jogos com peças pretas, e o nome de todos os jogadores.
    """
    dicionario = list(limpa_converter(ler_csv_dicionario(nome_ficheiro), ['white_username', 'white_result', 'black_username', 'black_result'], [str, str, str, str]))
    dicionario_ordenado = sorted(dicionario, key = lambda x: x['white_username'])
    jogadores_agrupados_por_pecas_brancas = groupby(dicionario_ordenado, key= lambda l: l['white_username'])
    jogadores_brancas = list(map(lambda x: (x[0].lower(), list(x[1])), jogadores_agrupados_por_pecas_brancas))
    dicionario_ordenado2 = sorted(dicionario, key = lambda x: x['black_username'])
    jogadores_agrupados_por_pecas_pretas = groupby(dicionario_ordenado2, key= lambda l: l['black_username'])
    jogadores_pretas = list(map(lambda x: (x[0].lower(), list(x[1])), jogadores_agrupados_por_pecas_pretas))
    lista_jogos_brancos = list(map(lambda x: (x[0], len(x[1])), jogadores_brancas))
    lista_jogos_pretos = list(map(lambda x: (x[0], len(x[1])), jogadores_pretas))
    nomes_todos_jogadores = list(map(lambda x: x[0], jogadores_pretas + jogadores_brancas))
    return [jogadores_brancas, jogadores_pretas, lista_jogos_brancos, lista_jogos_pretos, nomes_todos_jogadores]


def auxiliar3(lista_toda, lista):    
    """Função auxiliar que recebe duas listas e devolve um dicionário.

    Args:
        lista_toda (list): Lista de listas.
        lista (list): Lista de listas.

    Returns:
        dict: Dicionário contendo o nome de cada jogador e valor uma lista de tuplos contendo as diferentes ocorrências de 
        número de jogos com peças pretas e com peças brancas, número de vitórias com a respetiva peça, e o número de vitórias
        por xeque-mate com peças brancas e também com peças pretas.
    """
    dic = {}
    for jogador in set(lista_toda[-1]):
        dic[jogador] = [('nºjogosBrancos', 0),('nºjogosPretos', 0),('nºvitoriasBrancas', 0),('nºvitoriasPretas', 0), ('vitoriasXequeBranco', 0), ('vitoriasXequePreto', 0)]
    
    for sublista in lista:
        for x in sublista:
            if x[0] in dic:
                dic[x[0]][lista.index(sublista)] = (dic[x[0]][lista.index(sublista)][0], x[1])
    return dic


def desenhaGrafico2Eixos(abcissas, ordenadasEsq, ordenadasDireita):
    """Esta função recebe três argumentos, uma lista de abcissas, uma lista com as ordenadas do eixo da esquerda e outra lista com as ordenadas do
    eixo da direita. Desenha uma gráfico de barras em que as abcissas correspondem às ordenadas do lado esquerdo e um gráfico de linha em que as
    mesmas abcissas correspondem às ordenadas do lado direito.

    Args:
        abcissas (list): Lista das abcissas.
        ordenadasEsq (list): Lista das ordenadas que ficam no lado esquerdo do gráfico.
        ordenadasDireita (list): Lista das ordenadas que ficam no lado direito do gráfico.
    """
    fig, ax1 = plt.subplots()
    plt.title('Jogos e jogadoras por ano')
    ax1.set_xlabel('Ano')
    ax1.set_ylabel('Jogos', color='darkgreen')
    ax1.bar(abcissas, ordenadasEsq, color='darkgreen')
    ax1.tick_params(axis='y')
    plt.xticks(rotation= 90)
    ax2 = ax1.twinx()
    ax2.set_ylim(0, 12900)
    ax2.set_ylabel('#Jogadoras diferentes', color='blue') 
    ax2.plot(abcissas, ordenadasDireita, color = 'blue')
    ax2.tick_params(axis='y')
    ax1.legend(['#Jogos'], bbox_to_anchor=(0, -0.42, 1, 1)) 
    ax2.legend(['#Jogadoras Diferentes'])
    fig.tight_layout() 
    plt.show()


def desenhaGrafico(lista_abcissas, lista_ordenadas, n):
    """Esta função recebe três argumentos, uma lista de abcissas, uma lista com as ordenadas,
    e um inteiro n, que configura o número de abcissas a serem mostradas.

    Args:
        lista_abcissas (list): Lista com as abcissas para desenhar os gráficos.
        lista_ordenadas (list): Lista com as ordenadas para desenhar os gráficos.
        n (int): Número inteiro.
    """
    subplots = [(2, 3, 1, 'rapid'), (2, 3, 2, 'daily'), (2, 3, 3, 'bullet'), (2, 3, 4, 'blitz'), (2, 3, 5, 'time_class')]
    for x in subplots:
        plt.subplot(x[0], x[1], x[2])
        plt.bar(lista_abcissas[x[2] - 1][:n], lista_ordenadas[x[2] - 1][:n])
        plt.ylabel('#Jogos')
        plt.xlabel('Formato de Jogo')
        plt.xticks(rotation = 90)
        plt.title(x[3])
        
    plt.tight_layout()
    plt.subplots_adjust(hspace = 1.6, wspace = 1)
    plt.show()


def comando_anos(nome_ficheiro):
    """Esta função tem o objetivo de gerar um gráfico de barras que representa o número de jogos por ano
    e um gráfico de linhas representando o número de jogadoras diferentes que jogaram xadrez nos diferentes 
    anos.

    Args:
        nome_ficheiro (str): Nome do ficheiro a ser usado.
    """
    dicionario_jogadoras_ano = list(limpa_converter(ler_csv_dicionario(nome_ficheiro), ['black_username', 'white_username', 'end_time'], [string_para_ano, str, str]))
    anos = sorted(list(set(map(lambda x: x['end_time'], dicionario_jogadoras_ano))))
    listaTodosAnos = list(map(lambda x: list(filter(lambda y: y['end_time']==str(x),dicionario_jogadoras_ano)),anos))
    ordenadasEsq = list(map(lambda x: len(x), listaTodosAnos))
    todas = list(map(lambda y: set(list(map(lambda x: x['white_username'], listaTodosAnos[y])) + list(map(lambda x: x['black_username'], listaTodosAnos[y]))), range(len(anos))))
    ordenadasDireita = list(map(lambda x: len(x), todas))
    desenhaGrafico2Eixos(anos, ordenadasEsq, ordenadasDireita)


def comando_classes(nome_ficheiro, n = 5):
    """Esta função tem o objetivo de gerar vários gráfico de barras, (por omissão 5) que representam a distribuição de jogos por formato de jogo.

    Args:
        nome_ficheiro (str): Nome do ficheiro a ser usado.
        n (int): Número de classes com maior número de jogos.
    """
    dicionario_ordenado = sorted(list(limpa_converter(ler_csv_dicionario(nome_ficheiro), ['time_class', 'time_control'], [str,str])), key = lambda x: x['time_class'])
    par_ordenadas = list(map(lambda x: (x[0], list(x[1])), groupby(dicionario_ordenado, key= lambda l: l['time_class'])))
    lista_pares_ordenados = []
    for x in range(len(par_ordenadas)):
        valores_agrupados_graf = groupby(sorted(par_ordenadas[x][1], key = lambda x: x['time_control']), key= lambda l: l['time_control'])
        par_ordenado = sorted(list(map(lambda x: (x[0], len(list(x[1]))), valores_agrupados_graf)), key = lambda x: x[1], reverse = True)
        lista_pares_ordenados.append(par_ordenado)
    par_ordenadas_graf_5 = list(map(lambda x: (x[0], len(list(x[1]))), groupby(dicionario_ordenado, key= lambda l: l['time_class'])))
    lista_abcissas = [list(map(lambda x: x[0], lista_pares_ordenados[3]))] + [list(map(lambda x: x[0], lista_pares_ordenados[2]))] + [list(map(lambda x: x[0], lista_pares_ordenados[1]))] + [list(map(lambda x: x[0], lista_pares_ordenados[0]))] + [list(map(lambda x: x[0], par_ordenadas_graf_5))]
    lista_ordenadas = [list(map(lambda x: x[1], lista_pares_ordenados[3]))] + [list(map(lambda x: x[1], lista_pares_ordenados[2]))] + [list(map(lambda x: x[1], lista_pares_ordenados[1]))] + [list(map(lambda x: x[1], lista_pares_ordenados[0]))] + [list(map(lambda x: x[1], par_ordenadas_graf_5))]
    desenhaGrafico(lista_abcissas, lista_ordenadas, n)
    

def desenhaGraficoVitorias(lista_abcissas, lista_ordenadas2, lista_ordenadas1, n):
    """Função que configura um gráfico de barras agrupadas.

    Args:
        lista_abcissas (list): Lista com as abcissas para desenhar os gráficos.
        lista_ordenadas2 (list): Lista com as ordenadas para desenhar os gráficos.
        n (int): Número de jogadores a mostrar no gráfico.
    """
    fig, ax1= plt.subplots()
    bar1 = np.arange(len(lista_abcissas[:n]))
    ax1.bar(bar1 - 0.4/2, lista_ordenadas2[:n], 0.4, color='lightgray')
    ax1.bar(bar1 + 0.4/2, lista_ordenadas1[:n], 0.4, color='black')
    ax1.tick_params(axis='y')
    plt.xlabel('jogadoras')
    plt.xticks(rotation = 90)
    plt.title('Percentagem de vitórias jogando com\n peças brancas/pretas')
    ax1.legend(['peças brancas','peças pretas'])
    plt.ylabel('Percentagem ') 
    plt.xticks(bar1, lista_abcissas[:n]) 
    fig.tight_layout()
    plt.show()

def auxiliarSemJogadores(dic, n):
    """
    Função auxiliar à função 'comando_vitorias' para quando a lista de jogadores não é passada à função.
    Args:
        dic (dict): Dicionario composto pelo nome dos jogadores(chaves), e por uma lista correspondente 
        às estatisticas do jogador (valor).
        n (int): nº de jogadores a mostrar no gráfico  
    """
    novo_dic = {}
    for x in dic:
        novo_dic[x] = [dic[x][0][1],dic[x][1][1], dic[x][2][1], dic[x][3][1]]    
    dicOrdenado = dict(sorted(novo_dic.items(), key=lambda item: item[1], reverse=True))
    dicOrdenadoSemZero = list(filter(lambda x: novo_dic[x][1] != 0, dicOrdenado))
    dicOrdenadoSemZero2 = list(filter(lambda x: novo_dic[x][0] != 0, dicOrdenado))
    jogadoras=(list(dicOrdenado))
    abcissas=jogadoras[:n]
    ordenadasvitBrancas= list(map(lambda x: novo_dic[x][2]/novo_dic[x][0], dicOrdenadoSemZero2))
    ordenadasvitPretas= list(map(lambda x: novo_dic[x][3]/novo_dic[x][1], dicOrdenadoSemZero))
    desenhaGraficoVitorias(abcissas, ordenadasvitBrancas, ordenadasvitPretas, n)

def comando_vitorias(nome_ficheiro, jogadores = None, n=5):
    """
    Função que gera um gráfico referente às percentagens de vitória para cada jogadora 
    consoante a cor da peça(branca ou preta) escolhida para cada jogador.
    Args:
        nome_ficheiro (str): Nome do ficheiro (.csv) ao qual se irá extrair a informação.
        n (int): Número de jogadores a mostrar no gráfico.
        jogadores (list): Lista com as jogadoras a mostrar no gráfico, por default mostra as jogadoras com mais jogos.

    """
    lista_toda = auxiliar2(nome_ficheiro)
    dic = auxiliar3(lista_toda, [lista_toda[2], lista_toda[3], auxiliar(lista_toda[0], 'white_result', 'win', []), auxiliar(lista_toda[1], 'black_result', 'win', [])])
    if jogadores !=None:
        novo={}
        for x in jogadores:
            jogador = x.lower()
            novo[jogador]= [dic[jogador][0][1],dic[jogador][1][1], dic[jogador][2][1], dic[jogador][3][1]]
        ordenadasvitBrancas= list(map(lambda x: novo[x][2]/novo[x][0], novo))
        ordenadasvitPretas= list(map(lambda x: novo[x][3]/novo[x][1], novo))
        desenhaGraficoVitorias([x.lower() for x in jogadores], ordenadasvitBrancas, ordenadasvitPretas, n)
    else: 
        auxiliarSemJogadores(dic, n)


def desenhaGraficoSeguinte(lista_abcissas, lista_ordenadas, n, jogada):
    """Esta função recebe uma lista de abcissas, uma lista de ordenadas, uma jogada e um número inteiro n e desenha um gráfico de barras
    das top-n jogadas mais provável após a jogada que se introduzir.

    Args:
        lista_abcissas (list): Lista de valores a apresentar no eixo das abcissas.
        lista_ordenadas (list): Lista de valores a apresentar no eixo das ordenadas.
        jogada (str): Nome da primeira jogada, da qual se querem ver as probabilidades de ocorrência de jogadas seguintes.
        n (int): Inteiro que define o número de abcissas a serem apresentadas no gráfico.
    """
    plt.bar(lista_abcissas[:n], lista_ordenadas[:n])
    plt.title('Jogadas mais prováveis depois de ' + jogada)
    plt.xlabel('Jogadas')
    plt.ylabel('Probabilidade')
    plt.show()

def contaFrequencias(lista):
    """Esta função recebe uma lista de valores e conta o número de ocorrências de um dado valor na lista.

    Args:
        lista (list): Lista de valores.

    Returns:
        dic: Dicionário em que as chaves são os valores da lista, e os valores são o número de ocorrências respetivo ao valor. 
    """
    freq = {}
    for item in lista:
        if (item in freq):
            freq[item] += 1
        else:
            freq[item] = 1
    return freq

def levantaExcecao(tamanho2, jogada, n, lista = []):
    """
    Função auxiliar à função 'comando_seguinte', para a realização do gráfico caso 
    a jogada passada como argumento à função seja válida.
    Raises:
        ValueError: Caso a jogada não ocorra nenhuma vez como primeira jogada.
    Args:
        lista (list): Lista com as jogadas realizadas como primeira jogada.
        tamanho2 (list): Lista com apenas as duas primeiras jogadas
        n (int): Número de jogadores a mostrar no gráfico.
        jogada (str): Jogada sobre a qual se gera o gráfico        
    """
    try:
        for x in tamanho2:
            if x[0] not in lista:
                lista.append(x[0])
        valores = list(map(lambda x: [], lista))
        for x in lista:
            for y in tamanho2:
                if y[0]==x:
                    valores[lista.index(x)].append(y[1])
        lista_dic = list(map(lambda x: contaFrequencias(x), valores))
        indice_jogada = lista.index(jogada)
        abcissas = sorted(lista_dic[indice_jogada], key = lambda x: lista_dic[indice_jogada][x], reverse=True)
        ordenadas = list(map(lambda x: lista_dic[indice_jogada][x], abcissas))
        ordenadas_final = list(map(lambda x: round(x/sum(ordenadas), 2), ordenadas))
        desenhaGraficoSeguinte(abcissas, ordenadas_final, n, jogada)
    except ValueError: 
        print('Essa jogada nunca ocorreu como primeira jogada num jogo.')


def comando_seguinte(nome_ficheiro, n = 5, jogada = 'e4'):
    """Função que gera um gráfico de barras das top-n jogadas mais prováveis após uma dada jogada.
    
    Args:
        nome_ficheiro (str): Nome do ficheiro csv ao qual se irá extrair a informação.
        n (int): Número de jogadores a mostrar no gráfico.
        jogada (str): Jogada sobre a qual se gera o gráfico
    """
    
    dicionario = list(limpa_converter(ler_csv_dicionario(nome_ficheiro), ['game_id', 'pgn'], [str, str]))
    dicionario_filtrado = list(filter(lambda x: 'https:' not in x['game_id'], dicionario))
    so_pgn = list(map(lambda x: x['pgn'], dicionario_filtrado))
    separar = list(map(lambda x: x.split()[1:2] + x.split()[5:6], so_pgn))
    removeVazia = [ele for ele in separar if ele != []]
    tamanho2 = list(filter(lambda x: len(x)==2, removeVazia))
    levantaExcecao(tamanho2, jogada, n)



def desenhaGraficoMate(lista_abcissas, lista_ordenadas1, lista_ordenadas2, lista_ordenadas3, n): 
    """Função que configura dois gráficos (um de barras agrupadas e outro em forma de linha)
     com dois eixos de ordenadas distintos.

    Args:
        lista_abcissas (list): Lista com as abcissas para desenhar os gráficos.
        lista_ordenadas1 (list): Lista com as ordenadas para desenhar os gráficos.
        lista_ordenadas3 (list): Lista com as ordenadas para desenhar os gráficos.
        n (int): Número de jogadores a mostrar no gráfico.
    """
    fig, ax1= plt.subplots()
    bar1 = np.arange(len(lista_abcissas[:n]))
    ax1.bar(bar1 - 0.4/2, lista_ordenadas2[:n], 0.4, color='gainsboro')
    ax1.bar(bar1 + 0.4/2, lista_ordenadas1[:n], 0.4)
    ax1.tick_params(axis='y')
    plt.ylabel('#Jogos')   
    plt.xticks(rotation = 90)
    plt.title('Percentagem de xeque-mate,\n jogos ganhos, e jogos ganhos por xeque-mate')
    ax2 = ax1.twinx()
    ax2.plot(lista_abcissas[:n], lista_ordenadas3[:n], color='darkred')
    ax2.tick_params(axis='y')
    ax1.legend(['Jogos ganhos por xeque-mate','Jogos ganhos'])
    ax2.legend(['Percentagem\n de xeque-mate'], loc = 'center left') 
    plt.ylabel('Percentagem de xeque-mate', color='darkred') 
    fig.tight_layout() 
    plt.xticks(bar1, lista_abcissas[:n]) 
    plt.show()
    

def comando_mate(nome_ficheiro, n = 5):
    """
    Função que gera dois gráficos (um de barras agrupadas outro de linha) referente a o número de jogos ganhos por
    xeque-mate e ao número de jogos ganhos de qualquer modo.
    Args:
        nome_ficheiro (str): Nome do ficheiro csv ao qual se irá extrair a informação.
        n (int): Número de jogadores a mostrar no gráfico.

    """
    lista_toda = auxiliar2(nome_ficheiro)
    lista_jogos_brancos_ganhos = auxiliar(lista_toda[0], 'white_result', 'win', [])
    lista_jogos_brancos_xeque_mate = auxiliar(lista_toda[0], 'black_result', 'checkmated', [])
    lista_jogos_pretos_ganhos = auxiliar(lista_toda[1], 'black_result', 'win', [])
    lista_jogos_pretos_xeque_mate = auxiliar(lista_toda[1], 'white_result', 'checkmated', [])
    dic = auxiliar3(lista_toda, [lista_toda[2], lista_toda[3], lista_jogos_brancos_ganhos, lista_jogos_pretos_ganhos, lista_jogos_brancos_xeque_mate, lista_jogos_pretos_xeque_mate])
    novo_dic = {}
    for x in dic:
        novo_dic[x] = [dic[x][0][1]+dic[x][1][1], dic[x][2][1]+ dic[x][3][1], dic[x][4][1] + dic[x][5][1]]    
    dic_ordenado = sorted(novo_dic, key = lambda x: novo_dic[x][1], reverse=True)
    dic_ord_sem_zeros = list(filter(lambda x: novo_dic[x][1] != 0, dic_ordenado))
    ordenadas1 = list(map(lambda x: novo_dic[x][1], dic_ordenado))
    ordenadas2 = list(map(lambda x: novo_dic[x][2], dic_ordenado))
    ordenadas3 = list(map(lambda x: novo_dic[x][2]/novo_dic[x][1], dic_ord_sem_zeros))
    desenhaGraficoMate(list(map(lambda x: x, dic_ordenado)), ordenadas1, ordenadas2, ordenadas3, n)


def comando_extrair(nome_ficheiro, nome_ficheiro_saida, exp = '.*', coluna = 'wgm_username', separador = ','):
    """Esta função irá extrair a informação de um ficheiro csv, para um novo, abrangendo as linhas
    de interesse através da expressão regular e da coluna do ficheiro onde a expressão irá atuar.

    Args:
        nome_ficheiro (str): Nome do ficheiro original, com os dados todos.
        nome_ficheiro_saida (str): Nome a dar ao ficheiro que queremos obter.
        exp (str): Expressão regular a ser usada.
        coluna (str): Nome da coluna onde será testada a expressão regular.
        separador (str, optional): Separador a ser usado aquando da escrita do ficheiro de saída. Defaults to ','.
    """
    dados = ler_csv_dicionario(nome_ficheiro)
    lista_exp = list(map(lambda linha: re.findall(exp, linha[coluna]), dados))
    lista_indices = list(filter(lambda indice: lista_exp[indice] != [], range(len(lista_exp))))
    dic_final = list(map(lambda x: dados[x], lista_indices))
    cabecalho = ['game_id','game_url','pgn','time_control','end_time','rated','time_class','rules','wgm_username','white_username','white_rating','white_result','black_username','black_rating','black_result']
    with open(nome_ficheiro_saida, 'w', newline='') as ficheiro_csv:
        escritor = csv.DictWriter(ficheiro_csv, cabecalho, delimiter = separador)
        escritor.writeheader()
        for linha in dic_final:
            escritor.writerow(linha)

def classes():
    """
    Esta função desenha os gráficos do comando "classes" de acordo com os parametros que o utilizador 
    passa na linha de comando, neste caso pode-se escolher o número de abcissas do gráfico, a partir 
    da opção -c e através da opção -u podemos especificar os nomes das n jogadoras.
    """
    n=5
    for x in range(len(sys.argv)):
            if sys.argv[x] == '-c':
                n = int(sys.argv[x + 1])
    comando_classes(sys.argv[1], n)

def vitorias():
    """
    Esta função desenha o gráfico do comando "vitórias" de acordo com os parametros que o utilizador 
    passa na linha de comando, neste caso pode-se escolher o número de abcissas do gráfico, a partir 
    da opção -c e através da opção -u podemos especificar os nomes das n jogadoras.
    """
    n=5
    jogadores = None
    for x in range(len(sys.argv)):
        if sys.argv[x] == '-c':
            n = int(sys.argv[x + 1])
        if sys.argv[x] == '-u':
            jogadores = [sys.argv[x] for x in range(x + 1, len(sys.argv))]
            n = len(jogadores)
    comando_vitorias(sys.argv[1], jogadores, n) 

def seguinte():
    """
    Esta função desenha o gráfico do comando "seguinte" de acordo com os parametros que o utilizador 
    passa na linha de comando, neste caso pode-se escolher o número de abcissas do gráfico, a partir 
    da opção -c, bem como a jogada a considerar. Esta pode ser passada na
    linha de comandos com a opção -j.
    """
    n=5
    jogada = 'e4'
    for x in range(len(sys.argv)):
        if sys.argv[x] == '-j':
            jogada = sys.argv[x + 1]
        if sys.argv[x] == '-c':
            n = int(sys.argv[x + 1])
    comando_seguinte(sys.argv[1], n, jogada)

def mate():
    """
    Esta função desenha o gráfico do comando "mate" de acordo com os parametros que o utilizador 
    passa na linha de comando, neste caso pode-se escolher o número de abcissas do gráfico, a partir 
    da opção -c.
    """
    n=5
    for x in range(len(sys.argv)):
        if sys.argv[x] == '-c':
            n = int(sys.argv[x + 1])
    comando_mate(sys.argv[1], n)

def extrair():
    """
    Esta cria um ficheiro csv a partit do comando "extrair" de acordo com os parametros que o utilizador 
    passa na linha de comando, neste caso, a opção -o nome_ficheiro especifica o nome do ficheiro a criar com os
    novos dados. Já a opção -r expressão_regular identifica as linhas de interesse, e a opção -d coluna indica a 
    coluna na qual a expressão regular é testada.
    """
    for x in range(len(sys.argv)):
        if sys.argv[x] == '-o' :
            ficheiro_saida = sys.argv[x + 1]
        if sys.argv[x] == '-r':
            exp = sys.argv[x + 1]
        if sys.argv[x] == '-d':
            coluna = sys.argv[x + 1]
        if '-o' not in sys.argv:
            ficheiro_saida = 'out.csv'
        if '-r' not in sys.argv:
            exp = '.*'
        if '-d' not in sys.argv:
            coluna = 'wgm_username'                
    comando_extrair(sys.argv[1], ficheiro_saida, exp, coluna)

if __name__ == '__main__':
    import sys
    utilizacao = 'Utilização:  projeto.py ficheiro.csv comando opcoes'
    comandos = ['classes', 'vitorias', 'seguinte', 'mate', 'extrair']
    funcoes = [classes, vitorias, seguinte, mate, extrair]
    if len(sys.argv) <= 1:
        print(utilizacao)
    elif len(sys.argv) > 1:
        if sys.argv[2] == 'anos':
            comando_anos(sys.argv[1])
        for x in comandos:
            if sys.argv[2] == x:
                funcoes[comandos.index(x)]()
