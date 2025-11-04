<!doctype html>
<html lang="nl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Klassieke Adventskalender — November editie</title>
<style>
  :root{
    --christmas-red:#d62839;
    --christmas-dark-red:#850012;
    --christmas-green:#0f7b4f;
    --christmas-gold:#ffd66b;
    --night:#050815;
    --card-bg:rgba(8, 5, 24, 0.88);
    --frost:rgba(255,255,255,0.03);
  }

  *{
    box-sizing:border-box;
  }

  body {
    margin: 0;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    color: #fff7e6;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
    padding: 32px 16px;
    overflow-x: hidden;
    background: radial-gradient(circle at top, #281234 0%, #050815 55%, #020308 100%);
    position: relative;
  }

  /* Achtergrondvideo */
  #bgVideo {
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -3;
    filter: saturate(1.15) contrast(1.05) brightness(0.7);
  }

  /* Glow / kleuren over de video */
  body::before{
    content:"";
    position:fixed;
    inset:0;
    z-index:-2;
    background:
      radial-gradient(circle at 10% 0%, rgba(255,255,255,0.18) 0, transparent 55%),
      radial-gradient(circle at 90% 10%, rgba(255,195,113,0.25) 0, transparent 60%),
      radial-gradient(circle at 50% 100%, rgba(214,40,57,0.55) 0, transparent 65%);
    mix-blend-mode: screen;
    pointer-events:none;
  }

  /* Bodemsneeuw die langzaam groeit */
  .snow-layer{
    position:fixed;
    left:0;
    right:0;
    bottom:0;
    height:22vh;
    z-index:-1;
    pointer-events:none;
    background:
      radial-gradient(circle at 15% 0, #ffffff 0, #ffffff 55%, transparent 70%),
      radial-gradient(circle at 45% 0, #ffffff 0, #ffffff 55%, transparent 70%),
      radial-gradient(circle at 75% 0, #ffffff 0, #ffffff 55%, transparent 70%),
      linear-gradient(to top, #ffffff 0, rgba(255,255,255,0.95) 35%, rgba(255,255,255,0) 100%);
    background-repeat:no-repeat;
    background-size: 30% 70%, 30% 80%, 30% 65%, 100% 100%;
    transform-origin: bottom center;
    transform: scaleY(0.35);
    animation: snowGrow 45s ease-out forwards;
    box-shadow: 0 -12px 20px rgba(0,0,0,0.6);
  }

  @keyframes snowGrow{
    to{
      transform: scaleY(1);
    }
  }

  .app {
    position: relative;
    max-width: 1100px;
    width: 100%;
    text-align: center;
    background: var(--card-bg);
    border-radius: 28px;
    padding: 28px 20px 24px;
    box-shadow:
      0 26px 80px rgba(0,0,0,0.9),
      0 0 0 1px rgba(255,255,255,0.06);
    backdrop-filter: blur(14px);
    overflow: hidden;
  }

  .app::before{
    /* Lichtjes-slinger bovenaan de kaart */
    content:"";
    position:absolute;
    top:-16px;
    left:50%;
    transform:translateX(-50%);
    width:130%;
    height:52px;
    background-image:
      radial-gradient(circle at 12px 32px, #ff4b6e 0, #ff4b6e 6px, transparent 7px),
      radial-gradient(circle at 42px 26px, #ffd66b 0, #ffd66b 6px, transparent 7px),
      radial-gradient(circle at 72px 34px, #6cf2c2 0, #6cf2c2 6px, transparent 7px),
      radial-gradient(circle at 102px 28px, #9ad1ff 0, #9ad1ff 6px, transparent 7px);
    background-size: 120px 52px;
    background-repeat: repeat-x;
    filter: drop-shadow(0 6px 8px rgba(0,0,0,0.9));
    opacity:0.95;
    pointer-events:none;
  }

  .app::after{
    /* subtiele glans aan de onderkant */
    content:"";
    position:absolute;
    bottom:-40px;
    left:50%;
    transform:translateX(-50%);
    width:70%;
    height:80px;
    background: radial-gradient(circle, rgba(255,255,255,0.2) 0, transparent 60%);
    opacity:0.5;
    pointer-events:none;
  }

  h1 {
    font-family: "Playfair Display", "Georgia", serif;
    font-size: clamp(2.2rem, 4vw, 2.8rem);
    margin: 4px 0 12px;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    background: linear-gradient(120deg, #fff7e6, #ffe3a3, #ffd66b);
    -webkit-background-clip: text;
    color: transparent;
    text-shadow: 0 0 18px rgba(0,0,0,0.85);
  }

  #countdown {
    margin-top: 4px;
    display: inline-flex;
    gap: 8px;
    align-items: center;
    padding: 8px 18px;
    border-radius: 999px;
    background: linear-gradient(120deg, rgba(255,255,255,0.06), rgba(255,214,107,0.14));
    box-shadow: 0 14px 30px rgba(0,0,0,0.6);
    font-size: 0.95rem;
    letter-spacing:0.03em;
    text-transform: uppercase;
  }

  #countdown span{
    font-weight:600;
    color: var(--christmas-gold);
  }

  /* START OVERLAY MET GROTE HOUTEN DEUREN */
  #startOverlay {
    position: fixed;
    inset: 0;
    background:
      radial-gradient(circle at top, rgba(255,255,255,0.1) 0, transparent 55%),
      linear-gradient(135deg, #120908, #2a1410, #3d1a12);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 5;
    cursor: pointer;
    perspective: 1600px;
  }

  #startOverlay.hidden{
    display:none;
  }

  .intro-doors-wrapper{
    position:relative;
    width:min(720px, 90vw);
    height:min(420px, 65vh);
    box-shadow:0 26px 70px rgba(0,0,0,0.95);
    border-radius:22px;
    overflow:hidden;
    background:radial-gradient(circle at top, rgba(255,255,255,0.12) 0, transparent 65%);
  }

  .intro-door{
    position:absolute;
    top:0;
    width:50%;
    height:100%;
    background:
      /* houtnerf */
      linear-gradient(90deg, rgba(0,0,0,0.18), rgba(0,0,0,0.05)),
      repeating-linear-gradient(
        0deg,
        #5b3015 0px,
        #5b3015 6px,
        #6a3919 6px,
        #6a3919 12px
      );
    border:2px solid rgba(0,0,0,0.6);
    box-shadow:
      inset 0 0 24px rgba(0,0,0,0.75),
      0 0 14px rgba(0,0,0,0.8);
    transform-style:preserve-3d;
    transition:transform 1.2s cubic-bezier(0.77,0,0.175,1);
  }

  .intro-door::before{
    /* klassieke panelen */
    content:"";
    position:absolute;
    inset:10% 14%;
    border-radius:6px;
    border:2px solid rgba(255,214,150,0.35);
    box-shadow:
      inset 0 0 12px rgba(0,0,0,0.7),
      0 0 10px rgba(0,0,0,0.8);
  }

  .intro-door::after{
    /* goudkleurig handvat */
    content:"";
    position:absolute;
    top:50%;
    width:14px;
    height:46px;
    border-radius:999px;
    background:
      radial-gradient(circle at 30% 20%, #fff 0, #ffe9aa 40%, #c28a2b 100%);
    box-shadow:
      0 0 10px rgba(0,0,0,0.9),
      0 0 14px rgba(255,214,107,0.9);
    transform:translateY(-50%);
  }

  .intro-door.left{
    left:0;
    transform-origin:center left;
  }
  .intro-door.left::after{
    right:18px;
  }

  .intro-door.right{
    right:0;
    transform-origin:center right;
  }
  .intro-door.right::after{
    left:18px;
  }

  /* Sneeuw op bovenkant van de grote deuren */
  .intro-doors-wrapper::before{
    content:"";
    position:absolute;
    top:-16px;
    left:-6px;
    right:-6px;
    height:40px;
    background:
      radial-gradient(circle at 10% 100%, #ffffff 0, #ffffff 55%, transparent 75%),
      radial-gradient(circle at 40% 100%, #ffffff 0, #ffffff 55%, transparent 75%),
      radial-gradient(circle at 70% 100%, #ffffff 0, #ffffff 55%, transparent 75%),
      radial-gradient(circle at 100% 100%, #ffffff 0, #ffffff 55%, transparent 75%);
    border-radius:999px 999px 60% 60%;
    box-shadow:0 8px 18px rgba(0,0,0,0.7);
  }

  .intro-text{
    position:absolute;
    inset:0;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    text-align:center;
    pointer-events:none;
    color:#ffe7c4;
    text-shadow:0 0 14px rgba(0,0,0,0.9);
  }

  .intro-text h2{
    font-family:"Playfair Display","Georgia",serif;
    font-size:clamp(2rem, 4vw, 2.6rem);
    margin:0 0 6px;
    letter-spacing:0.12em;
    text-transform:uppercase;
  }

  .intro-text p{
    margin:4px 0 0;
    font-size:0.95rem;
    opacity:0.9;
  }

  .intro-text span{
    margin-top:10px;
    font-size:0.9rem;
    opacity:0.8;
  }

  #startOverlay.opening .intro-door.left{
    transform:rotateY(-115deg) translateX(-4%);
  }
  #startOverlay.opening .intro-door.right{
    transform:rotateY(115deg) translateX(4%);
  }
  #startOverlay.opening .intro-text{
    opacity:0;
    transition:opacity 0.5s ease-out;
  }

  /* Kalender GRID */
  .grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 22px;
    margin-top: 28px;
  }

  /* DAG-DEUREN: klassiek hout, geen ronde randen */
  .door-container {
    position: relative;
    width: 100%;
    padding-top: 125%;
    border-radius: 0;
    background:
      linear-gradient(145deg, rgba(255,255,255,0.04), rgba(0,0,0,0.35));
    box-shadow:
      0 18px 35px rgba(0,0,0,0.85),
      0 0 0 1px rgba(0,0,0,0.8);
    overflow: hidden;
    perspective: 1400px;
    cursor: pointer;
    transition: transform 0.22s ease, box-shadow 0.22s ease, filter 0.22s ease;
    border: 2px solid rgba(64,34,17,0.9);
  }

  .door-container:hover{
    transform: translateY(-4px) scale(1.02);
    box-shadow:
      0 26px 50px rgba(0,0,0,0.9),
      0 0 0 1px rgba(255,255,255,0.08);
  }

  .door-container::before{
    /* kleine kerststrik */
    content:"🎀";
    position:absolute;
    top:6px;
    left:8px;
    font-size:1.1rem;
    filter:drop-shadow(0 0 6px rgba(0,0,0,0.9));
    opacity:0.9;
    pointer-events:none;
    z-index:4;
  }

  /* HOUTEN DEURPANELEN BINNENIN */
  .door {
    position: absolute;
    top: 0;
    left: 0;
    width: 50%;
    height: 100%;
    background:
      linear-gradient(90deg, rgba(0,0,0,0.15), rgba(0,0,0,0.03)),
      repeating-linear-gradient(
        0deg,
        #5e3519 0px,
        #5e3519 7px,
        #774020 7px,
        #774020 14px
      );
    border-radius: 0;
    border: 1px solid rgba(0,0,0,0.8);
    box-shadow:
      inset 0 0 22px rgba(0,0,0,0.7),
      0 0 14px rgba(0,0,0,0.9);
    transform-origin: center left;
    transition: transform 1s cubic-bezier(0.77,0,0.175,1);
    z-index: 2;
    transform-style:preserve-3d;
  }

  .door::before{
    /* panelen */
    content:"";
    position:absolute;
    inset:8% 12%;
    border-radius:3px;
    border: 1px solid rgba(255,214,150,0.35);
    box-shadow:
      inset 0 0 8px rgba(0,0,0,0.7),
      0 0 6px rgba(0,0,0,0.8);
  }

  .door::after{
    /* gouden handvat */
    content:"";
    position:absolute;
    top:50%;
    right:16px;
    width:10px;
    height:26px;
    border-radius:999px;
    background:radial-gradient(circle at 30% 20%, #fff 0, #ffe39a 40%, #b5832d 100%);
    box-shadow:0 0 8px rgba(0,0,0,0.8);
    transform:translateY(-50%);
  }

  .door.right {
    left: 50%;
    transform-origin: center right;
  }

  .door.right::after{
    left:16px;
    right:auto;
  }

  .door-number {
    position: absolute;
    inset: 0;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size: 2.2rem;
    font-weight: 800;
    letter-spacing:0.08em;
    color: #ffe7c4;
    text-shadow:
      0 0 14px rgba(0,0,0,0.95),
      0 0 32px rgba(255,214,107,0.8);
    z-index: 3;
    pointer-events:none;
    transition: opacity 0.6s ease, transform 0.6s ease;
  }

  .task {
    position: absolute;
    inset: 10%;
    border-radius: 4px;
    background:
      radial-gradient(circle at top, #fff7ec 0%, #ffe3be 45%, #ffd1a0 100%);
    color: #4e220e;
    padding: 12px 10px;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    font-size: 0.95rem;
    line-height:1.4;
    box-shadow:
      inset 0 0 12px rgba(0,0,0,0.15),
      0 14px 22px rgba(0,0,0,0.55);
    transform: translateZ(-1px);
  }

  .door-container.locked::before{
    content:"🔒";
    position:absolute;
    top:10px;
    right:12px;
    font-size:1.4rem;
    filter:drop-shadow(0 0 8px rgba(0,0,0,0.7));
    z-index:4;
  }

  .door-container.locked{
    filter: grayscale(0.3) brightness(0.85);
  }

  .door-container.open {
    transform: translateY(-2px) scale(1.01);
    box-shadow:
      0 22px 45px rgba(0,0,0,0.95),
      0 0 0 1px rgba(255,255,255,0.08);
  }

  .door-container.open .door.left {
    transform: rotateY(-115deg) translateX(-6%);
  }

  .door-container.open .door.right {
    transform: rotateY(115deg) translateX(6%);
  }

  .door-container.open .door-number{
    opacity:0;
    transform:translateY(-10px) scale(0.9);
  }

  /* Wishlist – brief aan de Kerstman */
  #wishlist-container {
    margin-top: 40px;
    max-width: 540px;
    margin-inline: auto;
    padding: 24px 20px 18px;
    border-radius: 22px;
    background:
      repeating-linear-gradient(
        -3deg,
        #fff7eb 0,
        #fff7eb 24px,
        #ffe6cf 24px,
        #ffe6cf 26px
      );
    box-shadow:
      0 18px 38px rgba(0,0,0,0.85),
      0 0 0 1px rgba(118,66,33,0.45);
    color: #5a240f;
    position: relative;
    overflow: hidden;
  }

  #wishlist-container::before{
    content:"✉️ Brief aan de Kerstman";
    position:absolute;
    top:8px;
    left:20px;
    font-size:0.8rem;
    letter-spacing:0.18em;
    text-transform:uppercase;
    opacity:0.55;
  }

  #wishlist-container::after{
    content:"🎄";
    position:absolute;
    bottom:10px;
    right:14px;
    font-size:1.6rem;
    opacity:0.85;
  }

  #wishlist-container h2{
    margin-top: 26px;
    margin-bottom: 12px;
    font-size:1.2rem;
    font-weight:700;
    text-align:left;
  }

  #wishlist-container input,
  #wishlist-container button{
    font: inherit;
  }

  #wishlist-input,
  #wishlist-link{
    width: 100%;
    padding: 9px 11px;
    border-radius: 999px;
    border: 1px solid rgba(148,92,49,0.4);
    margin-bottom: 8px;
    outline:none;
    background: rgba(255,255,255,0.7);
  }

  #wishlist-input::placeholder,
  #wishlist-link::placeholder{
    color:rgba(90,36,15,0.6);
  }

  #wishlist-add{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding: 8px 18px;
    border-radius: 999px;
    border:none;
    background: linear-gradient(120deg, var(--christmas-red), var(--christmas-dark-red));
    color:#fff7e6;
    font-weight:600;
    cursor:pointer;
    box-shadow:0 10px 18px rgba(214,40,57,0.55);
    margin-top: 4px;
    margin-bottom: 10px;
  }

  #wishlist-add:hover{
    filter:brightness(1.07);
    transform:translateY(-1px);
  }

  #wishlist-items{
    list-style:none;
    padding:0;
    margin:10px 0 0;
    max-height:210px;
    overflow:auto;
  }

  #wishlist-items li{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:8px;
    padding:8px 10px;
    border-radius:12px;
    background:rgba(255,255,255,0.6);
    margin-bottom:6px;
    font-size:0.9rem;
  }

  #wishlist-items li span{
    flex:1;
    color:#4b200f;
    text-align:left;
  }

  #wishlist-items a{
    color:#b8142f;
    font-weight:600;
    text-decoration:none;
    font-size:0.85rem;
    margin-right:4px;
  }

  #wishlist-items a:hover{
    text-decoration:underline;
  }

  #wishlist-items button{
    background:none;
    border:none;
    cursor:pointer;
    font-size:1.1rem;
    line-height:1;
    color:#b8142f;
  }

  footer {
    margin-top: 24px;
    font-size: 0.85rem;
    color: #f2e3c5;
    opacity:0.9;
  }

  /* Sneeuwvlokken */
  .snowflake {
    position: fixed;
    top: -12px;
    color: #fff;
    font-size: clamp(10px, 1.4vw, 18px);
    opacity: 0.9;
    pointer-events: none;
    z-index: -1;
    animation-name: fall;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
  }

  @keyframes fall {
    0% {
      transform: translate3d(0, -10vh, 0);
      opacity: 0;
    }
    15%{
      opacity:1;
    }
    100% {
      transform: translate3d(0, 110vh, 0);
      opacity: 0.7;
    }
  }

  @media (max-width: 768px){
    body{
      padding: 22px 12px;
    }
    .app{
      border-radius:22px;
      padding:22px 14px 18px;
    }
    .grid{
      grid-template-columns: repeat(2, minmax(0,1fr));
      gap:16px;
    }
  }

  @media (max-width: 480px){
    h1{
      font-size:1.8rem;
    }
    #countdown{
      width:100%;
      justify-content:center;
    }
  }
</style>
</head>
<body>

<!-- Achtergrondvideo -->
<video id="bgVideo" autoplay muted loop playsinline>
  <source src="background-video.mp4" type="video/mp4">
  Jouw browser ondersteunt geen video.
</video>

<!-- Bodemsneeuw -->
<div class="snow-layer"></div>

<!-- Startoverlay met grote houten deuren -->
<div id="startOverlay">
  <div class="intro-doors-wrapper">
    <div class="intro-door left"></div>
    <div class="intro-door right"></div>
    <div class="intro-text">
      <h2>Adventskalender</h2>
      <p>Welkom in de klassieke kerstkamer.</p>
      <span>✨ Klik om de deuren te openen ✨</span>
    </div>
  </div>
</div>

<!-- Audio -->
<audio id="doorSound" src="click.mp3"></audio>
<audio id="bgMusic" src="background.mp3" loop></audio>

<div class="app">
  <h1>🎄 Klassieke Adventskalender — November editie</h1>
  <div id="countdown"></div>
  <div class="grid" id="calendar"></div>

  <div id="wishlist-container">
    <h2>Wat zet jij op je lijstje?</h2>
    <input type="text" id="wishlist-input" placeholder="Wat wil je toevoegen?">
    <input type="text" id="wishlist-link" placeholder="Link (optioneel)">
    <button id="wishlist-add">Toevoegen</button>
    <ul id="wishlist-items"></ul>
  </div>

  <footer>Gemaakt met liefde — Fijne feestdagen! ✨</footer>
</div>

<script>
// --- Kalender taken (dummy-teksten, kun je zelf kerstiger maken) ---
const tasks = [...Array(24).keys()].map(i => `Dag ${i+1} taak 🎁`); 
const calendar = document.getElementById("calendar");
const doorSound = document.getElementById("doorSound");
const bgMusic = document.getElementById("bgMusic");
const overlay = document.getElementById("startOverlay");
const today = new Date();
const currentMonth = today.getMonth();
const currentDay = today.getDate();
let openedDays = JSON.parse(localStorage.getItem('openedDays')) || [];

// --- Sneeuw effect ---
for(let i=0;i<50;i++){
  const snow = document.createElement('div');
  snow.classList.add('snowflake');
  snow.style.left = Math.random()*100 + 'vw';
  snow.style.animationDuration = (Math.random()*10+5)+'s';
  snow.style.animationDelay = Math.random()*10+'s';
  snow.innerHTML = '❄';
  document.body.appendChild(snow);
}

// --- Countdown tot kerst ---
const countdownEl = document.getElementById('countdown');
function updateCountdown(){
  const now = new Date();
  const christmas = new Date(now.getFullYear(),11,25);
  const diff = christmas - now;
  if (diff <= 0) {
    countdownEl.textContent = "Het is Kerst! 🎄";
    return;
  }
  const days   = Math.floor(diff / (1000*60*60*24));
  const hours  = Math.floor((diff / (1000*60*60)) % 24);
  const mins   = Math.floor((diff / (1000*60)) % 60);
  countdownEl.innerHTML = `Nog <span>${days} dagen</span>, <span>${hours} uur</span> en <span>${mins} minuten</span> tot Kerst`;
}
updateCountdown();
setInterval(updateCountdown, 60000);

// --- Start overlay klik: grote deuren openen, dan wegfaden ---
overlay.addEventListener('click',()=>{
  if(overlay.classList.contains('opening')) return;
  overlay.classList.add('opening');
  bgMusic.volume=0.3;
  bgMusic.play();

  setTimeout(()=>{
    overlay.classList.add('hidden');
  }, 1300);
});

// --- Kalender genereren ---
for(let dayNumber=1; dayNumber<=24; dayNumber++){
  const task = tasks[dayNumber-1];
  const box = document.createElement("div");
  box.classList.add("door-container");
  const canOpen = (currentMonth===10 && currentDay>=dayNumber); // november = 10
  if(!canOpen) box.classList.add("locked");
  if(openedDays.includes(dayNumber)) box.classList.add("open");

  box.innerHTML = `
    <div class="door left"></div>
    <div class="door right"></div>
    <div class="door-number">${dayNumber}</div>
    <div class="task">${task}</div>
  `;

  box.addEventListener("click",()=>{
    if(!canOpen) return;
    if(box.classList.contains("open")) return;

    box.classList.add("open");
    doorSound.currentTime=0;
    doorSound.play();

    // Confetti-sparkles
    for(let i=0;i<15;i++){
      const c=document.createElement('div');
      c.textContent='✨';
      c.style.position='absolute';
      c.style.left=Math.random()*100+'%';
      c.style.top='0';
      c.style.fontSize='1rem';
      c.style.animation=`fall ${Math.random()*2+1}s linear`;
      box.appendChild(c);
      setTimeout(()=>c.remove(),2500);
    }

    if(!openedDays.includes(dayNumber)){
      openedDays.push(dayNumber);
      localStorage.setItem('openedDays',JSON.stringify(openedDays));
    }
  });

  calendar.appendChild(box);
}

// --- Verlanglijst ---
const wishlistInput=document.getElementById('wishlist-input');
const wishlistLink=document.getElementById('wishlist-link');
const wishlistAdd=document.getElementById('wishlist-add');
const wishlistItems=document.getElementById('wishlist-items');
let wishlist=JSON.parse(localStorage.getItem('wishlist')) || [];
renderWishlist();

wishlistAdd.addEventListener('click',()=>{
  const item=wishlistInput.value.trim();
  const link=wishlistLink.value.trim();
  if(!item) return;
  wishlist.push({item,link});
  wishlistInput.value='';
  wishlistLink.value='';
  saveWishlist();
  renderWishlist();
});

function renderWishlist(){
  wishlistItems.innerHTML='';
  wishlist.forEach((entry,index)=>{
    const li=document.createElement('li');
    const textSpan=document.createElement('span');
    textSpan.textContent=entry.item;
    li.appendChild(textSpan);

    if(entry.link){
      const a=document.createElement('a');
      a.href=entry.link;
      a.target="_blank";
      a.rel="noopener noreferrer";
      a.textContent="link";
      li.appendChild(a);
    }

    const delBtn=document.createElement('button');
    delBtn.textContent='✕';
    delBtn.addEventListener('click',()=>removeItem(index));
    li.appendChild(delBtn);

    wishlistItems.appendChild(li);
  });
}

function saveWishlist(){
  localStorage.setItem('wishlist',JSON.stringify(wishlist));
}

function removeItem(index){
  wishlist.splice(index,1);
  saveWishlist();
  renderWishlist();
}
</script>

</body>
</html>
