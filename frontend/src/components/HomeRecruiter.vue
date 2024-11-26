<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
            
                <form class="d-flex">
                    <h2> Central de vagas</h2>
                <button class="btn-criar" type="submit" ><Router-link class="link" to="/FormsJobs">Criar nova vaga</Router-link></button>
                </form>
                
                <div class="dropdown" @mouseenter="toggleDropdown(true)" @mouseleave="toggleDropdown(false)">
                    <i class="fas fa-user-circle dropdown-icon" style="font-size: 40px; cursor: pointer;"></i>
                    <ul class="dropdown-menu" :class="{ show: isDropdownOpen }">
                        <li><Router-link class="dropdown-item" :to="`/profile/${getUserId || ''}`">Meu Perfil</Router-link></li>
                        <li><button class="dropdown-item" @click="logout">Sair</button></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
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
                        <button type="button" class="btn btn-danger" @click="ConfirmDeleteVaga">Excluir</button>
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
                <h3>Vagas de Emprego</h3>
                <div v-for="job in paginatedJobs" :key="job.id" class="job-card">
                    <h4>{{ job.title }}</h4>
                    <p>{{ job.salaries }} - {{ job.type }}</p>
                    <p>{{ job.description }}</p>
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
                    <button class="btn-editar"><Router-link class="link" :to="{ name: 'EditForms', params: { id: selectedJob.id } }" ><i class="fas fa-edit"></i></Router-link> Editar</button>
                    <button class="btn-editar" id ="button-delet" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                        <i class="fas fa-trash-alt"></i>
                </button>
                    <button @click="viewCandidatesJob(Candidates)" class="info-candidate">candidatos</button>
                </div>
            </div>
            <div class="modal" tabindex="-1" v-if="selectedCandidate">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Modal body text goes here.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>      
        </div>
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-danger" @click="confirmDelete">Excluir</button>
                </div>
                </div>
            </div>
        </div>

            <div class="pagination">
                <button @click="previousPage" :disabled="currentPage === 1">Anterior</button>
                <span>Página {{ currentPage }} de {{ totalPages }}</span>
                <button @click="nextPage" :disabled="currentPage === totalPages">Próxima</button>
            </div>
    </div>

</template>

<script>
    import { ShowRecrutadorVagas } from '@/services/JobServices';
    import { mapActions, mapGetters } from 'vuex';
import { Transition } from 'vue';
import { DeleteVagas } from '@/services/JobServices';
    
    export default {
        data() {
            return {
                searchQuery: '',
                selectedLocation: '',
                selectedType: '',
                selectedJob: null,
                jobs: [],
                Candidates: [],
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
            viewCandidatesJob(Candidates) {
                this.selectedCandidate = Candidates; 
            },
            closeJobDetails() {
            this.selectedJob = null;
            },
            toggleDropdown(status) {
                this.isDropdownOpen = status;
                
            },
            logout() {
                this.userlogout();
                alert("Você saiu da conta!");
                this.$router.push('/SignIn');
            },

            async ConfirmDeleteVaga() {
                try {
                    const response = await DeleteVagas(this.selectedJob.id);
                    alert("Vaga deletada com sucesso!");
                    console.log('response', response);
                    this.$router.push('/Home');
                } catch (error) {
                    console.error("Erro ao deletar vaga:", error);
                    alert("Erro ao deletar vaga!");
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