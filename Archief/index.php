<!doctype html>
<html lang="nl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Klassieke Adventskalender — November editie</title>
<style>
  body {
    margin: 0;
    font-family: 'Georgia', serif;
    color: #fff8e7;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
    padding: 40px;
    overflow-x: hidden;
  }

  /* Achtergrondvideo */
  #bgVideo {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    z-index: -1;
  }

  .app { max-width: 1100px; width: 100%; text-align: center; }
  h1 { font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 1rem; color: #f7e8c3; text-shadow: 1px 1px 4px rgba(0,0,0,0.4); }

  /* Kalender styling */
  .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 25px; margin-top: 30px; }
  .door-container { position: relative; width: 100%; padding-top: 100%; perspective: 1200px; cursor: pointer; transition: transform 0.2s; }
  .door-container:hover { transform: rotateY(5deg) scale(1.03); }
  .door { position: absolute; top: 0; left: 0; width: 50%; height: 100%; background: linear-gradient(180deg, #6b3e1f 0%, #4b2a14 100%); border: 2px solid #2b180d; border-radius: 2px; box-shadow: inset 0 0 12px rgba(0,0,0,0.6), 0 4px 6px rgba(0,0,0,0.3); transform-origin: center left; transition: transform 1s cubic-bezier(0.77,0,0.175,1); z-index: 2; }
  .door.right { left: 50%; transform-origin: center right; }
  .door-container.open .door.left { transform: rotateY(-100deg); }
  .door-container.open .door.right { transform: rotateY(100deg); }
  .door-number { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 2rem; color: #f6e9d0; text-shadow: 1px 1px 4px rgba(0,0,0,0.6); z-index: 3; pointer-events: none; transition: opacity 0.5s; }
  .door-container.open .door-number { opacity: 0; }
  .task { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle, #f8f3e0 0%, #e9d6b3 100%); color: #3b2414; border-radius: 4px; box-shadow: inset 0 0 25px rgba(0,0,0,0.3); display: flex; justify-content: center; align-items: center; padding: 10px; text-align: center; font-size: 0.9rem; font-weight: 500; opacity: 0; transition: opacity 1s ease 0.7s; }
  .door-container.open .task { opacity: 1; animation: glow 0.5s ease-out; }
  @keyframes glow { 0% { box-shadow: 0 0 5px rgba(255,255,255,0.7); } 50% { box-shadow: 0 0 20px rgba(255,255,255,0.9); } 100% { box-shadow: 0 0 5px rgba(255,255,255,0.7); } }
  .door-container.locked { opacity: 0.6; cursor: not-allowed; filter: grayscale(0.4); }

  /* Start overlay */
  #startOverlay { position: fixed; top:0; left:0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); color: #fff; display: flex; justify-content: center; align-items: center; z-index: 10000; cursor: pointer; font-size: 2rem; text-align: center; padding: 20px; }

  /* Verlanglijst kerstbrief-stijl */
  #wishlist-container { margin-top: 50px; max-width: 500px; margin-left:auto; margin-right:auto; background: linear-gradient(to bottom, #fff0e0 0%, #ffeacc 100%); padding: 25px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.4); font-family: 'Cursive', 'Georgia', serif; color: #5a2e0d; border: 2px solid #d49a6a; position: relative; }
  #wishlist-container::before { content: "✉️"; position: absolute; top: -20px; left: -20px; font-size: 2rem; }
  #wishlist-container::after { content: "🎄"; position: absolute; top: -20px; right: -20px; font-size: 2rem; }
  #wishlist-container h2 { font-size: 1.8rem; margin-bottom: 15px; text-align: center; color:#b72f2f; text-shadow: 1px 1px 3px #fff1c0; }
  #wishlist-container input { width: 40%; padding: 8px; font-size: 1rem; border-radius: 5px; border:1px solid #d49a6a; margin-bottom:5px; }
  #wishlist-container button { padding: 8px 12px; font-size: 1rem; cursor: pointer; border-radius: 5px; border: 1px solid #d49a6a; background: #f9c1b1; transition:0.2s; margin-left:5px; }
  #wishlist-container button:hover { background: #f48b73; color:#fff; }
  #wishlist-items { margin-top: 15px; padding-left: 20px; list-style: "🎁 "; }
  #wishlist-items li { margin-bottom: 12px; font-size: 1rem; line-height: 1.4; display: flex; justify-content: space-between; align-items:center; background: rgba(255,255,255,0.6); padding: 6px 10px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);}
  #wishlist-items li a { color:#8b1c1c; text-decoration:none; font-weight:bold; }
  #wishlist-items li a:hover { text-decoration: underline; }
  #wishlist-items li button { background:none; border:none; cursor:pointer; font-size:1rem; color:#c94e50; margin-left:10px; }

  /* Sneeuw */
  .snowflake { position: fixed; top: -10px; color: #fff; font-size: 1em; z-index: 9999; user-select: none; pointer-events: none; animation-name: fall; animation-timing-function: linear; animation-iteration-count: infinite; }
  @keyframes fall { 0% { transform: translateY(0); opacity:1; } 100% { transform: translateY(100vh); opacity:0.6; } }

  /* Countdown */
  #countdown { margin-top: 20px; font-size:1.2rem; color:#ffd700; text-shadow:1px 1px 2px #000; }

  footer { margin-top: 25px; font-size: 0.9rem; color: #f2e3c5; }

</style>
</head>
<body>

<!-- Achtergrondvideo -->
<video id="bgVideo" autoplay muted loop playsinline>
  <source src="background-video.mp4" type="video/mp4">
  Jouw browser ondersteunt geen video.
</video>

<!-- Startoverlay -->
<div id="startOverlay">🎄 Klik hier om de adventskalender te starten! 🎁</div>

<!-- Audio -->
<audio id="doorSound" src="magic-click.mp3"></audio>
<audio id="bgMusic" src="bgmusic.mp3" loop></audio>

<div class="app">
  <h1>🎄 Klassieke Adventskalender — November editie</h1>
  <div id="countdown"></div>
  <div class="grid" id="calendar"></div>

  <div id="wishlist-container">
    <h2>✉️ Brief aan de Kerstman</h2>
    <input type="text" id="wishlist-input" placeholder="Wat wil je toevoegen?">
    <input type="text" id="wishlist-link" placeholder="Link (optioneel)">
    <button id="wishlist-add">Toevoegen</button>
    <ul id="wishlist-items"></ul>
  </div>

  <footer>Gemaakt met liefde — Fijne novemberdagen!</footer>
</div>

<script>
// --- Kalender taken ---
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
  snow.style.fontSize = (Math.random()*15+10)+'px';
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
  const days = Math.floor(diff/1000/60/60/24);
  countdownEl.textContent = `Nog ${days} dagen tot Kerst 🎄`;
}
updateCountdown();
setInterval(updateCountdown, 3600000);

// --- Kalender genereren ---
const daysArr = Array.from({length:24},(_,i)=>i+1);
daysArr.sort(()=>Math.random()-0.5);

daysArr.forEach(dayNumber=>{
  const task = tasks[dayNumber-1];
  const box = document.createElement("div");
  box.classList.add("door-container");
  const canOpen = (currentMonth===10 && currentDay>=dayNumber);
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

    // Confetti
    for(let i=0;i<15;i++){
      const c=document.createElement('div');
      c.textContent='✨';
      c.style.position='absolute';
      c.style.left=Math.random()*100+'%';
      c.style.top='0';
      c.style.fontSize=(Math.random()*20+10)+'px';
      c.style.opacity=1;
      c.style.pointerEvents='none';
      box.appendChild(c);
      let top=0;
      const fall=setInterval(()=>{
        top+=2+Math.random()*3;
        c.style.top=top+'px';
        c.style.opacity-=0.02;
        if(top>box.offsetHeight){ clearInterval(fall); c.remove(); }
      },30);
    }

    if(!openedDays.includes(dayNumber)){
      openedDays.push(dayNumber);
      localStorage.setItem('openedDays', JSON.stringify(openedDays));
    }
  });

  calendar.appendChild(box);
});

// --- Start overlay click ---
overlay.addEventListener("click",()=>{
  overlay.style.display="none";
  bgMusic.volume=0.3;
  bgMusic.play();
});

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
    if(entry.link){
      li.innerHTML=`<span><a href="${entry.link}" target="_blank">${entry.item}</a></span> <button onclick="removeItem(${index})">❌</button>`;
    }else{
      li.innerHTML=`<span>${entry.item}</span> <button onclick="removeItem(${index})">❌</button>`;
    }
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
