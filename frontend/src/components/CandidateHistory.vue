<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <form class="d-flex">
                    <h2>Histórico de Candidaturas</h2>
                </form>
                <div class="dropdown" @mouseenter="toggleDropdown(true)" @mouseleave="toggleDropdown(false)">
                    <i class="fas fa-user-circle dropdown-icon" style="font-size: 40px; cursor: pointer;"></i>
                    <ul class="dropdown-menu" :class="{ show: isDropdownOpen }">
                        <li><Router-link class="dropdown-item" :to="`/profile/${getUserId || ''}`">Perfil</Router-link></li>
                        <li><Router-link class="dropdown-item" to="/">home</Router-link></li>
                        <li><button class="dropdown-item" @click="logout">Sair</button></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="content">
            <div class="filters">
                <h3>Filtros</h3>
                <div class="filter-group">
                    <label for="status">Status</label>
                    <select v-model="selectedStatus" id="status">
                        <option value="">Todos</option>
                        <option value="Aprovado">Aprovado</option>
                        <option value="Rejeitado">Rejeitado</option>
                        <option value="Pendente">Pendente</option>
                    </select>
                </div>
            </div>

            <div class="candidatura-list">
                <h3>Candidaturas</h3>
                <div v-if="paginatedCandidaturas && paginatedCandidaturas.length === 0">
                    <p>Nenhuma candidatura encontrada.</p>
                </div>
                <div v-for="candidatura in paginatedCandidaturas" :key="candidatura.id" class="candidatura-card">
                    {{ console.log("Candidatura exibida:", candidatura) }}
                    <h4>Vaga: {{ candidatura.job_opening.title }}</h4>
                    <p>Status: 
                        <span>{{ candidatura.status }}</span>
                        <span
                            class="status-indicator" 
                            :style="getStatusColor(candidatura.status)">
                        </span>

                    </p>
                    <p>Candidatura realizada em: {{ new Date(candidatura.created_at).toLocaleDateString() }}</p>
                    <button class = "details" @click="viewCandidaturaDetails(candidatura)">Ver detalhes</button>
                </div>
            </div>

            <div class="details-section" v-if="selectedCandidatura">
                <h3>
                    Detalhes da Candidatura
                    <span class="fa-solid fa-xmark" @click="selectedCandidatura = null"></span>
                </h3>
                <p><strong>Vaga:</strong> {{ selectedCandidatura.job_opening.title }}</p>
                <p><strong>Status:</strong> {{ selectedCandidatura.status }}</p>
                <p><strong>Data de Candidatura:</strong> {{ new Date(selectedCandidatura.created_at).toLocaleDateString() }}</p>
                <p><strong>Descrição:</strong> {{ selectedCandidatura.job_opening.description }}</p>
                <p><strong>Categoria:</strong> {{ selectedCandidatura.job_opening.categories }}</p>
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
    import { mapActions, mapGetters } from 'vuex';
    import { getApplications } from '@/services/CandidateServices';
    import Toastify from "toastify-js";
    import "toastify-js/src/toastify.css";
export default {
    
    data() {
        return {
            selectedStatus: '',
            selectedCandidatura: null,
            candidaturas: [],
            currentPage: 1,
            candidaturasPerPage: 4,
            isDropdownOpen: false,

        };
    },
    computed: {
        totalPages() {
            return this.candidaturas.length > 0
            ? Math.ceil(this.candidaturas.length / this.candidaturasPerPage)
            : 1;
        },
        paginatedCandidaturas() {
            if (!this.candidaturas || this.candidaturas.length === 0) {
                return [];
            }
            const start = (this.currentPage - 1) * this.candidaturasPerPage;
            const end = start + this.candidaturasPerPage;
            return this.candidaturas.slice(start, end);
        },
        ...mapGetters(['getUserId']),   
    },
    methods: {
        getStatusColor(status) {
        switch(status) {
            case 'Aprovado':
                return { backgroundColor: 'green' };
            case 'Rejeitado':
                return { backgroundColor: 'red' };
            case 'Pendente':
                return { backgroundColor: 'orange' }; 
            default:
                return { backgroundColor: 'gray' }; 
        }
    },
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

        async fetchCandidaturas() {
                    try {
                const response = await getApplications();
                console.log('Resposta da API:', response);
                if (response && Array.isArray(response.candidaturas)) {
                    this.candidaturas = response.candidaturas; 
                } else {
                    console.error('Formato inesperado da resposta:', response);
                    this.candidaturas = [];
                }
            } catch (error) {
                console.error('Erro ao buscar candidaturas:', error);
                this.candidaturas = [];
            }
                },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        viewCandidaturaDetails(candidatura) {
            this.selectedCandidatura = candidatura;
        },
        toggleDropdown(status) {
            this.isDropdownOpen = status;
        },
        logout() {
            this.userlogout();
                this.showToast("Você saiu da conta!", "error");
                this.$router.push('/SignIn');
        },
        ...mapActions(['userlogout']),
    },
    created() {
        this.fetchCandidaturas();
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

.candidatura-list {
    flex: 1;
    background-color: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.candidatura-card {
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 15px;
    transition: background-color 0.3s;
}

.candidatura-card:hover {
    background-color: #F0F0F0;
}

.details-section {
    width: 300px;
    margin-left: 20px;
    background-color: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: relative;
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
}

.pagination button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.pagination span {
    margin: 0 10px;
    font-weight: bold;
}

.status-indicator {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-left: 10px;
    display: inline-block;
}
.details {
    padding: 10px;
    background-color: #136ecf;

    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}
.details:hover {
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

.details-section .fa-xmark {
    font-size: 24px;
    color:#df0d0d;
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    transition: color 0.3s;
}

.custom-navbar .container-fluid {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    justify-content: space-between;
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
