if (window.location.hash) SetPage(window.location.hash.replace("#",""));
else SetPage("home");


$(window).on("popstate", e => {
    TrnsPage(e.originalEvent.state.id,false);
});

function MenuToggle() {
    $("#ham").toggleClass("active");
    $("#topbar").toggleClass("active");
}

function TrnsPage(page,pushstate = true) {
    $(".content-container").css("opacity", "0");
    setTimeout(SetPage,600,page, pushstate);
    setTimeout("$(\".content-container\").css(\"opacity\", \"1\")",600);
}

function SetPage(page,pushstate = true) {
    if (pushstate) window.history.pushState({id:page},`${page} • Goncermor`, `#${page}`);
    $.get(`/pages/${page}.html`, data => {
        $(".content").html(data);
    });
}

