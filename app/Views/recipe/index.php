<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<?= $breadcrumb ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-journal-richtext me-2 text-primary"></i>Recepty</h1>
    <?php if (session()->get('logged_in')): ?>
        <a href="<?= base_url('recepty/novy') ?>" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i>Nový recept
        </a>
    <?php endif; ?>
</div>

<!-- Filtr kategorií -->
<?php if (! empty($categories)): ?>
    <div class="mb-4">
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('recepty') ?>" class="btn btn-sm btn-outline-secondary">Vše</a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?= base_url('recepty?category=' . $cat['id']) ?>"
                   class="btn btn-sm btn-outline-warning"><?= esc($cat['name']) ?></a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Seznam receptů -->
<?php if (empty($recipes)): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>Žádné recepty nenalezeny.
    </div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($recipes as $recipe): ?>
            <div class="col">
                <div class="card h-100 recipe-card shadow-sm">
                    <?php if ($recipe['image_path']): ?>
                        <img src="<?= base_url('uploads/images/' . esc($recipe['image_path'])) ?>"
                             class="card-img-top" alt="<?= esc($recipe['title']) ?>" style="height:200px;object-fit:cover;">
                    <?php else: ?>
                        <div class="bg-light text-muted d-flex align-items-center justify-content-center" style="height:200px;">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <span class="badge bg-warning text-dark mb-2"><?= esc($recipe['category_name'] ?? 'Bez kategorie') ?></span>
                        <?php if ($recipe['prep_time_minutes']): ?>
                            <span class="badge bg-info text-dark mb-2 ms-1">
                                <i class="bi bi-clock me-1"></i><?= (int) $recipe['prep_time_minutes'] ?> min
                            </span>
                        <?php endif; ?>
                        <h5 class="card-title"><?= esc($recipe['title']) ?></h5>
                        <p class="card-text text-muted small">
                            <?= esc(substr($recipe['short_description'] ?? '', 0, 120)) ?>
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-person me-1"></i><?= esc($recipe['username'] ?? 'anonym') ?>
                            </small>
                            <div class="btn-group btn-group-sm">
                                <a href="<?= base_url('recepty/' . $recipe['id']) ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if (session()->get('logged_in')): ?>
                                    <a href="<?= base_url('recepty/' . $recipe['id'] . '/upravit') ?>" class="btn btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-item-name="<?= esc($recipe['title']) ?>"
                                            data-delete-url="<?= base_url('recepty/' . $recipe['id'] . '/smazat') ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
