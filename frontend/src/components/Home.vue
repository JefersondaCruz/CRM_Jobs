<template>
  <div class="container">
    <nav class="custom-navbar">
      <div class="container-fluid">
        <form class="d-flex" role="search">
          <input class="form-control me-2" @click="searchJobs" type="search" placeholder="Pesquise por vagas" aria-label="Search">
          <button class="btn-busca" type="submit">buscar</button>
        </form>
        <div>
          <div v-if="loggedIn" class="dropdown" @mouseenter="toggleDropdown(true)" @mouseleave="toggleDropdown(false)">
                    <i class="fas fa-user-circle dropdown-icon" style="font-size: 40px; cursor: pointer;"></i>
                    <ul class="dropdown-menu" :class="{ show: isDropdownOpen }">
                        <li><Router-link class="dropdown-item" to="/perfil">Perfil</Router-link></li>
                        <li><button class="dropdown-item" @click="logout">Sair</button></li>
                    </ul>
                </div>

        <div v-else class="user-actions">
          <a href="/SignIn" class="ms-3">
              <i class="fas fa-user-circle" style="font-size: 40px;"></i>
          </a>
            </div>
          </div>
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
        <div v-for="job in paginatedJobs" :key="job.id" class="job-card">
          <h4>{{ job.title }}</h4>
          <p>{{ job.salaries }} - {{ job.type }}</p>
          <p>{{ job.description }}</p>
          <button @click="viewJobDetails(job)">Mais Detalhes</button>
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
        <button 
          v-if="loggedIn"
          @click="submitApplication"
          >
            Candidatar-se
        </button>
        <button 
          v-else
          @click="$router.push('/SignUp')"
          >
            Fazer login para se candidatar
        </button>
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
  import { mapGetters } from 'vuex';
  import { vagas } from '@/services/JobServices';
  import { ApplyToJob } from '@/services/CandidateServices';
  import Toastify from "toastify-js";
  import "toastify-js/src/toastify.css";
export default {
  data() {
    return {
      searchQuery: '',
      selectedLocation: '',
      selectedType: '',
      selectedJob: null,
      allJobs: [],
      currentPage: 1,
      jobsPerPage: 4,
      isDropdownOpen: false, 
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.allJobs.length / this.jobsPerPage);
    },
    paginatedJobs() {
      const start = (this.currentPage - 1) * this.jobsPerPage;
      const end = start + this.jobsPerPage;
      return this.allJobs.slice(start, end);
    },
    ...mapGetters (['loggedIn']),
  },
  methods: {
    showToast(message, type = "success") {
            if(type === "error") {
                Toastify({
                    text: message,
                    duration: 5000,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "red",
                    close: true
                }).showToast();
            } else 
            Toastify({
                text: message,
                duration: 5000,
                gravity: "top",
                position: "center",
                backgroundColor: "green",
                close: true
            }).showToast();
        },
    async GetJob() {
      const response = await vagas();
      this.allJobs = response.data.vagas;
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
    viewJobDetails(job) {
      this.selectedJob = job;
    },
    closeJobDetails() {
      this.selectedJob = null;
    },
    async submitApplication() {
      if (!this.loggedIn) {
            this.$router.push('/SignUp');
            return;
        }
        try {
            const response = await ApplyToJob(this.selectedJob.id);
            console.log('response', response);
            this.showToast("Você se candidatou com sucesso à vaga!");
            this.$router.push('/');
            this.selectedJob = null;
        } catch (error) {
            console.error("Erro ao cadastrar vaga:", error);
            if (error.response && error.response.data.message === "Você já aplicou para esta vaga") {
              this.showToast("Você já se candidatou a esta vaga!", "error");
            } else {
              this.showToast("Erro ao se candidatar à vaga.", "error");
            }
            throw error;
        }
    },
    toggleDropdown(status) {
      this.isDropdownOpen = status;
                
    },
  },
  created() {
    this.GetJob();
  },
  toggleDropdown() {
      this.showDropdown = !this.showDropdown;
    },
    goToProfile() {
      this.$router.push('/perfil');
    },
    logout() {
      this.LoggedIn = false;
      this.$router.push('/SignIn');
    },

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

  .details-section button {
    background-color: #e97a12;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s, transform 0.2s;
  }
  .details-section button:hover {
    background-color: #f18a29;
    transform: scale(1.05);
  }
  .btn-busca {
    color: #e97a12;
    border: 1px solid #e97a12;
    border-radius: 0.25rem;
    display: inline-block;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    background-color: transparent;
    cursor: pointer;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out;
  }

  .btn-busca:hover{
    background-color: #e97a12;
    color: #fff;
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