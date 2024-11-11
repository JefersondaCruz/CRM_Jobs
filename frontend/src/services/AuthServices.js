import LaravelApi from "./HttpService";




export const register = async (name, email, password, password_confirmation, type) => {
        try {
            const response = await LaravelApi.post("/register", {
                name,
                email,
                password,
                password_confirmation: password_confirmation,
                type,
        });
        return response.data;
    } catch (error) {
        console.error("Erro ao cadastrar:", error.response || error);
        throw error;
        
    }

}

export const logout = () => {
    localStorage.removeItem("token");
}
