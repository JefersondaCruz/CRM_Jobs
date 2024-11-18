import { createStore } from "vuex";
import LaravelApi from "../services/HttpService";

export default createStore({
  state: {
    acessToken :localStorage.getItem("token")|| null,
    user: JSON.parse(localStorage.getItem('user')) || null,
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
    removeToken(state) {
      state.acessToken = null;
      state.user = null;
      localStorage.removeItem("token");
      localStorage.removeItem("user")
    },
  },
  getters: {
    getToken(state) {
      return state.acessToken;
    },
    getUser(state) {
      return state.user;
    },
    loggedIn(state) {
      return !!state.acessToken;
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
  userlogout({commit}) {
      commit("removeToken");
      console.log("Logout bem-sucedido");
      return true;
  },
  
}});
