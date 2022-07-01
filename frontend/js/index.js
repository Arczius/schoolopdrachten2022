"use strict";

const app = document.querySelector("#app");

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
}