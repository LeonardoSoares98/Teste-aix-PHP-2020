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
<script>
    function html_alert(msg) {
        alert(msg);
    }
</script>
<ul class="pagination">
    <li><a href="http://192.168.0.111/leonardo/listagem_alunos.php">Listagem dos Alunos</a></li>
    <li class="">
        <a href="http://192.168.0.111/leonardo/alunos_controller.php">Cadastrar aluno</a>
    </li>
    <li class="">
        <a href="http://192.168.0.111/leonardo/cursos_controller.php">Cadastrar curso</a>
    </li>
    <li><a href="">Importar cursos</a></li>
</ul>
<?php
$conn=mysqli_connect("srvdesenv","root","","teste");
// Check connection
if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
}
if(isset($_POST)) {
    if ($_POST['name'] != '' && $_POST['cod'] != '' && $_POST['situacao'] != '' && $_POST['cep'] != '' && $_POST['curso'] != '' && $_POST['turma'] != '' && $_POST['data'] != '') {
        if(isset($_GET['edit'])) {
            $sql = "UPDATE teste.alunos
                    SET cod_aluno=". $_POST['cod']. ", nom_aluno='". $_POST['name']. "', situacao_al=". $_POST['situacao']. ", cep_aluno=". $_POST['cep']. ", id_curso=". $_POST['curso']. ", turma=". $_POST['turma']. ", dat_matricula='". $_POST['data']. "', img_aluno=''
                    WHERE id=" . $_GET['edit']. ";
                    ";
        }else{
            $sql = "INSERT INTO teste.alunos
                (cod_aluno, nom_aluno, situacao_al, cep_aluno, id_curso, turma, dat_matricula, img_aluno)
                VALUES(" . $_POST['cod'] . ", '" . $_POST['name'] . "', " . $_POST['situacao'] . ", " . $_POST['cep'] . ", " . $_POST['curso'] . ", " . $_POST['turma'] . ", '" . $_POST['data'] . "', '');
                ";
        }
        $res_data = mysqli_query($conn,$sql);
        if($res_data == true){
            echo  "<script>alert('Aluno inserido');</script>";
        } else {
            echo  "<script>alert('Erro, verifique os campos');</script>";
        }
    }
}
if(isset($_GET)) {
    if(isset($_GET['edit'])){
        $sql = "SELECT * FROM teste.alunos WHERE id = " . $_GET['edit'];
        $res_data = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($res_data);
    }
}
mysqli_close($conn);
?>
<div class="w3-card-4">
    <div class="w3-container w3-blue">
        <h2>Inserir curso</h2>
    </div>
    <form action="cursos_controller.php<?php if(isset($_GET['edit'])){ echo '?edit=' . $_GET['edit'];}?>" method="post" class="w3-container">
        <p>
            <label class="w3-text-black"><b>Nome</b></label>
            <input class="w3-input w3-border w3-white" name="name" type="text" value="<?php echo $row['nom_curso'];?>"></p>
        <p>
        <p><input type="submit" /></p>
    </form>
</div>
</body>
</html>