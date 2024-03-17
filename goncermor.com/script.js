let HamElement, TopbarElement, ContentElement, ContentContainerElement;

document.addEventListener("DOMContentLoaded", (event) => {
    if (window.location.hash) SetPage(window.location.hash.replace("#",""));
    else SetPage("home");

    HamElement= document.getElementById('ham');
    TopbarElement = document.getElementById('topbar');
    ContentElement = document.querySelector('.content');
    ContentContainerElement = document.querySelector('.content-container');
});

window.addEventListener("popstate", (e) => {
    TrnsPage(e.state.id,false);
});

function MenuToggle() {
    HamElement.classList.toggle("active");
    TopbarElement.classList.toggle("active");
}

function TrnsPage(page,pushstate = true) {
    ContentContainerElement.style.opacity = "0";
    setTimeout(SetPage,600,page, pushstate);
    setTimeout("ContentContainerElement.style.opacity = \"1\";",600);
}

function SetPage(page,pushstate = true) {
    if (pushstate) window.history.pushState({id:page},`${page} • Goncermor`, `#${page}`);

    fetch(`pages/${page}.html`)
    .then(response => response.text())
    .then(data => {

      if (ContentElement) {
        ContentElement.innerHTML = data;
      }
    });
}

