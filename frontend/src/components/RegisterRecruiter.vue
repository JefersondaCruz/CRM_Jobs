<template>
    <div class="container">
        <div class="form-container">
            
            <form @submit.prevent="handlePersonalInfoSubmit">
                <h1>Informações</h1>
                <span>digite suas Informações pessoais </span>
                <img src="../../public/img/jb.png">

                <input type="text" placeholder="Nome Fantasia" v-model="nome_fantasia" />
                <input type="text" placeholder="CNPJ" v-model="cnpj" />
                <input type="text" placeholder="Localização" v-model="location" />
                <button type="submit">Salvar Informações</button>
            </form>
        </div>

        <div class="overlay">
        </div>
        
    </div>
</template><script>
export default {
    name: 'PersonalInfo',
    data() {
        return {
            nome_fantasia: '',
            cnpj: '',
            location: '',
        };
    },
    methods: {
        handlePersonalInfoSubmit() {
            console.log("nome_fantasia:", this.nome_fantasia, "cnpj:", this.cnpj, "location:", this.location);
        },
    },
};
</script><style scoped>

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
    background-color: #ff7e28;
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
    margin: 12px 0;
    width: 100%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.22);
}

.form-container {
    position: absolute;
    top: 0px;
    height: 80%;
    transition: all 0.6s ease-in-out;
    padding-left: 180px;
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

    