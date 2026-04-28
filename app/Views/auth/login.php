<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white text-center py-3">
                <h4 class="mb-0"><i class="bi bi-person-lock me-2"></i>Přihlášení</h4>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('auth/prihlasit') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="username" class="form-label">Uživatelské jméno <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="username" name="username"
                                   value="<?= esc(old('username')) ?>" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Heslo <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword" title="Zobrazit/skrýt heslo">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Přihlásit se
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center text-muted small py-3">
                <strong>Testovací přihlášení:</strong><br>
                admin / Admin123! &nbsp;|&nbsp; jancik / Jancik123!
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Zobrazení/skrytí hesla
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            passwordInput.type = 'password';
            icon.className = 'bi bi-eye';
        }
    });
</script>
<?= $this->endSection() ?>
