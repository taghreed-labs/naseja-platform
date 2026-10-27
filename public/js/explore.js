/**
 * NASEJA Explore Carousels
 * ---------------------------------------------------------
 * Existing Laravel markup only.
 * No routes, forms, favorites, loops or database logic changed.
 *
 * Carousels:
 * - Categories
 * - People
 * - Latest work
 * - Services
 */

(function () {
'use strict';

function prefersReducedMotion() {
var saved = document.documentElement.dataset.reducedMotion === 'true';

var system = window.matchMedia &&
window.matchMedia('(prefers-reduced-motion: reduce)').matches;

return saved || system;
}

function isRTL() {
return document.documentElement.dir === 'rtl';
}

function makeArrowIcon(direction) {
var path = direction === 'next'
? 'M9 18l6-6-6-6'
: 'M15 18l-6-6 6-6';

return '' +
'<svg viewBox="0 0 24 24" aria-hidden="true">' +
'<path d="' + path + '"></path>' +
'</svg>';
}

function debounce(fn, wait) {
var timeout = null;

return function () {
var args = arguments;
var context = this;

clearTimeout(timeout);

timeout = setTimeout(function () {
fn.apply(context, args);
}, wait);
};
}

function NasejaCarousel(track, options) {
this.track = track;
this.items = Array.from(track.children);

this.options = Object.assign({
autoplay: true,
interval: 5000
}, options || {});

this.currentPage = 0;
this.visibleCount = 1;
this.pageCount = 1;

this.timer = null;
this.progressFrame = null;
this.progressStart = 0;

this.paused = false;
this.manualResumeTimer = null;
this.scrollTimer = null;

if (this.items.length < 2) {
return;
}

this.buildControls();
this.bind();
this.refresh();

if (this.options.autoplay && !prefersReducedMotion()) {
this.startAutoplay();
}
}

NasejaCarousel.prototype.buildControls = function () {
var language = document.documentElement.lang === 'en'
? 'en'
: 'ar';

this.nav = document.createElement('div');
this.nav.className = 'explore-carousel-nav';

this.arrows = document.createElement('div');
this.arrows.className = 'explore-carousel-arrows';

this.prevButton = document.createElement('button');
this.prevButton.type = 'button';
this.prevButton.className =
'explore-carousel-arrow explore-carousel-prev';

this.nextButton = document.createElement('button');
this.nextButton.type = 'button';
this.nextButton.className =
'explore-carousel-arrow explore-carousel-next';

this.updateArrowLanguage(language);

this.arrows.appendChild(this.prevButton);
this.arrows.appendChild(this.nextButton);

this.dots = document.createElement('div');
this.dots.className = 'explore-carousel-dots';

this.progress = document.createElement('div');
this.progress.className = 'explore-carousel-progress';

this.progressBar = document.createElement('span');
this.progress.appendChild(this.progressBar);

this.nav.appendChild(this.arrows);
this.nav.appendChild(this.dots);
this.nav.appendChild(this.progress);

this.track.insertAdjacentElement('afterend', this.nav);
};

NasejaCarousel.prototype.updateArrowLanguage = function (language) {
var rtl = isRTL();

this.prevButton.innerHTML =
makeArrowIcon(rtl ? 'next' : 'prev');

this.nextButton.innerHTML =
makeArrowIcon(rtl ? 'prev' : 'next');

this.prevButton.setAttribute(
'aria-label',
language === 'en' ? 'Previous' : 'السابق'
);

this.nextButton.setAttribute(
'aria-label',
language === 'en' ? 'Next' : 'التالي'
);
};

NasejaCarousel.prototype.bind = function () {
var self = this;

this.prevButton.addEventListener('click', function () {
self.pauseTemporarily();
self.goTo(self.currentPage - 1);
});

this.nextButton.addEventListener('click', function () {
self.pauseTemporarily();
self.goTo(self.currentPage + 1);
});

this.track.addEventListener('mouseenter', function () {
self.pause();
});

this.track.addEventListener('mouseleave', function () {
self.resume();
});

this.nav.addEventListener('mouseenter', function () {
self.pause();
});

this.nav.addEventListener('mouseleave', function () {
self.resume();
});

this.track.addEventListener('focusin', function () {
self.pause();
});

this.track.addEventListener('focusout', function () {
self.resume();
});

this.track.addEventListener('touchstart', function () {
self.pause();
}, { passive: true });

this.track.addEventListener('touchend', function () {
window.setTimeout(function () {
self.resume();
}, 700);
}, { passive: true });

this.track.addEventListener('scroll', function () {
clearTimeout(self.scrollTimer);

self.scrollTimer = setTimeout(function () {
self.syncPageFromPosition();
}, 120);
}, { passive: true });

window.addEventListener('resize', debounce(function () {
self.refresh();
}, 150));

document.addEventListener('visibilitychange', function () {
if (document.hidden) {
self.pause();
} else {
self.resume();
}
});

window.addEventListener('naseja:language-changed', function (event) {
var language = event.detail && event.detail.language
? event.detail.language
: (document.documentElement.lang === 'en' ? 'en' : 'ar');

self.updateArrowLanguage(language);

/*
             * The direction can change while the page is open.
             * Recalculate pages without moving the document vertically.
             */
self.refresh(false);
});

window.addEventListener('naseja:motion-changed', function (event) {
var reduced = event.detail && event.detail.reduced;

if (reduced) {
self.stopAutoplay();
} else if (self.options.autoplay) {
self.startAutoplay();
}
});
};

NasejaCarousel.prototype.getGap = function () {
var style = window.getComputedStyle(this.track);

return parseFloat(
style.columnGap ||
style.gap ||
0
) || 0;
};

NasejaCarousel.prototype.refresh = function (moveToCurrent) {
if (typeof moveToCurrent === 'undefined') {
moveToCurrent = true;
}

if (!this.items.length || !this.track.clientWidth) {
return;
}

var firstItemWidth =
this.items[0].getBoundingClientRect().width;

if (!firstItemWidth) {
return;
}

var gap = this.getGap();

this.visibleCount = Math.max(
1,
Math.floor(
(this.track.clientWidth + gap) /
(firstItemWidth + gap)
)
);

this.pageCount = Math.max(
1,
Math.ceil(
this.items.length /
this.visibleCount
)
);

if (this.currentPage >= this.pageCount) {
this.currentPage = this.pageCount - 1;
}

if (this.currentPage < 0) {
this.currentPage = 0;
}

this.renderDots();
this.updateControls();

if (moveToCurrent && this.pageCount > 1) {
this.goTo(this.currentPage, false, true);
}

if (this.pageCount <= 1) {
this.stopAutoplay();
} else if (
this.options.autoplay &&
!this.paused &&
!prefersReducedMotion() &&
!this.timer
) {
this.startAutoplay();
}
};

NasejaCarousel.prototype.renderDots = function () {
var self = this;

this.dots.innerHTML = '';

if (this.pageCount <= 1) {
this.nav.style.display = 'none';
return;
}

this.nav.style.display = 'flex';

for (var i = 0; i < this.pageCount; i++) {
(function (pageIndex) {
var dot = document.createElement('button');

dot.type = 'button';
dot.className = 'explore-carousel-dot';

dot.setAttribute(
'aria-label',
document.documentElement.lang === 'en'
? 'Go to page ' + (pageIndex + 1)
: 'انتقل إلى الصفحة ' + (pageIndex + 1)
);

dot.addEventListener('click', function () {
self.pauseTemporarily();
self.goTo(pageIndex);
});

self.dots.appendChild(dot);
})(i);
}

this.updateControls();
};

NasejaCarousel.prototype.getTargetItem = function (page) {
var index = Math.min(
page * this.visibleCount,
this.items.length - 1
);

return this.items[index] || null;
};

NasejaCarousel.prototype.scrollTrackToItem = function (target, instant) {
if (!target) {
return;
}

/*
         * Important:
         * Never use scrollIntoView() here.
         * scrollIntoView can move the whole document vertically.
         * We move ONLY the horizontal track.
         */
var trackRect = this.track.getBoundingClientRect();
var itemRect = target.getBoundingClientRect();

var delta = isRTL()
? itemRect.right - trackRect.right
: itemRect.left - trackRect.left;

if (Math.abs(delta) < 1) {
return;
}

this.track.scrollBy({
left: delta,
top: 0,
behavior:
instant || prefersReducedMotion()
? 'auto'
: 'smooth'
});
};

NasejaCarousel.prototype.goTo = function (
page,
fromAutoplay,
instant
) {
if (this.pageCount <= 1) {
return;
}

if (page < 0) {
page = this.pageCount - 1;
}

if (page >= this.pageCount) {
page = 0;
}

this.currentPage = page;

var target = this.getTargetItem(page);

this.scrollTrackToItem(
target,
!!instant
);

this.updateControls();

if (!fromAutoplay) {
this.restartProgress();
}
};

NasejaCarousel.prototype.syncPageFromPosition = function () {
if (!this.items.length) {
return;
}

var trackRect =
this.track.getBoundingClientRect();

var nearestIndex = 0;
var nearestDistance = Infinity;

this.items.forEach(function (item, index) {
var rect = item.getBoundingClientRect();

var distance = isRTL()
? Math.abs(trackRect.right - rect.right)
: Math.abs(rect.left - trackRect.left);

if (distance < nearestDistance) {
nearestDistance = distance;
nearestIndex = index;
}
});

var page = Math.min(
this.pageCount - 1,
Math.round(
nearestIndex /
this.visibleCount
)
);

if (page !== this.currentPage) {
this.currentPage = page;
this.updateControls();
this.restartProgress();
}
};

NasejaCarousel.prototype.updateControls = function () {
var dots = Array.from(
this.dots.children
);

dots.forEach(function (dot, index) {
var active =
index === this.currentPage;

dot.classList.toggle(
'active',
active
);

dot.setAttribute(
'aria-current',
active ? 'true' : 'false'
);
}, this);

var disabled =
this.pageCount <= 1;

this.prevButton.disabled = disabled;
this.nextButton.disabled = disabled;
};

NasejaCarousel.prototype.animateProgress = function () {
var self = this;

if (
!this.progressBar ||
this.paused ||
!this.options.autoplay ||
prefersReducedMotion()
) {
return;
}

var elapsed =
performance.now() -
this.progressStart;

var percent = Math.min(
100,
(elapsed / this.options.interval) * 100
);

this.progressBar.style.width =
percent + '%';

if (percent >= 100) {
this.progressStart =
performance.now();
}

this.progressFrame =
requestAnimationFrame(function () {
self.animateProgress();
});
};

NasejaCarousel.prototype.startAutoplay = function () {
var self = this;

this.stopAutoplay();

if (
this.pageCount <= 1 ||
this.paused ||
prefersReducedMotion()
) {
return;
}

this.progressStart =
performance.now();

this.animateProgress();

this.timer = window.setInterval(
function () {
if (self.paused) {
return;
}

self.goTo(
self.currentPage + 1,
true,
false
);

self.progressStart =
performance.now();
},
this.options.interval
);
};

NasejaCarousel.prototype.stopAutoplay = function () {
if (this.timer) {
clearInterval(this.timer);
this.timer = null;
}

if (this.progressFrame) {
cancelAnimationFrame(
this.progressFrame
);

this.progressFrame = null;
}

if (this.progressBar) {
this.progressBar.style.width =
'0%';
}
};

NasejaCarousel.prototype.restartProgress = function () {
if (
!this.options.autoplay ||
this.paused ||
prefersReducedMotion()
) {
return;
}

this.progressStart =
performance.now();

if (!this.timer) {
this.startAutoplay();
}
};

NasejaCarousel.prototype.pause = function () {
if (
!this.options.autoplay ||
prefersReducedMotion()
) {
return;
}

this.paused = true;
this.stopAutoplay();
};

NasejaCarousel.prototype.resume = function () {
if (
!this.options.autoplay ||
prefersReducedMotion()
) {
return;
}

this.paused = false;
this.startAutoplay();
};

NasejaCarousel.prototype.pauseTemporarily = function () {
var self = this;

if (
!this.options.autoplay ||
prefersReducedMotion()
) {
return;
}

this.pause();

clearTimeout(
this.manualResumeTimer
);

this.manualResumeTimer =
setTimeout(function () {
self.resume();
}, 4500);
};


function initExploreCarousels() {
var configs = [
{
selector: '.explore-categories',
interval: 6500
},
{
selector: '.explore-users',
interval: 5400
},
{
selector: '.explore-works',
interval: 5000
},
{
selector: '.explore-services',
interval: 5800
}
];

window.NasejaExploreCarousels =
window.NasejaExploreCarousels || [];

configs.forEach(function (config) {
var track =
document.querySelector(
config.selector
);

if (
!track ||
track.dataset.nasejaCarousel ===
'ready'
) {
return;
}

track.dataset.nasejaCarousel =
'ready';

var carousel =
new NasejaCarousel(
track,
{
autoplay: true,
interval: config.interval
}
);

window.NasejaExploreCarousels
.push(carousel);
});
}


if (
document.readyState ===
'loading'
) {
document.addEventListener(
'DOMContentLoaded',
initExploreCarousels
);
} else {
initExploreCarousels();
}

})();