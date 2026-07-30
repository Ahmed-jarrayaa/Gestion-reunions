<?php
/**
 * @var \App\View\AppView $this
 */

use App\Model\Entity\Reunion;

$cakeDescription = 'CakePHP: the rapid development php framework';
$user = $this->request->getAttribute('identity');
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')) ?>
    <?= $this->Html->charset() ?>
    <?= $this->Html->css('app') ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReunionsWEB</title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'style']) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <style>
         body {
            margin: 0;
            font-family: "Segoe UI", Roboto, sans-serif;
            background: #fafafa;
            color: #333;
        }
        .dark-mode {
            background: #181a1b;
            color: #eee;
        }



        /* Sidebar */
        .sidebar {
            width: 230px;
            background: #ffffff;
            height: 100vh;
            padding: 20px;
            position: fixed;
            box-shadow: 2px 0 8px rgba(0,0,0,0.05);
            overflow-y: auto;
        }
        .sidebar h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #444;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 12px;
        }
        .sidebar ul li a {
            display: block;
            padding: 10px;
            border-radius: 8px;
            color: #333;
            text-decoration: none;
            font-size: 15px;
            transition: all .2s;
        }
        .sidebar ul li a:hover {
            background: #007bff;
            color: #fff;
        }

        /* Main content */
        .main-content {
            padding: 20px;
            width: 100%;
            margin-left: <?= ($user && in_array($user->role, ['admin', 'membre'])) ? '250px' : '0' ?>;
            padding-top: 70px;
            box-sizing: border-box;
        }

        /* Top bar */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #eee;
            position: fixed;
            width: 100%;
            left: 0;
            top: 0;
            z-index: 10;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .top-bar a {
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
        }

        /* Profile + notifications */
        .profile-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ccc;
        }
        .profile-menu, .notification-menu {
            position: relative;
            display: inline-block;
            margin-left: 20px;
        }
        #profileDropdown, #notifications-dropdown {
            display: none;
            position: absolute;
            right: 0;
            background: #fff;
            border-radius: 10px;
            padding: 10px;
            min-width: 240px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            z-index: 100;
        }
        #notifications-dropdown {
            width: 320px;
            max-height: 320px;
            overflow-y: auto;
            top: 40px;
        }
        .notification-icon {
            font-size: 22px;
            cursor: pointer;
            position: relative;
        }
        .notification-count {
            position: absolute;
            top: -6px;
            right: -8px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            display: none;
        }

        /* Notification item */
        .notif-item {
            border-bottom: 1px solid #f1f1f1;
            padding: 8px;
            font-size: 14px;
            cursor: pointer;
        }
        .notif-item:hover {
            background: #f9f9f9;
        }
    </style>
</head>
<body>

<?php if ($user && $user->role === 'admin'): ?>
    <div class="sidebar">
        <h3>Menu Admin</h3>
         <ul>
            <li><?= $this->Html->link('📅 Réunions', ['controller' => 'Reunions', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link('👥 Participants', ['controller' => 'Participants', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link('⚙️ Fonctions', ['controller' => 'Fonctions', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link('📝 Types de Réunions', ['controller' => 'TypesReunions', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link('➕ Ajouter participants', ['controller' => 'Reunions', 'action' => 'select']) ?></li>
            <li><?= $this->Html->link('👤 Utilisateurs', ['controller' => 'Utilisateurs', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link('📆 Calendrier', ['controller' => 'Reunions', 'action' => 'calendrier']) ?></li>
            <li><?= $this->Html->link('🗓️ Planification', ['controller' => 'Planification', 'action' => 'index']) ?></li>
        </ul>
    </div>
<?php elseif ($user && $user->role === 'membre'): ?>
    <div class="sidebar">
        <h3>Menu Membre</h3>
        <ul>
            <li><?= $this->Html->link('📅 Réunions', ['controller' => 'Reunions', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link('🗂️ Mes Réunions', ['controller' => 'Reunions', 'action' => 'mesReunions']) ?></li>
            <li><?= $this->Html->link('👥 Participants', ['controller' => 'Participants', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link('📆 Calendrier', ['controller' => 'Reunions', 'action' => 'calendrier']) ?></li>
            <li><?= $this->Html->link('👥 Mes Participants', ['controller' => 'Reunions', 'action' => 'mesParticipants']) ?></li>
            <li><?= $this->Html->link('🗓️ Planification', ['controller' => 'Planification', 'action' => 'index']) ?></li>
        </ul>
    </div>
<?php endif; ?>

<div class="main-content">
    <div class="top-bar">
        <div><a href="<?= $this->Url->build('/dashboard') ?>">🏠 Accueil</a></div>
        
        <div style="display:flex; align-items:center;">
            <?php if ($user): ?>
                <div class="notification-menu" style="position: relative;">
                    <span id="notification-bell" class="notification-icon" title="Notifications">
                        🔔
                        <span id="notif-count" class="notification-count"></span>
                    </span>

                    <div id="notifications-dropdown">
                        <p id="notif-loading" style="padding:10px;">Chargement...</p>
                    </div>
                </div>

                <!-- Profile Menu -->
                <div class="profile-menu">
                    <a href="javascript:void(0);" onclick="toggleProfileMenu()" style="display:inline-flex; align-items:center; text-decoration:none;">
                        <img src="<?= $this->Url->image('cover_person_0.png') ?>" alt="Profil" class="profile-avatar" />
                        <span style="margin-left:8px; cursor:pointer;"><?= h($user->nom) ?></span>
                    </a>
                    <div id="profileDropdown">
                        <p><strong><?= h($user->nom) ?></strong></p>
                        <p><?= h($user->email) ?></p>
                        <button id="toggleDarkMode">🌙 / ☀️</button>
                        <hr>
                        <li><?= $this->Html->link('Changer mot de passe', ['controller' => 'Utilisateurs', 'action' => 'changePassword']) ?></li>
                        <a href="<?= $this->Url->build(['controller'=>'Utilisateurs','action'=>'deconnexion']) ?>" style="color:red;">Déconnexion</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</div>

<script>
function toggleProfileMenu() {
    const menu = document.getElementById('profileDropdown');
    menu.style.display = menu.style.display==='block' ? 'none' : 'block';
}

// DARK MODE
document.getElementById('toggleDarkMode').addEventListener('click', ()=>{
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('theme', document.body.classList.contains('dark-mode')?'dark':'light');
});
if(localStorage.getItem('theme')==='dark') document.body.classList.add('dark-mode');

// Notifications
function fetchNotifications() {
    fetch('<?= $this->Url->build(["controller"=>"Reunions","action"=>"notificationsProches"]) ?>')
        .then(res => res.json())
        .then(data => {
            let notifications = data.items || [];

            // Annulations stockées en session
            <?php if ($this->request->getSession()->check('notifications.annulation') ): ?>
                const annulations = <?= json_encode($this->request->getSession()->read('notifications.annulation')) ?>;
                notifications = annulations.concat(notifications);
                <?= $this->request->getSession()->delete('notifications.annulation') ?>
            <?php endif; ?>

            <?php
            $user = $this->request->getAttribute('identity');
            if ($user) {
                $keyRefus   = "notifications.{$user->id}.refus";
                $keyAccepte = "notifications.{$user->id}.accepte";
            }
            ?>

            // Accept (session -> JS)  ✅ corrigé : pas de <script> imbriqué, pas d'echo du delete()
            <?php if ($this->request->getSession()->check('notifications.accept')): ?>
                const accept = <?= json_encode($this->request->getSession()->read('notifications.accept')) ?>;
                notifications = accept.concat(notifications);
                <?php $this->request->getSession()->delete('notifications.accept'); ?>
            <?php endif; ?>
            // Refus (session -> JS)  ✅ corrigé : pas de <script> imbriqué, pas d'echo du delete()
            <?php if ($this->request->getSession()->check('notifications.refus')): ?>
                const refus = <?= json_encode($this->request->getSession()->read('notifications.refus')) ?>;
                notifications = refus.concat(notifications);
                <?php $this->request->getSession()->delete('notifications.refus'); ?>
            <?php endif; ?>

            // Refus
            <?php if ($user && $this->request->getSession()->check($keyRefus)): ?>
                const refus = <?= json_encode($this->request->getSession()->read($keyRefus)) ?>;
                notifications = refus.concat(notifications);
                <?= $this->request->getSession()->delete($keyRefus) ?>
            <?php endif; ?>

            // Acceptés
            <?php if ($user && $this->request->getSession()->check($keyAccepte)): ?>
                const accepte = <?= json_encode($this->request->getSession()->read($keyAccepte)) ?>;
                notifications = accepte.concat(notifications);
                <?= $this->request->getSession()->delete($keyAccepte) ?>
            <?php endif; ?>

            // Autres notifications "reunion_*"
            <?php
            $session = $this->request->getSession();
            $notifications = $session->read('notifications') ?? [];
            foreach ($notifications as $key => $notes) {
                if (strpos($key, 'reunion_') === 0) {
                    foreach ($notes as $note) {
                        echo '<div class="alert alert-info" style="margin:10px 0;">';
                        echo h($note['message']) . ' <small>(' . h($note['send_at']) . ')</small>';
                        echo '</div>';
                    }
                    $session->delete('notifications.' . $key);
                }
            }
            ?>

            // MAJ du dropdown
            const dropdown = document.getElementById('notifications-dropdown');
            dropdown.innerHTML = '';

            if (notifications.length === 0) {
                dropdown.innerHTML = '<p style="padding:10px;">Aucune notification</p>';
            } else {
                notifications.forEach(n => {
                    const div = document.createElement('div');
                    div.textContent = n.message + ' (' + n.send_at + ')';
                    div.style.borderBottom = '1px solid #eee';
                    div.style.padding = '5px';

                    div.addEventListener('click', () => {
                        if(n.id_reunion) {
                            window.location.href = '/reunions/view/' + n.id_reunion;
                        }
                    });

                    dropdown.appendChild(div);
                });
            }

            // Badge
            const countBadge = document.getElementById('notif-count');
            countBadge.textContent = notifications.length;
            countBadge.style.display = notifications.length > 0 ? 'inline-block' : 'none';
        })
        .catch(err => console.error('Erreur fetch notifications:', err));
}

const notificationBell = document.getElementById('notification-bell');
const dropdown = document.getElementById('notifications-dropdown');
const notifCount = document.getElementById('notif-count');

notificationBell.addEventListener('click', () => {
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    fetch('<?= $this->Url->build(["controller"=>"Reunions","action"=>"markAllRead"]) ?>', {
        method: 'POST',
        headers: { 'X-CSRF-Token': '<?= $this->request->getAttribute("csrfToken") ?>' }
    }).then(() => {
        notifCount.style.display = 'none';
    });
});

// Charger immédiatement + toutes les 30s
fetchNotifications();
setInterval(fetchNotifications, 30000);
</script>

</body>
</html>
