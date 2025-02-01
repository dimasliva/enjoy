const form = document.querySelector(".auth-page__form");

// Анимация
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

  code.style.left = Math.random() * (window.innerWidth - 100) + "px";
  const duration = Math.random() * (5 - 3) + 3; // от 3 до 5 секунд
  code.style.animationDuration = duration + "s";

  container.appendChild(code);
  setTimeout(() => {
    code.remove();
  }, duration * 1000);
};

setInterval(createCodeElement, 300);
