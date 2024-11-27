<template>
    <div>
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <form class="d-flex">
                        <h2> Meu Perfil </h2>
                    </form>
                    <a href="/" class="ms-3">
                        <i class="fa-solid fa-house" style="font-size: 35px;"></i>
                    </a>
                </div>
            </nav>
        </div>
        <div class="container d-flex justify-content-center align-items-start min-vh-100">
            <div class="row w-100">
                <div class="col-md-4 mx-auto mb-4">
                    <div class="card text-center position-relative">
                        <div class="card-body">
                            <label for="profile-picture" class="d-block position-relative">
                                <img
                                    :src="profilePicture"
                                    alt="Foto do Usuário"
                                    class="img-fluid rounded-circle mb-3"
                                    style="max-width: 150px; cursor: pointer;"
                                    @click="triggerFileInput"
                                />
                                <i
                                    class="bi bi-camera position-absolute"
                                    style="top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 1.2rem; color: #fff; background-color: rgba(0, 0, 0, 0.5); padding: 10px; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"
                                ></i>
                            </label>
                            <input
                                id="profile-picture"
                                type="file"
                                accept="image/*"
                                class="d-none"
                                @change="handleFileChange"
                            />
                            <h5 class="card-title">{{ profileData.user?.name }}</h5>
                            <p class="card-text">
                                <strong>{{ profileData.recruiter?.company?.name }}</strong><br />
                                Localização: {{ profileData.recruiter?.company?.localization }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="position-relative">
                                <h5 class="card-title">Sobre</h5>
                                <i class="bi bi-pencil position-absolute" style="top: 5px; right: 10px; cursor: pointer;"></i>
                            </div>
                            <p>Email: {{ profileData.user?.email }}</p>
                            <hr />

                            <!-- Seção para Recrutadores -->
                            <div v-if="profileData.user?.type === 'recruiter'">
                                <div class="position-relative">
                                    <h5 class="card-title">Empresa</h5>
                                    <i class="bi bi-pencil position-absolute" style="top: 5px; right: 10px; cursor: pointer;"></i>
                                </div>
                                <p>Nome: {{ profileData.recruiter?.company?.name }}</p>
                                <p>CNPJ: {{ profileData.recruiter?.company?.CNPJ }}</p>
                                <p>Localização: {{ profileData.recruiter?.company?.localization }}</p>
                            </div>

                            <!-- Seção para Candidatos -->
                            <div v-if="profileData.user?.type === 'candidate'">
                                <div class="position-relative">
                                    <h5 class="card-title">Experiência</h5>
                                    <i class="bi bi-pencil position-absolute" style="top: 5px; right: 10px; cursor: pointer;"></i>
                                </div>
                                <p>Experiência: {{ profileData.candidate?.experience }}</p>
                                <hr />
                                <div class="position-relative">
                                    <h5 class="card-title">Educação</h5>
                                    <i class="bi bi-pencil position-absolute" style="top: 5px; right: 10px; cursor: pointer;"></i>
                                </div>
                                <p>Educação: {{ profileData.candidate?.education }}</p>
                            </div>

                            <hr />
                            <div class="position-relative">
                                <h5 class="card-title">Informações de Contato</h5>
                                <i class="bi bi-pencil position-absolute" style="top: 5px; right: 10px; cursor: pointer;"></i>
                            </div>
                            <p><strong>Email:</strong> {{ profileData.user?.email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { ShowRecrutadorVagas } from '@/services/JobServices';
    import { mapActions, mapGetters } from 'vuex';
    import { DeleteVagas } from '@/services/JobServices';
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
                currentPage: 1,
                jobsPerPage: 4,
                isDropdownOpen: false, 
                
            };
        },

        computed: {
            totalPages() {
                return Math.ceil(this.jobs.length / this.jobsPerPage);
            },
            paginatedJobs() {
                const start = (this.currentPage - 1) * this.jobsPerPage;
                const end = start + this.jobsPerPage;
                return this.jobs.slice(start, end);
            },

            ...mapGetters (['getUserId']),
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
            
            async GetJob() {
                const response = await ShowRecrutadorVagas();
                console.log('response', response);
                this.jobs = response.data.vaga;  
                
            },

            nextPage() {
                if (this.currentPage < this.totalPages) {
                    this.currentPage++;
                    this.GetJob();
                }
            },

            previousPage() {
                if (this.currentPage > 1) {
                    this.currentPage--;
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
                    this.showToast ("Erro ao Deletar vaga!", "error" )
                }
                
            },

            ...mapActions(['userlogout'])
        },

        created() {
            this.GetJob();
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
        background-color:#0056B3;
        
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
        color:#df0d0d;
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
    .btn-criar:hover{
        background-color: #0e8cc7;
    
    }
    .link{
        text-decoration: none;
        color: #fff;
    }


    .btn-editar{
        background-color: #e97a12;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s, transform 0.2s;
    }
    .btn-editar:hover{
        background-color: #f18a29;
        transform: scale(1.05);
    }
    #button-delet{
        background-color: #df0d0d;
    }
    .buttons{
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
</style>