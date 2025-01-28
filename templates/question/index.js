import { API_URL } from "/globals.js";

const ENGLISH_GROUP_ID = 1;

const form = document.querySelector(".form");

const params = new URLSearchParams(window.location.search);
const lessonId = Number(params.get("id"));
// изучить еще лучше этот способ - для точного получения

// console.log(lessonId);

// задний фон
const container = document.querySelector(".container");
const codes = [
  "const",
  "let",
  "var",
  "function",
  "console.log()",
  "document.getElementById()",
  "if",
  "else",
  "for",
  "while",
];

const createCodeElement = () => {
  const code = document.createElement("div");
  code.className = "code";
  code.textContent = codes[Math.floor(Math.random() * codes.length)];

  code.style.left = `${Math.random() * window.innerWidth}px`;

  const duration = Math.random() * 10 + 10;
  code.style.animationDuration = `${duration}s`;

  container.appendChild(code);

  setTimeout(() => {
    code.remove();
  }, duration * 1000);
};

setInterval(createCodeElement, 300);
