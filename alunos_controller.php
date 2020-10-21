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
    if ($_POST['action'] == 'Enviar') {
        if ($_POST['name'] != '' && $_POST['cod'] != '' && $_POST['situacao'] != '' && $_POST['cep'] != '' && $_POST['curso'] != '' && $_POST['turma'] != '' && $_POST['data'] != '') {

            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
            var_dump($_POST);
            var_dump($_GET);
            var_dump($_FILES);
            if(isset($_FILES["fileToUpload"]) && trim($_FILES["fileToUpload"]) !== '') {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check !== false) {

                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }


// Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }

// Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

// Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif") {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

// Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
                } else {
                    if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }

            if(isset($_GET['edit'])) {
                $sql = "UPDATE teste.alunos
                        SET cod_aluno=". $_POST['cod']. ", nom_aluno='". $_POST['name']. "', situacao_al=". $_POST['situacao']. ", cep_aluno=". $_POST['cep']. ", id_curso=". $_POST['curso']. ", turma=". $_POST['turma']. ", dat_matricula='". $_POST['data']. "', img_aluno='" . htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])) ."'
                        WHERE id=" . $_GET['edit']. ";
                        ";
            }else{
                $sql = "INSERT INTO teste.alunos
                    (cod_aluno, nom_aluno, situacao_al, cep_aluno, id_curso, turma, dat_matricula, img_aluno)
                    VALUES(" . $_POST['cod'] . ", '" . $_POST['name'] . "', " . $_POST['situacao'] . ", " . $_POST['cep'] . ", " . $_POST['curso'] . ", " . $_POST['turma'] . ", '" . $_POST['data'] . "', '" . htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])) ."');
                    ";
            }
            $res_data = mysqli_query($conn,$sql);
            if($res_data == true){
                echo  "<script>alert('Aluno inserido');</script>";
            } else {
                echo  "<script>alert('Erro, verifique os campos');</script>";
            }
        }
    } else if ($_POST['action'] == 'Excluir') {
        var_dump('aaa');
        if(isset($_GET['edit'])) {
            $sql = "DELETE FROM teste.alunos WHERE id=" . $_GET['edit'] . ";";
            $res_data = mysqli_query($conn, $sql);
            header('Location: http://192.168.0.111/leonardo/listagem_alunos.php');
        }else{
            echo  "<script>alert('Não há aluno para deletar');</script>";
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
        <h2>Inserir/ editar aluno</h2>
    </div>
    <form method="post" enctype="multipart/form-data" action="alunos_controller.php<?php if(isset($_GET['edit'])){ echo '?edit=' . $_GET['edit'];}?>" class="w3-container">
        <p>
            <label class="w3-text-black"><b>Nome</b></label>
            <input class="w3-input w3-border w3-white" name="name" type="text" value="<?php echo $row['nom_aluno'];?>"></p>
        <p>
            <label class="w3-text-black"><b>Código do aluno</b></label>
            <input class="w3-input w3-border w3-white" name="cod" type="text" value="<?php echo $row['cod_aluno'];?>"></p>

        <label class="w3-text-black"><b>Situação do Aluno</b></label>
        <select class="w3-select w3-border" name="situacao"">
            <option value="" disabled <?php if(!isset($_GET['edit'])){ echo 'selected';}?>>Selecione</option>
            <option value="1" <?php if($row['situacao'] == 1){ echo 'selected';}?>>Ativo</option>
            <option value="0" <?php if($row['situacao'] == 2){ echo 'selected';}?>>Inativo</option>
        </select>
        <p>
            <label class="w3-text-black"><b>CEP</b></label>
            <input class="w3-input w3-border w3-white" name="cep" type="text" value="<?php echo $row['cep_aluno'];?>"></p>
        <p>
            <label class="w3-text-black"><b>Curso</b></label>
            <input class="w3-input w3-border w3-white" name="curso" type="text" value="<?php echo $row['id_curso'];?>"></p>
        <p>
            <label class="w3-text-black"><b>Turma</b></label>
            <input class="w3-input w3-border w3-white" name="turma" type="text" value="<?php echo $row['turma'];?>"></p>
        <p>
            <label class="w3-text-black"><b>Data de matrícula</b></label>
            <input class="w3-input w3-border w3-white" name="data" type="date" value="<?php echo $row['dat_matricula'];?>"></p>
        <p>
            <label class="w3-text-black"><b>Data de matrícula</b></label>
            <input type="file" name="fileToUpload" id="fileToUpload">

        <p><input type="submit" name="action" value="Enviar" />
            <input type="submit" name="action" value="Excluir" /></p>
    </form>
</div>
</body>
</html>