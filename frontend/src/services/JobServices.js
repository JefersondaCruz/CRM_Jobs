import LaravelApi from "./HttpService";

export const MakeVagas = async (title, description, salaries, categories) => {
    try {
        const response = await LaravelApi.post("/Recruiter/vagas", {
        title,
        description,
        salaries,
        categories,
    },{
        headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`
        }
    })
    return response.data;
} catch (error) {
        console.error("Erro ao criar vaga:", error);
        throw error;
    }
}

export const vagas = async () => {
    try {
        const response = await LaravelApi.get("/vagas");
        console.log('response', response);
        return response;
    } catch (error) {
        console.error("Erro ao buscar vagas:", error);
        throw error;
    }
}

export const ShowRecrutadorVagas = async () => {
    try {
        const user = JSON.parse(localStorage.getItem("user"));
        const recrutadorId = user ? user.id : null;
        console.log(recrutadorId);
        
        if (!recrutadorId) {
            throw new Error("Recrutador ID não encontrado no localStorage.");
        }
        const response = await LaravelApi.get(`/Recruiter/vagas/recrutador/${recrutadorId}`,
            {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`
                }
            }
        );
        console.log('response', response);
        return response;
    } catch (error) {
        console.error("Erro ao buscar vagas:", error);
        throw error;
    }
}

export const DeleteVagas = async (id) => {
    try {
        const response = await LaravelApi.delete(`/Recruiter/vagas/${id}`,
            {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`
                }
            }
        );
        console.log('response', response);
        return response;
    } catch (error) {
        console.error("Erro ao deletar vaga:", error);
        throw error;
    }
}

export const EditVagas = async(title, description, salaries, categories,id) => {
    try {
        const response = await LaravelApi.update(`/Recruiter/vagas/${id}`,{
        title,
        description,
        salaries,
        categories
    }, {
        headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`
        }
    })
    return response.data
    } catch (error) {
        console.error("Erro ao editar vaga:", error);
        throw error;
    }
}
