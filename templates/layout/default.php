<?php
/**
 * @var \App\View\AppView $this
 */

$appName = 'MeetFlow';
$user = $this->request->getAttribute('identity');

// Notifications "en attente" stockées en session (annulation / acceptation / refus)
$jsonFlags = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT;
$pendingNotifications = [];
$session = $this->request->getSession();

foreach (['annulation', 'accept', 'refus'] as $pendingKey) {
    if ($session->check('notifications.' . $pendingKey)) {
        $items = (array)$session->read('notifications.' . $pendingKey);
        foreach ($items as $item) {
            if (is_array($item)) {
                $pendingNotifications[] = $item;
            }
        }
        $session->delete('notifications.' . $pendingKey);
    }
}
if ($user) {
    foreach (['refus', 'accepte'] as $pendingKey) {
        $key = "notifications.{$user->id}.{$pendingKey}";
        if ($session->check($key)) {
            foreach ((array)$session->read($key) as $item) {
                if (is_array($item)) {
                    $pendingNotifications[] = $item;
                }
            }
            $session->delete($key);
        }
    }
    foreach ((array)$session->read('notifications') as $key => $notes) {
        if (strpos((string)$key, 'reunion_') === 0) {
            foreach ((array)$notes as $note) {
                if (is_array($note)) {
                    $pendingNotifications[] = $note;
                }
            }
            $session->delete('notifications.' . $key);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->Html->css(['normalize.min', 'app']) ?>
    <title><?= h($this->fetch('title', $appName)) ?> - <?= h($appName) ?></title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>

    <!-- Top bar -->
    <header class="top-bar">
        <button class="hamburger" type="button" id="hamburger" aria-label="Menu">&#9776;</button>

        <a class="brand" href="<?= $this->Url->build('/') ?>">
            <span class="brand-logo">&#128203;</span>
            <span class="brand-text"><?= h($appName) ?></span>
        </a>

        <div class="top-bar-spacer"></div>

        <?php if ($user): ?>
            <div class="notification-menu" style="position:relative;">
                <span id="notification-bell"
                      class="notification-icon"
                      data-reunion-url="<?= h($this->Url->build(['controller' => 'Reunions', 'action' => 'view'])) ?>"
                      data-mark-read-url="<?= h($this->Url->build(['controller' => 'Reunions', 'action' => 'markAllRead'])); ?>"
                      data-notifications-url="<?= h($this->Url->build(['controller' => 'Reunions', 'action' => 'notificationsProches'])); ?>"
                      title="Notifications">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span id="notif-count" class="notification-count"></span>
                </span>

                <div id="notifications-dropdown">
                    <p class="notif-loading">Chargement...</p>
                </div>
            </div>

            <div class="profile-menu">
                <a href="javascript:void(0);" onclick="toggleProfileMenu(event)" style="display:inline-flex; align-items:center; gap:8px; text-decoration:none; color:inherit;">
                    <img src="<?= $this->Url->image('cover_person_0.png') ?>" alt="Profil" class="profile-avatar" />
                    <span style="font-size:14px; font-weight:500;"><?= h($user->nom) ?></span>
                </a>
                <div id="profileDropdown">
                    <p><strong><?= h($user->nom) ?></strong></p>
                    <p class="small text-muted"><?= h($user->email) ?></p>
                    <div class="dropdown-divider"></div>
                    <a href="<?= $this->Url->build(['controller' => 'Utilisateurs', 'action' => 'view', $user->id]) ?>">Mon profil</a>
                    <a href="<?= $this->Url->build(['controller' => 'Utilisateurs', 'action' => 'changePassword']) ?>">Changer mot de passe</a>
                    <?php if ($user->role === 'admin'): ?>
                        <a href="<?= $this->Url->build(['controller' => 'Utilisateurs', 'action' => 'index']) ?>">Utilisateurs</a>
                    <?php endif; ?>
                    <div class="dropdown-divider"></div>
                    <button id="toggleDarkMode" style="width:100%; border:1px solid var(--border); background:var(--light); color:inherit; border-radius:8px; padding:6px 10px; cursor:pointer;">&#127769;&#65039; / &#9728;&#65039; Mode sombre</button>
                    <div class="dropdown-divider"></div>
                    <a href="<?= $this->Url->build(['controller' => 'Utilisateurs', 'action' => 'deconnexion']) ?>" style="color:var(--danger);">Déconnexion</a>
                </div>
            </div>
        <?php else: ?>
            <a href="<?= $this->Url->build(['controller' => 'Utilisateurs', 'action' => 'login']) ?>" class="btn btn-primary btn-sm">Connexion</a>
            <a href="<?= $this->Url->build(['controller' => 'Utilisateurs', 'action' => 'add']) ?>" class="btn btn-light btn-sm">Inscription</a>
        <?php endif; ?>
    </header>

    <?php if ($user): ?>
        <aside class="sidebar" id="sidebar">
            <h3><?= $user->role === 'admin' ? 'Administration' : 'Navigation' ?></h3>
            <ul>
                <li><a href="<?= $this->Url->build('/dashboard') ?>">&#127968; Tableau de bord</a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Reunions', 'action' => 'index']) ?>">&#128197; Réunions</a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Reunions', 'action' => 'calendrier']) ?>">&#128467; Calendrier</a></li>
                <?php if ($user->role === 'admin'): ?>
                    <li><a href="<?= $this->Url->build(['controller' => 'Planification', 'action' => 'index']) ?>">&#128451; Planification</a></li>
                    <li><a href="<?= $this->Url->build(['controller' => 'Participants', 'action' => 'index']) ?>">&#128101; Participants</a></li>
                    <li><a href="<?= $this->Url->build(['controller' => 'Reunions', 'action' => 'select']) ?>">&#10133; Ajouter participants</a></li>
                    <li><a href="<?= $this->Url->build(['controller' => 'Utilisateurs', 'action' => 'index']) ?>">&#128100; Utilisateurs</a></li>
                    <li><a href="<?= $this->Url->build(['controller' => 'Fonctions', 'action' => 'index']) ?>">&#9881;&#65039; Fonctions</a></li>
                    <li><a href="<?= $this->Url->build(['controller' => 'TypesReunions', 'action' => 'index']) ?>">&#128220; Types de réunions</a></li>
                <?php else: ?>
                    <li><a href="<?= $this->Url->build(['controller' => 'Reunions', 'action' => 'mesReunions']) ?>">&#128220; Mes réunions</a></li>
                    <li><a href="<?= $this->Url->build(['controller' => 'Reunions', 'action' => 'mesParticipants']) ?>">&#128101; Mes participants</a></li>
                    <li><a href="<?= $this->Url->build(['controller' => 'Planification', 'action' => 'index']) ?>">&#128451; Planification</a></li>
                <?php endif; ?>
            </ul>
        </aside>
    <?php endif; ?>

    <main class="main-content <?= $user ? 'menu-open' : '' ?>" id="main-content">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>

    <?= $this->fetch('script') ?>

    <script>
    (function () {
        var PENDING = <?= json_encode($pendingNotifications, $jsonFlags) ?>;

        function onReady(fn) {
            if (document.readyState !== 'loading') { fn(); } else { document.addEventListener('DOMContentLoaded', fn); }
        }

        // ---------- Sidebar mobile ----------
        onReady(function () {
            var hamburger = document.getElementById('hamburger');
            var sidebar = document.getElementById('sidebar');
            if (hamburger && sidebar) {
                hamburger.addEventListener('click', function () {
                    sidebar.classList.toggle('open');
                });
                document.addEventListener('click', function (e) {
                    if (!sidebar.contains(e.target) && !hamburger.contains(e.target)) {
                        sidebar.classList.remove('open');
                    }
                });
            }
        });

        // ---------- Profil dropdown ----------
        window.toggleProfileMenu = function (e) {
            e.stopPropagation();
            var menu = document.getElementById('profileDropdown');
            if (menu) { menu.style.display = menu.style.display === 'block' ? 'none' : 'block'; }
        };

        // ---------- Dark mode ----------
        function applyDark(active) {
            document.body.classList.toggle('dark-mode', active);
        }
        onReady(function () {
            applyDark(localStorage.getItem('theme') === 'dark');
            var darkBtn = document.getElementById('toggleDarkMode');
            if (darkBtn) {
                darkBtn.addEventListener('click', function () {
                    var next = !document.body.classList.contains('dark-mode');
                    applyDark(next);
                    localStorage.setItem('theme', next ? 'dark' : 'light');
                });
            }
            // Fermer les menus en cliquant dehors
            document.addEventListener('click', function () {
                var dm = document.getElementById('profileDropdown');
                var mm = document.getElementById('notifications-dropdown');
                if (dm) { dm.style.display = 'none'; }
                if (mm) { mm.style.display = 'none'; }
            });
        });

        // ---------- Notifications ----------
        function notificationsUrl() {
            var bell = document.getElementById('notification-bell');
            return bell ? bell.getAttribute('data-notifications-url') : null;
        }
        function reunionViewUrl(id) {
            var bell = document.getElementById('notification-bell');
            var base = bell ? bell.getAttribute('data-reunion-url') : '/reunions/view';
            return base + '/' + encodeURIComponent(id);
        }

        function renderNotifications() {
            var list = [];
            var bell = document.getElementById('notification-bell');
            if (!bell) { return; }

            for (var i = 0; i < PENDING.length; i++) { list.push(PENDING[i]); }
            PENDING = [];

            fetch(notificationsUrl())
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    var items = data && data.items ? data.items : [];
                    list = list.concat(items);

                    var dropdown = document.getElementById('notifications-dropdown');
                    var badge = document.getElementById('notif-count');

                    if (list.length === 0) {
                        dropdown.innerHTML = '<p class="notif-loading">Aucune notification</p>';
                    } else {
                        dropdown.innerHTML = '';
                        list.forEach(function (n) {
                            var div = document.createElement('div');
                            div.className = 'notif-item';
                            div.textContent = (n.message || '') + (n.send_at ? ' (' + n.send_at + ')' : '');
                            var meta = document.createElement('div');
                            meta.className = 'notif-meta';
                            if (n.id_reunion) {
                                meta.textContent = 'Voir la réunion';
                            }
                            div.appendChild(meta);
                            div.addEventListener('click', function () {
                                if (n.id_reunion) {
                                    window.location.href = reunionViewUrl(n.id_reunion);
                                }
                            });
                            dropdown.appendChild(div);
                        });
                    }

                    badge.textContent = list.length;
                    badge.style.display = list.length > 0 ? 'inline-block' : 'none';
                })
                .catch(function () {
                    var dropdown = document.getElementById('notifications-dropdown');
                    if (dropdown) { dropdown.innerHTML = '<p class="notif-loading">Erreur lors du chargement.</p>'; }
                });
        }

        onReady(function () {
            var bell = document.getElementById('notification-bell');
            var dropdown = document.getElementById('notifications-dropdown');
            if (!bell || !dropdown) { return; }

            bell.addEventListener('click', function (e) {
                e.stopPropagation();
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                if (dropdown.style.display === 'block') {
                    var markUrl = bell.getAttribute('data-mark-read-url');
                    var badge = document.getElementById('notif-count');
                    if (markUrl) {
                        fetch(markUrl, { method: 'POST' }).catch(function () {});
                    }
                    if (badge) { badge.style.display = 'none'; }
                }
            });

            renderNotifications();
            setInterval(renderNotifications, 30000);
        });
    })();
    </script>

</body>
</html>