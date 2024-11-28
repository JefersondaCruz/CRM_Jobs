<template>
    <div>
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <form class="d-flex">
                        <h2>Meu Perfil</h2>
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
                                    :src="profilePicture || 'https://via.placeholder.com/150'"
                                    alt="Foto do Usuário"
                                    class="img-fluid rounded-circle mb-3"
                                    style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;"
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
                                ref="fileInput"
                                @change="handleFileChange"
                            />
                            <h5 class="card-title">{{ profileData.user?.name }}</h5>
                            <p><br /> {{ profileData.candidate?.about }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="position-relative">
                                <h5 class="card-title">Informações de Contato</h5>
                                <i class="bi bi-pencil position-absolute" style="top: 5px; right: 10px; cursor: pointer;"></i>
                            </div>
                            <p><strong>Email:</strong> {{ profileData.user?.email }}</p>
                            <hr />

                            <div v-if="profileData.user?.type === 'recruiter'">
                                <div class="position-relative">
                                    <h5 class="card-title">Empresa</h5>
                                    <i class="bi bi-pencil position-absolute" style="top: 5px; right: 10px; cursor: pointer;"></i>
                                </div>
                                <p>Nome: {{ profileData.recruiter?.company?.name }}</p>
                                <p>CNPJ: {{ profileData.recruiter?.company?.CNPJ }}</p>
                                <p>Localização: {{ profileData.recruiter?.company?.localization }}</p>
                            </div>

                            <div v-if="profileData.user?.type === 'candidate'">
                                <div class="position-relative">
                                    <h5 class="card-title">Experiência</h5>
                                    <i 
                                    class="bi bi-pencil position-absolute" 
                                    style="top: 5px; right: 10px; cursor: pointer;"
                                    @click="editExperience = !editExperience"
                                    > </i>
                                </div>
                                <p v-if="!editExperience">{{ profileData.candidate?.experiences }}</p>
                                <input 
                                    v-if="editExperience" 
                                    v-model="newExperiences" 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Digite sua experiência" 
                                />
                                <hr />

                                <div class="position-relative">
                                    <h5 class="card-title">Habilidades</h5>
                                    <i class="bi bi-pencil position-absolute" style="top: 5px; right: 10px; cursor: pointer;"></i>
                                </div>
                                <p>Habilidades: {{ profileData.candidate?.skills }}</p>
                                <hr />

                                <div class="position-relative">
                                    <h5 class="card-title">Telefone</h5>
                                    <i class="bi bi-pencil position-absolute" style="top: 5px; right: 10px; cursor: pointer;"></i>
                                </div>
                                <p>Telefone: {{ profileData.candidate?.phone }}</p>
                                <hr />

                                <div class="position-relative">
                                    <h5 class="card-title">Redes Sociais</h5>
                                    <i class="bi bi-pencil position-absolute" style="top: 5px; right: 10px; cursor: pointer;"></i>
                                </div>  
                                <p>Redes Sociais: {{ profileData.candidate?.social_media }}</p>
                                <hr />

                                <div class="position-relative">
                                    <h5 class="card-title">CEP</h5>
                                    <i class="bi bi-pencil position-absolute" style="top: 5px; right: 10px; cursor: pointer;"></i>
                                </div>
                                <p>CEP: {{ profileData.candidate?.CEP }}</p>
                                <hr />

                                <div class="position-relative">
                                    <h5 class="card-title">Número da Casa</h5>
                                    <i class="bi bi-pencil position-absolute" style="top: 5px; right: 10px; cursor: pointer;"></i>
                                </div>
                                <p>Número da Casa: {{ profileData.candidate?.house_number }}</p>
                            </div>
                        </div>
                        
                    </div>
                    <div class="d-flex justify-content-center mt-4">
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
        </div>

        <div class="modal fade" id="candidateModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Atualizar Perfil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateCandidateProfile">
                            <div class="mb-3">
                                <label for="experiences" class="form-label">Experiência</label>
                                <input 
                                    v-model="newExperiences" 
                                    type="text" 
                                    id="experiences" 
                                    class="form-control"
                                    :placeholder="profileData.candidate?.experiences"
                                />
                            </div>
                            <div class="mb-3">
                                <label for="skills" class="form-label">Habilidades</label>
                                <input 
                                    v-model="newSkills" 
                                    type="text" 
                                    id="skills" 
                                    class="form-control"
                                    :placeholder=" profileData.candidate?.skills "
                                />
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Telefone</label>
                                <input 
                                    v-model="newPhone" 
                                    type="text" 
                                    id="phone" 
                                    class="form-control"
                                    :placeholder=" profileData.candidate?.phone"
                                />
                            </div>
                            <div class="mb-3">
                                <label for="social-media" class="form-label">Redes Sociais</label>
                                <input 
                                    v-model="newSocialMedia" 
                                    type="text" 
                                    id="social-media" 
                                    class="form-control"
                                    :placeholder="profileData.candidate?.social_media"
                                />
                            </div>
                            <div class="mb-3">
                                <label for="cep" class="form-label">CEP</label>
                                <input 
                                    v-model="newCEP" 
                                    type="text" 
                                    id="cep" 
                                    class="form-control"
                                    :placeholder="profileData.candidate?.CEP"
                                />
                            </div>
                            <div class="mb-3">
                                <label for="house-number" class="form-label">Número da Casa</label>
                                <input 
                                    v-model="newHouseNumber" 
                                    type="text" 
                                    id="house-number" 
                                    class="form-control"
                                    :placeholder="profileData.candidate?.house_number"
                                />
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" @click="closeModal" class="btn btn-primary">Salvar Alterações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { UpdateProfilePicture, GetProfile, updateProfileData } from "../services/ProfileServices";
import { mapGetters, mapState, mapMutations } from "vuex";

export default {
    data() {
        return {
            profileData: {
            user: {},
            candidate: {
                experiences: '',
                skills: '',
                phone: '',
                social_media: '',
                CEP: '',
                house_number: '',
            }
        },
        newExperiences: '',
        newSkills: '',
        newPhone: '',
        newSocialMedia: '',
        newCEP: '',
        newHouseNumber: '',
    };
},
    computed: {
        ...mapState(["profilePicture", "user"]),
        ...mapGetters(["getUserId"]),
    },
    methods: {

        

        ...mapMutations(["setProfilePicture"]),
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        async updateCandidateProfile() {
            const updateData   = {
                experiences: this.newExperiences || this.profileData.candidate?.experiences,
                skills: this.newSkills || this.profileData.candidate?.skills,
                phone: this.newPhone || this.profileData.candidate?.phone,
                social_media: this.newSocialMedia || this.profileData.candidate?.social_media,
                CEP: this.newCEP || this.profileData.candidate?.CEP,
                house_number: this.newHouseNumber || this.profileData.candidate?.house_number,
            };

            console.log('atualizando com os dados:', updateData)
                try {
                const response = await updateProfileData(updateData);
                console.log("Resposta da API ao atualizar o perfil:", response);
                

                this.closeModal();
            

            } catch (error) {
                console.error("Erro ao atualizar o perfil:", error);
            }
        },

        async handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                const formData = new FormData();
                formData.append('profile_picture', file);

                try {
                    const response = await UpdateProfilePicture(this.getUserId, formData);
                    console.log("Resposta da API após a atualização da foto:", response);

                    if (response && response.profile_picture) {
                        const newProfilePicture = `http://127.0.0.1:8000/storage/${response.profile_picture}`;
                        this.setProfilePicture(newProfilePicture);
                        console.log("Imagem de perfil atualizada:", newProfilePicture);
                    } else {
                        console.error("Erro: 'profile_picture' não foi retornado pela API.", response);
                    }
                } catch (error) {
                    console.error("Erro ao atualizar foto de perfil:", error);
                }
            }
        },
        async GetProfileDatas() {
            try {
                const response = await GetProfile(this.getUserId);
                console.log("Resposta da API:", response);

                if (response && response.user) {
                    this.profileData = response;
                    console.log("Perfil carregado:", this.profileData);

                    if (this.profileData.candidate?.profile_picture) {
                        const profilePicturePath = this.profileData.candidate.profile_picture;
                        this.setProfilePicture(`http://127.0.0.1:8000/storage/${profilePicturePath}`);
                    }
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
</style>
