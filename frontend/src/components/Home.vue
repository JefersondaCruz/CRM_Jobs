<template>
  <div class="container">
  <h1 class="title">Jobify</h1>
  <div class="search-bar">
      <input
      type="text"
      v-model="searchQuery"
      placeholder="Pesquise por vagas"
      />
      <button @click="searchJobs">Buscar</button>
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
      <div v-for="job in filteredJobs" :key="job.id" class="job-card">
          <h4>{{ job.title }}</h4>
          <p>{{ job.location }} - {{ job.type }}</p>
          <p>{{ job.description }}</p>
          <button @click="applyToJob(job.id)">Mais Detalhes</button>
      </div>
      </div>
      <div class="details-section" v-if="selectedJob">
      <h3>Detalhes da Vaga</h3>
      <p><strong>Título:</strong> {{ selectedJob.title }}</p>
      <p><strong>Localização:</strong> {{ selectedJob.location }}</p>
      <p><strong>Tipo:</strong> {{ selectedJob.type }}</p>
      <p><strong>Descrição:</strong> {{ selectedJob.description }}</p>
      <button @click="submitApplication">Candidatar-se</button>
      </div>
  </div>
  </div>
</template>
<script>
export default {
  data() {
  return {
      searchQuery: '',
      selectedLocation: '',
      selectedType: '',
      selectedJob: null,
      jobs: [
      { id: 1, title: 'Desenvolvedor Frontend', location: 'São Paulo', type: 'Tempo Integral', description: 'Desenvolvimento de interfaces.' },
      { id: 2, title: 'Designer UI/UX', location: 'Rio de Janeiro', type: 'Freelance', description: 'Design de experiência e interface do usuário.' },
      { id: 3, title: 'Engenheiro de Software', location: 'São Paulo', type: 'Tempo Integral', description: 'Desenvolvimento de software.' }
      ]
  };
  },
  computed: {
  filteredJobs() {
      return this.jobs.filter(job => {
      const matchesQuery = job.title.toLowerCase().includes(this.searchQuery.toLowerCase());
      const matchesLocation = !this.selectedLocation || job.location === this.selectedLocation;
      const matchesType = !this.selectedType || job.type === this.selectedType;
      return matchesQuery && matchesLocation && matchesType;
      });
  }
  },
  methods: {
  searchJobs() {
      console.log('Pesquisando por:', this.searchQuery);
  },
  applyToJob(jobId) {
      this.selectedJob = this.jobs.find(job => job.id === jobId);
  },
  submitApplication() {
      alert(`Você se candidatou à vaga: ${this.selectedJob.title}`);
      this.selectedJob = null;
  }
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
  max-width: 1200px;
  margin: auto;
  padding: 20px;
}
.title {
  text-align: center;
  margin-bottom: 20px;
}
.search-bar {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
}
.search-bar input[type="text"] {
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ddd;
  border-radius: 4px 0 0 4px;
}
.search-bar button {
  padding: 10px 20px;
  font-size: 16px;
  background-color: #007BFF;
  color: #fff;
  border: none;
  border-radius: 0 4px 4px 0;
  cursor: pointer;
}
.search-bar button:hover {
  background-color: #0056B3;
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
}
.job-card:hover {
  background-color: #F0F0F0;
}
.job-card h4 {
  margin: 0;
}
.job-card button {
  padding: 10px;
  background-color: #28A745;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.job-card button:hover {
  background-color: #218838;
}
.details-section {
  width: 300px;
  margin-left: 20px;
  background-color: #fff;
  padding: 15px;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
.details-section h3 {
  margin: 0 0 10px;
}
.details-section button {
  background-color: #28A745;
  color: white;
  padding: 10px 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s, transform 0.2s;
}
.details-section button:hover {
  background-color: #218838;
  transform: scale(1.05);
}
</style>