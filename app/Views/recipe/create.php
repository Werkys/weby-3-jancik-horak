<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<!-- TinyMCE WYSIWYG Editor - tiny.cloud | MIT License | Tiny Technologies Inc. -->
<style>
    .tox-tinymce { border-radius: 0.375rem; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<?= $breadcrumb ?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Nový recept</h4>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('recepty') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-8">
                            <!-- Název receptu -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Název receptu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="<?= esc(old('title')) ?>" required>
                            </div>

                            <!-- Krátký popis -->
                            <div class="mb-3">
                                <label for="short_description" class="form-label">Krátký popis</label>
                                <input type="text" class="form-control" id="short_description" name="short_description"
                                       value="<?= esc(old('short_description')) ?>" maxlength="500"
                                       placeholder="Stručný popis receptu (max 500 znaků)">
                            </div>

                            <!-- Kategorie (dropdown) -->
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategorie <span class="text-danger">*</span></label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="" disabled selected>-- Vyberte kategorii --</option>
                                    <?php foreach ($categories as $id => $name): ?>
                                        <option value="<?= esc($id) ?>"
                                            <?= old('category_id') == $id ? 'selected' : '' ?>>
                                            <?= esc($name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Obrázek -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Obrázek receptu</label>
                                <input type="file" class="form-control" id="image" name="image"
                                       accept="image/jpeg,image/png,image/gif,image/webp">
                                <div class="form-text">JPEG, PNG, GIF nebo WebP, max. <?= config('RecipeConfig')->maxUploadSizeMB ?> MB</div>
                            </div>

                            <!-- Čas přípravy -->
                            <div class="mb-3">
                                <label for="prep_time_minutes" class="form-label">Čas přípravy (min)</label>
                                <input type="number" class="form-control" id="prep_time_minutes" name="prep_time_minutes"
                                       value="<?= esc(old('prep_time_minutes')) ?>" min="1" max="9999">
                            </div>

                            <!-- Počet porcí -->
                            <div class="mb-3">
                                <label for="servings" class="form-label">Počet porcí</label>
                                <input type="number" class="form-control" id="servings" name="servings"
                                       value="<?= esc(old('servings')) ?>" min="1" max="99">
                            </div>
                        </div>
                    </div>

                    <!-- Popis receptu - TinyMCE WYSIWYG -->
                    <div class="mb-4">
                        <label for="description" class="form-label">Postup přípravy</label>
                        <textarea class="form-control" id="description" name="description" rows="10"><?= esc(old('description')) ?></textarea>
                        <div class="form-text">Použijte editor pro formátování textu. Minimum 1000 znaků pro detailní popis.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Uložit recept
                        </button>
                        <a href="<?= base_url('recepty') ?>" class="btn btn-secondary">
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
<!-- TinyMCE WYSIWYG Editor - https://www.tiny.cloud | MIT License | Tiny Technologies Inc. -->
<script src="https://cdn.tiny.cloud/1/<?= esc(config('RecipeConfig')->tinymceApiKey) ?>/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#description',
        language: 'cs',
        height: 400,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }',
        promotion: false,
        branding: false,
    });
</script>
<?= $this->endSection() ?>
