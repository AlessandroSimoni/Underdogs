window.addEventListener('scroll', () => {
    document.body.style.setProperty('--scroll', window.scrollY / (document.body.offsetHeight - window.innerHeight));
}, false);

function GoTop(){
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}