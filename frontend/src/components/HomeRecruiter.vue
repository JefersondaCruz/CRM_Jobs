<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">

                <form class="d-flex">
                    <h2> Central de vagas</h2>
                    <button class="btn-criar" type="submit"><Router-link class="link" to="/FormsJobs">Criar nova
                            vaga</Router-link></button>
                </form>

                <div class="dropdown" @mouseenter="toggleDropdown(true)" @mouseleave="toggleDropdown(false)">
                    <i class="fas fa-user-circle dropdown-icon" style="font-size: 40px; cursor: pointer;"></i>
                    <ul class="dropdown-menu" :class="{ show: isDropdownOpen }">
                        <li><Router-link class="dropdown-item" :to="`/profile/${getUserId || ''}`">Meu
                                Perfil</Router-link></li>
                        <li><button class="dropdown-item" @click="logout">Sair</button></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Tem certeza de que deseja excluir esta vaga?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            @click="ConfirmDeleteVaga">Excluir</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">

            <div class="filters">
                <h3>Filtros</h3>
                <div class="filter-group">
                    <label for="location">Localização</label>
                    <select v-model="selectedLocation" id="location">
                        <option value="">Todos</option>
                        <option value="São Paulo">São Paulo</option>
                        <option value="Rio de Janeiro">Rio de Janeiro</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="type">Tipo de Vaga</label>
                    <select v-model="selectedType" id="type">
                        <option value="">Todos</option>
                        <option value="Tempo Integral">Tempo Integral</option>
                        <option value="Freelance">Freelance</option>
                    </select>
                </div>
            </div>

            <div class="job-list">
                <h3>Vagas de Empregos</h3>
                <div v-for="job in jobs" :key="job.id" class="job-card">
                    <h4>titulo: {{ job.title }}</h4>
                    <p>salario: {{ job.salaries }} - {{ job.type }}</p>
                    <p>descrição {{ job.description }}</p>
                    <button @click="viewJobDetails(job)">Vizualizar</button>
                </div>
            </div>

            <div class="details-section" v-if="selectedJob">
                <h3>
                    Detalhes da Vaga
                    <span class="fa-solid fa-xmark" @click="selectedJob = null"></span>
                </h3>
                <p><strong>Título:</strong> {{ selectedJob.title }}</p>
                <p><strong>Localização:</strong> {{ selectedJob.location }}</p>
                <p><strong>Salário:</strong> {{ selectedJob.salaries }}</p>
                <p><strong>Descrição:</strong> {{ selectedJob.description }}</p>

                <div class="buttons">
                    <button class="btn-editar"><Router-link class="link"
                            :to="{ name: 'EditForms', params: { id: selectedJob.id } }"><i
                                class="fas fa-edit"></i></Router-link></button>
                    <button class="btn-editar" id="button-delet" data-bs-toggle="modal"
                        data-bs-target="#confirmDeleteModal">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <button @click="loadCandidates" class="info-candidate" data-bs-toggle="modal"
                        data-bs-target="#candidateModal">candidatos</button>
                </div>
            </div>
        </div>

        <div class="pagination">
            <button @click="previousPage" :disabled="currentPage === 1">Anterior</button>
            <span>Página {{ currentPage }} de {{ totalPages }}</span>
            <button @click="nextPage" :disabled="currentPage === totalPages">Próxima</button>
        </div>

        <div class="modal fade" id="candidateModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h1 class="modal-title fs-5" id="candidateModal">Candidatos</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <div v-for="application in applications" :key="application.id" class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img :src="`http://127.0.0.1:8000/storage/${application.candidate.profile_picture}`" class="img-fluid profile-img"
                                        alt="Foto de perfil">
                                        <h4>
                                            nome do usuario
                                        </h4>
                                <div class="status-select">
                                    <label for="status">Status:</label>
                                    <select v-model="application.status" @change="updateStatus(application.id, application.status)">
                                        <option value="Pendente">Pendente</option>
                                        <option value="Aprovado">Aprovado</option>
                                        <option value="Rejeitado">Rejeitado</option>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Informações do Candidato</h5>
                                        <p class="card-text"><strong>Sobre:</strong> {{ application.candidate.about }}</p>
                                        <p class="card-text"><strong>Experiência:</strong> {{ application.candidate.experiences }}</p>
                                        <p class="card-text"><strong>Habilidades:</strong> {{ application.candidate.skills }}</p>
                                        <p class="card-text"><strong>Telefone:</strong> {{ application.candidate.phone }}</p>
                                        <p class="card-text"><strong>Redes Sociais:</strong> <a :href="application.candidate.social_media"
                                                target="_blank">{{  application.candidate.social_media }}</a></p>
                                        <p class="card-text"><strong>Endereço:</strong> CEP {{ application.candidate.CEP }}, Nº {{
                                            application.candidate.house_number }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="pagination d-flex justify-content-center align-items-center w-100">
                            <button @click="previousPageCandidate" :disabled="currentPageCandidate === 1" class="btn btn-primary mx-2">
                                Anterior
                            </button>
                            <span>Página {{ currentPageCandidate }} de {{ totalCandidatesPages }}</span>
                            <button @click="nextPageCandidate" :disabled="currentPageCandidate === totalCandidatesPages"
                                class="btn btn-primary mx-2">
                                Próxima
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { ShowRecrutadorVagas, DeleteVagas, getApplications, UpdateVagasStatus } from '@/services/JobServices';
import { mapActions, mapGetters } from 'vuex';
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";


export default {
    data() {
        return {
            searchQuery: '',
            selectedLocation: '',
            selectedType: '',
            selectedJob: null,
            selectedCandidate: null,
            jobs: [],
            candidates: [],
            currentPage: 1,
            jobsPerPage: 4,
            isDropdownOpen: false,
            currentPageCandidate: 1,
            candidatesPerPage: 1,
            applications: [],

        };
    },

    computed: {
        totalPages() {
            return Math.ceil(this.jobs.length / this.jobsPerPage);
        },
        totalCandidatesPages() {
            return Math.ceil(this.candidates.length / this.candidatesPerPage);
        },
        paginatedJobs() {
            const start = (this.currentPage - 1) * this.jobsPerPage;
            const end = start + this.jobsPerPage;
            return this.jobs.slice(start, end);
        },
        paginatedCandidate() {
            const start = (this.currentPageCandidate - 1) * this.candidatesPerPage;
            const end = start + this.candidatessPerPage;
            return this.candidates.slice(start, end);
        },


        ...mapGetters(['getUserId', 'getUser']),
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

        async updateStatus(id,status) {
            const response = await UpdateVagasStatus(id, status);
            this.showToast("Status da vaga atualizado", "success");
            console.log('response do update status', response);
            console.log('jobs', this.jobs);
        },

        async GetJob() {
            const response = await ShowRecrutadorVagas();   
            console.log('response do get job', response);
            this.jobs = response.data.vaga;
            console.log('jobs', this.jobs);

        },

        async getApplicationsData() {
            try {
                const response = await getApplications(this.getUserId);
                console.log('response applications', response);
                this.applications = response.applications;
                console.log('applications', this.applications);
            } catch (error) {
                console.error('Erro ao carregar candidaturas', error);
            }
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                
            }
        },
        nextPageCandidate() {
            if (this.currentPage < this.totalCandidatesPages) {
                this.currentPage++;
            }
        },

        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                
            }
        },
        previousPageCandidate() {
            if (this.currentPageCandidate > 1) {
                this.currentPageCandidate--;
                this.GetJob();
            }
        },

        viewJobDetails(jobs) {
            this.selectedJob = jobs;
        },


        closeJobDetails() {
            this.selectedJob = null;
        },

        toggleDropdown(status) {
            this.isDropdownOpen = status;

        },

        logout() {
            this.userlogout();
            this.showToast("Você saiu da conta!", "error");
            this.$router.push('/SignIn');
        },

        removeJob(jobId) {
            this.jobs = this.jobs.filter(job => job.id != jobId)
        },

        async ConfirmDeleteVaga() {
            try {
                const response = await DeleteVagas(this.selectedJob.id);
                this.removeJob(this.selectedJob.id)
                this.showToast("Vaga Deletada Com sucesso!", "error");
                this.closeJobDetails();
                console.log('response', response);
            } catch (error) {
                console.error("Erro ao deletar vaga:", error);
                this.showToast("Erro ao Deletar vaga!", "error")
            }

        },

        loadCandidates() {
            this.candidates = []
        },
        ...mapActions(['userlogout'])

    },
    
    created() {
        this.GetJob();
        this.getApplicationsData();
        console.log('user', this.getUser)
    }
};
</script>

<style scoped>
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

.title {
    text-align: center;
    margin-bottom: 20px;
}

.content {
    display: flex;

}

.filters {
    width: 200px;
    background-color: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin-right: 20px;
}

.job-list {
    flex: 1;
    background-color: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding-top: 20px;
}

.job-list h3 {
    margin: 0 0 15px;
}

.job-card {
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 15px;
    transition: background-color 0.3s;
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
    max-height: max-content;
    max-width: 900px;

}

.job-card:hover {
    background-color: #F0F0F0;
}

.job-card h4 {
    margin: 0;
}

.job-card button {
    padding: 10px;
    background-color: #136ecf;

    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.job-card button:hover {
    background-color: #0056B3;

}

.details-section {
    width: 300px;
    margin-left: 20px;
    background-color: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: relative;
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
    max-height: max-content;
    max-width: 900px;
    margin-top: 50px;
}

.details-section h3 {
    margin: 0 0 10px;
    margin: 0;
    padding-right: 30px;
}

.details-section .fa-xmark {
    font-size: 24px;
    color: #df0d0d;
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    transition: color 0.3s;
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

.btn-criar:hover {
    background-color: #0e8cc7;

}

.link {
    text-decoration: none;
    color: #fff;
}


.btn-editar {
    background-color: #e97a12;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s, transform 0.2s;
}

.btn-editar:hover {
    background-color: #f18a29;
    transform: scale(1.05);
}

#button-delet {
    background-color: #df0d0d;
}

.buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-top: 15px;
}

.info-candidate {
    background-color: #007bff;
    color: white;
    padding: 8px 11px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s, transform 0.2s;
}

.info-candidate:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

.custom-navbar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 1rem;
    background-color: #f8f9fa;
    border-bottom: 1px solid #e0e0e0;
}

.custom-navbar .container-fluid {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    justify-content: space-between;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.pagination button {
    padding: 5px 10px;
    margin: 0 5px;
    border: none;
    border-radius: 3px;
    background-color: #007bff;
    color: white;
    cursor: pointer;
    transition: background-color 0.2s;
}

.pagination button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.pagination span {
    margin: 0 10px;
    font-weight: bold;
}

.dropdown {
    position: relative;
}

.dropdown-menu {
    position: absolute;
    top: 42px;
    right: 0;
    display: none;
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    min-width: 150px;
}

.dropdown-menu.show {
    display: block;
}

.dropdown-menu .dropdown-item {
    padding: 10px 20px;
    color: #333;
    text-decoration: none;
    display: block;
    transition: background-color 0.2s;
    cursor: pointer;
}

.dropdown-menu .dropdown-item:hover {
    background-color: #f0f0f0;
}

#candidateModal {
    text-align: center;
}

#pageCandidate {
    text-align: center;
}

.profile-img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    display: block;
    margin: 30px 55px;
    border-radius: 50%;
}

.modal-header .btn-close {
    border: none;
    background-color: transparent;
    font-size: 20px;
    color: #df0d0d;
    cursor: pointer;
    transition: color 0.3s;
}

.modal-header .btn-close:hover {
    color: #ff4d4d;
}

.modal-content {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.modal-body {
    font-size: 1.1rem;
    color: #333;
}

.modal-footer {
    display: flex;
    justify-content: space-between;
}

modal-footer .btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.modal-footer .btn-secondary:hover {
    background-color: #5a6268;
}

.modal-footer .btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.modal-footer .btn-danger:hover {
    background-color: #c82333;
}

.modal-dialog {
    max-width: 500px;
    width: 100%;
}

.modal-header {
    background-color: #0e8cc7;
    color: white;
    padding: 15px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.modal-title {
    font-size: 1.5rem;
}


.fade {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.fade.show {
    opacity: 1;
}

.modal-dialog {
    max-width: 800px;
    margin: 30px auto;
}

.modal-content {
    padding: 20px;
    border-radius: 8px;
    background-color: #fff; 
}

.modal-header {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border-radius: 8px;
}

.modal-body {
    padding: 20px; 
    font-size: 16px; 
    line-height: 1.5; 
}

.modal-footer {
    padding: 10px 20px;
    text-align: right; 
}

.modal-footer button {
    margin-left: 10px;
}

.btn-close {
    font-size: 20px; 
    color: white;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-danger:hover {
    background-color: #c82333;
}

.status-select {
    margin-bottom: 20px;
    
    display: flex;
    flex-direction: column;
    gap: 5px;
}


.status-select label {
    font-size: 14px;
    color: #333;
    font-weight: bold;
    margin-bottom: 5px;
}


.status-select select {
    padding: 10px;
    margin-left: 20px;
    font-size: 14px;
    border-radius: 5px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    color: #333;
    outline: none;
    transition: all 0.3s ease;
}


.status-select select:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}


.status-select option {
    padding: 10px;
    font-size: 14px;
}
</style>