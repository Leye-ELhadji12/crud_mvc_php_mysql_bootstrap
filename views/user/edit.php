<?php
    require_once __DIR__ . '/../templates/header.php';
?>

        <h1 class="mb-4">Modifier l'Utilisateur</h1>

        <?php echo $message ?? '';?>

        <?php if ($user):?>
        <form action="index.php?action=edit&id=<?php echo htmlspecialchars($user['id']); ?>" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Mettre à jour</button>
            <a href="index.php?action=list" class="btn btn-secondary">Annuler</a>
        </form>
        <?php else: ?>
            <a href="index.php?action=list" class="btn btn-primary">Retour à la liste des utilisateurs</a>
        <?php endif; ?>

<?php
    require_once __DIR__ . '/../templates/footer.php';
?>