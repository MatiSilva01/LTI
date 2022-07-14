import pickle
import sys

argumentosLinha = list(sys.argv)   
with open(argumentosLinha[1] ,"rb") as inFile:
        x = pickle.load(inFile)
        for y in x[1:]:
               y.split(',')
               print(y)
