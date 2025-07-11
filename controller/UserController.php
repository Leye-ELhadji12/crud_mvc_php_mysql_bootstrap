<?php 
require_once __DIR__ . '/../model/User.php'; 
    class UserController {
        private $userModel; 

        public function __construct(PDO $pdo)
        {
            $this->userModel = new User($pdo);
        }

        public function listUsers()
        {
            $recordsPerPage = 5; 
            $currentPage = $_GET['page'] ?? 1; 
            $currentPage = max(1, (int)$currentPage); 
            $totalUsers = $this->userModel->getTotalUsersCount(); 
            $totalPages = ceil($totalUsers / $recordsPerPage);
            $currentPage = min($currentPage, $totalPages > 0 ? $totalPages : 1);
            $offset = ($currentPage - 1) * $recordsPerPage; 
            $users = $this->userModel->getAllUsers($recordsPerPage, $offset);
            $statusMessage = '';
            if (isset($_GET['status'])) {
                if ($_GET['status'] === 'success_add') {
                    $statusMessage = '<div class="alert alert-success" role="alert">Utilisateur ajouté avec succès !</div>';
                } elseif ($_GET['status'] === 'success_edit') {
                    $statusMessage = '<div class="alert alert-success" role="alert">Utilisateur modifié avec succès !</div>';
                } elseif ($_GET['status'] === 'success_delete') {
                    $statusMessage = '<div class="alert alert-success" role="alert">Utilisateur supprimé avec succès !</div>';
                } elseif (isset($_GET['status']) && $_GET['status'] === 'error') {
                    $statusMessage = '<div class="alert alert-danger" role="alert">Une erreur est survenue : ' . htmlspecialchars($_GET['message'] ?? 'Erreur inconnue') . '</div>';
                }
            }
            require_once __DIR__ . '/../views/user/list.php';
        }

        public function create()
        {
            $message = ''; 
            $name = '';
            $email = ''; 

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');

                if (empty($name) || empty($email)) {
                    $message = '<div class="alert alert-danger" role="alert">Le nom et l\'email ne peuvent pas être vides.</div>';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $message = '<div class="alert alert-danger" role="alert">Format d\'email invalide.</div>';
                } else {
                    try {
                        $success = $this->userModel->createUser($name, $email);

                        if ($success) {
                            header('Location: index.php?action=list&status=success_add');
                            exit();
                        } else {
                            $message = '<div class="alert alert-danger" role="alert">Une erreur inconnue est survenue lors de l\'ajout.</div>';
                        }
                    } catch (PDOException $e) {
                        if ($e->getCode() == 23000) { 
                            $message = '<div class="alert alert-danger" role="alert">Cet email est déjà utilisé.</div>';
                        } else {
                            $message = '<div class="alert alert-danger" role="alert">Erreur de base de données : ' . $e->getMessage() . '</div>';
                        }
                    }
                }
            }
            require_once __DIR__ . '/../views/user/create.php';
        }

        public function edit()
        {
            $message = '';
            $user = null;
            $userId = $_GET['id'] ?? null;

            if ($userId === null || !is_numeric($userId)) {
                $message = '<div class="alert alert-danger" role="alert">ID utilisateur invalide ou manquant.</div>';
            } else {
                $user = $this->userModel->getUser((int)$userId);

                if (!$user) {
                    $message = '<div class="alert alert-danger" role="alert">Utilisateur non trouvé.</div>';
                }
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user) {
                $updatedName = trim($_POST['name'] ?? '');
                $updatedEmail = trim($_POST['email'] ?? '');
                if (empty($updatedName) || empty($updatedEmail)) {
                    $message = '<div class="alert alert-danger" role="alert">Le nom et l\'email ne peuvent pas être vides.</div>';
                    $user['name'] = $updatedName;
                    $user['email'] = $updatedEmail;
                } elseif (!filter_var($updatedEmail, FILTER_VALIDATE_EMAIL)) {
                    $message = '<div class="alert alert-danger" role="alert">Format d\'email invalide.</div>';
                    $user['name'] = $updatedName;
                    $user['email'] = $updatedEmail;
                } else {
                    try {
                        $success = $this->userModel->updateUser((int)$userId, $updatedName, $updatedEmail);

                        if ($success) {
                            header('Location: index.php?action=list&status=success_edit');
                            exit();
                        } else {
                            $message = '<div class="alert alert-danger" role="alert">Une erreur inconnue est survenue lors de la modification.</div>';
                        }
                    } catch (PDOException $e) {
                        if ($e->getCode() == 23000) {
                            $message = '<div class="alert alert-danger" role="alert">Cet email est déjà utilisé par un autre utilisateur.</div>';
                        } else {
                            $message = '<div class="alert alert-danger" role="alert">Erreur de base de données : ' . $e->getMessage() . '</div>';
                        }
                        $user['name'] = $updatedName;
                        $user['email'] = $updatedEmail;
                    }
                }
                require_once __DIR__ . '/../views/user/edit.php';
            }
            require_once __DIR__ . '/../views/user/edit.php';
        }

        public function delete()
        {
            $userId = $_GET['id'] ?? null;

            if ($userId === null || !is_numeric($userId)) {
                header('Location: index.php?action=list&status=error&message=' . urlencode('ID utilisateur invalide ou manquant'));
                exit();
            }

            try {
                $success = $this->userModel->deleteUser((int)$userId);

                if ($success) {
                    header('Location: index.php?action=list&status=success_delete');
                } else {
                    header('Location: index.php?action=list&status=error&message=' . urlencode('Utilisateur non trouvé pour suppression'));
                }
                exit();
            } catch (PDOException $e) {
                header('Location: index.php?action=list&status=error&message=' . urlencode('Erreur de base de données lors de la suppression: ' . $e->getMessage()));
                exit();
            }
        }
    }
?>