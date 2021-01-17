import axios from 'axios'

const baseURL = 'http://api.localhost'
//const baseURL = 'http://localhost:8000'

export const songURL = baseURL + '/api/song/'

const request = axios.create({
    baseURL
})

export default request