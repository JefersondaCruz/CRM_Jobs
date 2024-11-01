import LaravelApi from "./HttpService";


export const login = async (email, password) => {
    await LaravelApi.post("/login", {
        email,
        password,
    })
    .then(Response => {
        localStorage.setItem("token", Response.data.token);
        return Response.data.user;
    })
    .catch(error => {
        console.error("Erro ao fazer login:", error);
        throw error;
    });
}

export const register = async (name, email, password, password_confirmation, type) => {
    await LaravelApi.post("/register", {
        name,
        email,
        password,
        password_confirmation: password_confirmation,
        type,
    });
    
}

export const logout = () => {
    localStorage.removeItem("token");
}
