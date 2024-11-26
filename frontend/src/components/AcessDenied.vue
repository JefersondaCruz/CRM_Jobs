<template>
    <div class="access-denied">
        <h1>Acesso Negado</h1>
        <p>Você não tem permissão para acessar esta página.</p>
        <p>Se acha que isso é um erro, entre em contato com o suporte ou <router-link to="/">volte para a página inicial</router-link>.</p>
    </div>
</template>

<script>
export default {
    name: 'AccessDenied',
};
</script>

<style scoped>
.access-denied {
    text-align: center;
    padding: 50px;
}
</style>