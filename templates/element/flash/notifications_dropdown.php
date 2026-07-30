<div class="dropdown">
    <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown">
        <i class="bi bi-bell" style="font-size: 1.5rem;"></i>
        <?php if (!empty($notifications)): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= count($notifications) ?>
            </span>
        <?php endif; ?>
    </button>
    <ul class="dropdown-menu dropdown-menu-end p-2" style="min-width: 250px;">
        <?php if (empty($notifications)): ?>
            <li class="text-center text-muted">Aucune notification</li>
        <?php else: ?>
            <?php foreach ($notifications as $n): ?>
                <li>
                    <div class="small fw-bold"><?= h($n->message) ?></div>
                    <div class="small text-muted"><?= $n->created->format('d/m/Y H:i') ?></div>
                </li>
                <li><hr class="dropdown-divider"></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>
