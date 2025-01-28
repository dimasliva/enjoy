const container = document.querySelector('.container');
const codes = ['const', 'let', 'var', 'function', 'console.log()', 'document.getElementById()', 'if', 'else', 'for', 'while'];

const createCodeElement = () => {
    const code = document.createElement('div');
    code.className = 'code';
    code.textContent = codes[Math.floor(Math.random() * codes.length)];
    
    code.style.left = Math.random() * window.innerWidth + 'px';

    const duration = Math.random() * 2 + 3;
    code.style.animationDuration = duration + 's';
    
    container.appendChild(code);

    setTimeout(() => {
        code.remove();
    }, duration * 1000);
};

setInterval(createCodeElement, 300); 