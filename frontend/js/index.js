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

const scoreBoardArr = [];

const addScoreToScoreBoard = (goodAnswers, badAnswers, maxSeconds, SecondsLeft, totalPokemon) => {
    if(scoreBoardArr.length === 10) scoreBoardArr.remove(9);

    scoreBoardArr.push(
        {
            "goodAnswers": goodAnswers, 
            "badAnswers": badAnswers,
            "maxSeconds": maxSeconds,
            "secondsLeft": SecondsLeft,
            "totalPokemon": totalPokemon
        }
    );
}

const genScoreBoardLastGames = () => {
    let items = `<div class="scoreboard">
        <h3>Scorebord</h3>   
    `;
    scoreBoardArr.forEach((item, index) => {
        items += `<div class="item">
            <p>Game: ${index + 1}</p> 
            <p>Aantal pokemon om te raden: ${item.totalPokemon}</p>
            <p>Goede antwoorden: ${item.goodAnswers}</p>
            <p>Foute antwoorden: ${item.badAnswers}</p>
            <p>Maximale tijd: ${item.maxSeconds}</p>
            <p>Seconden over: ${item.secondsLeft}</p>
        </div>`;        
    });

    items += `</div>`;

    return items;
}

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
    app.innerHTML += genScoreBoardLastGames();
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
var PokemonSeconds = 0;

const startGame = () => {
    app.innerHTML = header;

    app.innerHTML += `
    <div class="game">
        pokemon: <input type="number" id="pokeAmount" value="${pokemonAmount}" max="${pokemonArray.length}"></input>
        <br>
        tijd in seconden: <input type="number" value=${PokemonSeconds} id="pokemonSeconds"></input>
        <br>
        <button onclick="randomPoke();">Start</button>
    </div>`;
}

const randomPoke = () => {
    let pokeAmount = document.querySelector("input#pokeAmount").value;
    let timeAmount = document.querySelector("input#pokemonSeconds").value
    PokemonSeconds = timeAmount;
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
var pokemonLeft;

const checkValue = (pokemonName) => {
    if(pokemonLeft !== 0){
        let checkbox = document.querySelector(`#` + pokemonName);
        if(checkbox !== null && checkbox !== undefined){
            if(checkbox.checked){
                goedeAntwoorden++;
                let corrAnw = document.getElementsByClassName(pokemonName);
                corrAnw[0].remove();
                corrAnw[0].remove();
                console.log(pokemonLeft)
                pokemonLeft--;
            }
            else{
                fouteAntwoorden++;
                let item = document.querySelectorAll('input[type=checkbox]');
                for(let i = 0; i < item.length; i++){
                    item[i].checked = false;
                }
            }
        }
    }
    else{
        goedeAntwoorden++;
        gameDone(interval, seconds);
    }
}

var interval;
var seconds = 0;

const game = () => {
    seconds = parseInt(PokemonSeconds);
    let pokemonArr = [];
    
    for(let i = 0; i < parseInt(pokemonAmount); i++){
        let pokemonName = generatePokemonName();
        if(!pokemonArr.includes(pokemonName)) pokemonArr.push(pokemonName);
    }
    pokemonLeft = parseInt(pokemonAmount) - 1;
    // let namesArr = pokemonArr.sort();

    let names = "<div class='namesHolder'>";
    let images = "<div class='imagesHolder'>";

    pokemonArr.forEach((val) => {
        images += `<div class="${val}">
        <img src="./img/${val}.png" onclick="checkValue('${val}')">
        </div>`;

    });

    pokemonArr.sort().forEach((val) => {
        names += `<div class="${val}">
        <input class="hidden" id="${val}" type="checkbox" name=${val}></input>  
        <label for="${val}">${val}</label>
        </div>`;
    });

    names += "</div>";
    images += "</div>";

    app.innerHTML = `<div class="timer"></div>`;

    app.innerHTML += names;
    app.innerHTML += images;

    if(curPokemonAmount === undefined){
        curPokemonAmount = 0;
        fouteAntwoorden = 0;
        goedeAntwoorden = 0;
    }


    interval = setInterval(function() {
        if(document.querySelector(".timer") !== undefined || document.querySelector(".timer") !== null) {
            document.querySelector(".timer").innerHTML = seconds; 
        }
        if(seconds === 0){
            gameDone(interval, seconds);
            alert("de tijd is op");
        } 
        seconds--;
    }, 1000);
}

const gameDone = (interval, secondsLeft) => {
    clearInterval(interval);
    app.innerHTML = header;
    app.innerHTML += `
    <ul>
        <li>aantal ingestelde vragen: ${pokemonAmount}</li>
        <li>aantal ingestelde seconden: ${PokemonSeconds}</li>
        <li>aantal seconden over: ${secondsLeft}</li>
        <li>aantal vragen correct beantwoord: ${goedeAntwoorden}
        <li>aantal vragen fout beantwoord: ${fouteAntwoorden}</li>
    </ul>
    `;

    addScoreToScoreBoard(goedeAntwoorden, fouteAntwoorden, PokemonSeconds, secondsLeft, pokemonAmount);
    console.log(genScoreBoardLastGames());
    goedeAntwoorden = 0;
    fouteAntwoorden = 0;
}