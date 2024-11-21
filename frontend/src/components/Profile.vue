<template>
<div>
    <div class="container">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
    
        <form class="d-flex">
            <h2> Meu Perfil </h2>
        </form>
            <a href="/perfil" class="ms-3">
            <i class="fas fa-user-circle" style="font-size: 40px;"></i>
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
                                alt="Foto de João Silva"
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
                            <h5 class="card-title">João Silva</h5>
                            <p class="card-text">
                            <strong>Desenvolvedor Frontend</strong><br />Especializado em HTML, CSS, JavaScript e frameworks modernos como React.
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
                            <p>Sou um desenvolvedor frontend com 5 anos de experiência, apaixonado por criar interfaces de usuário intuitivas e responsivas. Gosto de trabalhar com equipes dinâmicas e sempre busco aprender novas tecnologias para melhorar minha performance.</p>
                            <hr />
                        <div class="position-relative">
                            <h5 class="card-title">Experiência Profissional</h5>
                            <i class="bi bi-pencil position-absolute" style="top: 5px; right: 10px; cursor: pointer;"></i>
                        </div>
                            <ul class="list-unstyled">
                                <li><strong>Desenvolvedor Frontend</strong> - Empresa XYZ (2020 - presente)</li>
                                <li><strong>Analista de Sistemas</strong> - Empresa ABC (2017 - 2020)</li>
                            </ul>
                            <hr />
                        <div class="position-relative">
                            <h5 class="card-title">Formação</h5>
                            <i class="bi bi-pencil position-absolute" style="top: 5px; right: 10px; cursor: pointer;"></i>
                        </div>
                            <p><strong>Universidade ABC</strong> - Bacharelado em Ciência da Computação (2014 - 2017)</p>
                            <hr />
                        <div class="position-relative">
                            <h5 class="card-title">Informações de Contato</h5>
                            <i class="bi bi-pencil position-absolute" style="top: 5px; right: 10px; cursor: pointer;"></i>
                        </div>
                            <ul class="list-unstyled">
                                <li><strong>Email:</strong> joao.silva@email.com</li>
                                <li><strong>LinkedIn:</strong> <a href="https://www.linkedin.com/in/joaosilva" target="_blank">linkedin.com/in/joaosilva</a></li>
                                <li><strong>GitHub:</strong> <a href="https://github.com/joaosilva" target="_blank">github.com/joaosilva</a></li>
                            </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
    return {
        profilePicture: "https://via.placeholder.com/150",
    };
    },
    methods: {
    triggerFileInput() {
        this.$refs.fileInput.click();
    },
    handleFileChange(event) {
        const file = event.target.files[0];
        if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            this.profilePicture = reader.result;
        };
        reader.readAsDataURL(file);
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
        background-color: #F5F7FA;
    }
    .container {
        max-width: 1500px;
        margin: auto;
        padding: 20px;
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
</style>
