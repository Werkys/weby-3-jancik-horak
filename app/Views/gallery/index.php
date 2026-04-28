<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<?= $breadcrumb ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-images me-2 text-info"></i>Galerie obrázků</h1>
    <?php if (session()->get('logged_in')): ?>
        <a href="<?= base_url('galerie/pridat') ?>" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i>Přidat obrázek
        </a>
    <?php endif; ?>
</div>

<!-- Informace o stránkování -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0">
        Celkem obrázků: <strong><?= (int) $total ?></strong>
        | Na stránce: <strong><?= count($images) ?></strong>
        | Stránka: <strong><?= (int) $currentPage ?></strong> z <strong><?= (int) $totalPages ?></strong>
    </p>
</div>

<!-- Galerie v kartách -->
<?php if (empty($images)): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>Galerie je prázdná. <a href="<?= base_url('galerie/pridat') ?>">Přidejte první obrázek!</a>
    </div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        <?php foreach ($images as $image): ?>
            <div class="col">
                <div class="card h-100 shadow-sm gallery-card">
                    <img src="<?= base_url('uploads/images/' . esc($image['filename'])) ?>"
                         class="card-img-top"
                         alt="<?= esc($image['alt_text'] ?? $image['filename']) ?>"
                         onerror="this.src='https://via.placeholder.com/400x220?text=Obrázek+není+k+dispozici'">
                    <div class="card-body py-2">
                        <p class="card-text small text-muted mb-0">
                            <?= esc($image['alt_text'] ?? $image['filename']) ?>
                        </p>
                        <?php if ($image['recipe_title']): ?>
                            <small class="text-muted">
                                <i class="bi bi-journal me-1"></i><?= esc($image['recipe_title']) ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    <?php if (session()->get('logged_in')): ?>
                        <div class="card-footer py-2">
                            <button type="button" class="btn btn-sm btn-outline-danger w-100"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-item-name="<?= esc($image['alt_text'] ?? $image['filename']) ?>"
                                    data-delete-url="<?= base_url('galerie/' . $image['id'] . '/smazat') ?>">
                                <i class="bi bi-trash me-1"></i>Smazat
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Stránkování -->
    <?php if ($totalPages > 1): ?>
        <nav class="mt-5" aria-label="Stránkování galerie">
            <ul class="pagination justify-content-center">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= base_url('galerie/strana/' . ($currentPage - 1)) ?>">
                            <i class="bi bi-chevron-left"></i> Předchozí
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bi bi-chevron-left"></i> Předchozí</span>
                    </li>
                <?php endif; ?>

                <?php for ($i = max(1, $currentPage - 3); $i <= min($totalPages, $currentPage + 3); $i++): ?>
                    <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                        <a class="page-link" href="<?= base_url('galerie/strana/' . $i) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= base_url('galerie/strana/' . ($currentPage + 1)) ?>">
                            Další <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Další <i class="bi bi-chevron-right"></i></span>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
<?php endif; ?>

<?= $this->endSection() ?>
