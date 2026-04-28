<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Receptář') ?> | <?= esc(config('RecipeConfig')->appName) ?></title>

    <!-- Bootstrap 5.3 CSS - getbootstrap.com | MIT License | The Bootstrap Authors -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons - icons.getbootstrap.com | MIT License -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; font-size: 1.5rem; }
        .recipe-card { transition: transform 0.2s; }
        .recipe-card:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
        .recipe-card img { height: 200px; object-fit: cover; }
        .gallery-card img { height: 220px; object-fit: cover; cursor: pointer; }
        .breadcrumb { background: transparent; padding: 0; }
        footer { background-color: #343a40; color: #adb5bd; }
        .alert { border-radius: 0.5rem; }
        .btn-delete { cursor: pointer; }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

<!-- Navigace -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>">
            <i class="bi bi-book-half me-2"></i><?= esc(config('RecipeConfig')->appName) ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>"><i class="bi bi-house me-1"></i>Domů</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('recepty') ?>"><i class="bi bi-journal-richtext me-1"></i>Recepty</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('kategorie') ?>"><i class="bi bi-tags me-1"></i>Kategorie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('galerie') ?>"><i class="bi bi-images me-1"></i>Galerie</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if (session()->get('logged_in')): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i><?= esc(session()->get('username')) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= base_url('recepty/novy') ?>"><i class="bi bi-plus-circle me-2"></i>Nový recept</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= base_url('auth/odhlasit') ?>"><i class="bi bi-box-arrow-right me-2"></i>Odhlásit se</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('auth/prihlasit') ?>"><i class="bi bi-person me-1"></i>Přihlásit se</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Flash zprávy -->
<div class="container mt-3">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Opravte prosím chyby:</strong>
            <ul class="mb-0 mt-1">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
</div>

<!-- Hlavní obsah -->
<main class="container py-4">
    <?= $this->renderSection('content') ?>
</main>

<!-- Zápatí -->
<footer class="py-4 mt-5">
    <div class="container text-center">
        <p class="mb-1">&copy; <?= date('Y') ?> <?= esc(config('RecipeConfig')->appName) ?> | Jančík &amp; Horák</p>
        <small class="text-muted">
            Vytvořeno s <a href="https://codeigniter.com" class="text-muted">CodeIgniter 4</a> a
            <a href="https://getbootstrap.com" class="text-muted">Bootstrap 5</a>
        </small>
    </div>
</footer>

<!-- Modal pro potvrzení smazání -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel"><i class="bi bi-trash me-2"></i>Potvrdit smazání</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Opravdu chcete smazat <strong id="deleteItemName">tento záznam</strong>?</p>
                <p class="text-muted small">Záznam bude označen jako smazaný (soft delete) a nebude dále zobrazován.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Zrušit
                </button>
                <form id="deleteForm" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Smazat
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle (includes Popper) - MIT License | The Bootstrap Authors -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Inicializace modálního okna pro smazání
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const itemName = button.getAttribute('data-item-name') || 'tento záznam';
                const deleteUrl = button.getAttribute('data-delete-url');

                document.getElementById('deleteItemName').textContent = itemName;
                document.getElementById('deleteForm').setAttribute('action', deleteUrl);
            });
        }

        // Auto-dismiss flash alerts after 5 seconds
        setTimeout(function () {
            document.querySelectorAll('.alert').forEach(function (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
