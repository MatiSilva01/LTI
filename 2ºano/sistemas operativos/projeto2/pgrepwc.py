#coding=utf-8
import sys, os
from multiprocessing import Process, Value, Lock
import signal, time, sys, datetime
from multiprocessing.managers import SyncManager
import pickle 
from timeit import default_timer as timer
from datetime import timedelta

start = timer()
sinal=Value("i",0)
Processos=[]
argumentosLinha = list(sys.argv)        #Argumentos da linha de comandos colocados numa lista
argumentosLinha.pop(0) #Porque nao preciso do nome do ficheiro
ficheirosProcessados = Value("i",0)
tempo=0
nome=''
mutex = Lock()
numeroFilhos=0
opcoes=[]
ficheiros=[]
palavras=[]
indice=0
indice2=0
resultado = Value ('i', 0)
contralador = Value ('i', 0)
inicio_programa = datetime.datetime.now().strftime('%d/%m/%Y %H:%M:%S:%f') 
time_T = datetime.datetime.now()
start_time = time.time()
mutex = Lock()
num_linhas = Value('i',0)
linhasProcessada=Value("i", 0)

def mgr_init():
    signal.signal(signal.SIGINT, signal.SIG_IGN)

manager = SyncManager()
manager.start(mgr_init)
listaHpwc2 = manager.list()


if '-f' not in argumentosLinha:
    ficheiroInput = input("Insira os ficheiros a analisar: ")
    ficheiroInputSeparado = ficheiroInput.split()
    print(ficheiroInputSeparado)
    for x in ficheiroInputSeparado:
        ficheiros.append(x)

for elemento in argumentosLinha:
    if '-w' == elemento:
        tempo = int(argumentosLinha[argumentosLinha.index('-w')+1])
    if '-o' == elemento and '-f' not in argumentosLinha:
        nome=argumentosLinha[argumentosLinha.index('-o')+1]
        for x in range(argumentosLinha.index('-o')+2, len(argumentosLinha)):
            palavras.append(argumentosLinha[x])
    if '-o' == elemento and '-f' in argumentosLinha:
        nome=argumentosLinha[argumentosLinha.index('-o')+1]
        for x in range(argumentosLinha.index('-o')+2, argumentosLinha.index('-f')):
            palavras.append(argumentosLinha[x])
    if '-a' == elemento and '-l' in argumentosLinha:
        opcoes.append('-a')
        opcoes.append('-l')
    if '-l' == elemento and '-a' not in opcoes:
        opcoes.append('-l')
    if '-c' == elemento:
        opcoes.append('-c')
    if '-f' == elemento:
        for i in range(argumentosLinha.index('-f')+1, len(argumentosLinha)):
            ficheiros.append(argumentosLinha[i])
    if '-p' == elemento:
        numeroFilhos = int(argumentosLinha[argumentosLinha.index('-p')+1])
    if '-w' == elemento and '-o' not in argumentosLinha and '-f' not in argumentosLinha:
        for j in range(argumentosLinha.index('-w')+2, len(argumentosLinha)):
            palavras.append(argumentosLinha[j])
    if '-w' == elemento and '-o' not in argumentosLinha and '-f' in argumentosLinha:
        for j in range(argumentosLinha.index('-w')+2, argumentosLinha.index('-f')):
            palavras.append(argumentosLinha[j])
    if '-p' == elemento and '-w' not in argumentosLinha and '-o' not in argumentosLinha and '-f' not in argumentosLinha:
        for j in range(argumentosLinha.index('-p')+2, len(argumentosLinha)):
            palavras.append(argumentosLinha[j])
    if '-p' == elemento and '-w' not in argumentosLinha and '-o' not in argumentosLinha and '-f' in argumentosLinha:
        for j in range(argumentosLinha.index('-p')+2, argumentosLinha.index('-f')):
            palavras.append(argumentosLinha[j])
    if '-l' == elemento and '-p' not in argumentosLinha and '-w' not in argumentosLinha and '-o' not in argumentosLinha and '-f' not in argumentosLinha:
        for j in range(argumentosLinha.index('-l')+1, len(argumentosLinha)):
            palavras.append(argumentosLinha[j])
    if '-l' == elemento and '-p' not in argumentosLinha and '-w' not in argumentosLinha and '-o' not in argumentosLinha and '-f' in argumentosLinha:
        for j in range(argumentosLinha.index('-l')+1, argumentosLinha.index('-f')):
            palavras.append(argumentosLinha[j])
    if '-c' == elemento and '-p' not in argumentosLinha and '-w' not in argumentosLinha and '-o' not in argumentosLinha and '-f' not in argumentosLinha:
        for j in range(argumentosLinha.index('-c')+1, len(argumentosLinha)):
            palavras.append(argumentosLinha[j])
    if '-c' == elemento and '-p' not in argumentosLinha and '-w' not in argumentosLinha and '-o' not in argumentosLinha and '-f' in argumentosLinha:
        for j in range(argumentosLinha.index('-c')+1, argumentosLinha.index('-f')):
            palavras.append(argumentosLinha[j])
    if '-w' not in argumentosLinha:
        tempo=0

#Trata dos sinais enviados SIGINT enviados pelo utilizador usando ctrl+C 
def handler_input(sig, NULL):
    print('-----------------------------------------------------------')
    print('------- PROGRAMA INTERROMPIDO, TERMINARA EM BREVE. --------')
    print('-----------------------------------------------------------')
    for processo in Processos:
        try:
            processo.terminate()
        except:
            pass
    

def handler_timeout_w(sig, NULL):
    print("---Update periodico---")
    print("Ocorrencias: ", str(resultado.value))
    print("Ficheiros Processados: ", str(ficheirosProcessados.value))
    print("Ficheiros em Processamento: ", str(len(ficheiros)-ficheirosProcessados.value))
    print("Tempo decorrido: ", str(int((time.time() - start_time)*1000000)))
    print("----------------------")
    signal.alarm(tempo)

def funcaoFilho(opcoes, ficheiros, ficheirosdividir, parteanalisar, palavras):
    
    res = 0
    for fich in ficheiros:
        res = funcaoanalisar(opcoes, fich, palavras, "")
        mutex.acquire() 
        resultado.value += res
        ficheirosProcessados.value += 1
        mutex.release() 

    for fich in ficheirosdividir:
        linhasAnalisar = dividirlinhas(fich)
        linhaInicial = parteanalisar*linhasAnalisar + 1
        linhaFinal = (parteanalisar + 1)*linhasAnalisar
        comandoSelecionarLinhas = "sed -n '" + str(linhaInicial) + ',' + str(linhaFinal) + 'p;' + str(linhaFinal + 1) + "q' " + fich + ' | '
        res = funcaoanalisar(opcoes, fich, palavras, comandoSelecionarLinhas)
        mutex.acquire() 
        resultado.value += res
        if (parteanalisar + 1) == numeroFilhos:
            ficheirosProcessados.value += 1
        mutex.release()

def dividirlinhas(fich):
    numLinhas = sum(1 for line in open(fich))
    if numLinhas % numeroFilhos == 0:
        return numLinhas/numeroFilhos
    else:
        return (numLinhas//numeroFilhos)+1


def funcaoanalisar(opcoes, fich, palavras, comandoinicial):
    listaHpwc=[]
    if numeroFilhos > 1 and numeroFilhos > len(ficheiros): 
        lf=comandoinicial.index('q')
        li=(comandoinicial[8:lf].replace(';',' ').replace(',',' ').split())
        p=li.pop(1)
        linhas=(int(li[1])-int(li[0]))
        linhasProcessada.value=linhas
        listaHpwc.append(linhasProcessada.value)
    else:
        listaHpwc.append(sum(1 for line in open(fich)))
        
    res = 0
    if comandoinicial == "":
        ficheiroAnalisar = fich
    else:
        ficheiroAnalisar = "" 

    if opcoes == ['-c'] or opcoes == ['-a', '-c']: 
        start2 = timer()
        listaOcorrPal=[]
        for palavra in palavras:
                numOccurrences = os.popen(comandoinicial + "grep -wo " + str(palavra) + " " + str(ficheiroAnalisar) + " | wc -l").read() 
                if numOccurrences == '':
                    res += 0
                else:
                    res += int(numOccurrences)   
                print('Sou o PID = {} e contei {} ocorrencias da palavra {} no {}'.format( int(os.getpid()), numOccurrences.replace('\n', ''), palavra, fich))
                pids=0
                pids+=(int(os.getpid())) 
                listaOcorrPal.append(palavra)
                listaOcorrPal.append(numOccurrences.replace('\n', ''))
                end2 = timer()
    if opcoes == ['-l'] or opcoes == ['-a', '-l'] and len(palavras)==1:
        start2 = timer()
        listaOcorrPal=[]
        for palavra in palavras:
            linhasContagem = os.popen(comandoinicial + "grep -wc " + palavra + " " + ficheiroAnalisar).read() 
            if linhasContagem == '':
                res += 0
            else:
                res += int(linhasContagem)  
            print('Sou o com PID = {} e contei {} linhas em que aparece a palavra {} no ficheiro {}'.format( int(os.getpid()), linhasContagem, palavra, fich))
            pids=0
            pids+=(int(os.getpid()))  
            listaOcorrPal.append(palavra)
            listaOcorrPal.append(linhasContagem.replace('\n', ''))
            end2 = timer()
    if opcoes == ['-a', '-l'] and len(palavras)==2:
                start2 = timer()
                listaOcorrPal=[]
                linhasContagem = os.popen(comandoinicial + "grep -w " + palavras[0]+" "+ficheiroAnalisar+ " | grep -w "+palavras[1]+" | wc -l").read()
                print('Sou o com PID = {} e contei {} linhas em que aparecem simultaneamente as palavras no ficheiro {}'.format( int(os.getpid()), linhasContagem, fich))
                pids=0
                pids+=(int(os.getpid())) 
                if linhasContagem == '':
                    res += 0
                else:
                    res += int(linhasContagem) 
                listaOcorrPal.append(palavras[0])
                listaOcorrPal.append(linhasContagem.replace('\n', ''))
                listaOcorrPal.append(palavras[1])
                listaOcorrPal.append(linhasContagem.replace('\n', ''))
                end2 = timer()
    if opcoes == ['-a', '-l'] and len(palavras)==3:
                start2 = timer()
                listaOcorrPal=[]
                linhasContagem = os.popen(comandoinicial + "grep -w " + palavras[0]+" "+ficheiroAnalisar + " | grep -w "+palavras[1]+" | grep -w " + palavras[2] + " | wc -l").read()
                print('Sou o com PID = {} e contei {} linhas em que aparecem simultaneamente as palavras no ficheiro {}'.format( int(os.getpid()), linhasContagem, fich)) 
                mutex.acquire() 
                if linhasContagem == '':
                    res += 0
                else:
                    res += int(linhasContagem) 
                mutex.release()
                pids=0
                pids+=(int(os.getpid()))
                listaOcorrPal.append(palavras[0])
                listaOcorrPal.append(linhasContagem.replace('\n', ''))
                listaOcorrPal.append(palavras[1])
                listaOcorrPal.append(linhasContagem.replace('\n', ''))
                listaOcorrPal.append(palavras[2])
                listaOcorrPal.append(linhasContagem.replace('\n', ''))
                end2 = timer()
    if '-o' in argumentosLinha:
        listaHpwc.append(pids) 
        listaHpwc.append(fich) 
        listaHpwc.append(timedelta(seconds=end2-start2))
        listaHpwc.append(listaOcorrPal)
        listaHpwc2.append(listaHpwc)
    return res

signal.signal(signal.SIGINT, handler_input)
signal.signal(signal.SIGALRM, handler_timeout_w)
signal.alarm(tempo)

if numeroFilhos == 0 or numeroFilhos == 1:
    for ficheiro in ficheiros:
        res=funcaoanalisar(opcoes, ficheiro, palavras, "")
        mutex.acquire()
        resultado.value += res
        mutex.release()
else:
    ficheirosPorProcesso = len(ficheiros)//numeroFilhos
    resto = len(ficheiros)%numeroFilhos
    f = resto
    for filho in range(numeroFilhos):
        Processos.append(Process(target=funcaoFilho, args = (opcoes, ficheiros[f:f+ficheirosPorProcesso], ficheiros[0:resto], filho, palavras,)))
        f += ficheirosPorProcesso
    for processo in Processos:
        processo.start()
    for processo in Processos:
        processo.join()

signal.alarm(0)
end = timer()

def binario(listaHpwc):
        timestamp = float(int((time.time() - start_time)*1000000))/1000000 
        hours,remainder = divmod(timestamp, 3600)
        minutes,seconds = divmod(remainder, 60)
        lista=[]
        lista.append(nome)
        lista.append("Inicio da execucao da pesquisa: {}".format(str(datetime.datetime.now().strftime("%d/%m/%Y, %H:%M:%S:%f"))))
        lista.append("Duracao da execucao: {}".format(timedelta(seconds=end-start)))
        lista.append("Numero de processos filhos: {}".format(numeroFilhos))
        if '-a' in argumentosLinha:
            lista.append("Opcao -a ativada: Sim" )
        else: 
            lista.append("Opcao -a ativada: Nao" )
        lista.append("Emissao de alarmes no intervalo de {} segundos".format(tempo*0.000001))
        for x in range(len(listaHpwc)):
                lista.append("Processo: {}".format(listaHpwc[x][1]))
                string=("ficheiro: {}".format(listaHpwc[x][2]))
                string_length=len(string)+5
                lista.append(string.rjust(string_length))
                string2=("tempo de pesquisa: {}".format(listaHpwc[x][3]))
                string_length2=len(string2)+10
                lista.append(string2.rjust(string_length2))
                string3=("dimensao do ficheiro: {}".format(listaHpwc[x][0]))
                string_length3=len(string3)+10
                lista.append(string3.rjust(string_length3))
                if '-c' in opcoes:
                    for y in range(len(palavras)):
                        if y%2==0 and y < 2:
                            lista.append("          numero de ocorrencias da palavra {}: {}".format(palavras[y], listaHpwc[x][4][y+1]))
                        if y%2!=0 and y < 2:
                            lista.append("          numero de ocorrencias da palavra {}: {}".format(palavras[y], listaHpwc[x][4][y+2]))
                            #no caso de serem 3 palavras
                        if y%2==0 and y == 2:
                            lista.append("          numero de ocorrencias da palavra {}: {}".format(palavras[y], listaHpwc[x][4][y+3]))
                else:
                    for y in range(len(palavras)):
                        if y%2==0 and y < 2:
                            lista.append("          numero de linhas da palavra {}: {}".format(palavras[y], listaHpwc[x][4][y+1]))
                        if y%2!=0 and y < 2:
                            lista.append("          numero de linhas da palavra {}: {}".format(palavras[y], listaHpwc[x][4][y+2]))
                            #no caso de serem 3 palavras
                        if y%2==0 and y == 2:
                            lista.append("          numero de linhas da palavra {}: {}".format(palavras[y], listaHpwc[x][4][y+3]))
        with open(nome,"wb") as outFile:
                pickle.dump(lista, outFile)

if '-o' in argumentosLinha:
    binario(listaHpwc2)

print("Sou o pai (PID=", str(os.getppid()), "). Recebi a mensagem do filho: ", str(resultado.value))
