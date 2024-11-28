<template>
    <div class="container">
        <div class="form-container">
            
            <form @submit.prevent="handlePersonalInfoSubmit">
                <h1>Informações</h1>
                <span>Forneça as informações corporativas </span>
                <img src="../../public/img/jb.png">
                <div v-if="currentStep === 1">
                    <input type="text" placeholder="Nome Fantasia" v-model="name">
                </div>
                <div v-if="currentStep === 2">
                    <input type="text" placeholder="CNPJ" v-model="cnpj">
                </div>
                <div class="form-step" v-if="currentStep === 3">
                    <input type="text" placeholder="Localização" v-model="localization" />
                </div>
                <br><button type="button" @click="prevStep" v-if="currentStep > 1">Voltar</button><br>
                    <button type="button" @click="nextStep" v-if="currentStep < totalSteps">Avançar</button>
                    <button type="submit" v-if="currentStep === totalSteps">Salvar</button>
            </form>
        </div>

        <div class="overlay">
        </div>
        
    </div>
</template>
<script>
import { MakeCompany } from '../services/CompanyService';
export default {
    name: 'PersonalInfo',
    data() {
        return {
            currentStep: 1, 
            totalSteps: 3,  
            name: '',
            cnpj: '',
            localization: '',
        };
    },
    methods: {
        nextStep() {
            if (this.currentStep < this.totalSteps) {
                this.currentStep++;
            }
        },
        prevStep() {
            if (this.currentStep > 1) {
                this.currentStep--;
            }
        },
        async handlePersonalInfoSubmit() {
            try {
                const response = await MakeCompany(this.name, this.cnpj, this.localization);
                console.log(response);
                this.$router.push('/Home');
            } catch (error) {
                console.error("Erro ao cadastrar:", error);
                throw error;
            }
        }
    }
}
</script>

<style scoped>

    body {
        background: #F6F5F7;
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
        margin-top: 20px;
        border-radius: 20px;
        border: 1px solid #E97A12;
        background-color: #E97A12;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
    }

    button:hover {
        background-color: #f36d14;
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
    }

    input {
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 12px 0;
        width: 100%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.22);
    }

    .form-container {
        position: absolute;
        top: 0px;
        height: 80%;
        transition: all 0.6s ease-in-out;
        padding-left: 160px;
    }

    .container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.25),
        0 10px 10px rgba(0,0,0,0.22);
        position: relative;
        max-width: 96%;
        height: 1000px;
        max-height: 760px;
        margin-top: 40px;
    }

    .overlay {
        background-image: url(../../public/img/recrutadorCap.PNG);
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

    .footer {
        margin-top: 20px;
        text-align: center;
    }
</style>

    