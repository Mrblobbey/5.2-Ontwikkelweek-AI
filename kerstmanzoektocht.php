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
  background: linear-gradient(to bottom, #001f3f, #003366);
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
  text-shadow:2px 2px 5px #000;
}
.menu {
  display:flex; flex-wrap:wrap; justify-content:center; gap:15px; margin:20px;
}
.menu button {
  padding:10px 20px;
  font-size:1rem;
  cursor:pointer;
  border-radius:8px;
  border:none;
  background:#f48b73;
  color:#fff;
  transition:0.2s;
}
.menu button:hover { background:#ffb347; }

.controls {
  display:flex;
  justify-content:center;
  gap:20px;
  margin-bottom:10px;
}
.reset-btn {
  padding:5px 10px;
  cursor:pointer;
  border-radius:5px;
  border:none;
  background:#f48b73;
  color:#fff;
}
.reset-btn:hover { background:#ffb347; }
.highscore {
  font-size:1rem;
  color:#ffd700;
  align-self:center;
}

.game {
  display:none;
  margin-top:20px;
  position:relative;
  width:100%;
  max-width:1000px;
  text-align:center;
}

/* Vakjes */
#gameBoard {
  display:grid;
  justify-content: center;
  grid-template-columns: repeat(5, 80px);
  grid-template-rows: repeat(5, 80px);
  gap:10px;
  margin:0 auto;
}
.cell {
  width:80px;
  height:80px;
  background:#b30000;
  border-radius:10px;
  display:flex;
  justify-content:center;
  align-items:center;
  font-size:2rem;
  cursor:pointer;
  transition:transform 0.2s;
  position:relative;
}
.cell:hover { transform:scale(1.1); }

/* Memory */
#memoryBoard {
  display:grid;
  justify-content: center;
  grid-template-columns: repeat(4, 80px);
  grid-template-rows: repeat(4, 80px);
  gap:10px;
  margin:0 auto;
}
.card {
  width:80px;
  height:80px;
  background:#b30000;
  border-radius:10px;
  display:flex;
  justify-content:center;
  align-items:center;
  font-size:2rem;
  cursor:pointer;
  color:#fff;
}

/* Pong */
#pongCanvas {
  background:#004400;
  border:2px solid #fff;
  display:block;
  margin:0 auto;
}

.message { margin-top:15px; font-size:1.2rem; text-align:center; }
</style>
</head>
<body>

<h1>🎄 Vind de Kerstman! 🎅</h1>

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

<div id="startMenu" class="game" style="display:block;">
  <p>Kies één van de spellen en probeer de Kerstman te vinden of speel Pong! 🎅</p>
</div>

<div id="game1" class="game">
  <div id="gameBoard"></div>
  <div class="message" id="message1"></div>
</div>

<div id="game2" class="game">
  <div id="memoryBoard"></div>
  <div class="message" id="message2"></div>
</div>

<div id="game3" class="game">
  <canvas id="pongCanvas" width="1000" height="500"></canvas>
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

/* Highscore helpers */
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

  function drawPaddle(x,y){
    // Zuurstok paddle rood-wit
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
</script>
</body>
</html>
