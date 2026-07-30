<?php 
$user = $this->request->getAttribute('identity');

if ($user && isset($user->role)):

    if ($user->role === 'admin'): ?>
        <!-- Sidebar visible uniquement pour les admins -->
        <div class="sidebar">
            <h3>Menu</h3>
            <ul>
                <li><?= $this->Html->link('Réunions', ['controller' => 'Reunions', 'action' => 'index']) ?></li>
                <li><?= $this->Html->link('Participants', ['controller' => 'Participants', 'action' => 'index']) ?></li>
                <li><?= $this->Html->link('Fonctions', ['controller' => 'Fonctions', 'action' => 'index']) ?></li>
                <li><?= $this->Html->link('Types de Réunions', ['controller' => 'TypesReunions', 'action' => 'index']) ?></li>
                <li><?= $this->Html->link('Utilisateurs', ['controller' => 'Utilisateurs', 'action' => 'index']) ?></li>
            </ul>
        </div>
    <?php elseif ($user->role === 'membre'): ?>
        <!-- Sidebar visible uniquement pour les membres -->
        <div class="sidebar">
            <h3>Menu</h3>
            <ul>
                <li><?= $this->Html->link('Mes Réunions', ['controller' => 'Reunions', 'action' => 'mesReunions']) ?></li>
                <li><?= $this->Html->link('Participants', ['controller' => 'Participants', 'action' => 'index']) ?></li>
                <li><?= $this->Html->link('Participants de mes réunions', ['controller' => 'Reunions', 'action' => 'mesParticipants']) ?></li>
                <!-- Tu peux ajouter d’autres liens spécifiques aux membres ici -->
            </ul>
        </div>
    <?php endif; 

endif; ?>
