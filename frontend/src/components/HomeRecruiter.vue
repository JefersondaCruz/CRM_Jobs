<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
        
            <form class="d-flex">
                <h2> Central de vagas</h2>
            <button class="btn-criar" type="submit" ><Router-link class="link"to="/FormsJobs">Criar nova vaga</Router-link></button>
            </form>
                <a href="/perfil" class="ms-3">
                <i class="fas fa-user-circle" style="font-size: 40px;"></i>
                </a>
        </div>
    </nav>
    
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
            <div v-for="job in jobs" :key="job.id" class="job-card">
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
                    <button class="btn-editar"><i class="fas fa-edit"></i></button>
                    <button class="btn-editar" id ="button-delet"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
        </div>
        </div>
    </template>
    <script>
    import { vagas } from '@/services/JobServices';
    
    export default {
        data() {
        return {
            searchQuery: '',
            selectedLocation: '',
            selectedType: '',
            selectedJob: null,
            jobs: []
        };
        },
        methods: {
        async GetJob() {
            const response = await vagas();
            console.log('response', response);
            this.jobs = response.data.vagas;  
        },
        viewJobDetails(jobs) {
            this.selectedJob = jobs; 
        },
        closeJobDetails() {
            this.selectedJob = null;
        },
        submitApplication() {
            alert(`Você se candidatou à vaga: ${this.selectedJob.title}`);
            this.selectedJob = null;
        }
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
</style>