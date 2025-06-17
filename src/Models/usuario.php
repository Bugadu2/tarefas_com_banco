<?php
namespace App\Models;
class Usuario
{
    private \PDO $conexao;
    public ?int $id = null;
    public string $nome = '';
    public string $login = '';
    public string $senha = '';
    public string $email = '';
 
       public function __construct(\PDO $connection) {
        $this->conexao = $connection;
    }
 
    public function create(): bool {
        $sql = "INSERT INTO usuario (nome, login, senha, email) VALUES (:nome, :login, :senha, :email)";
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([
            ':nome' => $this->nome,
            ':login' => $this->login,
            ':senha' => password_hash($this->senha, PASSWORD_DEFAULT),
            ':email' => $this->email
        ]);
    }
 
    public function getUsuariosById(int $id): ?array {
        $sql = "SELECT * FROM usuario WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
 
    public function update(): bool {
        $sql = "UPDATE usuario SET nome = :nome, login = :login, senha = :senha, email = :email WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([
            ':nome' => $this->nome,
            ':login' => $this->login,
            ':senha' => password_hash($this->senha, PASSWORD_DEFAULT),
            ':email' => $this->email,
            ':id' => $this->id
        ]);
    }
    
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM usuario WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
   
    //criar a propriedade da conexão igual á classe Tarefa
   
    //Criar o metodo construtor igual á tarefa
 
    //criar os metodos criate, findById, update e delete para gerenciar os usuarios
}