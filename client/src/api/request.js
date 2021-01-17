import axios from 'axios'

const baseURL = 'http://api.localhost'

export const songURL = baseURL + '/api/song/'

const request = axios.create({
    baseURL
})

export default request