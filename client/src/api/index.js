import request from './request'

export async function getPlaylist() {
    return await request.get('/api/playlist')
}

export async function getSong() {
    return await request.get('/api/song/' + name, {
        responseType: 'arraybuffer'
    })
}