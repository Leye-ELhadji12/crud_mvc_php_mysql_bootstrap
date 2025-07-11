<?php
    require_once __DIR__ . '/../templates/header.php';
?>

        <h1 class="mb-4">Ajouter un nouvel Utilisateur</h1>

        <?php echo $message ?? ''; ?>
        <form action="index.php?action=create" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" required 
                       value="<?php echo htmlspecialchars($name ?? ''); ?>"> 
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required 
                       value="<?php echo htmlspecialchars($email ?? ''); ?>"> 
            </div>
            <button type="submit" class="btn btn-success">Ajouter l'utilisateur</button>
            <a href="index.php?action=list" class="btn btn-secondary">Annuler</a>
        </form>

<?php
    require_once __DIR__ . '/../templates/footer.php';
?>