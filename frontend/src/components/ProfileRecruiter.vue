<template>
    <div>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <h2 class="navbar-brand">Meu Perfil Recrutador</h2>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                <a href="/home" class="nav-link d-flex align-items-center">
                    <i class="fa-solid fa-house" style="font-size: 25px;"></i> <!-- Ícone com tamanho ajustado -->
                    <span class="ms-2">Home</span>
                </a>
                </li>
            </ul>
            </div>
        </div>
        </nav>
    </div>
                <div class="container d-flex justify-content-center align-items-start min-vh-100">
                    <div class="row w-100">
                    <div class="col-md-4 mx-auto mb-4">
                        <div class="card text-center position-relative">
                        <div class="card-body">
                            <img
                                :src="profilePicture || 'http://127.0.0.1:8000/storage/Empresa.jpg'"
                                alt="Foto do Usuário"
                                class="img-fluid rounded-circle mb-3"
                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;"
                            />
                            <h5 class="card-title">{{ profileData.user?.name }}</h5>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-8 mx-auto">
                        <div class="card">
                        <div class="card-body">
                            <div class="position-relative">
                            <h5 class="card-title">Contato</h5>
                            </div>
                            <p>Email: {{ profileData.user?.email }}</p>
                            <hr />
                            <div v-if="profileData.user?.type === 'recruiter'">
                            <div class="position-relative">
                                <h5 class="card-title">Empresa</h5>
                            </div>
                            <p>Nome: {{ profileData.recruiter?.company?.name }}</p>
                            <p>CNPJ: {{ profileData.recruiter?.company?.CNPJ }}</p>
                            <p>Localização: {{ profileData.recruiter?.company?.localization }}</p>
                            </div>
                        </div>
                        <button 
                            data-bs-toggle="modal"
                            class="btn btn-primary"
                            data-bs-target="#candidateModal"
                        >
                            Atualizar Perfil
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="candidateModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Atualizar Perfil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateCompanyData">
                            <div class="mb-3">
                                <label for="experiences" class="form-label">Name</label>
                                <input 
                                    v-model="newName" 
                                    type="text" 
                                    id="name" 
                                    class="form-control"
                                    :placeholder="profileData.recruiter?.company?.name"
                                />
                            </div>
                            <div class="mb-3">
                                <label for="skills" class="form-label">Cnpj</label>
                                <input 
                                    v-model="newCnpj" 
                                    type="text" 
                                    id="cnpj" 
                                    class="form-control"
                                    :placeholder=" profileData.recruiter?.company?.CNPJ"
                                />
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Localização</label>
                                <input 
                                    v-model="Localization" 
                                    type="text" 
                                    id="localization" 
                                    class="form-control"
                                    :placeholder=" profileData.recruiter?.company?.localization"
                                />
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit"  class="btn btn-primary">Salvar Alterações</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { updateCompany } from "@/services/CompanyService";
import { GetProfile } from "../services/ProfileServices";
import { mapGetters, mapState, } from "vuex";
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";

export default {
data() {
    return {
        profileData: {},
    };
},
computed: {
    ...mapState([ "user"]),
    ...mapGetters(["getUserId"]),
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

async updateCompanyData() {
    const updateData = {
        name: this.newName || this.profileData.recruiter?.name,
        CNPJ: this.newCnpj || this.profileData.recruiter?.CNPJ,
        localization: this.Localization || this.profileData.recruiter?.localization,
    };
    try {
        const response = await updateCompany(updateData);
        console.log("Resposta da API após a atualização dos dados:", response);
        this.profileData.recruiter.name = this.newName || this.profileData.recruiter?.name;
        this.profileData.recruiter.CNPJ = this.newCnpj || this.profileData.recruiter?.CNPJ;
        this.profileData.recruiter.localization = this.Localization || this.profileData.recruiter?.localization;
        this.newName = '';
        this.newCnpj = '';
        this.Localization = '';
        this.showToast("Empresa atualizada com sucesso!", "success");
    } catch (error) {
        console.error("Erro ao atualizar empresa:", error);
    }
},

async GetProfileDatas() {
    try {
        const response = await GetProfile(this.getUserId);

        if (response && response.user) {
            this.profileData = response;
            console.log("Perfil carregado:", this.profileData);
        } else {
            console.error("Dados do perfil não encontrados na resposta da API:", response);
        }
    } catch (error) {
        console.error("Erro ao carregar o perfil:", error);
    }
},
},
mounted() {
    this.GetProfileDatas();
},
};
</script>

<style scoped>
.img-fluid {
    max-width: 100%;
    height: auto;
}

.rounded-circle {
    border-radius: 50%;
}

.mb-3 {
    margin-bottom: 1rem;
}

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
    background-color: #F5F7FA;
}

.container {
    max-width: 1500px;
    margin: auto;
    padding: 20px;
}

.fa-solid {
    padding-right: 20px;
    color: rgb(44, 42, 42);
}

.profile-img {
    width: 200px;
    height: 200px;
    object-fit: cover;
}
.nav bar {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
}

.navbar-brand {
    font-weight: bold;
    font-size: 1.75rem;
}

.navbar-nav .nav-item .nav-link {
    font-size: 1.1rem;
    color: #fff;
    transition: color 0.3s;
}

.navbar-nav .nav-item .nav-link:hover {
    color: rgba(80, 80, 244, 0.867); 
}

.navbar-toggler-icon {
    background-color: #fff;
}
</style>
