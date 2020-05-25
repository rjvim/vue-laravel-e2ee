// initial state
const state = {
    user: null,
    encryptionPassword: null,
    publicKey: null,
    privateKey: null
};

// getters
const getters = {};

// actions
const actions = {
    getUser({ commit, dispatch }) {
        return axios.get("api/user").then(response => {
            commit("setUser", response);
        });
    },

    clearEncryptionData({ commit, dispatch }) {
        commit("clearEncryptionData");
    },

    setEncryptionPassword({ commit, dispatch }, { encryptionPassword }) {
        commit("setEncryptionPassword", encryptionPassword);
    },

    setPublicKey({ commit, dispatch }, { publicKey }) {
        commit("setPublicKey", publicKey);
    },

    setPrivateKey({ commit, dispatch }, { privateKey }) {
        commit("setPrivateKey", privateKey);
    }
};

// mutations
const mutations = {
    setUser(state, response) {
        state.user = response.data;
    },

    clearEncryptionData(state) {
        state.encryptionPassword = null;
        state.publicKey = null;
        state.privateKey = null;
    },

    setEncryptionPassword(state, encryptionPassword) {
        state.encryptionPassword = encryptionPassword;
    },

    setPublicKey(state, publicKey) {
        state.publicKey = publicKey;
    },

    setPrivateKey(state, privateKey) {
        state.privateKey = privateKey;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
