import LaravelApi from "./HttpService";

export const GetProfile = async (id) => {
    try {
        console.log("ID do usuário:", id);
        const response = await LaravelApi.get(`/user/${id}`, {

            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
        });
        console.log("Resposta daa API:", response);
        return response.data;
    } catch (error) {
        console.error("Erro ao recuperar perfil:", error);
        throw error;
    }
};

export const UpdateProfilePicture = async (userId, formData) => {
    try {
        const response = await LaravelApi.post(`/Candidate/profile/${userId}/update-picture`, formData, {
            headers: {
                "Content-Type": "multipart/form-data",
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
        });
        console.log("Resposta daa API:", response);
        return response.data;
    } catch (error) {
        console.error("Erro ao atualizar foto de perfil:", error);
        throw error;
    }
};

export const updateProfileData = async (data) => {
    try {
        const response = await LaravelApi.put(`/Candidate/profile/update-profile`, data, {    
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
        });
        console.log("respostas do update perfil:", response);
        return response.data;
    } catch (error) {
        console.error("Erro ao atualizar dados de perfil:", error);
        throw error;
    }
}
