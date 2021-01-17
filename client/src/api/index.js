import request from './request'

export default {
    getPlaylist: () => request.get('/api/playlist'),
    getSong: (name) => request.get('/api/song/' + name, {
        responseType: 'arraybuffer'
    })
}