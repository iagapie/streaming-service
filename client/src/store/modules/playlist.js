import {getPlaylist} from '@/api'

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
        const response = await getPlaylist()

        commit('SET_SONGS', response.data)
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}