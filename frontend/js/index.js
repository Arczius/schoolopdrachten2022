"use strict";

const app = document.querySelector("#app");
const Cookie = new ManageCookies();

var fouteAntwoorden;
var goedeAntwoorden;

const startupSetTheme = () => {
    if(Cookie.exists("Theme")){
        const ThemeVal = Cookie.value("Theme");
        if(Themes.includes(ThemeVal)){
            document.querySelector("html").classList.add(ThemeVal);
        }
    }
}

window.addEventListener('DOMContentLoaded', () => {
    startupSetTheme();
});


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
        <button onclick="showAllThemes()">Show a theme</button>
        <button onclick="startGame();">Start</button>
    </div>

</div>
`;

app.innerHTML = home;

const homeButton = () => {
    app.innerHTML = home;
}

const showAllThemes = () => {
    let item = `
    ${header}
    <div>
        <button onclick="pickTheme('pink')">Pink</button>
        <button onclick="pickTheme('blue')">Blue</button>
        <button onclick="pickTheme('black')">Black</button>
    </div>
    `;
    app.innerHTML = item;
}

const pickTheme = (ThemeName) => {
    if(Themes.includes(ThemeName.toLowerCase())){
        Cookie.create("Theme", ThemeName, 7, "Strict");
        window.location.href = "/"
    }
}

const showAllPokemon = () => { 
    app.innerHTML = header;

    app.innerHTML += `<ul class="list">`;
    pokemonArray.forEach(function(pokemon,number){
        app.innerHTML += `<li>${number + 1}: ${pokemon} <img src="./img/${pokemon}.png" alt="afbeelding voor ${pokemon}"></li>`;
    });
    app.innerHTML += `</ul>`; 
}

var pokemonAmount = 0;

const startGame = () => {
    app.innerHTML = header;

    app.innerHTML += `
    <div class="game">
        pokemon: <input type="number" id="pokeAmount" value="${pokemonAmount}"></input>
        <br>
        <button onclick="randomPoke();">Start</button>
    </div>`;
}

const randomPoke = () => {
    let pokeAmount = document.querySelector("input#pokeAmount").value;
    pokemonAmount = pokeAmount;
    if(pokemonAmount != 0){        
        game();
    }
    else{
        alert("je kan geen 0 pokemon raden");
    }
}

const generatePokemonName = () => {
    let number = Math.floor(Math.random() * pokemonArray.length);
    return pokemonArray[number];
}



var curPokemonAmount;
var curPokemon;

const checkValue = (pokemonName) => {
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

const game = () => {
    console.log(pokemonAmount);

    if(curPokemonAmount === undefined){
        curPokemonAmount = 0;
        fouteAntwoorden = 0;
        goedeAntwoorden = 0;
    }
    
    if(pokemonAmount !== 0){

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