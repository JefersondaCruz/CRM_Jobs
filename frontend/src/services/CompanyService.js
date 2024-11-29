import LaravelApi from "./HttpService";

export const MakeCompany = async (name, CNPJ, localization) => {
    try {
        const response = await LaravelApi.post("/Recruiter/companies", {
        name,
        CNPJ,
        localization,
    },{
        headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`
        }
    })
    return response.data;
} catch (error) {
        console.error("Erro ao criar empresa:", error);
        throw error;
    }
}

export const updateCompany = async ( updateData) => {
    try {
        const response = await LaravelApi.put(`/Recruiter/companie/update-company`, updateData, {
        headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`
        },
        }
    );
    return response.data;
    } catch (error) {
        console.error("Erro ao atualizar empresa:", error);
        throw error;
    }
}

