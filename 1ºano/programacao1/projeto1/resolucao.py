#ex1
def carregarVocabulario(filename):
  dic = set()
  for line in open(filename, 'r', encoding='utf8'):
    dic.add(line.rstrip().lower())
  return sorted(dic)

dic = carregarVocabulario('vocabulario.txt')

#ex2
import re
def gerarPalavras(texto):
    filtra=re.split(r'[`\-=~!()_+\[\]{};\n\:;. ,"0123456789|,./<>?]', texto)    
    tiraEspaco=([x for x in filtra if x != ''])
    return tiraEspaco
    
#ex3
def mmLetras(palavra1, palavra2):
    atualiza=0;
    len1= len(palavra1)
    len2= len(palavra2)
    maior=len2
    if len2<len1:
        maior=len1
    menor= len1
    if len2<len1:
        menor= len2
    for i in range(menor):
        if palavra1[i]== palavra2[i]:
            atualiza=atualiza+ 1
    return maior-atualiza

#ex4
def edicoes(palavra1, palavra2):
    tamanho1=len(palavra1)
    tamanho2=len(palavra2)
    if palavra1==palavra2:
        return 0
    if tamanho1 == 0:
        return tamanho2
    elif tamanho2 == 0:
        return tamanho1
    if palavra2[-1] == palavra1[-1]:
        r = 0
    else:
        r = 1
    return min(edicoes(palavra1[:-1], palavra2) +1,(edicoes(palavra1, palavra2[:-1])+1),edicoes(palavra1[:-1],palavra2[:-1])+r)
 
#ex5
def sugerir(dic, palavra, distancia, maxSugestoes=5):
    resultados=[]
    melhores=[]
    for j in dic:
            dista=(distancia(palavra,j))
            resultados.append((((dista, j, palavra))))
    ordena=sorted(resultados, key=lambda _:_[0])
    for m in range(maxSugestoes):
            melhores.append(ordena[m][1])
    return sorted(melhores)
  
#ex6
def corretor(dic, texto, distancia, maxSugestoes=5): 
    resultado=''
    for x in gerarPalavras(texto):
        if x not in dic:
            sugere=str(sugerir(dic, x, distancia, maxSugestoes))
            resultado= resultado + x + ' ' + '-->' + ' ' +sugere + '\n'
    print(resultado)


