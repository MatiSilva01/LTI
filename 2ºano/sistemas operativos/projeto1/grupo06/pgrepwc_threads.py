import sys, os
from threading import Thread

argumentosLinha = list(sys.argv)  #Argumentos da linha de comandos colocados numa lista
argumentosLinha.pop(0) #Porque nao preciso do nome do ficheiro 
opcoes=[]
resultado = 0
ficheiros=[]
palavras=[]

#quando passam os ficheiros e numero de filhos
if '-f' in argumentosLinha and '-p' in argumentosLinha:
    for x in range(len(argumentosLinha)):
        if argumentosLinha[x] == '-p':
            numeroFilhos = int(argumentosLinha[x+1])
            for j in range(0, x):
                opcoes.append(argumentosLinha[j])
            for j in range(x+2, argumentosLinha.index('-f')):
                palavras.append(argumentosLinha[j])
        if argumentosLinha[x] == '-f':
            for j in range(x+1, len(argumentosLinha)):
                ficheiros.append(argumentosLinha[j])

#quando passam os ficheiros mas nao o numero de filhos
if '-f' in argumentosLinha and '-p' not in argumentosLinha: 
    numeroFilhos=1
    if '-a' in argumentosLinha and '-l' in argumentosLinha:
        opcoes.append('-a')
        opcoes.append('-l')
        for x in range(len(argumentosLinha)):
            if argumentosLinha[x] == '-f':
                for j in range(x+1, len(argumentosLinha)):
                    ficheiros.append(argumentosLinha[j])
                for j in range(2,x):
                    palavras.append(argumentosLinha[j])
    if  '-a' not in argumentosLinha and '-l' in argumentosLinha:
        opcoes.append('-l')
        for x in range(len(argumentosLinha)):
            if argumentosLinha[x] == '-f':
                for j in range(x+1, len(argumentosLinha)):
                    ficheiros.append(argumentosLinha[j])
                for j in range(1,x):
                    palavras.append(argumentosLinha[j])
    if '-a' in argumentosLinha and '-c' in argumentosLinha:
        opcoes.append('-c')
        for x in range(len(argumentosLinha)):
            if argumentosLinha[x] == '-f':
                for j in range(x+1, len(argumentosLinha)):
                    ficheiros.append(argumentosLinha[j])
                for j in range(2,x):
                    palavras.append(argumentosLinha[j])
    if '-a' not in argumentosLinha and '-c' in argumentosLinha:
        opcoes.append('-c')
        for x in range(len(argumentosLinha)):
            if argumentosLinha[x] == '-f':
                for j in range(x+1, len(argumentosLinha)):
                    ficheiros.append(argumentosLinha[j])
                for j in range(1,x):
                    palavras.append(argumentosLinha[j])


#quando me passam o numero de filhos mas nao os ficheiros
if '-p' in argumentosLinha and '-f' not in argumentosLinha:
    for x in range(len(argumentosLinha)):
        if argumentosLinha[x] == '-p':
            numeroFilhos = argumentosLinha[x+1]
            for j in range(0, x):
                opcoes.append(argumentosLinha[j])
            for j in range(x+2, len(argumentosLinha)):
                palavras.append(argumentosLinha[j])
    aux = input("Insira os ficheiros a tratar: ")
    auxL = aux.split()
    for x in auxL:
        ficheiros.append(x)
    

#quando nao passam nem os ficheiros nem o numero de filhos 
if '-p' not in argumentosLinha and '-f' not in argumentosLinha:
    numeroFilhos=1
    if '-a' in argumentosLinha and '-c' in argumentosLinha:
        opcoes.append('-c')
        for j in range(2, len(argumentosLinha)):
            palavras.append(argumentosLinha[j])
    if '-a' in argumentosLinha and '-l' in argumentosLinha:
        for j in range(2, len(argumentosLinha)):
            palavras.append(argumentosLinha[j])
        opcoes.append('-a')
        opcoes.append('-l')
    if '-a' not in argumentosLinha and '-l' in argumentosLinha:
        opcoes.append('-l')
        for j in range(1, len(argumentosLinha)):
            palavras.append(argumentosLinha[j])
    if '-a' not in argumentosLinha and '-c' in argumentosLinha:
        opcoes.append('-c')
        for j in range(1, len(argumentosLinha)):
            palavras.append(argumentosLinha[j])
    aux = input("Insira os ficheiros a tratar: ")
    auxL = aux.split()
    for x in auxL:
        ficheiros.append(x)

if numeroFilhos > len(ficheiros): #se o valor de n for superior ao numero de ficheiros, o comando
#redefine-o automaticamente para o numero de ficheiros
    numeroFilhos=len(ficheiros)

def funcao_filho(opcoes, ficheiros, palavras):
    global resultado
    if opcoes == ['-c'] or opcoes == ['-a', '-c']: #porque quando dou os ficheiros e os filhos ele da append ao -a tambem 
        for fich in ficheiros:
            for palavra in palavras:
                    numOccurrences = os.popen("grep -wo -i " + palavra + " " + fich+ " | wc -l").read()
                    resultado+=int(numOccurrences)    
                    print('Sou a nova Thread e contei {} ocorrencias da palavra {} no {}'.format(numOccurrences, palavra, fich))
    if opcoes == ['-l'] or opcoes == ['-a', '-l'] and len(palavras)==1:
        for fich in ficheiros:
            for palavra in palavras:
                linhasContagem=os.popen("grep -wc -i " + palavra + " " + fich).read()
            resultado+=int(linhasContagem)
            print('Sou a nova Thread e contei {} linhas em que aparece a palavra {} no ficheiro {}'.format(linhasContagem, palavra, fich))
    if opcoes == ['-a', '-l'] and len(palavras)==2:
        for fich in ficheiros:
                for i in range(0, len(palavras)-1):
                    linhasContagem=os.popen("grep -i -w " + palavras[0]+" "+fich + " | grep -i -w "+palavras[1]+" | wc -l").read()
                    print('Sou a nova Thread e contei {} linhas em que aparecem simultaneamente as palavras no ficheiro {}'.format(linhasContagem, fich))
                    resultado+=int(linhasContagem)
    if opcoes == ['-a', '-l'] and len(palavras)==3:
            for fich in ficheiros:
                    linhasContagem=os.popen("grep -i -w " + palavras[0]+" "+fich + " | grep -i -w "+palavras[1]+" | grep -i -w " + palavras[2] + " | wc -l").read()
                    print('Sou a nova Thread e contei {} linhas em que aparecem simultaneamente as palavras no ficheiro {}'.format(linhasContagem, fich))
                    resultado+=int(linhasContagem)
#criacao de threads
T = []
ficheirosPorThread = len(ficheiros)//numeroFilhos
resto = len(ficheiros)%numeroFilhos
c = 0
if resto == 0:
    for i in range(numeroFilhos):
        T.append(Thread(target=funcao_filho, args = (opcoes, ficheiros[c:c+ficheirosPorThread], palavras,)))
        c += ficheirosPorThread
else:
    for i in range(numeroFilhos):
        if i < resto:
            T.append(Thread(target=funcao_filho, args = (opcoes, ficheiros[c:c+ficheirosPorThread+1], palavras,)))
            c += ficheirosPorThread+1 
        else:
            P.append(Thread(target=funcao_filho, args = (opcoes, ficheiros[c:c+ficheirosPorThread], palavras,)))
            c += ficheirosPorThread

for thread in T:
    thread.start()
    thread.join()
print("Sou a main Thread, a nova terminou. Recebi: ", str(resultado))