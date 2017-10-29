<?php
  class Cliente
  {
    private $nome;
    private $sexo;
    private $idade;
    private $salario;

    function __construct($nome, $sexo, $idade, $salario) {
      $this->setNome($nome)
        ->setSexo($sexo)
        ->setIdade($idade)
        ->setSalario($salario);
    }

    private function setNome($nome){
      if(empty($nome)) {
        throw new Exception("Nome não pode ser vazio.");
      }

      $this->nome = $nome;

      return $this;
    }

    private function setSexo($sexo){
      if(empty($sexo)) {
        throw new Exception("Sexo não pode ser vazio.");
      }

      if($sexo != 'masculino' && $sexo != 'feminino') {
        throw new Exception(sprintf("Sexo deve ser masculino ou feminino, fornecido %s", $sexo));
      }

      $this->sexo = $sexo;

      return $this;
    }

    private function setIdade($idade) {
      if(!is_numeric($idade)) {
        throw new Exception("A idade deve ser um número");
      }

      $this->idade = (int) $idade;

      return $this;
    }

    private function setSalario($salario) {
      if(!is_numeric($salario)) {
        throw new Exception("O salário deve ser um número");
      }

      $this->salario = (int) $salario;

      return $this;
    }

    public function getSexo() {
      return $this->sexo;
    }

    public function getSalario() {
      return $this->salario;
    }

    public function getIdade() {
      return $this->idade;
    }
  }

  class ClientesRepository
  {
    private $clientes = [];
    private $repositorio = null;

    function __construct($url) {
      $this->repositorio = $url;
    }

    public function adicionar(Cliente $cliente) {
      $this->clientes[] = $cliente;
    }

    public function listar() {
      return $this->clientes;
    }

    public function getTotalDeClientes() {
      return count($this->clientes);
    }

    public function importarDoTXT() {
      $arquivo = TXTHelper::ler($this->repositorio);
      $quantidadeDeLinhas = count($arquivo);

      for($indice = 0; $indice < $quantidadeDeLinhas; $indice = $indice + 4){
        $nomePosicao = $indice;
        $sexoPosicao = $indice + 1;
        $idadePosicao = $indice + 2;
        $salarioPosicao = $indice + 3;

        $cliente = new Cliente(
          $arquivo[$nomePosicao],
          $arquivo[$sexoPosicao],
          $arquivo[$idadePosicao],
          $arquivo[$salarioPosicao]
        );

        $this->adicionar($cliente);
      }
    }
  }

  class TXTHelper
  {
    private $path;
    static $TXTHelper = null;

    private function __construct($path) {
      if(!is_file($path)) {
        throw new Exception(sprintf("O arquivo %s não é um arquivo válido.", $path));
      }

      if(!is_readable($path)) {
        throw new Exception(sprint_f("Arquivo %s é inacessivel.", $path));
      }

      $this->path = $path;
    }

    public static function ler($path) {
      if(null === static::$TXTHelper) {
        static::$TXTHelper = new TXTHelper($path);
      }

      return static::$TXTHelper->lerArquivo();
    }

    private function lerArquivo() {
      $linhas = [];
      $arquivo = fopen($this->path, 'r');
      while (($linha = fgets($arquivo)) !== false) {
        $linhas[] = $this->limpaCaracteres($linha);
      }

      fclose($arquivo);
      return $linhas;
    }

    private function limpaCaracteres($linha) {
      return trim(preg_replace('/\s\s+/', ' ', $linha));
    }
  }

  class IndicadoresDosClientes
  {
    private $clientes;

    function __construct(ClientesRepository $clientes) {
      $this->clientes = $clientes;
    }

    // - A média de idade dos clientes;
    public function calcularMediaDeIdadeDosClientes() {
      $somaDasIdades = 0;

      foreach($this->clientes->listar() as $cliente) {
        $somaDasIdades += $cliente->getIdade();
      }

      return $somaDasIdades / $this->clientes->getTotalDeClientes();
    }

    // - A média de salário das mulheres;
    public function calcularMediaDeSalarioDosClientesMulheres() {
      $somaDosSalarios = 0;
      $qantidadeDeClientesMulheres = 0;

      foreach($this->clientes->listar() as $cliente) {
        if($cliente->getSexo() !== 'feminino') {
          continue;
        }
        $qantidadeDeClientesMulheres++;
        $somaDosSalarios += $cliente->getSalario();
      }

      return $somaDosSalarios / $qantidadeDeClientesMulheres;
    }

    // - Quantas pessoas acima de 25 anos possuem salários superiores a 5000 reais.
    public function calcularQuantasPessoasTemMaisDe25EGanhamMaisDe5000() {
      $quantidadeDeClientes = 0;
      foreach($this->clientes->listar() as $cliente) {
        if($cliente->getIdade() >= 25 && $cliente->getSalario() >= 5000) {
          continue;
        }

        $quantidadeDeClientes++;
      }

      return $quantidadeDeClientes;
    }
  }


  $clientes = new ClientesRepository('ex-2-clientes.txt');
  $clientes->importarDoTXT();

  $relatorio = new IndicadoresDosClientes($clientes);

  printf('\nA média da idade dos clientes é %f', $relatorio->calcularMediaDeIdadeDosClientes());
  printf('\nA média salarial dos clientes mulheres é %f', $relatorio->calcularMediaDeSalarioDosClientesMulheres());
  printf('\nA quantidade de clientes que tem mais de 25 anos e ganham mais de 5 mil é %d', $relatorio->calcularQuantasPessoasTemMaisDe25EGanhamMaisDe5000());
?>
