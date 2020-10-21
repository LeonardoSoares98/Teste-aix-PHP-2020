<html>
<head>
    <title>Pagination</title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<ul class="pagination">
    <li><a href="http://192.168.0.111/leonardo/listagem_alunos.php">Listagem dos Alunos</a></li>
    <li class="">
        <a href="http://192.168.0.111/leonardo/alunos_controller.php">Cadastrar aluno</a>
    </li>
    <li class="">
        <a href="">Cadastrar curso</a>
    </li>
    <li><a href="">Importar cursos</a></li>
</ul>
<?php

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 5;
$offset = ($pageno-1) * $no_of_records_per_page;

$conn=mysqli_connect("srvdesenv","root","","teste");
// Check connection
if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
}

$total_pages_sql = "SELECT COUNT(*) FROM alunos";
$result = mysqli_query($conn,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

$sql = "SELECT * FROM alunos LIMIT $offset, $no_of_records_per_page";
$res_data = mysqli_query($conn,$sql);

?>
<div class="w3-container">
  <ul class="w3-ul w3-card-4">
    <?php
        while($row = mysqli_fetch_array($res_data)){

    ?>
    <li class="w3-bar">
      <span onclick="javascript:location.href='http://192.168.0.111/leonardo/alunos_controller.php?edit=<?php echo $row["id"]?>'" class="w3-bar-item w3-button w3-white w3-xlarge w3-right">✏️</span>
      <img src="uploads/<?php $row["img_aluno"]; if(trim($row["img_aluno"]) !== '') {echo $row["img_aluno"];}else{ echo "avatar.png";}?>"class="w3-bar-item w3-circle w3-hide-small" style="width:85px">
      <div class="w3-bar-item">
        <span class="w3-large"><?php echo "Nome: " . $row["nom_aluno"] ?></span><br>
        <span><?php echo "Código:" . $row["cod_aluno"]?></span>
      </div>
    </li>
      <?php
      }
      ?>
  </ul>
</div>
<?php
while($row = mysqli_fetch_array($res_data)){
    echo "<li>".trim($row["nom_aluno"]) . "</li>";
}
mysqli_close($conn);
?>
<ul class="pagination">
    <li><a href="?pageno=1">Primeira pág.</a></li>
    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
        <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Anterior</a>
    </li>
    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
        <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Próxima</a>
    </li>
    <li><a href="?pageno=<?php echo $total_pages; ?>">Ultima pág.</a></li>
</ul>
</body>
</html>