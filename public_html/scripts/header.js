const mainToggle = document.querySelector(".header-top .main-toggle");
const inlineToggle = document.querySelector(".header-top .inline-toggle");
const ul = document.querySelector(".header-top ul");

function toggle()
{
    document.body.classList.toggle("toggle-active");
    mainToggle.classList.toggle("active");
    inlineToggle.classList.toggle("active");
    ul.classList.toggle("active");
    return false; //Stop propagation
}
mainToggle.onclick = toggle;
inlineToggle.onclick = toggle;
