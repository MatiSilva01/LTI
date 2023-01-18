import matplotlib.pyplot as plt
import numpy as np

def criarDados(k, ns, mus, covs, seed=-1):
  """
  k    : número de aglomerados
  ns   : lista com os tamanhos de cada aglomerado
  mus  : lista dos centros de cada aglomerado
  covs : lista com as matrizes de covariância
  seed : valor para controlar a aleatoriadade (default -1 -> imprevísivel)
  
  retorna uma lista de pares com coordenadas (x,y)
  """
  if seed != -1:
    np.random.seed(seed)
  xs = []
  ys = []
  for i in range(k):
    x,y = np.random.multivariate_normal(mus[i], covs[i], ns[i]).T
    xs.extend(x)
    ys.extend(y)
  
  return (xs,ys)

def criarPontos(ns, seed=-1):
  """
  requires: len(ns) < 8
  """
  k    = len(ns)
  mus  = [[0, 0], [5,5], [4,-5],[-5,-5],[-4,5],[-7.5,0],[0,8]]
  covs = [
      [[2,    0], [    0,  2]],
      [[1, -0.5], [ -0.5,  1]],
      [[2, 0.75], [ 0.75, .5]],
      [[2, 0.75], [ 0.75, .5]],
      [[2,-0.75], [-0.75,  1]],
      [[1, -0.5],  [-0.5,  1]],
      [[1, -0.5], [ -0.5,  1]],
    ]

  x,y = criarDados(k, ns[:k], mus[:k], covs[:k], seed)
  pts = [ (x[i],y[i]) for i in range(len(x))]
  return pts


pts = criarPontos([140, 50, 100, 160, 120], 101)

for pt in pts:
  plt.scatter(pt[0], pt[1], marker=".", color='k')
plt.show()  