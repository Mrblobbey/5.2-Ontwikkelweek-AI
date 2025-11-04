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
    background: radial-gradient(circle at top, #4a2c1a, #2b180d);
    color: #fff8e7;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
    padding: 40px;
  }

  .app { max-width: 1100px; width: 100%; text-align: center; }
  h1 { font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 1rem; color: #f7e8c3; text-shadow: 1px 1px 4px rgba(0,0,0,0.4); }
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
  #startOverlay { position: fixed; top:0; left:0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); color: #fff; display: flex; justify-content: center; align-items: center; z-index: 10000; cursor: pointer; font-size: 2rem; text-align: center; padding: 20px; }
  footer { margin-top: 25px; font-size: 0.9rem; color: #f2e3c5; }
</style>
</head>
<body>

<!-- Startoverlay -->
<div id="startOverlay">🎄 Klik hier om de adventskalender te starten! 🎁</div>

<!-- AUDIO ELEMENTEN -->
<audio id="doorSound" src="click.mp3"></audio> <!-- klikgeluid bij vakje -->
<audio id="bgMusic" src="bgmusic.mp3" loop></audio> <!-- achtergrondmuziek, verborgen -->

<div class="app">
  <h1>🎄 Klassieke Adventskalender — November editie</h1>
  <div class="grid" id="calendar"></div>
  <footer>Gemaakt met liefde — Fijne novemberdagen!</footer>
</div>

<script>
const tasks = [
  "Begin november met een glimlach en een warme drank.",
  "Schrijf drie doelen voor deze maand op.",
  "Maak een herfstwandeling en verzamel mooie bladeren.",
  "Ruim iets op dat je al lang wilde aanpakken.",
  "Bel of app iemand die je mist.",
  "Maak een lekkere pompoensoep of iets warms.",
  "Doe vandaag iets creatiefs (tekenen, schrijven, knutselen).",
  "Zet een rustgevend muziekje op en ontspan even.",
  "Schrijf iets liefs over jezelf op papier.",
  "Doe een dag offline of zonder social media.",
  "Brand een kaarsje en denk aan iets of iemand moois.",
  "Geef vandaag een compliment aan iemand.",
  "Lees een hoofdstuk van een boek dat je blij maakt.",
  "Maak je favoriete herfstdrank (chai, warme choco, etc.).",
  "Plan een klein verwenmomentje voor dit weekend.",
  "Kijk een feelgoodfilm of serie.",
  "Ga even naar buiten en adem diep in de frisse lucht.",
  "Schrijf drie dingen op waar je trots op bent.",
  "Doe iets onverwachts aardigs voor iemand.",
  "Luister naar muziek uit je jeugd en geniet van de herinneringen.",
  "Doe iets nieuws wat je normaal niet zou doen.",
  "Bak iets lekkers en deel het met iemand.",
  "Maak een mini planning voor de rest van november.",
  "Vier vandaag dat je het tot hier gehaald hebt — goed gedaan!"
];

const calendar = document.getElementById("calendar");
const today = new Date();
const currentMonth = today.getMonth(); // november = 10
const currentDay = today.getDate();

const doorSound = document.getElementById("doorSound");
const bgMusic = document.getElementById("bgMusic");

// array 1-24 en hussel
const days = Array.from({length:24}, (_,i)=>i+1);
days.sort(()=>Math.random()-0.5);

// vakjes toevoegen
days.forEach(dayNumber => {
  const task = tasks[dayNumber-1];
  const box = document.createElement("div");
  box.classList.add("door-container");

  const canOpen = (currentMonth === 10 && currentDay >= dayNumber);
  if (!canOpen) box.classList.add("locked");

  box.innerHTML = `
    <div class="door left"></div>
    <div class="door right"></div>
    <div class="door-number">${dayNumber}</div>
    <div class="task">${task}</div>
  `;

  box.addEventListener("click", () => {
    if (!canOpen) return;
    if (box.classList.contains("open")) return;

    box.classList.add("open");
    doorSound.currentTime = 0;
    doorSound.play();
  });

  calendar.appendChild(box);
});

// startoverlay logica
const overlay = document.getElementById("startOverlay");
overlay.addEventListener("click", () => {
  overlay.style.display = "none";

  // speel achtergrondmuziek en klikgeluid
  bgMusic.volume = 0.3;
  bgMusic.play();
  doorSound.currentTime = 0;
  doorSound.play().then(()=>doorSound.pause());
});
</script>

</body>
</html>
