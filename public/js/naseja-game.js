(function () {
    'use strict';

    var categories = Array.isArray(window.NASEJA_RUSH_CATEGORIES) ? window.NASEJA_RUSH_CATEGORIES : [];
    var skills = Array.isArray(window.NASEJA_RUSH_SKILLS) ? window.NASEJA_RUSH_SKILLS : [];

    var startScreen = document.getElementById('rushStart');
    var playScreen = document.getElementById('rushPlay');
    var resultScreen = document.getElementById('rushResult');
    var startBtn = document.getElementById('rushStartBtn');
    var againBtn = document.getElementById('rushAgainBtn');

    var scoreEl = document.getElementById('rushScore');
    var comboEl = document.getElementById('rushCombo');
    var heartsEl = document.getElementById('rushHearts');
    var timeEl = document.getElementById('rushTime');
    var progressEl = document.getElementById('rushProgress');
    var speedEl = document.getElementById('rushSpeed');

    var fallArea = document.getElementById('rushFallArea');
    var portalsBox = document.getElementById('rushPortals');
    var feedback = document.getElementById('rushFeedback');

    var finalScoreEl = document.getElementById('rushFinalScore');
    var caughtEl = document.getElementById('rushCaught');
    var bestComboEl = document.getElementById('rushBestCombo');
    var bestScoreEl = document.getElementById('rushBestScore');
    var rankEl = document.getElementById('rushRank');
    var titleEl = document.getElementById('rushTitle');

    var active = [];
    var score = 0;
    var combo = 0;
    var bestCombo = 0;
    var hearts = 3;
    var caught = 0;
    var seconds = 45;
    var elapsed = 0;
    var finished = false;
    var lastFrame = 0;
    var lastSpawn = 0;
    var animationId = null;

    function show(screen) {
        [startScreen, playScreen, resultScreen].forEach(function (item) {
            if (item) item.classList.remove('is-active');
        });
        if (screen) screen.classList.add('is-active');
    }

    function renderHearts() {
        var text = '';
        for (var i = 0; i < 3; i++) text += i < hearts ? '❤️' : '🖤';
        heartsEl.textContent = text;
    }

    function speedMultiplier() {
        return 1 + Math.min(1.3, elapsed / 34);
    }

    function spawnInterval() {
        return Math.max(720, 1500 - (elapsed * 18));
    }

    function updateStats() {
        scoreEl.textContent = score;
        comboEl.textContent = combo;
        timeEl.textContent = Math.max(0, Math.ceil(seconds));
        progressEl.style.width = Math.max(0, (seconds / 45) * 100) + '%';
        speedEl.textContent = speedMultiplier().toFixed(1) + 'x';
        renderHearts();
    }

    function createPortals() {
        portalsBox.innerHTML = '';

        categories.forEach(function (category) {
            var portal = document.createElement('div');
            portal.className = 'rush-portal';
            portal.dataset.categoryId = String(category.id);
            portal.textContent = category.name;
            portalsBox.appendChild(portal);
        });
    }

    function flashPortal(portal, type) {
        if (!portal) return;
        portal.classList.add(type);
        setTimeout(function () { portal.classList.remove(type); }, 420);
    }

    function say(text, type) {
        feedback.textContent = text;
        feedback.className = 'rush-feedback ' + (type || '');
        clearTimeout(say.timer);
        say.timer = setTimeout(function () {
            feedback.textContent = '';
            feedback.className = 'rush-feedback';
        }, 800);
    }

    function removeToken(obj) {
        var i = active.indexOf(obj);
        if (i !== -1) active.splice(i, 1);
        if (obj.el && obj.el.parentNode) obj.el.parentNode.removeChild(obj.el);
    }

    function loseHeart(message, portal) {
        hearts--;
        combo = 0;
        if (portal) flashPortal(portal, 'wrong');
        say(message, 'wrong');
        updateStats();
        if (hearts <= 0) finish();
    }

    function correct(obj, portal) {
        caught++;
        combo++;
        bestCombo = Math.max(bestCombo, combo);

        var points = 10 + Math.min((combo - 1) * 2, 12);
        if (obj.golden) points *= 2;

        score += points;
        flashPortal(portal, 'correct');
        say('+' + points + (combo >= 2 ? ' 🔥 Combo x' + combo : '') + (obj.golden ? ' ✨ x2' : ''), 'correct');
        removeToken(obj);
        updateStats();
    }

    function wrong(obj, portal) {
        removeToken(obj);
        loseHeart('بوابة خاطئة — خسرت قلبًا', portal);
    }

    function missed(obj) {
        removeToken(obj);
        loseHeart('أفلتت منك مهارة — خسرت قلبًا');
    }

    function drop(obj, x, y) {
        var match = null;

        portalsBox.querySelectorAll('.rush-portal').forEach(function (portal) {
            portal.classList.remove('drag-over');
            var r = portal.getBoundingClientRect();

            if (x >= r.left && x <= r.right && y >= r.top && y <= r.bottom) {
                match = portal;
            }
        });

        if (!match) {
            obj.dragging = false;
            return;
        }

        if (String(obj.skill.category_id) === match.dataset.categoryId) {
            correct(obj, match);
        } else {
            wrong(obj, match);
        }
    }

    function attachDrag(obj) {
        var el = obj.el;

        el.addEventListener('pointerdown', function (e) {
            if (finished) return;

            obj.dragging = true;
            obj.pointerId = e.pointerId;

            var area = fallArea.getBoundingClientRect();
            obj.dx = e.clientX - area.left - obj.x;
            obj.dy = e.clientY - area.top - obj.y;

            el.classList.add('dragging');
            el.setPointerCapture(e.pointerId);
            e.preventDefault();
        });

        el.addEventListener('pointermove', function (e) {
            if (!obj.dragging || e.pointerId !== obj.pointerId) return;

            var area = fallArea.getBoundingClientRect();

            obj.x = e.clientX - area.left - obj.dx;
            obj.y = e.clientY - area.top - obj.dy;

            obj.x = Math.max(0, Math.min(area.width - obj.width, obj.x));
            obj.y = Math.max(0, Math.min(area.height - obj.height + 120, obj.y));

            el.style.transform = 'translate(' + obj.x + 'px,' + obj.y + 'px)';

            portalsBox.querySelectorAll('.rush-portal').forEach(function (portal) {
                portal.classList.remove('drag-over');
                var p = portal.getBoundingClientRect();

                if (e.clientX >= p.left && e.clientX <= p.right && e.clientY >= p.top && e.clientY <= p.bottom) {
                    portal.classList.add('drag-over');
                }
            });

            e.preventDefault();
        });

        el.addEventListener('pointerup', function (e) {
            if (!obj.dragging || e.pointerId !== obj.pointerId) return;

            obj.dragging = false;
            el.classList.remove('dragging');
            drop(obj, e.clientX, e.clientY);

            try { el.releasePointerCapture(e.pointerId); } catch (err) {}
        });

        el.addEventListener('pointercancel', function () {
            obj.dragging = false;
            el.classList.remove('dragging');
        });
    }

    function randomSkill() {
        return skills[Math.floor(Math.random() * skills.length)];
    }

    function spawn() {
        if (finished || active.length >= 5 || !skills.length) return;

        var skill = randomSkill();
        var el = document.createElement('div');
        el.className = 'rush-token';
        el.textContent = skill.name;

        var golden = Math.random() < .16;
        if (golden) el.classList.add('golden');

        fallArea.appendChild(el);

        var width = el.offsetWidth || 132;
        var height = el.offsetHeight || 64;
        var areaWidth = fallArea.clientWidth || 700;
        var x = Math.max(4, Math.random() * Math.max(20, areaWidth - width - 8));

        var obj = {
            el: el,
            skill: skill,
            golden: golden,
            x: x,
            y: -height - 8,
            width: width,
            height: height,
            speed: (46 + Math.random() * 16) * speedMultiplier(),
            dragging: false
        };

        el.style.transform = 'translate(' + obj.x + 'px,' + obj.y + 'px)';
        active.push(obj);
        attachDrag(obj);
    }

    function frame(ts) {
        if (finished) return;

        if (!lastFrame) lastFrame = ts;
        var dt = Math.min(.04, (ts - lastFrame) / 1000);
        lastFrame = ts;

        elapsed += dt;
        seconds -= dt;

        if (ts - lastSpawn >= spawnInterval()) {
            spawn();
            lastSpawn = ts;
        }

        var maxY = fallArea.clientHeight;

        active.slice().forEach(function (obj) {
            if (obj.dragging) return;

            obj.y += obj.speed * dt;
            obj.el.style.transform = 'translate(' + obj.x + 'px,' + obj.y + 'px)';

            if (obj.y > maxY - obj.height - 4) {
                missed(obj);
            }
        });

        updateStats();

        if (seconds <= 0) {
            finish();
            return;
        }

        animationId = requestAnimationFrame(frame);
    }

    function rankText() {
        if (score >= 260) return '🏆 أسطورة نسيجة';
        if (score >= 180) return '🔥 صائد محترف';
        if (score >= 110) return '✨ صائد مهارات';
        if (score >= 60) return '🎯 مستكشف نسيجة';
        return '🌱 مبتدئ نسيجة';
    }

    function titleText() {
        if (score >= 260) return 'جولة خارقة! 🏆';
        if (score >= 180) return 'صيد قوي جدًا! 🔥';
        if (score >= 110) return 'أداء ممتاز ✨';
        if (score >= 60) return 'جولة جميلة 🎯';
        return 'جرّب جولة ثانية 🌱';
    }

    function finish() {
        if (finished) return;

        finished = true;

        if (animationId) cancelAnimationFrame(animationId);

        active.slice().forEach(removeToken);

        var key = 'naseja_skill_rush_best';
        var oldBest = parseInt(localStorage.getItem(key) || '0', 10);
        var newBest = Math.max(oldBest, score);

        localStorage.setItem(key, String(newBest));

        finalScoreEl.textContent = score;
        caughtEl.textContent = caught;
        bestComboEl.textContent = bestCombo;
        bestScoreEl.textContent = newBest;
        rankEl.textContent = rankText();
        titleEl.textContent = titleText();

        show(resultScreen);

        if (window.lucide) window.lucide.createIcons();
    }

    function start() {
        if (!categories.length || !skills.length) return;

        score = 0;
        combo = 0;
        bestCombo = 0;
        hearts = 3;
        caught = 0;
        seconds = 45;
        elapsed = 0;
        finished = false;
        lastFrame = 0;
        lastSpawn = 0;
        active = [];

        createPortals();
        updateStats();
        show(playScreen);

        setTimeout(function () {
            spawn();
            animationId = requestAnimationFrame(frame);
        }, 250);
    }

    if (startBtn) startBtn.addEventListener('click', start);
    if (againBtn) againBtn.addEventListener('click', function () { location.reload(); });

    if (window.lucide) window.lucide.createIcons();
})();