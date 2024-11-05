<template>
    <div class="container">
        <div class="form-container">
            <form @submit.prevent="handlePersonalInfoSubmit">
                <h1>Informações</h1>
                <span>digite suas Informações pessoais </span>
                <img src="../../public/img/jb.png">
                <div v-if="currentStep === 1">
                    <textarea type="text" placeholder="Experiências" v-model="experiences">
                    </textarea>
                </div>
                <div v-if="currentStep === 2">
                    <textarea type="text" placeholder="Habilidades" v-model="skills">
                    </textarea>
                </div>
                <div class="form-step" v-if="currentStep === 3">
                    <input type="text" placeholder="CEP" v-model="cep" />
                    <input type="text" placeholder="Número da Casa" v-model="house_number" />
                </div>
                <br><button type="button" @click="prevStep" :disabled="currentStep === 1">Voltar</button><br>
                <button type="button" @click="nextStep" v-if="currentStep < totalSteps">Avançar</button>
                <button type="submit" v-if="currentStep === totalSteps">Salvar</button>
            </form>
        </div>
        <div class="overlay">
        </div>
    </div>
</template>

<script>
export default {
    name: 'PersonalInfo',
    data() {
        return {
            currentStep: 1, 
            totalSteps: 3,  
            experiences: '',
            skills: '',
            cep: '',
            house_number: '',
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
        handlePersonalInfoSubmit() {
            console.log("Experiences:", this.experiences, "Skills:", this.skills, "CEP:", this.cep, "House Number:", this.house_number);
        },
    },
};
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
    margin-left: 8px;
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
    max-height: 98%;
}

.form-step {
    display: flex;
    flex-direction: column;
}

textarea{
    background-color: #eee;
    border: none;
    padding: 90px 35x;
    margin: 25px 10px;
    margin-left: 34px;
    height: 70px;
    align-content: center;
    position: center;
    resize: none;
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
    height: 100%;
    transition: all 0.6s ease-in-out;
    padding-left: 10%;
    max-width: 50%;
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
    background-image: url(../../public/img/Candidato.png);
    background-size: 770px;
    background-position: center ;
    left: -100%;
    position: absolute;
    background-repeat: no-repeat;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    z-index: 100;
}


</style>