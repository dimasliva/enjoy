import { API_URL } from "/globals.js";
const lessonsContainerElement = document.querySelector(".lessons");
const pagesContainerElement = document.querySelector(".main__pages");

// УРОКИ
const lessonsPerPage = 50;
let lessons = [];
const language = "English";

const renderLessonsByPage = (page, lessonsToRender) => {
  lessonsContainerElement.innerHTML = "";

  lessonsToRender
    .slice(page * lessonsPerPage, (page + 1) * lessonsPerPage)
    .forEach((lesson) => {
      const lessonElement = document.createElement("li");
      lessonElement.classList.add("lessons__item");

      const lessonLinkElement = document.createElement("a");
      lessonLinkElement.classList.add("lessons__link");
      lessonLinkElement.textContent = lesson.name;
      lessonLinkElement.setAttribute(
        "href",
        `./lessons/index.html?id=${lesson.id}`
      );
      lessonElement.append(lessonLinkElement);
      lessonsContainerElement.append(lessonElement);
    });
};
const setupPagination = (filteredLessons) => {
  pagesContainerElement.innerHTML = "";
  const pages = Math.ceil(filteredLessons.length / lessonsPerPage);

  for (let i = 0; i < pages; i++) {
    const button = document.createElement("button");
    button.classList.add("main__page-btn");

    const startLesson = i * lessonsPerPage + 1;
    const endLesson = Math.min(
      (i + 1) * lessonsPerPage,
      filteredLessons.length
    );

    button.textContent = `${startLesson} - ${endLesson}`;
    button.dataset.page = i;
    pagesContainerElement.appendChild(button);
  }
};

const handlePageButtonClick = (e) => {
  const targetElement = e.target;
  const button = targetElement.closest(".main__page-btn");
  if (button) {
    const page = Number(button.dataset.page);
    renderLessonsByPage(page, lessons);
  }
};

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

  const duration = Math.random() * 5 + 5;
  code.style.animationDuration = `${duration}s`;

  container.appendChild(code);

  setTimeout(() => {
    code.remove();
  }, duration * 1000);
};

setInterval(createCodeElement, 300);

async function getLessons() {
  try {
    const response = await fetch(`${API_URL}/lessons`);
    const lessons = await response.json();

    renderLessonsByPage(0, lessons);
    setupPagination(lessons);
    pagesContainerElement.addEventListener("click", handlePageButtonClick);
  } catch (error) {
    console.error("Ошибка:", error);
    alert("Сервер не доступен! " + error.message);
  }
}
getLessons();
