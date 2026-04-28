<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero sekce -->
<div class="p-5 mb-4 bg-dark text-white rounded-3">
    <div class="container-fluid py-3">
        <h1 class="display-5 fw-bold"><i class="bi bi-book-half me-3"></i>Vítejte v Receptáři!</h1>
        <p class="col-md-8 fs-4">Sbírka oblíbených receptů z české i světové kuchyně.</p>
        <a href="<?= base_url('recepty') ?>" class="btn btn-warning btn-lg">
            <i class="bi bi-search me-2"></i>Prohlédnout recepty
        </a>
    </div>
</div>

<!-- Nejnovější recepty -->
<section class="mb-5">
    <h2 class="mb-4"><i class="bi bi-clock-history me-2 text-primary"></i>Nejnovější recepty</h2>
    <?php if (empty($recentRecipes)): ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>Zatím žádné recepty. <a href="<?= base_url('recepty/novy') ?>">Přidejte první recept!</a>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($recentRecipes as $recipe): ?>
                <div class="col">
                    <div class="card h-100 recipe-card shadow-sm">
                        <?php if ($recipe['image_path']): ?>
                            <img src="<?= base_url('uploads/images/' . esc($recipe['image_path'])) ?>"
                                 class="card-img-top" alt="<?= esc($recipe['title']) ?>" style="height:200px;object-fit:cover;">
                        <?php else: ?>
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:200px;">
                                <i class="bi bi-image fs-1"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <span class="badge bg-warning text-dark mb-2"><?= esc($recipe['category_name'] ?? 'Bez kategorie') ?></span>
                            <h5 class="card-title"><?= esc($recipe['title']) ?></h5>
                            <p class="card-text text-muted small"><?= esc(substr($recipe['short_description'] ?? '', 0, 100)) ?>...</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-person me-1"></i><?= esc($recipe['username'] ?? 'anonym') ?>
                            </small>
                            <a href="<?= base_url('recepty/' . $recipe['id']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i>Zobrazit
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?= base_url('recepty') ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-right me-2"></i>Všechny recepty
            </a>
        </div>
    <?php endif; ?>
</section>

<!-- Statistiky kategorií -->
<section>
    <h2 class="mb-4"><i class="bi bi-bar-chart me-2 text-success"></i>Recepty podle kategorií</h2>
    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-3">
        <?php foreach ($categoriesStats as $cat): ?>
            <div class="col">
                <a href="<?= base_url('recepty?category=' . $cat['id']) ?>" class="text-decoration-none">
                    <div class="card text-center h-100 border-0 shadow-sm">
                        <div class="card-body py-3">
                            <div class="fs-3 fw-bold text-primary"><?= (int) $cat['recipe_count'] ?></div>
                            <div class="text-muted small"><?= esc($cat['name']) ?></div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?= $this->endSection() ?>
