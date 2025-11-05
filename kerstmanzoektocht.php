<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kerstspel Portal — Vind de Kerstman!</title>

<style>
  body {
    margin: 0;
    font-family: 'Georgia', serif;
    background: linear-gradient(to bottom, #0a2a4c, #001f3f);
    color: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    min-height: 100vh;
  }

  h1 {
    text-align:center;
    margin-bottom: 10px;
    color:#ffd700;
    text-shadow: 2px 2px 8px #000;
    font-size: 2.8rem;
  }

  .menu {
    display:flex; flex-wrap:wrap; justify-content:center; gap:15px; margin:20px 0;
  }

  .menu button {
    padding:12px 25px;
    font-size:1.1rem;
    cursor:pointer;
    border-radius:12px;
    border:none;
    background: linear-gradient(135deg, #f44336, #ff7961);
    color:#fff;
    font-weight:bold;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    transition:0.3s;
  }

  .menu button:hover {
    background: linear-gradient(135deg, #ff7961, #f44336);
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0,0,0,0.4);
  }

  .controls {
    display:flex;
    justify-content:center;
    gap:20px;
    margin-bottom:10px;
    align-items:center;
  }

  .reset-btn {
    padding:8px 15px;
    cursor:pointer;
    border-radius:8px;
    border:none;
    background: linear-gradient(135deg, #f48b73, #ffb347);
    color:#fff;
    font-weight:bold;
    box-shadow: 0 3px 6px rgba(0,0,0,0.3);
    transition:0.3s;
  }

  .reset-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 10px rgba(0,0,0,0.4);
  }

  .highscore {
    font-size:1.2rem;
    color:#ffd700;
    text-shadow: 1px 1px 2px #000;
  }

  .game {
    display:none;
    margin-top:20px;
    position:relative;
    width:100%;
    max-width:1000px;
    text-align:center;
  }

  /* Vakjes Klikspel */
  #gameBoard {
    display:grid;
    justify-content:center;
    grid-template-columns: repeat(5, 90px);
    grid-template-rows: repeat(5, 90px);
    gap:12px;
    margin:0 auto;
  }

  .cell {
    width:90px;
    height:90px;
    background: linear-gradient(145deg, #c62828, #b71c1c);
    border-radius:15px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:2.5rem;
    cursor:pointer;
    box-shadow: 0 4px 8px rgba(0,0,0,0.4);
    transition: transform 0.2s, background 0.3s;
  }

  .cell:hover { 
    transform:scale(1.15); 
    background: linear-gradient(145deg, #d32f2f, #e53935);
  }

  /* Memory Game */
  #memoryBoard {
    display:grid;
    justify-content:center;
    grid-template-columns: repeat(4, 90px);
    grid-template-rows: repeat(4, 90px);
    gap:12px;
    margin:0 auto;
  }

  .card {
    width:90px;
    height:90px;
    background: linear-gradient(145deg, #c62828, #b71c1c);
    border-radius:15px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:2.5rem;
    cursor:pointer;
    color:#fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.4);
    transition: transform 0.2s, background 0.3s;
  }

  .card:hover { transform: scale(1.1); background: linear-gradient(145deg, #d32f2f, #e53935); }

  /* Pong */
  #pongCanvas {
    background: #004d00;
    border: 3px solid #ffd700;
    border-radius: 15px;
    display:block;
    margin:0 auto;
    box-shadow: 0 5px 15px rgba(0,0,0,0.5);
  }

  .message {
    margin-top:15px;
    font-size:1.3rem;
    text-align:center;
    color:#ffd700;
    text-shadow: 1px 1px 2px #000;
  }

  .back-button {
    text-align: center;
    margin: 20px 0;
  }

  .menu-button {
    display: inline-block;
    padding: 12px 25px;
    font-size: 1.1rem;
    font-weight: bold;
    color: #fff;
    background: linear-gradient(135deg, #4caf50, #81c784);
    border-radius: 12px;
    text-decoration: none;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    transition: 0.3s;
  }

  .menu-button:hover {
    background: linear-gradient(135deg, #81c784, #4caf50);
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0,0,0,0.4);
  }

  /* --- Mobiel responsive --- */
  @media (max-width: 768px){
    h1 {
      font-size: 2rem;
    }

    .menu button, .menu-button {
      padding: 10px 18px;
      font-size: 1rem;
    }

    .reset-btn {
      padding: 6px 12px;
      font-size: 0.95rem;
    }

    #gameBoard, #memoryBoard {
      grid-template-columns: repeat(5, 60px);
      grid-template-rows: repeat(5, 60px);
      gap: 8px;
    }

    .cell, .card {
      width: 60px;
      height: 60px;
      font-size: 1.8rem;
    }

    #pongCanvas {
      width: 100%;
      height: auto;
      max-height: 300px;
    }
  }

  @media (max-width: 480px){
    #gameBoard, #memoryBoard {
      grid-template-columns: repeat(4, 50px);
      grid-template-rows: repeat(4, 50px);
      gap: 6px;
    }

    .cell, .card {
      width: 50px;
      height: 50px;
      font-size: 1.5rem;
    }

    h1 {
      font-size: 1.6rem;
    }
  }

  /* Pong touch-buttons */
  #pongControls button {
    padding: 8px 16px;
    font-size: 1.2rem;
    margin: 2px;
    border-radius: 8px;
    border: none;
    background: linear-gradient(135deg, #4caf50, #81c784);
    color: white;
    font-weight: bold;
  }
  #pongControls {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 10px;
    flex-wrap: wrap;
  }
</style>
</head>
<body>

<h1>🎄 Kerst Mini Games! 🎅</h1>

<div class="menu">
  <button onclick="startGame(0)">🏠 Startmenu</button>
  <button onclick="startGame(1)">Vakjes Klikspel</button>
  <button onclick="startGame(2)">Memory Game</button>
  <button onclick="startGame(3)">Pong 2 Player</button>
</div>

<div class="controls">
  <button class="reset-btn" id="resetBtn">🔄 Reset Huidig Spel</button>
  <div class="highscore" id="highscoreDisplay">🏆 Highscore: -</div>
</div>

<!-- Startmenu -->
<div id="startMenu" class="game" style="display:block;">
  <h2>🎄 Welkom bij het Kerstspel Portal!</h2>
  <p>Kies één van de spellen hieronder en probeer de Memory Game of speel een potje Pong met een vriend!</p>
</div>

<!-- Vakjes Klikspel -->
<div id="game1" class="game">
  <div id="gameBoard"></div>
  <div class="message" id="message1"></div>
</div>

<!-- Memory Game -->
<div id="game2" class="game">
  <div id="memoryBoard"></div>
  <div class="message" id="message2"></div>
</div>

<!-- Pong -->
<div id="game3" class="game">
  <canvas id="pongCanvas" width="1000" height="500"></canvas>
  <div id="pongControls">
    <button id="up1">⬆️</button>
    <button id="down1">⬇️</button>
    <button id="up2">⬆️</button>
    <button id="down2">⬇️</button>
  </div>
  <div class="message" id="message3"></div>
</div>

<audio id="successSound" src="success.mp3"></audio>

<script>
const games = [
  document.getElementById('startMenu'),
  document.getElementById('game1'),
  document.getElementById('game2'),
  document.getElementById('game3')
];
let currentGame = 0;
const resetBtn = document.getElementById('resetBtn');
const highscoreDisplay = document.getElementById('highscoreDisplay');

function startGame(n){
  currentGame=n;
  games.forEach(g=>g.style.display='none');
  games[n].style.display='block';
  updateHighscoreDisplay();
  if(n===1) setupVakjes();
  if(n===2) setupMemory();
  if(n===3) setupPong();
}

resetBtn.addEventListener('click', ()=>{
  if(currentGame===1) setupVakjes(true);
  if(currentGame===2) setupMemory(true);
  if(currentGame===3) setupPong(true);
});

function updateHighscore(key,value){
  let current = parseInt(localStorage.getItem(key)) || null;
  if(current===null || value<current){
    localStorage.setItem(key,value);
  }
}
function updateHighscoreDisplay(){
  let key;
  if(currentGame===1) key='highscore1';
  if(currentGame===2) key='highscore2';
  if(currentGame===3) key='highscore3';
  let val = parseInt(localStorage.getItem(key));
  highscoreDisplay.textContent='🏆 Highscore: '+(val||'-');
}

/* --- Vakjes Klikspel --- */
function setupVakjes(reset=false){
  const board=document.getElementById('gameBoard');
  const msg=document.getElementById('message1');
  board.innerHTML=''; msg.textContent='';
  const total=25;
  const santa=Math.floor(Math.random()*total);
  let clicks=0;
  for(let i=0;i<total;i++){
    const cell=document.createElement('div');
    cell.classList.add('cell');
    cell.dataset.index=i;
    cell.addEventListener('click',()=>{
      clicks++;
      if(i===santa){
        cell.textContent='🎅';
        msg.textContent=`🎉 Je hebt de Kerstman gevonden in ${clicks} klikken!`;
        document.getElementById('successSound').play();
        updateHighscore('highscore1',clicks);
        updateHighscoreDisplay();
      } else {
        cell.textContent='❌'; cell.style.background='#444';
        msg.textContent='Helaas, probeer opnieuw…';
      }
    });
    board.appendChild(cell);
  }
}

/* --- Memory Game --- */
function setupMemory(reset=false){
  const board=document.getElementById('memoryBoard');
  const msg=document.getElementById('message2');
  board.innerHTML=''; msg.textContent='';
  const symbols=['🎅','🎄','❄','🎁','⛄','🦌','🕯','🍪'];
  let cards=[...symbols,...symbols].sort(()=>Math.random()-0.5);
  let first=null,second=null,attempts=0,matches=0;
  cards.forEach(sym=>{
    const card=document.createElement('div');
    card.classList.add('card');
    card.dataset.symbol=sym;
    card.textContent='';
    card.addEventListener('click',()=>{
      if(card.textContent!==''||second) return;
      card.textContent=sym;
      if(!first) first=card;
      else{
        second=card;
        attempts++;
        if(first.dataset.symbol===second.dataset.symbol){
          first=null; second=null; matches++;
          if(matches===symbols.length){
            msg.textContent=`🎉 Memory voltooid in ${attempts} pogingen!`;
            document.getElementById('successSound').play();
            updateHighscore('highscore2',attempts);
            updateHighscoreDisplay();
          }
        } else {
          setTimeout(()=>{first.textContent=''; second.textContent=''; first=null; second=null;},500);
        }
        msg.textContent=`Aantal pogingen: ${attempts}`;
      }
    });
    board.appendChild(card);
  });
}

/* --- Pong --- */
let pongInterval;
function setupPong(reset=false){
  const canvas=document.getElementById('pongCanvas');
  const ctx=canvas.getContext('2d');
  const paddleWidth=20, paddleHeight=120;
  let paddle1Y=canvas.height/2-paddleHeight/2;
  let paddle2Y=canvas.height/2-paddleHeight/2;
  let ballX=canvas.width/2, ballY=canvas.height/2;
  let ballSpeedX=3, ballSpeedY=3;
  let up1=false,down1=false,up2=false,down2=false;
  let score1=0,score2=0;

  if(pongInterval) clearInterval(pongInterval);

  document.onkeydown=function(e){
    if(e.key==='w') up1=true;
    if(e.key==='s') down1=true;
    if(e.key==='ArrowUp') up2=true;
    if(e.key==='ArrowDown') down2=true;
  }
  document.onkeyup=function(e){
    if(e.key==='w') up1=false;
    if(e.key==='s') down1=false;
    if(e.key==='ArrowUp') up2=false;
    if(e.key==='ArrowDown') down2=false;
  }

  // Touch controls
  document.getElementById('up1').ontouchstart = () => up1=true;
  document.getElementById('up1').ontouchend = () => up1=false;
  document.getElementById('down1').ontouchstart = () => down1=true;
  document.getElementById('down1').ontouchend = () => down1=false;
  document.getElementById('up2').ontouchstart = () => up2=true;
  document.getElementById('up2').ontouchend = () => up2=false;
  document.getElementById('down2').ontouchstart = () => down2=true;
  document.getElementById('down2').ontouchend = () => down2=false;

  function drawPaddle(x,y){
    for(let i=0;i<paddleHeight;i+=10){
      ctx.fillStyle=i%20===0?'#ff0000':'#ffffff';
      ctx.fillRect(x,y+i,paddleWidth,10);
    }
  }

  function draw(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    drawPaddle(20,paddle1Y);
    drawPaddle(canvas.width-40,paddle2Y);
    ctx.fillStyle='#ffffff';
    ctx.beginPath();
    ctx.arc(ballX,ballY,10,0,Math.PI*2);
    ctx.fill();
    ctx.fillStyle='#ffd700';
    ctx.font='20px Georgia';
    ctx.fillText(score1,canvas.width/4,30);
    ctx.fillText(score2,canvas.width*3/4,30);
  }

  function update(){
    if(up1 && paddle1Y>0) paddle1Y-=5;
    if(down1 && paddle1Y<canvas.height-paddleHeight) paddle1Y+=5;
    if(up2 && paddle2Y>0) paddle2Y-=5;
    if(down2 && paddle2Y<canvas.height-paddleHeight) paddle2Y+=5;

    ballX+=ballSpeedX;
    ballY+=ballSpeedY;

    if(ballY<10||ballY>canvas.height-10) ballSpeedY*=-1;

    if(ballX<40 && ballY>paddle1Y && ballY<paddle1Y+paddleHeight){
      ballSpeedX*=-1.05;
    }
    if(ballX>canvas.width-40 && ballY>paddle2Y && ballY<paddle2Y+paddleHeight){
      ballSpeedX*=-1.05;
    }

    if(ballX<0){ score2++; ballX=canvas.width/2; ballY=canvas.height/2; ballSpeedX=3; ballSpeedY=3;}
    if(ballX>canvas.width){ score1++; ballX=canvas.width/2; ballY=canvas.height/2; ballSpeedX=-3; ballSpeedY=3;}
  }

  pongInterval=setInterval(()=>{ update(); draw(); },16);
}

// Startmenu standaard tonen
startGame(0);
</script>
<div class="back-button">
  <a href="index.php" class="menu-button">🎁 Terug naar Adventskalender</a>
</div>

</body>
</html>
