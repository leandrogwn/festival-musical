<?php
include("../../conectaMysqlOO.php");

class editarInscricao
{

    private $dadosForm;
    private $id;
    private $nome;
    private $nascimento;
    private $rg;
    private $cpf;
    private $telefone;
    private $celular;
    private $email;
    private $informacoes_interprete;
    private $cep;
    private $uf;
    private $rua;
    private $numero;
    private $bairro;
    private $cidade;
    private $categoria;
    private $cancao;
    private $compositor;
    private $gravado_por;
    private $link;
    private $informacao_cancao;
    private $letra;
    private $sql;
    private $tela;

    public function __construct()
    {
        $this->recebeDados();
        $this->gravaDados();
    }

    private function recebeDados()
    {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->id = $this->dadosForm["id"];
        $this->nome = $this->dadosForm["nome"];
        $this->nascimento = $this->dadosForm["nascimento"];
        $this->rg = $this->dadosForm["rg"];
        $this->cpf = $this->dadosForm["cpf"];
        $this->telefone = $this->dadosForm["telefone"];
        $this->celular = $this->dadosForm["celular"];
        $this->email = $this->dadosForm["email"];
        $this->informacoes_interprete = $this->dadosForm["informacao_interprete"];
        $this->cep = $this->dadosForm["cep"];
        $this->uf = $this->dadosForm["uf"];
        $this->rua = $this->dadosForm["rua"];
        $this->numero = $this->dadosForm["numero"];
        $this->bairro = $this->dadosForm["bairro"];
        $this->cidade = $this->dadosForm["cidade"];
        $this->categoria = $this->dadosForm["categoria"];
        $this->cancao = $this->dadosForm["cancao"];
        $this->compositor = $this->dadosForm["compositor"];
        $this->gravado_por = $this->dadosForm["gravado_por"];
        $this->link = $this->dadosForm["link"];
        $this->informacao_cancao = $this->dadosForm["informacao_cancao"];
        $this->letra = $this->dadosForm["letra"];
        $this->tela = $this->dadosForm["tela"];
    }

    private function gravaDados()
    {
        $ObjConecta = new conectaMysql();
        $this->sql = "UPDATE f_inscricao SET nome = :nome,
        nascimento = :nascimento,
        rg = :rg,
        cpf = :cpf,
        telefone = :telefone,
        celular = :celular,
        email = :email,
        informacoes_interprete = :informacoes_interprete,
        cep = :cep,
        uf = :uf,
        rua = :rua,
        numero = :numero,
        bairro = :bairro,
        cidade = :cidade,
        categoria = :categoria,
        cancao = :cancao,
        compositor = :compositor,
        gravado_por = :gravado_por,
        link = :link,
        informacao_cancao = :informacao_cancao,
        letra = :letra WHERE id = :id";

        $params = array(
            ':nome' => $this->nome,
            ':nascimento' => $this->nascimento,
            ':rg' => $this->rg,
            ':cpf' => $this->cpf,
            ':telefone' => $this->telefone,
            ':celular' => $this->celular,
            ':email' => $this->email,
            ':informacoes_interprete' => $this->informacoes_interprete, 
            ':cep' => $this->cep,
            ':uf' => $this->uf,
            ':rua' => $this->rua,
            ':numero' => $this->numero, 
            ':bairro' => $this->bairro,
            ':cidade' => $this->cidade, 
            ':categoria' => $this->categoria,
            ':cancao' => $this->cancao, 
            ':compositor' => $this->compositor,
            ':gravado_por' => $this->gravado_por,   
            ':link' => $this->link,
            ':informacao_cancao' => $this->informacao_cancao,
            ':letra' => $this->letra,
            ':id' => $this->id
        );

        $ObjConecta->updateDBLiberacao($this->sql, $this->tela, $params, "../tab/inscritos.php");
    }

}

$ObjInscricaoFestival = new editarInscricao();