
const DESIGN_WIDTH = 1512;
const MIN_ZOOM = 0.62;
const MAX_ZOOM = 1.15;
const MOBILE_BREAKPOINT = 900;

const canvas = document.getElementById('canvas');
let currentZoom = 1;
let isMobileLayout = false;

function applyZoom(){
  const w = window.innerWidth;

  if (w < MOBILE_BREAKPOINT) {
    isMobileLayout = true;
    currentZoom = 1;
    canvas.style.zoom = 1;
    document.body.classList.add('is-mobile-layout');
  } else {
    isMobileLayout = false;
    document.body.classList.remove('is-mobile-layout');
    const raw = w / DESIGN_WIDTH;
    currentZoom = Math.min(Math.max(raw, MIN_ZOOM), MAX_ZOOM);
    canvas.style.zoom = currentZoom;
  }

  growLineToEdge();
}

/* ---------- Navbar reveal on scroll ---------- */

const nav = document.getElementById('navbar');

function handleScroll(){
  const heroHeight = document.querySelector('.hero').offsetHeight;
  if(window.scrollY > heroHeight * 0.08){ nav.classList.add('solid'); }
  else{ nav.classList.remove('solid'); }

  const progress = Math.min(window.scrollY / heroHeight, 1);
  regLine.style.opacity = String(1 - progress * 0.85);
}

/* ---------- Registration line: grows to the true screen edge ---------- */

const regLine = document.getElementById('regLine');

function growLineToEdge(){
  const rect = regLine.getBoundingClientRect();
  const targetCanvasPx = rect.right / currentZoom;
  regLine.style.width = targetCanvasPx + 'px';
}

/* ---------- Section dividers grow in on first scroll into view ---------- */

const dividerObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if(entry.isIntersecting){
      entry.target.classList.add('grow');
      dividerObserver.unobserve(entry.target);
    }
  });
}, { threshold: 0.4 });

document.querySelectorAll('.section-head').forEach(el => dividerObserver.observe(el));

/* ---------- Gallery lightbox ----------*/

/* const eras = [
  {
    label: '2019 — Women Paris Media',
    images: [
      "images/women-paris-media-archive/women-paris-media-archive.png",
      "images/women-paris-media-archive/women-paris-media-archive2.png",
      "images/women-paris-media-archive/women-paris-media-archive3.png",
      "images/women-paris-media-archive/women-paris-media-archive4.png",
      "images/women-paris-media-archive/women-paris-media-archive5.png",
      "images/women-paris-media-archive/women-paris-media-archive6.png",
      "images/women-paris-media-archive/women-paris-media-archive7.png",
      "images/women-paris-media-archive/women-paris-media-archive8.png",
      "images/women-paris-media-archive/women-paris-media-archive9.png",
      "images/women-paris-media-archive/women-paris-media-archive10.png"
    ],
    narrative: ""
  },
  { label: 'Unknown',  images: ["images/.jpg"],  narrative: "" },
  { label: 'Unknown', images: ["images/.jpg"], narrative: "" },
  { label: 'Unknown', images: ["images/.jpg"], narrative: "" },
  { label: 'Unknown',   images: ["images/.jpg"],   narrative: "" },
  { label: 'Unknown',  images: ["images/.jpg"],  narrative: "" },
  { label: 'Unknown', images: ["images/.jpg"], narrative: "" },
  { label: 'Unknown',  images: ["images/.jpg"],  narrative: "" } 
];


const lightbox = document.getElementById('lightbox');
const lightboxImg = document.getElementById('lightboxImg');
const lightboxStage = lightboxImg.parentElement;
const caption = document.getElementById('lightboxCaption');
const thumbsRow = document.getElementById('lightboxThumbs');
const narrativeToggle = document.getElementById('lightboxNarrativeToggle');
const narrativeText = document.getElementById('lightboxNarrative');

let stagePlaceholder = document.getElementById('lightboxPlaceholder');
if(!stagePlaceholder){
  stagePlaceholder = document.createElement('div');
  stagePlaceholder.id = 'lightboxPlaceholder';
  stagePlaceholder.className = 'lightbox-placeholder';
  stagePlaceholder.textContent = 'Plate not yet added';
  lightboxStage.appendChild(stagePlaceholder);
}

let currentEra = 0;
let currentImage = 0;

lightboxImg.addEventListener('error', () => {
  lightboxImg.style.display = 'none';
  stagePlaceholder.style.display = 'flex';
});
lightboxImg.addEventListener('load', () => {
  lightboxImg.style.display = 'block';
  stagePlaceholder.style.display = 'none';
});

function renderLightbox(){
  const era = eras[currentEra];
  const src = era.images[currentImage];

  if(src){
    lightboxImg.src = src;
    lightboxImg.alt = era.label;
  } else {
    lightboxImg.removeAttribute('src');
    lightboxImg.style.display = 'none';
    stagePlaceholder.style.display = 'flex';
  }

  const count = era.images.length;
  caption.textContent = count > 1
    ? `${era.label} — ${currentImage + 1}/${count}`
    : era.label;

  thumbsRow.innerHTML = '';
  if(count > 1){
    era.images.forEach((imgSrc, i) => {
      const t = document.createElement('img');
      t.src = imgSrc;
      t.alt = `${era.label} thumbnail ${i + 1}`;
      if(i === currentImage) t.classList.add('active');
      t.addEventListener('click', () => { currentImage = i; renderLightbox(); });
      thumbsRow.appendChild(t);
    });
    thumbsRow.style.display = 'flex';
  } else {
    thumbsRow.style.display = 'none';
  }

  narrativeText.classList.remove('open');
  narrativeToggle.setAttribute('aria-expanded', 'false');
  narrativeToggle.textContent = 'Show narrative story';

  if(era.narrative){
    narrativeText.textContent = era.narrative;
    narrativeText.classList.remove('narrative-empty');
  } else {
    narrativeText.textContent = "This storyline hasn't been published yet.";
    narrativeText.classList.add('narrative-empty');
  }
}

narrativeToggle.addEventListener('click', () => {
  const isOpen = narrativeText.classList.toggle('open');
  narrativeToggle.setAttribute('aria-expanded', String(isOpen));
  narrativeToggle.textContent = isOpen ? 'Hide narrative story' : 'Show narrative story';
});

function openLightbox(eraIndex){
  currentEra = eraIndex;
  currentImage = 0;
  renderLightbox();
  lightbox.classList.add('open');
}

function closeLightbox(){ lightbox.classList.remove('open'); }

function showImage(delta){
  const count = eras[currentEra].images.length;
  currentImage = (currentImage + delta + count) % count;
  renderLightbox();
}

document.querySelectorAll('.archive-item').forEach(item => {
  item.addEventListener('click', () => openLightbox(Number(item.dataset.index)));
});

document.getElementById('lightboxClose').addEventListener('click', closeLightbox);
document.getElementById('lightboxPrev').addEventListener('click', () => showImage(-1));
document.getElementById('lightboxNext').addEventListener('click', () => showImage(1));

lightbox.addEventListener('click', (e) => { if(e.target === lightbox){ closeLightbox(); } });

document.addEventListener('keydown', (e) => {
  if(!lightbox.classList.contains('open')) return;
  if(e.key === 'Escape') closeLightbox();
  if(e.key === 'ArrowLeft') showImage(-1);
  if(e.key === 'ArrowRight') showImage(1);
});

/* ---------- Wire up load / scroll / resize ---------- */

window.addEventListener('scroll', handleScroll);

window.addEventListener('load', () => {
  applyZoom();
  requestAnimationFrame(growLineToEdge);
});

let resizeTimer;
window.addEventListener('resize', () => {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(applyZoom, 150);
});

window.addEventListener('orientationchange', () => {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(applyZoom, 200);
});
