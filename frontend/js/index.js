"use strict";

// initialising the base app
const app = document.querySelector("#app");
const Cookie = new ManageCookies();

// the variable where we save the amount of items in a scoreboard
const scoreBoardSaveAmount = 10;

// a variable to set how long cookies stay on the web page
const cookieTime = 300;

// initialising the bad and good answers
var fouteAntwoorden;
var goedeAntwoorden;

// a function to set the theme of the webpage
const startupSetTheme = () => {
    if(Cookie.exists("Theme")){
        const ThemeVal = Cookie.value("Theme");
        if(Themes.includes(ThemeVal)){
            document.querySelector("html").classList.add(ThemeVal);
        }
    }
}

// a function to set the layout of the page
const startupLayoutSet = () => {
    if(!Cookie.exists("layout")) layoutTheme("horizontal");

    const layoutVal = Cookie.value("layout");
    const layoutThemes = ["horizontal", "vertical"];

    if(!layoutThemes.includes(layoutVal)) layoutTheme("horizontal");

    document.querySelector("html").classList.add(layoutVal);
}


// when the base page is loaded it initializes the base layout and theme
window.addEventListener('DOMContentLoaded', () => {
    startupSetTheme();
    startupLayoutSet();
});

// an array to save the scoreboard in
const scoreBoardArr = [];

// reading the local storage for an possibly already existing scoreboard
const initialiseLocalScoreboard = () => {
    if(Cookie.exists("scoreboard")){
        let scoreboard = Cookie.value("scoreboard").split("},");
        scoreboard.forEach((item) => {
            if(item !== ""){
                item += "}";
                console.log(item);
                let testItem = JSON.parse(item);
                scoreBoardArr.push(testItem);
            }
        })
    }
}

// setting the scoreboard from the local storage
initialiseLocalScoreboard();

// a function to add game scores to the scoreboard variable
const addScoreToScoreBoard = (goodAnswers, badAnswers, maxSeconds, SecondsLeft, totalPokemon) => {
    if(scoreBoardArr.length === scoreBoardSaveAmount) scoreBoardArr.remove(scoreBoardSaveAmount - 1);

    scoreBoardArr.push(
        {
            "index": scoreBoardArr.length + 1,
            "goodAnswers": goodAnswers, 
            "badAnswers": badAnswers,
            "maxSeconds": maxSeconds,
            "secondsLeft": SecondsLeft,
            "totalPokemon": totalPokemon,
            "date": new Date(Date.now())
        }
    );
    saveScoreBoard();
}

// a function to save the scoreboard earlier created scoreboard variable to local storage
const saveScoreBoard = () => {
    let item = "";
    
    scoreBoardArr.forEach((score) => {
        item += JSON.stringify(score);
        item += ",";
    });

    Cookie.create("scoreboard", item, cookieTime, "Strict");
}

// a function for the sort buttons on the homepage
const genScoreBoardHomeSorted = (sortby) => {
    switch(sortby){
        case "oldest":
        case "newest":
        case "none":
                app.innerHTML = home;
                app.innerHTML += genScoreBoardLastGames(sortby);
            break;
        
        default:
            homeButton();
    }
}

// the base function for generating the frontend for all the scores
const genScoreBoardLastGames = (sortby = null) => {
    let items = `<div class="scoreboard">
        <div class="sortbyControls">
            <h4>sort by</h4>
            <button onclick="genScoreBoardHomeSorted('oldest')">oldest</button>
            <button onclick="genScoreBoardHomeSorted('newest')">newest</button>
            <button onclick="genScoreBoardHomeSorted('none')">none</button>
        </div>
        <h3>Scorebord</h3>   
    `;

    let dates = scoreBoardArr;
    if(sortby === "oldest"){
        dates.sort((a, b) => a.date - b.date);
    }
    else if(sortby === "newest"){
        dates.sort((a, b) => a.date - b.date);

        dates.reverse();
    }

    dates.forEach((item) => {
        items += `<div class="item">
            <p>Game: ${item.index}</p> 
            <p>Aantal pokemon om te raden: ${item.totalPokemon}</p>
            <p>Goede antwoorden: ${item.goodAnswers}</p>
            <p>Foute antwoorden: ${item.badAnswers}</p>
            <p>Maximale tijd: ${item.maxSeconds}</p>
            <p>Seconden over: ${item.secondsLeft}</p>
            <p>Datum: ${item.date}</p>
        </div>`;
    });
   
    items += `</div>`;

    return items;
}

// the base header variable
const header = `
<div class="header">
    <h1>Pokemon Quiz</h1>
    <div>
        <button onclick="homeButton();">Home</button> 
    </div>
</div>
`;

// the base homepage value
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


// the behaviour of the home button in the header, also called in other functions
const homeButton = () => {
    document.location.href = "/";
}

// a function to show all the possible themes in the app / layout configurations
const showAllThemes = () => {
    let item = `
    ${header}
    <div>
        <h3>color themes</h3>
        <button onclick="pickTheme('pink')">Pink</button>
        <button onclick="pickTheme('blue')">Blue</button>
        <button onclick="pickTheme('black')">Black</button>

        <br>
        <h3>layout themes</h3>
        <button onclick="layoutTheme('horizontal')">horizontal</button>
        <button onclick="layoutTheme('vertical')">vertical</button>
    </div>
    `;
    app.innerHTML = item;
}

// a function to save the layout theme to local storage
const layoutTheme = (ThemeName) => {
    if(ThemeName === 'horizontal' || ThemeName === 'vertical'){
        Cookie.create("layout", ThemeName, cookieTime, "Strict");
        window.location.href = "/";
    }
}

const pickTheme = (ThemeName) => {
    if(Themes.includes(ThemeName.toLowerCase())){
        Cookie.create("Theme", ThemeName, cookieTime, "Strict");
        window.location.href = "/";
    }
}

const showAllPokemon = () => { 
    app.innerHTML = header;

    let item = "";
    pokemonArray.forEach(function(pokemon,number){
        item += `<li>${number + 1}: ${pokemon} <img src="./img/${pokemon}.png" alt="afbeelding voor ${pokemon}"></li>`;
    });

    app.innerHTML += `<ul class="list--all-pokemon">${item}</ul>`; 
}

var pokemonAmount = 0;
var PokemonSeconds = 0;

const startGame = () => {
    app.innerHTML = header;

    app.innerHTML += `
    <div class="game">
        pokemon: <input type="number" id="pokeAmount" value="${pokemonAmount}" max="${pokemonArray.length}" min="0"></input>
        <br>
        tijd in seconden: <input type="number" min="0" value=${PokemonSeconds} id="pokemonSeconds"></input>
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

// the values for the game
var interval;
var seconds = 0;

// a function to run the game itself
const game = () => {
    seconds = parseInt(PokemonSeconds);
    let pokemonArr = [];
    
    for(let i = 0; i < parseInt(pokemonAmount); i++){
        let pokemonName = generatePokemonName();
        if(!pokemonArr.includes(pokemonName)) pokemonArr.push(pokemonName);
    }
    pokemonLeft = parseInt(pokemonAmount) - 1;

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

    app.innerHTML = `<div class="timer" style="--max-time: ${PokemonSeconds}; --current-time-left: ${PokemonSeconds};"><span> ${PokemonSeconds}</span></div>`;

    app.innerHTML += `<div class="top-game-container">
    ${names}
    ${images} 
    </div> 
    `;

    if(curPokemonAmount === undefined){
        curPokemonAmount = 0;
        fouteAntwoorden = 0;
        goedeAntwoorden = 0;
    }


    interval = setInterval(function() {
        if(document.querySelector(".timer") !== undefined || document.querySelector(".timer") !== null) {
            let timer = document.querySelector(".timer");
            timer.innerHTML = `<span>${seconds}</span>`;

            timer.style.setProperty("--current-time-left", seconds);
        }
        if(seconds === 0){
            gameDone(interval, seconds);
            alert("de tijd is op");
        } 
        seconds--;
    }, 1000);
}

// a function which is called when the game is done
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


// initialising the base app when the page loads
app.innerHTML = home;
app.innerHTML += genScoreBoardLastGames();