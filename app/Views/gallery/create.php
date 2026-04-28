<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<?= $breadcrumb ?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="bi bi-image me-2"></i>Přidat obrázek</h4>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('galerie') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- Recept (dropdown) -->
                    <div class="mb-3">
                        <label for="recipe_id" class="form-label">Přiřadit k receptu</label>
                        <select class="form-select" id="recipe_id" name="recipe_id">
                            <option value="" disabled selected>-- Vyberte recept (volitelné) --</option>
                            <?php foreach ($recipes as $id => $name): ?>
                                <option value="<?= esc($id) ?>"><?= esc($name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Soubor obrázku -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Soubor obrázku <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="image" name="image"
                               accept="image/jpeg,image/png,image/gif,image/webp" required>
                        <div class="form-text">JPEG, PNG, GIF nebo WebP, max. <?= config('RecipeConfig')->maxUploadSizeMB ?> MB</div>
                    </div>

                    <!-- Popis obrázku -->
                    <div class="mb-4">
                        <label for="alt_text" class="form-label">Popis obrázku (alt text)</label>
                        <input type="text" class="form-control" id="alt_text" name="alt_text"
                               value="<?= esc(old('alt_text')) ?>" maxlength="255"
                               placeholder="Stručný popis obsahu obrázku">
                    </div>

                    <!-- Náhled obrázku -->
                    <div id="imagePreview" class="mb-3 d-none">
                        <label class="form-label">Náhled:</label>
                        <img id="previewImg" src="" alt="Náhled" class="img-fluid rounded" style="max-height: 200px;">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload me-2"></i>Nahrát obrázek
                        </button>
                        <a href="<?= base_url('galerie') ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Zrušit
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Náhled obrázku před nahráním
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('previewImg').src = event.target.result;
                document.getElementById('imagePreview').classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
<?= $this->endSection() ?>
