//Desativar scroll através das setas e da barra de espaço
window.addEventListener("keydown", function(e) {
    if(["Space","ArrowUp","ArrowDown","ArrowLeft","ArrowRight"].indexOf(e.code) > -1) {
        e.preventDefault();
    }
}, false);

const BOTAO_SUBIR = "up";
const BOTAO_DESCER ="down";
const BOTAO_DIREITA = "right";
const BOTAO_ESQUERDA = "left";
function defineBotoes(){
document.getElementById(BOTAO_SUBIR)
    .addEventListener('click', andarCima )
document.getElementById(BOTAO_DESCER)
    .addEventListener('click', andar)
document.getElementById(BOTAO_DIREITA)
    .addEventListener('click', andar )
document.getElementById(BOTAO_ESQUERDA)
    .addEventListener('click', andar )
}

function cima() {
    if ( tabuleiro[eevee.y-1][eevee.x] !== 1 &&
        tabuleiro[eevee.y-1][eevee.x] !== 7 &&
        tabuleiro[eevee.y-1][eevee.x] !== 8 &&
        tabuleiro[eevee.y-1][eevee.x] !== 9) {
            eevee.y -= 1;
            tabuleiro[eevee.y][eevee.x] = 5;
            if (tabuleiro[eevee.y+1][eevee.x-1] == 9 && tabuleiro[eevee.y+1][eevee.x+1] == 9){
                tabuleiro[eevee.y+1][eevee.x] = 11;
            }
            else{tabuleiro[eevee.y+1][eevee.x]=3;}
            desenharTabuleiro();
        }
}
function baixo() {
    if ( tabuleiro[eevee.y+1][eevee.x] !== 1 &&
        tabuleiro[eevee.y+1][eevee.x] !== 7 &&
        tabuleiro[eevee.y+1][eevee.x] !== 8 &&
        tabuleiro[eevee.y+1][eevee.x] !== 9 ) {
            eevee.y += 1;
            tabuleiro[eevee.y][eevee.x] = 5;
            if (tabuleiro[eevee.y-1][eevee.x+1] == 9 && tabuleiro[eevee.y-1][eevee.x-1] == 9){
                tabuleiro[eevee.y-1][eevee.x] = 11;
            }
            else{tabuleiro[eevee.y-1][eevee.x]=3;}
            desenharTabuleiro();
        }
}
function esquerda() {
    if ( tabuleiro[eevee.y][eevee.x-1] !== 1 &&  
        tabuleiro[eevee.y][eevee.x-1] !== 7 && 
        tabuleiro[eevee.y][eevee.x-1] !== 8 && 
        tabuleiro[eevee.y][eevee.x-1] !== 9) {
            eevee.x -= 1;
            tabuleiro[eevee.y][eevee.x] = 5;
            if (tabuleiro[eevee.y+1][eevee.x+1] == 9 && tabuleiro[eevee.y-1][eevee.x+1] == 9){
                tabuleiro[eevee.y][eevee.x+1] = 11;
            }
            else{tabuleiro[eevee.y][eevee.x+1]=3;}
            desenharTabuleiro();
        }
}
function direita() {
    if ( tabuleiro[eevee.y][eevee.x+1] !== 1 &&
    tabuleiro[eevee.y][eevee.x+1] !== 7 &&
    tabuleiro[eevee.y][eevee.x+1] !== 8 &&
    tabuleiro[eevee.y][eevee.x+1] !== 9) {
        eevee.x += 1;
        tabuleiro[eevee.y][eevee.x] = 5;
        if (tabuleiro[eevee.y+1][eevee.x-1] == 9 && tabuleiro[eevee.y-1][eevee.x-1] == 9){
            tabuleiro[eevee.y][eevee.x-1] = 11;
        }
        else{tabuleiro[eevee.y][eevee.x-1]=3;}
        desenharTabuleiro();
    }
}

// 1 => <div class='wall'></div>
// 2 => <div class='coin'></div>
// 3 => <div class='ground'></div>
// 5 => <div class='eevee'></div>
// 4 => <div class='vidaa'></div>
// 6 => <div class='fruta'></div>
// 7 => <div class='arvore'></div>
// 8 => <div class='pedra'></div>
// 9 => <div class='agua'></div>
//10 => <div class='fim'></div>
//11 => <div class='ponte'></div>
//12 => <div class='chao'></div>
// 'p' -> <div class='pikachu'></div>
// 's' -> squirtle
// 'g' -> growlithe

eevee = {
    x: 5,
    y: 8
}

tabuleiro = [ 
    [7,9,1,1,1,10,1,8,1,1,7,1,1], 
    [8,9,9,6,2,'s',2,2,2,2,2,2,1], 
    [1,4,9,1,1,2,1,7,1,1,8,2,1], 
    [1,2,9,9,1,2,2,1,1,1,1,2,1], 
    [1,2,1,9,8,1,2,1,7,2,2,'g',7], 
    [1,2,2,11,2,'p',2,2,2,2,7,2,8], 
    [1,1,7,9,1,2,1,1,8,2,1,6,1], 
    [7,1,1,9,9,11,9,9,4,2,2,2,1], 
    [1,1,1,8,1,5,1,9,1,7,1,1,1]
]


function desenharTabuleiro(){ 
    var el = document.getElementById('world');
    el.innerHTML = '';
    for(var y = 0; y < tabuleiro.length ; y = y + 1) {
        for(var x = 0; x < tabuleiro[y].length ; x = x + 1) {		
            if (tabuleiro[y][x] === 1) {
                el.innerHTML += "<div class='wall'></div>";
            }
            else if (tabuleiro[y][x] === 2) {
                el.innerHTML += "<div class='coin'></div>";
            }
            else if (tabuleiro[y][x] === 3) {
                el.innerHTML += "<div class='ground'></div>";
            }
            else if (tabuleiro[y][x] === 4) {
                el.innerHTML += "<div class='vidaa'></div>";
            }
            else if (tabuleiro[y][x] === 5) {
                el.innerHTML += "<div class='eevee'></div>";
            }
            else if (tabuleiro[y][x] === 6) {
                el.innerHTML += "<div class='fruta'></div>";
            }
            else if (tabuleiro[y][x] === 7) {
                el.innerHTML += "<div class='arvore'></div>";
            }
            else if (tabuleiro[y][x] === 8) {
                el.innerHTML += "<div class='pedra'></div>";
            }
            else if (tabuleiro[y][x] === 10) {
                el.innerHTML += "<div class='fim'></div>";
            }
            else if (tabuleiro[y][x] === 9) {
                el.innerHTML += "<div class='agua'></div>";
            }
            else if (tabuleiro[y][x] === 11) {
                el.innerHTML += "<div class='ponte'></div>";
            }
            else if (tabuleiro[y][x] === 'p') {
                el.innerHTML += "<div class='pikachu'></div>";	
            }
            else if (tabuleiro[y][x] === 'g') {
                el.innerHTML += "<div class='growlithe'></div>";
            }
            else if (tabuleiro[y][x] === 's') {
                el.innerHTML += "<div class='squirtle'></div>";
            }
        }
        el.innerHTML += "<br>";
    }
}

window.addEventListener("load", desenharTabuleiro);


document.onkeydown = function(event){
    // console.log(event);
    if (event.keyCode === 37){ // jogador ANDAR PARA ESQUERDA
        if ( tabuleiro[eevee.y][eevee.x-1] !== 1 &&  
        tabuleiro[eevee.y][eevee.x-1] !== 7 && 
        tabuleiro[eevee.y][eevee.x-1] !== 8 && 
        tabuleiro[eevee.y][eevee.x-1] !== 9) {
            eevee.x -= 1;
            tabuleiro[eevee.y][eevee.x] = 5;
            if (tabuleiro[eevee.y+1][eevee.x+1] == 9 && tabuleiro[eevee.y-1][eevee.x+1] == 9){
                tabuleiro[eevee.y][eevee.x+1] = 11;
            }
            else{tabuleiro[eevee.y][eevee.x+1]=3;}
            desenharTabuleiro();
        }
    }
    else if (event.keyCode === 38) {
// jogador ANDAR PARA CIMA
        if ( tabuleiro[eevee.y-1][eevee.x] !== 1 &&
        tabuleiro[eevee.y-1][eevee.x] !== 7 &&
        tabuleiro[eevee.y-1][eevee.x] !== 8 &&
        tabuleiro[eevee.y-1][eevee.x] !== 9) {
            eevee.y -= 1;
            tabuleiro[eevee.y][eevee.x] = 5;
            if (tabuleiro[eevee.y+1][eevee.x-1] == 9 && tabuleiro[eevee.y+1][eevee.x+1] == 9){
                tabuleiro[eevee.y+1][eevee.x] = 11;
            }
            else{tabuleiro[eevee.y+1][eevee.x]=3;}
            desenharTabuleiro();
        }
    }
    else if (event.keyCode === 39){ // jogador ANDAR PARA DIREITA
        if ( tabuleiro[eevee.y][eevee.x+1] !== 1 &&
        tabuleiro[eevee.y][eevee.x+1] !== 7 &&
        tabuleiro[eevee.y][eevee.x+1] !== 8 &&
        tabuleiro[eevee.y][eevee.x+1] !== 9) {
            eevee.x += 1;
            tabuleiro[eevee.y][eevee.x] = 5;
            if (tabuleiro[eevee.y+1][eevee.x-1] == 9 && tabuleiro[eevee.y-1][eevee.x-1] == 9){
                tabuleiro[eevee.y][eevee.x-1] = 11;
            }
            else{tabuleiro[eevee.y][eevee.x-1]=3;}
            desenharTabuleiro();
        }
    }
    else if (event.keyCode === 40){ // jogador ANDAR PARA BAIXO
        if ( tabuleiro[eevee.y+1][eevee.x] !== 1 &&
        tabuleiro[eevee.y+1][eevee.x] !== 7 &&
        tabuleiro[eevee.y+1][eevee.x] !== 8 &&
        tabuleiro[eevee.y+1][eevee.x] !== 9 ) {
            eevee.y += 1;
            tabuleiro[eevee.y][eevee.x] = 5;
            if (tabuleiro[eevee.y-1][eevee.x+1] == 9 && tabuleiro[eevee.y-1][eevee.x-1] == 9){
                tabuleiro[eevee.y-1][eevee.x] = 11;
            }
            else{tabuleiro[eevee.y-1][eevee.x]=3;}
            desenharTabuleiro();
        }
    }
    console.log(tabuleiro)
}
function andarCima(){
if ( tabuleiro[eevee.y][eevee.x-1] !== 1 &&  
        tabuleiro[eevee.y][eevee.x-1] !== 7 && 
        tabuleiro[eevee.y][eevee.x-1] !== 8 && 
        tabuleiro[eevee.y][eevee.x-1] !== 9) {
            eevee.x -= 1;
            tabuleiro[eevee.y][eevee.x] = 5;
            tabuleiro[eevee.y][eevee.x+1]=3;
            desenharTabuleiro();
}
}
// comeca aqui do cronometro
"use strict"
var horas = 0;
var minutos = 0;
var segundos = 0;
var tempo = 1000;//em milesimos seg, vale 1 seg
var cronometro;

//Iniciar o temporizador

function iniciar() {
cronometro = setInterval(() => { temporizador(); }, tempo);
}

//Para o temporizador mas não apaga TUDO, é so pausa
//qual o interalo que quero pausar?? o cronometro
function pausa() {
clearInterval(cronometro);
}

//Para o temporizador e apaga tudo
//como a pausa, mas o cronometro volta a zero
//ou seja, quem quero pausar? o cronometro
//depois atualizo as variaveis para zero
function parar() {
clearInterval(cronometro);
horas = 0;
minutos = 0;
segundos = 0;
document.getElementById('contador').innerText = '00:00:00';
}

//faz a contagem do tempo
function temporizador() {
segundos++; //Incrementa +1 na variável s, segundos
if (segundos == 59) { //Verifica se deu 59 segundos
    segundos = 0; //Volta os segundos para 0
    minutos++; //Adiciona +1 na variável m

    if (minutos == 59) { //Verifica se deu 59 minutos
        minutos = 0;//Volta os minutos para 0
        horas++;//Adiciona +1 na variável hora
    }
}
//variavel com as horas e os minutos
//se minutos menor que 10, entao mete um 0 antes e adiciona os minutos atuais
// e o mesmo formato para os milissegundo e as horas!
let formato = (horas < 10 ? '0' + horas : horas) + ':' + (minutos < 10 ? '0' + minutos : minutos) + ':' + (segundos < 10 ? '0' + segundos : segundos);

//Ipara aparecer no formaro q fizzemos antes
document.getElementById('contador').innerText = formato;

//Retorna o valor tratado
return formato;
}

//botoes
const left = document.querySelector('.left')
const up = document.querySelector('.up')
const right = document.querySelector('.right')
const down = document.querySelector('.down')

//dados 
console.log("Vivek pandey");
const btn=document.getElementById("Btn");
const result=document.getElementById("Result")
let score1=document.getElementById("score1");
let score2=document.getElementById("score2");

btn.addEventListener('click',function(){
const player1=Math.floor(Math.random()*6)+1;  //Generating random number from 1 to 6 
const player1Dice=`dice${player1}.png`;        
document.getElementById("img1").setAttribute('src',player1Dice);  
const player2=Math.floor(Math.random()*6)+1;
const player2Dice=`dice${player2}.png`;
document.getElementById("img2").setAttribute('src',player2Dice);
let result1=parseInt(score1.value);        //Converting string to decimal by using parseInt
score=player1+result1;
score1.setAttribute('value',`${score}`);
let result2=parseInt(score2.value);        //Converting string to decimal by using parseInt
score4=player2+result2;
score2.setAttribute('value',`${score4}`);
console.log(score1.value);
console.log(score2.value);
   
    
});

