import LaravelApi from "./HttpService";

export const GetProfile = async (id) => {
    try {
        const response = await LaravelApi.get("/user/{id}", {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`
            }
        });
        return response.data;
    } catch (error) {
        console.error("Erro ao recuperar perfil:", error);
        throw error;
    }
}