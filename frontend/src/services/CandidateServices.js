import LaravelApi from "./HttpService";

export const MakeCandidate = async (experiences, skills, phone, social_media, CEP, house_number, about) => {
    try {
        const response = await LaravelApi.post("/Candidate/details/candidate", {
        experiences,
        skills,
        phone,
        social_media,
        CEP,
        house_number,
        about,
    },{
        headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`
        }
    })
    return response.data;
} catch (error) {
        console.error("Erro ao criar candidato:", error);
        throw error;
    }
}

export const ApplyToJob = async (id) => {
    try {
        const response = await LaravelApi.post(`/Candidate/vagas/candidatar/${id}`, {
        },{
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`
            }   
        })
        return response.data;
    } catch (error) {
        console.error("Erro ao candidatar a vaga:", error);
        throw error;
    }
}

export const getApplications = async () => {
    try {
        const response = await LaravelApi.get(`/Candidate/applications`, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`
            }
        })
        return response.data;
    } catch (error) {
        console.error("Erro ao buscar candidaturas:", error);
        throw error;
    }
}

export const updateProfile = async (experiences, skills, phone, social_media, CEP, house_number, about) => {
    try {
        const response = await LaravelApi.put(`/Candidate/profile/${userId}/update-profile`, {
        experiences,
        skills,
        phone,
        social_media,
        CEP,
        house_number,
        about,
    },{
        headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`
        }
    })
    return response.data;
} catch (error) {
        console.error("Erro ao atualizar perfil:", error);
        throw error;
    }   
}