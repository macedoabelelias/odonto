<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Painel - Odonto</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    background:#f4f6f9;
}

.wrapper{
    display:flex;
}

.sidebar{
    width:240px;
    min-height:100vh;
    background:linear-gradient(180deg,#4f46e5,#6366f1);
    color:#fff;
    padding-top:20px;
}

.sidebar h4{
    text-align:center;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    padding:12px 25px;
    color:#fff;
    text-decoration:none;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.1);
}

.main{
    flex:1;
}

.navbar-top{
    background:#fff;
    padding:15px 25px;
    border-bottom:1px solid #ddd;
    display:flex;
    justify-content:space-between;
}

.content{
    padding:30px;
}
</style>
</head>

<body>

<div class="wrapper">