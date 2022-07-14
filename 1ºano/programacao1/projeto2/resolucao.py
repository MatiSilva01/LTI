#ex1
import math
def distancia(pt1, pt2):
    um=(float(pt1[0]-pt2[0]))
    um2=um*um
    dois=(float(pt1[1]-pt2[1]))
    dois2=dois*dois
    soma= um2 + dois2
    raiz=soma**0.5
    return raiz

#ex2
def sugerirCentroide(centros, pt):
    distancias=[]
    k=len(centros)
    if k==1: 
        return 0
    else:
        for m in centros:
            distancias.append(distancia(m, pt))
            minimo=min(distancias)
            indice=distancias.index(minimo)
        return(indice)

#ex3
def encontrarCentroMassa(pts):
    k=len(pts)
    somax=sum([pt[0] for pt in pts])
    somay=sum([pt[1] for pt in pts])
    x=somax/k
    y=somay/k
    return (x,y)

#ex4
import doctest
def aglomerar(k, pts, tol=0.001, maxIter=500):
    """
    Função que calcula aglomerados, devolvendo uma lista de paress dos centroides mais proximos
    k=numero de aglomerados
    requires : type(k) is int
    requires : k > 0 
    """
    aglomerados=[] 
    centroides=[]
    for valor in range(0,k): #1.Definir os primeiros k pontos da lista como centróides (inicialização)
        aglomerados.append([]) #consoante o k faz k vezes [] onde esta o ponto e o centroide, fica assim uma lista de listas onde cada uma associa ao ponto
        inicializa=pts[valor]#inicializaçao
        centroides.append(inicializa)
    iteracoes = 0
    associacaoDePontos={} #com um dicionario pois este guarda pares (chave, valor), e nos quermos associar(ponto,centMaisProx)
    #while porque nao sei o numero de iteracoes necessarias
    while iteracoes < maxIter: # enquanto o num de interacoes for menor que o num max de iter (condicao de paragem):
        for pto in pts: #2.para cada ponto da lista de pontos faz o seguinte (Repetir os seguintes passos):
            Kaglomerados = sugerirCentroide(centroides,pto) # devolve o indice do cent mais prox2.1
            #Associar cada ponto da lista ao centróide mais perto, isto vai produzir k aglomerados à volta dos centróides
            if pto in associacaoDePontos: #se ja esta no dic
                aglomerados[associacaoDePontos[pto]].remove(pto) #tira
            aglomerados[Kaglomerados].append(pto) # se ainda nao esta, associa o
            associacaoDePontos[pto]=Kaglomerados #Kaglomerados 1. associar cada ponto da lista ao 
            #centróide mais perto, isto vai produzir k aglomerados à volta dos centróides
        for valor in range(0,k):
            novosCentroides = encontrarCentroMassa(aglomerados[valor]) #2.2Uma vez criados 
            #os aglomerados, calcular os respetivos centros de massa; estes serão os novos centróides
            somaDist=0
            somaDist+=distancia(centroides[valor], novosCentroides) #Para tal vamos somar as distâncias 
            #da cada novo centróide com a sua versão anterior
            centroides[valor] = novosCentroides #centroides ->versao atual dos centroides
        if somaDist > tol: #Esta soma terá de ser menor que um valor de tolerância dado;
            continue
        break
    return centroides #lista com a versão atual dos centróides.

#ex5
def custear(centros, pts):
    tamanho=len(pts)
    final=[]
    for j in range(tamanho):
        minimoIndice=sugerirCentroide(centros,pts[j])
        distanciaMenor=distancia(pts[j], centros[minimoIndice])
        final.append(distanciaMenor**2)
        soma=sum(final)
    return soma
    
#ex6
def sugerirK(pts, minK=2, maxK=10):
  """
  requires: minK >= 2
  requires: minK < maxK
  """
  lista1=[]
  lista2=[]
  for k in range(minK, maxK):
      centros=aglomerar(k,pts)
      distancias=custear(centros,pts)
      distancias2=int(distancias *(k**1.5))
      lista2.append(distancias2)
      minimo=min(lista2)
      indice=lista2.index(minimo)
      kMelhor=indice+minK
  return(kMelhor)

