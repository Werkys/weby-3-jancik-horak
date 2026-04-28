<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<?= $breadcrumb ?>

<div class="row">
    <div class="col-lg-8">
        <!-- Hlavní info receptu -->
        <div class="card shadow-sm mb-4">
            <?php if ($recipe['image_path']): ?>
                <img src="<?= base_url('uploads/images/' . esc($recipe['image_path'])) ?>"
                     class="card-img-top" alt="<?= esc($recipe['title']) ?>" style="max-height:400px;object-fit:cover;">
            <?php endif; ?>
            <div class="card-body">
                <div class="mb-3">
                    <span class="badge bg-warning text-dark fs-6"><?= esc($recipe['category_name'] ?? 'Bez kategorie') ?></span>
                    <?php if ($recipe['prep_time_minutes']): ?>
                        <span class="badge bg-info text-dark fs-6 ms-2">
                            <i class="bi bi-clock me-1"></i><?= (int) $recipe['prep_time_minutes'] ?> min
                        </span>
                    <?php endif; ?>
                    <?php if ($recipe['servings']): ?>
                        <span class="badge bg-success fs-6 ms-2">
                            <i class="bi bi-people me-1"></i><?= (int) $recipe['servings'] ?> porce
                        </span>
                    <?php endif; ?>
                </div>

                <h1 class="mb-3"><?= esc($recipe['title']) ?></h1>

                <?php if ($recipe['short_description']): ?>
                    <p class="lead text-muted"><?= esc($recipe['short_description']) ?></p>
                <?php endif; ?>

                <hr>

                <!-- Popis receptu (WYSIWYG obsah) -->
                <?php if ($recipe['description']): ?>
                    <div class="recipe-description">
                        <?= $recipe['description'] /* Záměrně bez escapování - obsah je z WYSIWYG editoru */ ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted"><em>Popis receptu nebyl přidán.</em></p>
                <?php endif; ?>
            </div>
            <div class="card-footer text-muted small">
                <i class="bi bi-person me-1"></i>Autor: <?= esc($recipe['full_name'] ?? $recipe['username'] ?? 'anonym') ?>
                &nbsp;|&nbsp;
                <i class="bi bi-calendar me-1"></i>Přidáno: <?= date('d.m.Y', strtotime($recipe['created_at'])) ?>
            </div>
        </div>

        <!-- Akce -->
        <div class="mb-4">
            <a href="<?= base_url('recepty') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Zpět na recepty
            </a>
            <?php if (session()->get('logged_in')): ?>
                <a href="<?= base_url('recepty/' . $recipe['id'] . '/upravit') ?>" class="btn btn-warning ms-2">
                    <i class="bi bi-pencil me-2"></i>Upravit
                </a>
                <button type="button" class="btn btn-danger ms-2"
                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                        data-item-name="<?= esc($recipe['title']) ?>"
                        data-delete-url="<?= base_url('recepty/' . $recipe['id'] . '/smazat') ?>">
                    <i class="bi bi-trash me-2"></i>Smazat
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sidebar: Ingredience -->
    <div class="col-lg-4">
        <div class="card shadow-sm sticky-top" style="top: 20px;">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Ingredience</h5>
            </div>
            <div class="card-body">
                <?php if (empty($ingredients)): ?>
                    <p class="text-muted"><em>Ingredience nebyly přidány.</em></p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($ingredients as $ing): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span><?= esc($ing['ingredient_name']) ?></span>
                                <span class="badge bg-secondary">
                                    <?= $ing['amount'] ? number_format((float)$ing['amount'], 1) . ' ' . esc($ing['unit']) : esc($ing['unit'] ?? '') ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
