<template>
    <div class="container">
        <div class="form-container">
            <form @submit.prevent="handleSubmit">
                <h1>Entrar</h1>
                <span>use seu e-mail para fazer login</span><br>
                
                <input type="email" placeholder="Email" v-model="email" required />
                <input type="password" placeholder="Senha" v-model="password" required />

                <button type="submit">Entrar</button><br>
                Não tem uma conta?
                <router-link to="/SignUp">Cadastre-se</router-link>
            </form>
        </div>
        <div class="overlay"></div>
    </div>
</template>

<script>
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";
import { mapGetters } from "vuex";

export default {
    name: 'SignInForm',
    
    data() {
        return {
            email: '',
            password: '',
        };
    },
    computed: {
        ...mapGetters(['getUser']),
    },
    methods: {
        showToast(message, type = "success") {
            Toastify({
                text: message,
                duration: 5000,
                gravity: "top",
                position: "center",
                backgroundColor: type === "success" ? "green" : "red",
                close: true
            }).showToast();
        },
        async handleSubmit() {
            try {
                await this.$store.dispatch("Userlogin", {
                    email: this.email,
                    password: this.password
                });
                this.showToast("Bem vindo!");
                if (this.getUser?.type === "recruiter") {
                    this.$router.push("/home");
                }else{
                    this.$router.push("/");
                }
            } catch (error) {
                this.showToast("Erro ao fazer login. Senha ou email incorreto.", "error");
            }
        },
    }
}
</script>


<style scoped>
    body {
        background: #f6f5f7;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        font-family: 'Montserrat', sans-serif;
        height: 100vh;
        margin: -20px 0 50px;
    }

    h1 {
        font-weight: bold;
        margin: 0;
    }

    span {
        font-size: 12px;
    }

    button {
        border-radius: 20px;
        border: 1px solid #e97a12;
        background-color: #e97a12;
        color: #ffffff;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
    }

    button:active {
        transform: scale(0.95);
    }

    form {
        background-color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 50px;
        height: 100%;
        text-align: center;
    }

    input {
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
        padding-left: 160px;
    }

    .container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 
                0 10px 10px rgba(0,0,0,0.22);
        position: relative;
        max-width: 96%;
        height: 1000px;
        max-height: 760px;
        margin-top: 40px;
    }

    .overlay {
        background-image: url(../../public/img/logo.png);
        background-size: 800px;
        background-position: absolute ;
        left: -100%;
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        z-index: 100;
    }
</style>
