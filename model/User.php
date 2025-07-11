<?php
    class User
    {
        private $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }

        public function getAllUsers(int $limit, int $offset): array
        {
            $stmt = $this->pdo->prepare("SELECT id, name, email, created_at FROM users ORDER BY id DESC LIMIT :limit OFFSET :offset");
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getTotalUsersCount(): int
        {
            $stmt = $this->pdo->query("SELECT COUNT(id) FROM users");
            return (int) $stmt->fetchColumn(); 
        }

        public function getUser(int $id)
        {
            $stmt = $this->pdo->prepare("SELECT id, name, email FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]); 
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }

        public function updateUser(int $id, string $name, string $email): bool
        {
            $stmt = $this->pdo->prepare("UPDATE users SET email = :email, name = :name WHERE id = :id");
            $stmt->execute([
                'id' => $id,
                'email' => $email,
                'name' => $name
            ]);
            return $stmt->rowCount() > 0;
        }

        public function deleteUser(int $id): bool 
        {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount() > 0;
        }

        public function createUser(string $name, string $email): bool
        {
            $stmt = $this->pdo->prepare("INSERT INTO users(name, email) VALUES(:name, :email)");
            $stmt->execute([
                'name' => $name,
                'email' => $email
            ]);
            return $stmt->rowCount() > 0;
        }
    }
?>