<?php
    require_once __DIR__ . '/../templates/header.php';
?>

        <h1 class="mb-4">Liste des Utilisateurs</h1>

        <?php echo $statusMessage ?? '';?>

        <a href="index.php?action=create" class="btn btn-primary mb-3">Ajouter un nouvel utilisateur</a>

        <?php if (empty($users)):?>
            <div class="alert alert-info" role="alert">
                Aucun utilisateur enregistré pour le moment.
            </div>
        <?php else: ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                            <td>
                                <a href="index.php?action=edit&id=<?php echo htmlspecialchars($user['id']); ?>"
                                    class="btn btn-warning btn-sm me-1"
                                >
                                    Modifier
                                </a>
                                <a 
                                    href="index.php?action=delete&id=<?php echo htmlspecialchars($user['id']); ?>" 
                                    class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');"
                                >
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="index.php?action=list&page=<?php echo $currentPage - 1; ?>">Précédent</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                            <a class="page-link" href="index.php?action=list&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="index.php?action=list&page=<?php echo $currentPage + 1; ?>">Suivant</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>

<?php
    require_once __DIR__ . '/../templates/footer.php'; 
?>