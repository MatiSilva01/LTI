// Grupo 18, Diogo Esteves nº56927, Sonia Sousa nº56898 e Matilde Silva nº56895, PL21
//Desativar scroll através das setas e da barra de espaço
window.addEventListener("keydown", function(e) {
    if(["Space","ArrowUp","ArrowDown","ArrowLeft","ArrowRight"].indexOf(e.code) > -1) {
        e.preventDefault();
    }
}, false);


function cima() {
    if ( tabuleiro2[eevee.y-1][eevee.x] !== 1 &&
        tabuleiro2[eevee.y-1][eevee.x] !== 7 &&
        tabuleiro2[eevee.y-1][eevee.x] !== 8 &&
        tabuleiro2[eevee.y-1][eevee.x] !== 9) {
            if ( tabuleiro2[eevee.y-1][eevee.x] === 'g' ||
            tabuleiro2[eevee.y-1][eevee.x] === 'p' ||
            tabuleiro2[eevee.y-1][eevee.x] === 's')
            {
                box.classList.add("active")
            }
            eevee.y -= 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro2[eevee.y][eevee.x] = 5;
            if (tabuleiro2[eevee.y+1][eevee.x-1] == 9 && tabuleiro2[eevee.y+1][eevee.x+1] == 9){
                tabuleiro2[eevee.y+1][eevee.x] = 11;
            }
            else{tabuleiro2[eevee.y+1][eevee.x]=3;}
            desenharTabuleiro();
        }
}
function baixo() {
    if ( tabuleiro2[eevee.y+1][eevee.x] !== 1 &&
        tabuleiro2[eevee.y+1][eevee.x] !== 7 &&
        tabuleiro2[eevee.y+1][eevee.x] !== 8 &&
        tabuleiro2[eevee.y+1][eevee.x] !== 9 ) {
            if ( tabuleiro2[eevee.y+1][eevee.x] === 'g' ||
            tabuleiro2[eevee.y+1][eevee.x] === 'p' ||
            tabuleiro2[eevee.y+1][eevee.x] === 's')
            {
                box.classList.add("active")
            }
            eevee.y += 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro2[eevee.y][eevee.x] = 5;
            if (tabuleiro2[eevee.y-1][eevee.x+1] == 9 && tabuleiro2[eevee.y-1][eevee.x-1] == 9){
                tabuleiro2[eevee.y-1][eevee.x] = 11;
            }
            else{tabuleiro2[eevee.y-1][eevee.x]=3;}
            desenharTabuleiro();
        }
}
function esquerda() {
    if ( tabuleiro2[eevee.y][eevee.x-1] !== 1 &&  
        tabuleiro2[eevee.y][eevee.x-1] !== 7 && 
        tabuleiro2[eevee.y][eevee.x-1] !== 8 && 
        tabuleiro2[eevee.y][eevee.x-1] !== 9) {
            if ( tabuleiro2[eevee.y][eevee.x-1] === 'g' ||
            tabuleiro2[eevee.y][eevee.x-1] === 'p' ||
            tabuleiro2[eevee.y][eevee.x-1] === 's')
            {
                box.classList.add("active")
            }
            eevee.x -= 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro2[eevee.y][eevee.x] = 5;
            if (tabuleiro2[eevee.y+1][eevee.x+1] == 9 && tabuleiro2[eevee.y-1][eevee.x+1] == 9){
                tabuleiro2[eevee.y][eevee.x+1] = 11;
            }
            else{tabuleiro2[eevee.y][eevee.x+1]=3;}
            desenharTabuleiro();
        }
    
}
function direita() {
    if ( tabuleiro2[eevee.y][eevee.x+1] !== 1 &&
    tabuleiro2[eevee.y][eevee.x+1] !== 7 &&
    tabuleiro2[eevee.y][eevee.x+1] !== 8 &&
    tabuleiro2[eevee.y][eevee.x+1] !== 9) {
        if ( tabuleiro2[eevee.y][eevee.x+1] === 'g' ||
            tabuleiro2[eevee.y][eevee.x+1] === 'p' ||
            tabuleiro2[eevee.y][eevee.x+1] === 's')
            {
                box.classList.add("active")
            }
            eevee.x += 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro2[eevee.y][eevee.x] = 5;
            if (tabuleiro2[eevee.y+1][eevee.x-1] == 9 && tabuleiro2[eevee.y-1][eevee.x-1] == 9){
                tabuleiro2[eevee.y][eevee.x-1] = 11;
            }
            else{tabuleiro2[eevee.y][eevee.x-1]=3;}
            desenharTabuleiro();
    }
}


eevee = {
    x: 5,
    y: 8
}

const som_bater = new Audio();
som_bater.src='./audio/baterObjetos.m4a';
const som_vida = new Audio();
som_vida.src='./audio/Vida.m4a';
const comer = new Audio();
comer.src='./audio/Comer.m4a';
const som_Ganhou = new Audio();
som_Ganhou.src='./audio/Ganhou.m4a';


tabuleiro = [ 
    [1,10,2,8,8,8,1,1,1,1,1,1,1], 
    [1,8,6,2,2,'s',2,2,2,2,2,8,8], 
    [1,8,8,8,8,2,1,1,1,2,8,2,1], 
    [1,2,2,8,8,2,1,1,1,2,2,2,1], 
    [1,2,2,4,2,2,2,1,8,8,1,2,8], 
    [1,1,1,1,1,1,2,2,2,1,1,2,8], 
    [1,1,1,8,8,8,8,'p',2,2,2,6,1], 
    [1,1,1,2,2,2,2,2,8,8,1,2,1], 
    [1,8,8,8,8,5,8,1,1,1,1,1,1]
]

tabuleiro2 =  [ 
    [8,10,1,8,1,1,7,1,1,9,9,7,1], 
    [1,2,4,1,1,1,'g',1,1,9,1,1,1], 
    [1,2,2,2,6,2,2,2,2,11,6,2,7], 
    [7,2,1,8,1,1,1,9,9,9,8,2,1], 
    [1,2,2,6,2,1,1,9,1,1,1,'p',1], 
    [8,1,7,1,2,6,2,11,2,4,2,2,1], 
    [1,1,1,1,9,11,9,9,1,2,1,4,1], 
    [9,9,9,9,9,2,1,7,1,2,1,1,1], 
    [1,1,1,1,1,5,1,1,1,1,8,1,1]
]

tabuleiro3 = [ 
    [1,10,1,1,1,1,1,8,1,1,1,1,1], 
    [8,2,6,2,2,'s',2,2,2,2,2,2,9], 
    [1,2,2,1,1,2,1,1,1,2,4,9,9], 
    [7,2,1,1,1,2,2,1,1,2,9,9,1], 
    [1,2,2,4,8,1,2,1,1,9,9,'g',1], 
    [1,2,1,1,1,4,2,2,9,9,1,2,8], 
    [1,7,1,1,1,2,2,2,11,2,1,6,7], 
    [1,1,1,2,2,2,1,9,9,2,2,2,1], 
    [1,1,1,8,1,5,1,9,1,7,1,1,1]
]

function desenharTabuleiro(){ 
    document.getElementById("score").innerHTML = `Score: ${score}`;
    var el = document.getElementById('world');
    el.innerHTML = '';
    for(var y = 0; y < tabuleiro2.length ; y = y + 1) {
        for(var x = 0; x < tabuleiro2[y].length ; x = x + 1) {		
            if (tabuleiro2[y][x] === 1) {
                el.innerHTML += "<div class='mar'></div>";
            }
            else if (tabuleiro2[y][x] === 2) {
                el.innerHTML += "<div class='areia'></div>";
            }
            else if (tabuleiro2[y][x] === 3) {
                el.innerHTML += "<div class='ground'></div>";
            }
            else if (tabuleiro2[y][x] === 4) {
                el.innerHTML += "<div class='vida'></div>";
            }
            else if (tabuleiro2[y][x] === 5) {
                el.innerHTML += "<div class='squir'></div>";
            }
            else if (tabuleiro2[y][x] === 6) {
                el.innerHTML += "<div class='borboleta'></div>";
            }
            else if (tabuleiro2[y][x] === 7) {
                el.innerHTML += "<div class='peixe'></div>";
            }
            else if (tabuleiro2[y][x] === 8) {
                el.innerHTML += "<div class='polvo'></div>";
            }
            else if (tabuleiro2[y][x] === 10) {
                el.innerHTML += "<div class='end'></div>";
            }
            else if (tabuleiro2[y][x] === 9) {
                el.innerHTML += "<div class='tubarao'></div>";
            }
            else if (tabuleiro2[y][x] === 11) {
                el.innerHTML += "<div class='barco'></div>";
            }
            else if (tabuleiro2[y][x] === 'p') {
                el.innerHTML += "<div class='pika'></div>";	
            }
            else if (tabuleiro2[y][x] === 'g') {
                el.innerHTML += "<div class='growl'></div>";
            }
            
        }
        el.innerHTML += "<br>";
    }


 document.onkeydown = function(event){
    // console.log(event);
    if (event.keyCode === 37){ // jogador ANDAR PARA ESQUERDA
        if ( tabuleiro2[eevee.y][eevee.x-1] !== 1 &&  
        tabuleiro2[eevee.y][eevee.x-1] !== 7 && 
        tabuleiro2[eevee.y][eevee.x-1] !== 8 && 
        tabuleiro2[eevee.y][eevee.x-1] !== 9) {
            if ( tabuleiro2[eevee.y][eevee.x-1] === 'g' ||
            tabuleiro2[eevee.y][eevee.x-1] === 'p' ||
            tabuleiro2[eevee.y][eevee.x-1] === 's')
            {
                box.classList.add("active")
            }
            eevee.x -= 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro2[eevee.y][eevee.x] = 5;
            if (tabuleiro2[eevee.y+1][eevee.x+1] == 9 && tabuleiro2[eevee.y-1][eevee.x+1] == 9){
                tabuleiro2[eevee.y][eevee.x+1] = 11;
            }
            else{tabuleiro2[eevee.y][eevee.x+1]=3;}
            desenharTabuleiro();
        }
    }
    if (event.keyCode === 37){ // jogador ANDAR PARA ESQUERDA SOM BATER
        if ( tabuleiro2[eevee.y][eevee.x-1] === 1 ||
            tabuleiro2[eevee.y][eevee.x-1] === 7 ||
            tabuleiro2[eevee.y][eevee.x-1] === 8 ||
            tabuleiro2[eevee.y][eevee.x-1] === 9 ){
            som_bater.play();
        }
    }

    else if (event.keyCode === 38) {
// jogador ANDAR PARA CIMA
        if ( tabuleiro2[eevee.y-1][eevee.x] !== 1 &&
        tabuleiro2[eevee.y-1][eevee.x] !== 7 &&
        tabuleiro2[eevee.y-1][eevee.x] !== 8 &&
        tabuleiro2[eevee.y-1][eevee.x] !== 9) {
            if ( tabuleiro2[eevee.y-1][eevee.x] === 'g' ||
            tabuleiro2[eevee.y-1][eevee.x] === 'p' ||
            tabuleiro2[eevee.y-1][eevee.x] === 's')
            {
                box.classList.add("active")
            }
            eevee.y -= 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro2[eevee.y][eevee.x] = 5;
            if (tabuleiro2[eevee.y+1][eevee.x-1] == 9 && tabuleiro2[eevee.y+1][eevee.x+1] == 9){
                tabuleiro2[eevee.y+1][eevee.x] = 11;
            }
            else{tabuleiro2[eevee.y+1][eevee.x]=3;}
            desenharTabuleiro();
        }
    }
    if (event.keyCode === 38){ // jogador ANDAR PARA CIMA SOM BATER
        if ( tabuleiro2[eevee.y-1][eevee.x] === 1 ||
            tabuleiro2[eevee.y-1][eevee.x] === 7 ||
            tabuleiro2[eevee.y-1][eevee.x] === 8 ||
            tabuleiro2[eevee.y-1][eevee.x] === 9 ){
            som_bater.play();
        }
    }


    else if (event.keyCode === 39){ // jogador ANDAR PARA DIREITA
        if ( tabuleiro2[eevee.y][eevee.x+1] !== 1 &&
        tabuleiro2[eevee.y][eevee.x+1] !== 7 &&
        tabuleiro2[eevee.y][eevee.x+1] !== 8 &&
        tabuleiro2[eevee.y][eevee.x+1] !== 9) {
            if ( tabuleiro2[eevee.y][eevee.x+1] === 'g' ||
            tabuleiro2[eevee.y][eevee.x+1] === 'p' ||
            tabuleiro2[eevee.y][eevee.x+1] === 's')
            {
                box.classList.add("active")
            }
            eevee.x += 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro2[eevee.y][eevee.x] = 5;
            if (tabuleiro2[eevee.y+1][eevee.x-1] == 9 && tabuleiro2[eevee.y-1][eevee.x-1] == 9){
                tabuleiro2[eevee.y][eevee.x-1] = 11;
            }
            else{tabuleiro2[eevee.y][eevee.x-1]=3;}
            desenharTabuleiro();
        }
    }
    if (event.keyCode === 39){ // jogador ANDAR PARA DIREITA SOM BATER
        if ( tabuleiro2[eevee.y][eevee.x+1] === 1 ||
            tabuleiro2[eevee.y][eevee.x+1] === 7 ||
            tabuleiro2[eevee.y][eevee.x+1] === 8 ||
            tabuleiro2[eevee.y][eevee.x+1] === 9 ){
            som_bater.play();
        }
    }


    else if (event.keyCode === 40){ // jogador ANDAR PARA BAIXO
        if ( tabuleiro2[eevee.y+1][eevee.x] !== 1 &&
        tabuleiro2[eevee.y+1][eevee.x] !== 7 &&
        tabuleiro2[eevee.y+1][eevee.x] !== 8 &&
        tabuleiro2[eevee.y+1][eevee.x] !== 9 ) {
            if ( tabuleiro2[eevee.y+1][eevee.x] === 'g' ||
            tabuleiro2[eevee.y+1][eevee.x] === 'p' ||
            tabuleiro2[eevee.y+1][eevee.x] === 's')
            {
                box.classList.add("active")
            }
            eevee.y += 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro2[eevee.y][eevee.x] = 5;
            if (tabuleiro2[eevee.y-1][eevee.x+1] == 9 && tabuleiro2[eevee.y-1][eevee.x-1] == 9){
                tabuleiro2[eevee.y-1][eevee.x] = 11;
            }
            else{tabuleiro2[eevee.y-1][eevee.x]=3;}
            desenharTabuleiro();
        }
    }
    if (event.keyCode === 40){ // jogador ANDAR PARA BAIXO SOM BATER
        if ( tabuleiro2[eevee.y+1][eevee.x] === 1 ||
            tabuleiro2[eevee.y+1][eevee.x] === 7 ||
            tabuleiro2[eevee.y+1][eevee.x] === 8 ||
            tabuleiro2[eevee.y+1][eevee.x] === 9 ){
            som_bater.play();
            
        }
    }
    
    console.log(tabuleiro)
 }

}
window.addEventListener("load", desenharTabuleiro);



function desenharTabuleiro3(){ 
    document.getElementById("score").innerHTML = `Score: ${score}`;
    var el = document.getElementById('world');
    el.innerHTML = '';
    for(var y = 0; y < tabuleiro.length ; y = y + 1) {
        for(var x = 0; x < tabuleiro[y].length ; x = x + 1) {		
            if (tabuleiro[y][x] === 1) {
                el.innerHTML += "<div class='lavaGrowlithe'></div>";
            }
            else if (tabuleiro[y][x] === 2) {
                el.innerHTML += "<div class='caminhoGrowlithe'></div>";
            }
            else if (tabuleiro[y][x] === 3) {
                el.innerHTML += "<div class='ground'></div>";
            }
            else if (tabuleiro[y][x] === 4) {
                el.innerHTML += "<div class='vidaGrowlithe'></div>";
            }
            else if (tabuleiro[y][x] === 5) {
                el.innerHTML += "<div class='Growlithe'></div>";
            }
            else if (tabuleiro[y][x] === 6) {
                el.innerHTML += "<div class='camaraoGrowlithe'></div>";
            }
            else if (tabuleiro[y][x] === 8) {
                el.innerHTML += "<div class='pedraGrowlithe'></div>";
            }
            else if (tabuleiro[y][x] === 10) {
                el.innerHTML += "<div class='eeveeGrowlithe'></div>";
            }
            else if (tabuleiro[y][x] === 'p') {
                el.innerHTML += "<div class='pikachuGrowlithe'></div>";	
            }
            else if (tabuleiro[y][x] === 's') {
                el.innerHTML += "<div class='squirtle'></div>";	
            }
            
        }
        el.innerHTML += "<br>";
    }





 document.onkeydown = function(event){
    // console.log(event);
    if (event.keyCode === 37){ // jogador ANDAR PARA ESQUERDA
        if ( tabuleiro[eevee.y][eevee.x-1] !== 1 &&  
        tabuleiro[eevee.y][eevee.x-1] !== 7 && 
        tabuleiro[eevee.y][eevee.x-1] !== 8 && 
        tabuleiro[eevee.y][eevee.x-1] !== 9) {
            if ( tabuleiro[eevee.y][eevee.x-1] === 'g' ||
            tabuleiro[eevee.y][eevee.x-1] === 'p' ||
            tabuleiro[eevee.y][eevee.x-1] === 's')
            {
                box.classList.add("active")
            }
            eevee.x -= 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro[eevee.y][eevee.x] = 5;
            if (tabuleiro[eevee.y+1][eevee.x+1] == 9 && tabuleiro[eevee.y-1][eevee.x+1] == 9){
                tabuleiro[eevee.y][eevee.x+1] = 11;
            }
            else{tabuleiro[eevee.y][eevee.x+1]=3;}
            desenharTabuleiro3();
        }
    }
    if (event.keyCode === 37){ // jogador ANDAR PARA ESQUERDA SOM BATER
        if ( tabuleiro[eevee.y][eevee.x-1] === 1 ||
            tabuleiro[eevee.y][eevee.x-1] === 7 ||
            tabuleiro[eevee.y][eevee.x-1] === 8 ||
            tabuleiro[eevee.y][eevee.x-1] === 9 ){
            som_bater.play();
        }
    }

    else if (event.keyCode === 38) {
// jogador ANDAR PARA CIMA
        if ( tabuleiro[eevee.y-1][eevee.x] !== 1 &&
        tabuleiro[eevee.y-1][eevee.x] !== 7 &&
        tabuleiro[eevee.y-1][eevee.x] !== 8 &&
        tabuleiro[eevee.y-1][eevee.x] !== 9) {
            if ( tabuleiro[eevee.y-1][eevee.x] === 'g' ||
            tabuleiro[eevee.y-1][eevee.x] === 'p' ||
            tabuleiro[eevee.y-1][eevee.x] === 's')
            {
                box.classList.add("active")
            }
            eevee.y -= 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro[eevee.y][eevee.x] = 5;
            if (tabuleiro[eevee.y+1][eevee.x-1] == 9 && tabuleiro[eevee.y+1][eevee.x+1] == 9){
                tabuleiro[eevee.y+1][eevee.x] = 11;
            }
            else{tabuleiro[eevee.y+1][eevee.x]=3;}
            desenharTabuleiro3();
        }
    }
    if (event.keyCode === 38){ // jogador ANDAR PARA CIMA SOM BATER
        if ( tabuleiro[eevee.y-1][eevee.x] === 1 ||
            tabuleiro[eevee.y-1][eevee.x] === 7 ||
            tabuleiro[eevee.y-1][eevee.x] === 8 ||
            tabuleiro[eevee.y-1][eevee.x] === 9 ){
            som_bater.play();
        }
    }


    else if (event.keyCode === 39){ // jogador ANDAR PARA DIREITA
        if ( tabuleiro[eevee.y][eevee.x+1] !== 1 &&
        tabuleiro[eevee.y][eevee.x+1] !== 7 &&
        tabuleiro[eevee.y][eevee.x+1] !== 8 &&
        tabuleiro[eevee.y][eevee.x+1] !== 9) {
            if ( tabuleiro[eevee.y][eevee.x+1] === 'g' ||
            tabuleiro[eevee.y][eevee.x+1] === 'p' ||
            tabuleiro[eevee.y][eevee.x+1] === 's')
            {
                box.classList.add("active")
            }
            eevee.x += 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro[eevee.y][eevee.x] = 5;
            if (tabuleiro[eevee.y+1][eevee.x-1] == 9 && tabuleiro[eevee.y-1][eevee.x-1] == 9){
                tabuleiro[eevee.y][eevee.x-1] = 11;
            }
            else{tabuleiro[eevee.y][eevee.x-1]=3;}
            desenharTabuleiro3();
        }
    }
    if (event.keyCode === 39){ // jogador ANDAR PARA DIREITA SOM BATER
        if ( tabuleiro[eevee.y][eevee.x+1] === 1 ||
            tabuleiro[eevee.y][eevee.x+1] === 7 ||
            tabuleiro[eevee.y][eevee.x+1] === 8 ||
            tabuleiro[eevee.y][eevee.x+1] === 9 ){
            som_bater.play();
        }
    }


    else if (event.keyCode === 40){ // jogador ANDAR PARA BAIXO
        if ( tabuleiro[eevee.y+1][eevee.x] !== 1 &&
        tabuleiro[eevee.y+1][eevee.x] !== 7 &&
        tabuleiro[eevee.y+1][eevee.x] !== 8 &&
        tabuleiro[eevee.y+1][eevee.x] !== 9 ) {
            if ( tabuleiro[eevee.y+1][eevee.x] === 'g' ||
            tabuleiro[eevee.y+1][eevee.x] === 'p' ||
            tabuleiro[eevee.y+1][eevee.x] === 's')
            {
                box.classList.add("active")
            }
            eevee.y += 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro[eevee.y][eevee.x] = 5;
            if (tabuleiro[eevee.y-1][eevee.x+1] == 9 && tabuleiro[eevee.y-1][eevee.x-1] == 9){
                tabuleiro[eevee.y-1][eevee.x] = 11;
            }
            else{tabuleiro[eevee.y-1][eevee.x]=3;}
            desenharTabuleiro3();
        }
    }
    if (event.keyCode === 40){ // jogador ANDAR PARA BAIXO SOM BATER
        if ( tabuleiro[eevee.y+1][eevee.x] === 1 ||
            tabuleiro[eevee.y+1][eevee.x] === 7 ||
            tabuleiro[eevee.y+1][eevee.x] === 8 ||
            tabuleiro[eevee.y+1][eevee.x] === 9 ){
            som_bater.play();
            
        }
    }
    
    console.log(tabuleiro)
 }

}
window.addEventListener("load", desenharTabuleiro3);




function desenharTabuleiro2(){ 
    document.getElementById("score").innerHTML = `Score: ${score}`;
    var el = document.getElementById('world');
    el.innerHTML = '';
    for(var y = 0; y < tabuleiro3.length ; y = y + 1) {
        for(var x = 0; x < tabuleiro3[y].length ; x = x + 1) {	
            if (tabuleiro3[y][x] === 1) {
                el.innerHTML += "<div class='wall'></div>";
            }
            else if (tabuleiro3[y][x] === 2) {
                el.innerHTML += "<div class='caminho'></div>";
            }
            else if (tabuleiro3[y][x] === 3) {
                el.innerHTML += "<div class='ground'></div>";
            }
            else if (tabuleiro3[y][x] === 4) {
                el.innerHTML += "<div class='vidaa'></div>";
            }
            else if (tabuleiro3[y][x] === 5) {
                el.innerHTML += "<div class='pikachu'></div>";
            }
            else if (tabuleiro3[y][x] === 6) {
                el.innerHTML += "<div class='fruta'></div>";
            }
            else if (tabuleiro3[y][x] === 7) {
                el.innerHTML += "<div class='arvore'></div>";
            }
            else if (tabuleiro3[y][x] === 8) {
                el.innerHTML += "<div class='pedra'></div>";
            }
            else if (tabuleiro3[y][x] === 10) {
                el.innerHTML += "<div class='fim'></div>";
            }
            else if (tabuleiro3[y][x] === 9) {
                el.innerHTML += "<div class='agua'></div>";
            }
            else if (tabuleiro3[y][x] === 11) {
                el.innerHTML += "<div class='ponte'></div>";
            }
            else if (tabuleiro3[y][x] === 'g') {
                el.innerHTML += "<div class='growlithe'></div>";	
            }
            else if (tabuleiro3[y][x] === 's') {
                el.innerHTML += "<div class='squirtle'></div>";	
            }
            
        }
        el.innerHTML += "<br>";
    }





 document.onkeydown = function(event){
    // console.log(event);
    if (event.keyCode === 37){ // jogador ANDAR PARA ESQUERDA
        if ( tabuleiro3[eevee.y][eevee.x-1] !== 1 &&  
        tabuleiro3[eevee.y][eevee.x-1] !== 7 && 
        tabuleiro3[eevee.y][eevee.x-1] !== 8 && 
        tabuleiro3[eevee.y][eevee.x-1] !== 9) {
            if ( tabuleiro3[eevee.y][eevee.x-1] === 'g' ||
            tabuleiro3[eevee.y][eevee.x-1] === 'p' ||
            tabuleiro3[eevee.y][eevee.x-1] === 's')
            {
                box.classList.add("active")
            }
            eevee.x -= 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro3[eevee.y][eevee.x] = 5;
            if (tabuleiro3[eevee.y+1][eevee.x+1] == 9 && tabuleiro3[eevee.y-1][eevee.x+1] == 9){
                tabuleiro3[eevee.y][eevee.x+1] = 11;
            }
            else{tabuleiro3[eevee.y][eevee.x+1]=3;}
            desenharTabuleiro2();
        }
    }
    if (event.keyCode === 37){ // jogador ANDAR PARA ESQUERDA SOM BATER
        if ( tabuleiro3[eevee.y][eevee.x-1] === 1 ||
            tabuleiro3[eevee.y][eevee.x-1] === 7 ||
            tabuleiro3[eevee.y][eevee.x-1] === 8 ||
            tabuleiro3[eevee.y][eevee.x-1] === 9 ){
            som_bater.play();
        }
    }

    else if (event.keyCode === 38) {
// jogador ANDAR PARA CIMA
        if ( tabuleiro3[eevee.y-1][eevee.x] !== 1 &&
        tabuleiro3[eevee.y-1][eevee.x] !== 7 &&
        tabuleiro3[eevee.y-1][eevee.x] !== 8 &&
        tabuleiro3[eevee.y-1][eevee.x] !== 9) {
            if ( tabuleiro3[eevee.y-1][eevee.x] === 'g' ||
            tabuleiro3[eevee.y-1][eevee.x] === 'p' ||
            tabuleiro3[eevee.y-1][eevee.x] === 's')
            {
                box.classList.add("active")
            }
            eevee.y -= 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro3[eevee.y][eevee.x] = 5;
            if (tabuleiro3[eevee.y+1][eevee.x-1] == 9 && tabuleiro3[eevee.y+1][eevee.x+1] == 9){
                tabuleiro3[eevee.y+1][eevee.x] = 11;
            }
            else{tabuleiro3[eevee.y+1][eevee.x]=3;}
            desenharTabuleiro2();
        
        }
    }
    if (event.keyCode === 38){ // jogador ANDAR PARA CIMA SOM BATER
        if ( tabuleiro3[eevee.y-1][eevee.x] === 1 ||
            tabuleiro3[eevee.y-1][eevee.x] === 7 ||
            tabuleiro3[eevee.y-1][eevee.x] === 8 ||
            tabuleiro3[eevee.y-1][eevee.x] === 9 ){
            som_bater.play();
        }
    }


    else if (event.keyCode === 39){ // jogador ANDAR PARA DIREITA
        if ( tabuleiro3[eevee.y][eevee.x+1] !== 1 &&
        tabuleiro3[eevee.y][eevee.x+1] !== 7 &&
        tabuleiro3[eevee.y][eevee.x+1] !== 8 &&
        tabuleiro3[eevee.y][eevee.x+1] !== 9) {
            if ( tabuleiro3[eevee.y][eevee.x+1] === 'g' ||
            tabuleiro3[eevee.y][eevee.x+1] === 'p' ||
            tabuleiro3[eevee.y][eevee.x+1] === 's')
            {
                box.classList.add("active")
            }
            eevee.x += 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro3[eevee.y][eevee.x] = 5;
            if (tabuleiro3[eevee.y+1][eevee.x-1] == 9 && tabuleiro3[eevee.y-1][eevee.x-1] == 9){
                tabuleiro3[eevee.y][eevee.x-1] = 11;
            }
            else{tabuleiro3[eevee.y][eevee.x-1]=3;}
            desenharTabuleiro2();
        }
    }
    if (event.keyCode === 39){ // jogador ANDAR PARA DIREITA SOM BATER
        if ( tabuleiro3[eevee.y][eevee.x+1] === 1 ||
            tabuleiro3[eevee.y][eevee.x+1] === 7 ||
            tabuleiro3[eevee.y][eevee.x+1] === 8 ||
            tabuleiro3[eevee.y][eevee.x+1] === 9 ){
            som_bater.play();
        }
    }


    else if (event.keyCode === 40){ // jogador ANDAR PARA BAIXO
        if ( tabuleiro3[eevee.y+1][eevee.x] !== 1 &&
        tabuleiro3[eevee.y+1][eevee.x] !== 7 &&
        tabuleiro3[eevee.y+1][eevee.x] !== 8 &&
        tabuleiro3[eevee.y+1][eevee.x] !== 9 ) {
            if ( tabuleiro3[eevee.y+1][eevee.x] === 'g' ||
            tabuleiro3[eevee.y+1][eevee.x] === 'p' ||
            tabuleiro3[eevee.y+1][eevee.x] === 's')
            {
                box.classList.add("active")
            }
            eevee.y += 1;
            atualizaScore(eevee.x, eevee.y);
            tabuleiro3[eevee.y][eevee.x] = 5;
            if (tabuleiro3[eevee.y-1][eevee.x+1] == 9 && tabuleiro3[eevee.y-1][eevee.x-1] == 9){
                tabuleiro3[eevee.y-1][eevee.x] = 11;
            }
            else{tabuleiro3[eevee.y-1][eevee.x]=3;}
            desenharTabuleiro2();
        }
    }
    if (event.keyCode === 40){ // jogador ANDAR PARA BAIXO SOM BATER
        if ( tabuleiro3[eevee.y+1][eevee.x] === 1 ||
            tabuleiro3[eevee.y+1][eevee.x] === 7 ||
            tabuleiro3[eevee.y+1][eevee.x] === 8 ||
            tabuleiro3[eevee.y+1][eevee.x] === 9 ){
            som_bater.play();
            
        }
    }
    
    console.log(tabuleiro3)
 }


}
window.addEventListener("load", desenharTabuleiro2);


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

//para aparecer no formato q fizemos antes
document.getElementById('contador').innerText = formato;
paraStr2=JSON.stringify(formato)
localStorage.setItem("formato", paraStr2)
//Retorna o valor tratado
return formato;
}

//--------------------------------------------------------------

function Verifica(){
    if (JSON.parse(localStorage.getItem('formData')).Username  === undefined) {
        alert('Por favor inicie sessão primeiro')
    }
}


  var score = 0;
  
  function atualizaScore(x, y) {
      if (tabuleiro2[y][x] === 4 ){
          score += 50;
          som_vida.play()
      }
      if (tabuleiro2[y][x] === 6 ){
          score += 50;
          comer.play()
      }
      if (tabuleiro2[y][x] === 10 ){
          score += 50;
          som_Ganhou.play()
          pausa(cronometro);
          alert('Parabéns! Você ganhou!')
          paraStr=JSON.stringify(score)
          localStorage.setItem("score", paraStr)
          
            
      }
  }



  console.log(window.localStorage.getItem('formato'));
//Dados
        function rollTheDice() {
            setTimeout(function () {
                var randomNumber1 = Math.floor(Math.random() * 6) + 1;
                var randomNumber2 = Math.floor(Math.random() * 6) + 1;

                document.querySelector(".img1").setAttribute("src",
                    "imagens/dice" + randomNumber1 + ".png");

                document.querySelector(".img2").setAttribute("src",
                    "imagens/dice" + randomNumber2 + ".png");

                if (randomNumber1 < randomNumber2) {
                    document.querySelector("h1.lanca-dados").innerHTML
                        = ( "Pokémon Venceu!");
                    setTimeout(function() {box.classList.remove("active")}, 1000); 
                    GameOver.classList.add("active");
                }

                else {
                    document.querySelector("h1.lanca-dados").innerHTML
                        = ( "Jogador Venceu!");
                    setTimeout(function() {box.classList.remove("active")}, 1000); 
                    document.querySelector("h1.lanca-dados").innerHTML
                        = ( "Lança os dados");
                }
            }, 100);
        }

