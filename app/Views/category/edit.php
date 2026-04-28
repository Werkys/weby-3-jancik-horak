<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<?= $breadcrumb ?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0"><i class="bi bi-pencil me-2"></i>Editace kategorie</h4>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('kategorie/' . $category['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">

                    <div class="mb-3">
                        <label for="name" class="form-label">Název kategorie <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="<?= esc(old('name', $category['name'])) ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Popis</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?= esc(old('description', $category['description'])) ?></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle me-2"></i>Uložit změny
                        </button>
                        <a href="<?= base_url('kategorie') ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Zrušit
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
