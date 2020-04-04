/* Burger Menu */
var menu = document.querySelector(".navbar-menu");
var burger = document.querySelector(".navbar-burger");
if (burger) {
    burger.addEventListener("click", function () {
        burger.classList.toggle("is-active");
        menu.classList.toggle("is-active");
    });
}

/* Modal */
var rootEl = document.documentElement;
var $modals = getAll(".modal");
var $modalButtons = getAll(".modal-button");
var $modalCloses = getAll(
    ".modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button"
);
if ($modalButtons.length > 0) {
    $modalButtons.forEach(function ($el) {
        $el.addEventListener("click", function () {
            var target = $el.dataset.target;
            openModal(target);
        });
    });
}
if ($modalCloses.length > 0) {
    $modalCloses.forEach(function ($el) {
        $el.addEventListener("click", function () {
            closeModals();
        });
    });
}
document.addEventListener("keydown", function (event) {
    var e = event || window.event;
    if (e.keyCode === 27) {
        closeModals();
    }
});

// Remove # sign after facebook login
if (location.hash == "#_=_" || location.href.slice(-1) == "#_=_") {
    removeHash();
}

function getAll(selector) {
    return Array.prototype.slice.call(document.querySelectorAll(selector), 0);
}

function openModal(target) {
    var $target = document.getElementById(target);
    rootEl.classList.add("is-clipped");
    $target.classList.add("is-active");
}

function closeModals() {
    rootEl.classList.remove("is-clipped");
    $modals.forEach(function ($el) {
        $el.classList.remove("is-active");
    });
}

function removeHash() {
    var scrollV,
        scrollH,
        loc = window.location;
    if ("replaceState" in history) {
        history.replaceState("", document.title, loc.pathname + loc.search);
    } else {
        // Prevent scrolling by storing the page's current scroll offset
        scrollV = document.body.scrollTop;
        scrollH = document.body.scrollLeft;

        loc.hash = "";

        // Restore the scroll offset, should be flicker free
        document.body.scrollTop = scrollV;
        document.body.scrollLeft = scrollH;
    }
}

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
