<?php
namespace App\Servicos;

class tarefa
{
    public ?int $id = null;
    public string $titulo = "";
    public string $descricao = "";
    public bool $status = false;
    public int $user_id = 0;
}