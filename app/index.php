<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Cadastro - Microsserviços</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 600px;
            width: 100%;
        }
        h1 { 
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        .info-item {
            margin: 8px 0;
            display: flex;
            justify-content: space-between;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .value {
            color: #333;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            border-left: 4px solid #28a745;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            border-left: 4px solid #dc3545;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🐳 Sistema de Microsserviços</h1>
        <p class="subtitle">Demonstração de Docker + Load Balancing + MySQL</p>

<?php
// Configuração de erros
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Função para sanitizar output
function sanitize($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Configuração do banco via variáveis de ambiente
$db_host = getenv('DB_HOST') ?: 'db';
$db_user = getenv('DB_USER') ?: 'appuser';
$db_password = getenv('DB_PASSWORD') ?: 'AppSenha123';
$db_name = getenv('DB_NAME') ?: 'meubanco';

// Informações do sistema
$php_version = phpversion();
$hostname = gethostname();

echo '<div class="info-box">';
echo '<div class="info-item"><span class="label">Versão PHP:</span> <span class="value">' . sanitize($php_version) . '</span></div>';
echo '<div class="info-item"><span class="label">Container:</span> <span class="value">' . sanitize($hostname) . '</span></div>';
echo '<div class="info-item"><span class="label">Servidor DB:</span> <span class="value">' . sanitize($db_host) . '</span></div>';
echo '</div>';

try {
    // Conexão com o banco usando variáveis de ambiente
    $link = new mysqli($db_host, $db_user, $db_password, $db_name);
    
    // Verifica conexão
    if ($link->connect_errno) {
        throw new Exception("Falha na conexão: " . $link->connect_error);
    }
    
    // Define charset
    $link->set_charset("utf8mb4");
    
    // Gera dados aleatórios
    $valor_rand1 = rand(1, 999);
    $valor_rand2 = strtoupper(substr(bin2hex(random_bytes(4)), 1));
    
    // Prepared Statement para prevenir SQL Injection
    $stmt = $link->prepare(
        "INSERT INTO dados (AlunoID, Nome, Sobrenome, Endereco, Cidade, Host) 
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    
    if (!$stmt) {
        throw new Exception("Erro ao preparar query: " . $link->error);
    }
    
    // Bind dos parâmetros
    $stmt->bind_param(
        "isssss", 
        $valor_rand1, 
        $valor_rand2, 
        $valor_rand2, 
        $valor_rand2, 
        $valor_rand2, 
        $hostname
    );
    
    // Executa a query
    if ($stmt->execute()) {
        echo '<div class="success">';
        echo '<strong>✓ Sucesso!</strong><br>';
        echo 'Registro criado com sucesso!<br><br>';
        echo '<div class="info-item"><span class="label">ID do Aluno:</span> <span class="value">' . sanitize($valor_rand1) . '</span></div>';
        echo '<div class="info-item"><span class="label">Nome Gerado:</span> <span class="value">' . sanitize($valor_rand2) . '</span></div>';
        echo '<div class="info-item"><span class="label">Processado por:</span> <span class="value">' . sanitize($hostname) . '</span></div>';
        echo '</div>';
        
        // Busca total de registros
        $result = $link->query("SELECT COUNT(*) as total FROM dados");
        if ($result) {
            $row = $result->fetch_assoc();
            echo '<div class="info-box" style="margin-top: 20px;">';
            echo '<div class="info-item"><span class="label">Total de Registros:</span> <span class="value">' . $row['total'] . '</span></div>';
            echo '</div>';
        }
    } else {
        throw new Exception("Erro ao executar query: " . $stmt->error);
    }
    
    // Fecha statement e conexão
    $stmt->close();
    $link->close();
    
} catch (Exception $e) {
    echo '<div class="error">';
    echo '<strong>✗ Erro:</strong><br>';
    echo sanitize($e->getMessage());
    echo '</div>';
}
?>

        <div class="footer">
            <p>🚀 Projeto evoluído para demonstração de microsserviços com Docker</p>
            <p>Load Balancing • Multiple Instances • Health Checks</p>
        </div>
    </div>
</body>
</html>
