import api from '@/api'

const state = {
    songs: []
}

const getters = {}

const mutations = {
    SET_SONGS(state, songs) {
        state.songs = songs
    }
}

const actions = {
    getSongs: async function({ commit }) {
        try {
            const response = await api.getPlaylist()
            commit('SET_SONGS', response.data)
        } catch (e) {
            console.log(e)
        }
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}