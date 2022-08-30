"use strict";

const app = document.querySelector("#app");

var fouteAntwoorden;
var goedeAntwoorden;

const header = `
<div class="header">
    <h1>Pokemon Quiz</h1>
    <div>
        <button onclick="homeButton();">Home</button> 
    </div>

</div>
`;

const home = `
${header}
<div class="homeContainer">


    <div class="inner">
        <button onclick="showAllPokemon();">Show All Pokemon</button> 

        <button onclick="startGame();">Start</button>
    </div>
</div>
`;

app.innerHTML = home;

function homeButton(){
    app.innerHTML = home;
}


function showAllPokemon(){ 
    app.innerHTML = header;

    app.innerHTML += `<ul class="list">`;
    pokemonArray.forEach(function(pokemon,number){
        app.innerHTML += `<li>${number + 1}: ${pokemon} <img src="./img/${pokemon}.png" alt="afbeelding voor ${pokemon}"></li>`;
    });
    app.innerHTML += `</ul>`; 
}

var pokemonAmount = 0;
var minutes = 0;

function startGame(){
    app.innerHTML = header;

    app.innerHTML += `
    <div class="game">
        pokemon: <input type="number" id="pokeAmount" value="${pokemonAmount}"></input>
        <br>
        minutes: <input type="number" id="gameMinutes" value=${minutes}></input>
        <br>
        <button onclick="randomPoke();">Start</button>
    </div>`;
}

function randomPoke(){
    let pokeAmount = document.querySelector("input#pokeAmount").value;
    pokemonAmount = pokeAmount;
    let minAmount = document.querySelector("input#gameMinutes").value;
    minutes = minAmount;

    game(pokeAmount,minAmount);
}

function generatePokemonName(){
    let number = Math.floor(Math.random() * pokemonArray.length);
    return pokemonArray[number];
}



var curPokemonAmount;
var curPokemon;

function checkValue(pokemonName){
    if(pokemonName == curPokemon){
        curPokemonAmount++;
        goedeAntwoorden++;
        game();
    }
    else{
        curPokemonAmount++;
        fouteAntwoorden++;
        game();
    }
}

function game(){

    if(curPokemonAmount === undefined){
        curPokemonAmount = 0;
        fouteAntwoorden = 0;
        goedeAntwoorden = 0;
    }
    
    if(curPokemonAmount < pokemonAmount){
        app.innerHTML = header;
        curPokemon = generatePokemonName();

        const arr = [
            curPokemon,
        ];
        
        for(let i = 0; i < 2; i++){
            let pokemon = generatePokemonName();
            while(arr.includes(pokemon)){
                pokemon = generatePokemonName();
            }
            arr.push(pokemon);
        }

        let content;

        for(let i = 0; i < 3; i++) {
            let pokemon = arr[Math.floor(Math.random() * arr.length)];
            let item = `<li><img src="./img/${pokemon}.png">${pokemon} <button>deze?</button></li>`;
            if(content !== undefined){
                while(content.includes(pokemon)){
                    pokemon = arr[Math.floor(Math.random() * arr.length)];
                }
            }
            item = `<li><button onclick="checkValue('${pokemon}')">${pokemon}</button></li>`;

            if(i === 0){
                content = item;
            }
            else{
                content += item;
            }
        }       

        app.innerHTML += `<ul class="gameHolder">
        <div class="pokemonActualHolder">
            <p>welke pokemon zie je hier?</p> 
            <img src="./img/${curPokemon}.png">
        </div>
        ${content}
        </ul>`;
    }
    else{
        app.innerHTML = header;
        app.innerHTML += `<div>
            <ul>
                <li>Goede antwoorden: ${goedeAntwoorden}</li>
                <li>Foute antwoorden: ${fouteAntwoorden}</li>
            </ul>
        </div>`;
        goedeAntwoorden = 0;
        fouteAntwoorden = 0;
        curPokemonAmount = undefined;
    }
}