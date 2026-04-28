<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<?= $breadcrumb ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-tags me-2 text-warning"></i>Kategorie</h1>
    <?php if (session()->get('logged_in')): ?>
        <a href="<?= base_url('kategorie/nova') ?>" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i>Nová kategorie
        </a>
    <?php endif; ?>
</div>

<div class="table-responsive">
    <table class="table table-hover table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Název</th>
                <th>Popis</th>
                <th class="text-center">Počet receptů</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($categories)): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Žádné kategorie nenalezeny.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= (int) $cat['id'] ?></td>
                        <td><strong><?= esc($cat['name']) ?></strong></td>
                        <td class="text-muted small"><?= esc($cat['description'] ?? '') ?></td>
                        <td class="text-center">
                            <span class="badge bg-primary"><?= (int) $cat['recipe_count'] ?></span>
                        </td>
                        <td class="text-end">
                            <?php if (session()->get('logged_in')): ?>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= base_url('kategorie/' . $cat['id'] . '/upravit') ?>" class="btn btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-item-name="<?= esc($cat['name']) ?>"
                                            data-delete-url="<?= base_url('kategorie/' . $cat['id'] . '/smazat') ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
