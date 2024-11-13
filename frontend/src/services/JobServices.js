import LaravelApi from "./HttpService";

export const MakeVagas = async (title, description, salaries, categories) => {
    try {
        const response = await LaravelApi.post("/vagas", {
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

