import { createStore } from "vuex";
import LaravelApi from "../services/HttpService";

export default createStore({
  state: {
    acessToken :localStorage.getItem('token')|| null,
    user: JSON.parse(localStorage.getItem('user')) || null,
    profilePicture: null,
  },  
  
  mutations: {
    setToken(state, token) {
      state.acessToken = token;
      localStorage.setItem("token", token);
    },  
    setUser(state, user) {
      state.user = user;  
      localStorage.setItem('user', JSON.stringify(user))
    },

    setProfilePicture(state, profilePicture) {
      state.profilePicture = profilePicture;
    },
    removeToken(state) {
      state.acessToken = null;
      state.user = null;
      state.profilePicture = null;
      localStorage.removeItem("token");
      localStorage.removeItem("user")
    },
  },
  getters: {
    getUserId(state) {
      return state.user ? state.user.id : null;
    },
    getToken(state) {
      return state.acessToken;
    },
    getUser(state) {
      return state.user || {};
    },
    loggedIn(state) {
      return !!state.acessToken && !!state.user;
    },
  },
  actions: {
    async Userlogin  ({commit}, {email, password}) {
      try {
          const response = await LaravelApi.post("/user/login", {
              email,
              password,
          });
  
          if (response.data.token) {
              commit("setToken", response.data.token);
              commit("setUser", response.data.user);
              if (response.data.user.profile_picture) {
                const profilePicturePath = response.data.user.profile_picture;
                commit("setProfilePicture", `http://127.0.0.1:8000/storage/${profilePicturePath}`);
              }
              console.log("Login bem-sucedido");
  
              return response.data.user;
          } else {
              console.error("Token não encontrado na resposta.");
              
              throw new Error("Token não encontrado.");
          }
      } catch (error) {
          console.error("Erro ao fazer login:", error.response);
          throw error;
      }
  },

  async UserRegister({commit}, {name, email, password, password_confirmation, type}) {
      try {
          const response = await LaravelApi.post("/user/register", {
              name,
              email,
              password,
              password_confirmation,
              type,
          });

          console.log('registro da respostas:',response);
          console.log('respostas do token', response.data.token);
          
          if (response.data.token) {
              commit("setToken", response.data.token);
              commit("setUser", response.data.user);

              console.log('User depois do commit', this.state.user)
              console.log("Cadastro bem-sucedido");

              return response.data.user;
          } else {
              console.error("Token não encontrado na resposta.");
              throw new Error("Token não encontrado.");
          }
        } catch (error) {
          console.error("Erro ao cadastrar:", error.response);
          throw error;
        }
  },

  userlogout({commit}) {
      commit("removeToken");
      console.log("Logout bem-sucedido");
      return true;
  },
  
  
}});
