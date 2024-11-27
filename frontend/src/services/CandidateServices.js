import LaravelApi from "./HttpService";

export const MakeCandidate = async (experiences, skills, CEP, house_number, phone, social_media, about) => {
    try {
        const response = await LaravelApi.post("/Candidate/details/candidate", {
        experiences,
        skills,
        CEP,
        house_number,
        phone,
        social_media,
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