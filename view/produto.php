<?php
session_start();
include_once '../model/ProdutoDao.php';
include_once "../model/ClienteDao.php";
$nomeProduto = $_GET['nome'];
if ($nomeProduto == null) {
  header('location: produtos.php');
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
  <!-- CSS -->
  <meta name="robots" content="noindex,follow" />
  <link rel="stylesheet" href="css/styleDetalhe.css">
  <title><?= $nomeProduto ?></title>
  <link rel="icon" type="image/x-icon" href="img/logoMS.png">
</head>

<?php
if (!isset($_SESSION['id'])) {
  include_once("navs/navAlt.php");
} else {
  include_once("navs/navSairAlt.php");
}
?>

<body style="background: -webkit-linear-gradient(to left, rgb(153, 206, 255), rgb( 233, 243, 250));

background: linear-gradient(to left,rgb(153, 206, 255), rgb( 233, 243, 250));">

  <main class="container">


    <?php
    $clienteDao = new ClienteDao();
    if (!isset($_SESSION['id'])) {
      $linhasCli = $clienteDao->read(null);
      $taxa = "um valor minino";
      $frete = "Preços imperdiveis";
    } else {
      $linhasCli = $clienteDao->read($_SESSION['id']);
      foreach ($linhasCli as $linhaCli) {
        if ($linhaCli['plano_atual'] == "G") {
          $taxa = "14%";
          $frete = "Frete R$50";
        } elseif ($linhaCli['plano_atual'] == "P") {
          $taxa = "7%";
          $frete = "Frete Gratis";
        }
      }
    }

    $produtoDao = new ProdutoDao();
    $linhas = $produtoDao->read_prod_nome($nomeProduto);
    foreach ($linhas as $linha) {
    ?>

      <form action="../controller/pagamento.php" method="post">
        <section id="sec-4496">
          <!--imagem-->
          <Table>
            <tr>

              <!-- Left Column / Headphones Image -->
              <div class="left-column">
                <img alt="" style="width: 500px; height: 500px;" src="img/produtos/<?= $linha['imagem'] ?>">
              </div>

            </tr>
          </Table>
          <!--/imagem-->

          <div class="right-column">

            <!-- Product Description -->
            <div class="product-description">
              <h1><?= $nomeProduto ?></h1>
              <p><?= $linha['Descricao'] ?></p>
            </div>

            <!-- não mexer -->
            <input type="hidden" value="<?= $linha['idProduto'] ?>" name="idProduto">
            <input type="hidden" value="<?= $nomeProduto ?>" name="nomeProduto">
            <!-- /não mexer -->

            <!-- Product Configuration -->
            <div class="product-configuration">

              <!-- Cable Configuration -->
              <div class="cable-config">
                <span>Detalhes</span>

                <div class="cable-choose">

                  <p>Taxa adicional de <?= $taxa ?></p>
                  <p>Quantidade de itens por lote: <?= $linha['Quantidade'] ?></p>
                  <p>Tamanhos: <?= $linha['Tamanho'] ?></p>
                  <p>Lotes disponíveis: <?= $linha['Disponivel'] ?></p>

                  <label for="cxDisponivel">
                    Escolha quantos lotes deseja:
                  </label>
                  <input required min="1" max="<?= $linha['Disponivel'] ?>" type="number" name="quantidadeComprar" id="cxDisponivel">
                  <br>
                  <select required="" name="tipoEnvio" id="envio">
                    <option disabled="" selected="">Metodo de Envio...</option>
                    <option value="1">Sedex (Preços imperdiveis)</option>
                    <option value="2">Pac (Preços imperdiveis)</option>
                    <option value="3">JetLog (Preços imperdiveis)</option>
                    <option value="4">Retirada</option>
                  </select>

                </div>
              </div>

            </div>

            </br>

            <div class="product-price">
              <div style="margin-right: 20px;">
                <span>
                  <div>$<?= $linha['Preco'] ?></div>
                </span>

                <input type="hidden" value="<?= $linha['Preco'] ?>" name="precoLote">
              </div>

              <?php
              if (isset($_SESSION['id'])) {
              ?>
                <button class="cart-btn">
                  Comprar
                </button>

              <?php
              } else {
              ?>
                <a href="loginCli.php">Faça login</a>
              <?php
              }
              ?>

            </div>

          </div>
        </section>

      </form>

    <?php
    }
    ?>

  </main>

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" charset="utf-8"></script>
</body>

</html>