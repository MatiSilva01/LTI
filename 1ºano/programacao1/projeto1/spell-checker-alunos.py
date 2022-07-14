# -*- coding: utf-8 -*-

import doctest
import re

###########################

def carregarVocabulario(filename):
  """
  >>> len(carregarVocabulario('vocabulario.txt'))
  41952
  """
  dic = set()
  for line in open(filename, 'r', encoding='utf8'):
    dic.add(line.rstrip().lower())
  return sorted(dic)

dic = carregarVocabulario('vocabulario.txt')

#########################

def gerarPalavras(texto):
  """
  >>> gerarPalavras('Em 2020 observamos, e catalogamos (com fotografias), os barcos que chegaram ao Porto! Até breve.')
  ['Em', 'observamos', 'e', 'catalogamos', 'com', 'fotografias', 'os', 'barcos', 'que', 'chegaram', 'ao', 'Porto', 'Até', 'breve']
  """
  pass

###########################

def mmLetras(palavra1, palavra2):
  """
  >>> mmLetras('promessa', 'promessa')
  0
  
  >>> mmLetras('promessa', 'passagem')
  7
  
  >>> mmLetras('antes', 'depois')
  6
  """
  pass

###########################
  
def edicoes(palavra1, palavra2):
  """
  >>> edicoes('promessa', 'promessa')
  0
  
  >>> edicoes('promessa', 'passagem')
  7
  
  >>> edicoes('antes', 'depois')
  5
  """
  pass
   
#########################

def sugerir(dic, palavra, distancia, maxSugestoes=5):
  """
  maxSugestoes : numero de sugestoes
  
  >>> sugerir(dic, 'promeessa', mmLetras, 2)
  ['profetisa', 'progresso']
  
  >>> sugerir(dic, 'promeessa', edicoes)
  ['homessa', 'premissa', 'pressa', 'processar', 'promessa']
  """
  pass


#########################

def corretor(dic, texto, distancia, maxSugestoes=5): 
  pass
    
#########################

# doctest.testmod()  # descomente para ativar os testes