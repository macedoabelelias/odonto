<form method="POST" enctype="multipart/form-data">
    <input type="file" name="icone_upload">
    <button type="submit">Enviar</button>
</form>

<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    echo "<pre>";
    var_dump($_FILES);
}
?>