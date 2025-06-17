<?php

use App\Database\Mariadb;
use App\Models\Tarefa;
use App\Models\Usuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$banco = new Mariadb();

// cadastra usuário
$app->post('/usuario', function(Request $request, Response $response, array $args) use ($banco)
 {
    $campos_obrigatórios = ['nome', "login", 'senha', "email"];
    $body = $request->getParsedBody();

    try{
        $usuario = new Usuario($banco->getConnection());
        $usuario->nome = $body['nome'] ?? '';
        $usuario->email = $body['email'] ?? '';
        $usuario->login = $body['login'] ?? '';
        $usuario->senha = $body['senha'] ?? '';
        foreach($campos_obrigatórios as $campo){
            if(empty($usuario->{$campo})){
                throw new \Exception("o campo {$campo} é obrigatório");
            }
        }
        $usuario->create();
    }catch(\Exception $exception){
         $response->getBody()->write(json_encode(['message' => $exception->getMessage() ]));
         return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    $response->getBody()->write(json_encode([
        'message' => 'Usuário cadastrado com sucesso!'
    ]));
    return $response->withHeader('Content-Type', 'application/json');
});

// listando usuário
$app->get('/usuario/{id}', 
    function(Request $request, Response $response, array $args) use ($banco)
 {
    $id = $args['id'];
    $usuario = new Usuario($banco->getConnection());
    $usuario = $usuario->getUsuariosById($id);
    $response->getBody()->write(json_encode($usuario));
    return $response->withHeader('Content-Type', 'application/json');
});

// Atualizar usuário
$app->put('/usuario/{id}', 
    function(Request $request, Response $response, array $args) use ($banco)
 {
    $campos_obrigatórios = ['nome', "login", 'senha', "email"];
    $body = json_decode($request->getBody()->getContents(), true);

    try{
        $usuario = new Usuario($banco->getConnection());
        $usuario->id = $args['id'];
        $usuario->nome = $body['nome'] ?? '';
        $usuario->email = $body['email'] ?? '';
        $usuario->login = $body['login'] ?? '';
        $usuario->senha = $body['senha'] ?? '';
        foreach($campos_obrigatórios as $campo){
            if(empty($usuario->{$campo})){
                throw new \Exception("o campo {$campo} é obrigatório");
            }
        }
        $usuario->update();
    }catch(\Exception $exception){
         $response->getBody()->write(json_encode(['message' => $exception->getMessage() ]));
         return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    $response->getBody()->write(json_encode([
        'message' => 'Usuário atualizado com sucesso!'
    ]));
    return $response->withHeader('Content-Type', 'application/json');
});

// deletando usuário
$app->delete('/usuario/{id}', 
    function(Request $request, Response $response, array $args) use ($banco)
 {
    $id = $args['id'];
    $usuario = new Usuario($banco->getConnection());
    $usuario->delete($id);
    $response->getBody()->write(json_encode(['message' => 'Usuário excluído']));
    return $response->withHeader('Content-Type', 'application/json');
});


$app->post('/tarefa', function(Request $request, Response $response, array $args) use ($banco)
 {
    $campos_obrigatórios = ['titulo', "descricao", 'status', "user_id"];
    $body = $request->getParsedBody();

    try{
        $tarefa = new tarefa($banco->getConnection());
        $tarefa->titulo = $body['titulo'] ?? '';
        $tarefa->descricao = $body['descricao'] ?? '';
        $tarefa->status = $body['status'] ?? '';
        $tarefa->user_id = (isset($body['user_id']) && is_numeric($body['user_id'])) ? (int)$body['user_id'] : 0;
        foreach($campos_obrigatórios as $campo){
            if(empty($tarefa->{$campo})){
                throw new \Exception("o campo {$campo} é obrigatório");
            }
        }
        $tarefa->create();
    }catch(\Exception $exception){
         $response->getBody()->write(json_encode(['message' => $exception->getMessage() ]));
         return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    $response->getBody()->write(json_encode([
        'message' => 'Tarefa cadastrada com sucesso!'
    ]));
    return $response->withHeader('Content-Type', 'application/json');
});

// listando tarefa
$app->get('/tarefa/{id}', 
    function(Request $request, Response $response, array $args) use ($banco)
 {
    $id = $args['id'];
    $tarefa = new tarefa($banco->getConnection());
    $tarefa = $tarefa->getTarefaById($id);
    $response->getBody()->write(json_encode($tarefa));
    return $response->withHeader('Content-Type', 'application/json');
});

// Atualizar tarefa
$app->put('/tarefa/{id}', 
    function(Request $request, Response $response, array $args) use ($banco)
 {
    $campos_obrigatórios = ['titulo', "descricao", 'status', "user_id"];
    $body = json_decode($request->getBody()->getContents(), true);

    try{
        $tarefa = new tarefa($banco->getConnection());
        $tarefa->id = $args['id'];
        $tarefa->titulo = $body['titulo'] ?? '';
        $tarefa->descricao = $body['descricao'] ?? '';
        $tarefa->status = $body['status'] ?? '';
        $tarefa->user_id = (isset($body['user_id']) && is_numeric($body['user_id'])) ? (int)$body['user_id'] : 0;
        foreach($campos_obrigatórios as $campo){
            if(empty($tarefa->{$campo})){
                throw new \Exception("o campo {$campo} é obrigatório");
            }
        }
        $tarefa->update();
    }catch(\Exception $exception){
         $response->getBody()->write(json_encode(['message' => $exception->getMessage() ]));
         return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    $response->getBody()->write(json_encode([
        'message' => 'Tarefa atualizada com sucesso!'
    ]));
    return $response->withHeader('Content-Type', 'application/json');
});

// deletando tarefa
$app->delete('/tarefa/{id}', 
    function(Request $request, Response $response, array $args) use ($banco)
 {
    $id = $args['id'];
    $tarefa = new tarefa($banco->getConnection());
    $tarefa->delete($id);
    $response->getBody()->write(json_encode(['message' => 'Tarefa excluída']));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();