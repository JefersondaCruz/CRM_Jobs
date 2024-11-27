<template>
    <div>
        <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
            <form class="d-flex">
            <h2>Cadastro de Candidato</h2>
            </form>
            <a href="/" class="ms-3">
                <i class="fa-solid fa-house" style="font-size: 35px;"></i>
            </a>
        </div>
        </nav>
    </div>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row w-100">
        <div class="col-md-8 mx-auto">
            <div class="card">
            <div class="card-body">
                <div class="position-relative mb-4">
                <h5 class="card-title text-center">Informações do Candidato</h5>
                </div>

                <div>
                <textarea
                    placeholder="Experiência"
                    v-model="experiences"
                    class="form-control mb-3"
                    rows="4"
                ></textarea>
                <textarea
                    placeholder="Habilidades"
                    v-model="skills"
                    class="form-control mb-3"
                    rows="4"
                ></textarea>
                <input
                    type="text"
                    placeholder="Telefone"
                    v-model="phone"
                    class="form-control mb-3"
                />
                <input
                    type="text"
                    placeholder="Redes Sociais (LinkedIn, GitHub)"
                    v-model="social_media"
                    class="form-control mb-3"
                />
                <input
                    type="text"
                    placeholder="CEP"
                    v-model="cep"
                    class="form-control mb-3"
                />
                <input
                    type="text"
                    placeholder="Número da Casa"
                    v-model="house_number"
                    class="form-control mb-3"
                />
                </div>

                <div class="d-flex justify-content-end mt-3">
                <button
                    type="submit"
                    @click="handleRegistrationSubmit"
                    class="btn btn-success"
                >
                    Salvar
                </button>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</template>

<script>
import { MakeCandidate } from "@/services/CandidateServices"; 

export default {
    name: "UserRegistration",
    data() {
        return {
        experiences: '',
        skills: '',
        phone: '',
        social_media: '',
        cep: '',
        house_number: '',
        };
    },
    methods: {
        async handleRegistrationSubmit() {
        try {
            const response = await MakeCandidate(this.experiences, this.skills, this.phone, this.social_media, this.cep, this.house_number);
            console.log("Cadastro realizado:", response);
            this.$router.push("/");
        } catch (error) {
            console.error("Erro ao cadastrar usuário:", error);
        }
    },
    },
};
</script>

<style scoped>
.container {
    padding-top: 20px;
}

.card-body i {
    transition: all 0.3s ease;
}

.card-body i:hover {
    color: #007bff;
}

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f7fa;
}

.container {
    max-width: 1500px;
    margin: auto;
    padding: 20px;
}

.form-control {
    width: 100%;
}

button {
    border-radius: 20px;
    padding: 12px 45px;
    font-size: 12px;
    font-weight: bold;
    transition: transform 80ms ease-in;
}

button:hover {
    background-color: #ff7e28;
}

.card {
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.card-body {
    padding: 30px;
}

.card-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
}

textarea {
    resize: vertical; /* Permite redimensionar verticalmente */
}
</style>
