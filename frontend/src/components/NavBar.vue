<template>
<div class="container">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
    
        <form class="d-flex">
            <h2> Central de vagas</h2>
        <button class="btn-criar" type="submit" ><Router-link class="link" to="/FormsJobs">Criar nova vaga</Router-link></button>
        </form>
            <a href="/perfil" class="ms-3">
            <i class="fas fa-user-circle" style="font-size: 40px;"></i>
            </a>
        </div>
    </nav>
</div>

</template>

<style>
body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #F5F7FA;
    }
    .container {
        max-width: 1500px;
        margin: auto;
        padding: 20px;
    }
    .btn-criar {
        background-color: #0e8cc7;
        border: 1px solid #0e8cc7;
        border-radius: 0.25rem;
        display: inline-block;
        margin-left: 780px;
        font-size: 1rem;
        font-weight: 400;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .btn-criar:hover{
        background-color: #0e8cc7;
    
    }
    .link{
        text-decoration: none;
        color: #fff;
    }
</style>
