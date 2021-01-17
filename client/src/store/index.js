import {createStore, createLogger} from 'vuex'
import playlist from './modules/playlist'

const debug = process.env.NODE_ENV !== 'production'
const plugins = debug ? [createLogger({})] : []

export default createStore({
  modules: {
    playlist
  },
  strict: debug,
  plugins
})
