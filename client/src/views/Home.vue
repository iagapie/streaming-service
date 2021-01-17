<template>
  <div class="container" v-if="songs.length">
    <div class="container__main" :class="{'container__main--show': active >= 0}">
      <song-list v-model:active="active" />
    </div>
    <player
        class="container__player"
        :class="{'container__player--show': active >= 0}"
        :song="song"
        @next="next"
        @prev="prev"
        @ended="ended"
        v-model:shuffle="shuffle"
        v-model:repeat="repeat"
    />
  </div>
  <div class="loading" v-else-if="loading">
    <div class="loading__dot-pulse"></div>
  </div>
  <div v-else class="no-songs">
    <div class="no-songs__text">
      NO SONGS
    </div>
    <div class="no-songs__sub-text">
      ./api/storage/app/media
    </div>
  </div>
</template>

<script>
import {ref, watch, nextTick, computed} from 'vue'
import {useStore} from 'vuex'
import SongList from '@/components/SongList'
import Player from '@/components/Player'
import RepeatState from '@/@types/repeat-state'

export default {
  name: 'Home',
  components: {
    SongList,
    Player
  },
  setup() {
    const loading = ref(true)
    const active = ref(-1)
    const song = ref({})
    const shuffle = ref(false)
    const repeat = ref(RepeatState.Context)

    const store = useStore()
    const songs = computed(() => store.state.playlist.songs)

    watch(songs, () => loading.value = false)

    watch(active, () => song.value = active.value < 0 ? {} : songs.value[active.value])

    const setActive = (i) => {
      if (i === active.value) {
        active.value = -1
      }

      nextTick(() => active.value = i)
    }

    const r = (m, e) => {
      let n = Math.floor(Math.random() * m)
      return n === e ? r(m, e) : n
    }

    const next = () => {
      const l = songs.value.length

      if (shuffle.value && l > 1) {
        setActive(r(l, active.value))
        return
      }

      const i = active.value + 1

      if (i < songs.value.length) {
        setActive(i)
      } else if (RepeatState.Context === repeat.value) {
        setActive(0)
      }
    }

    const prev = () => {
      const l = songs.value.length

      if (shuffle.value && l > 1) {
        setActive(r(l, active.value))
        return
      }

      const i = active.value - 1

      if (i >= 0) {
        setActive(i)
      } else if (RepeatState.Context === repeat.value) {
        setActive(songs.value.length - 1)
      }
    }

    const ended = () => {
      if (RepeatState.Context === repeat.value) {
        next()
      }
    }

    store.dispatch('playlist/getSongs')

    return {
      loading,
      active,
      songs,
      song,
      shuffle,
      repeat,
      next,
      prev,
      ended
    }
  }
}
</script>

<style scoped lang="scss">
.container {
  &__main {
    margin: 0 auto;
    max-width: 1305px;

    &--show {
      padding-bottom: 90px;
    }
  }

  &__player {
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 0;
    z-index: 2;
    overflow: hidden;
    -moz-transition: all 0.5s ease-in-out;
    -o-transition: all 0.5s ease-in-out;
    -webkit-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out;

    &--show {
      height: 90px;
    }
  }
}

.no-songs {
  background: $c-tundra url('../assets/bg.png');
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;

  &__text {
    color: $c-gray;
    font-family: Tahoma, Helvetica, Arial, sans-serif;
    font-size: 40px;
    font-weight: 900;
    padding-bottom: 15px;
    text-shadow: 1px 1px 1px rgba($c-shark, 0.9);
  }

  &__sub-text {
    font-family: Arial, sans-serif;
    color: $c-nobel;
    font-size: 20px;
    font-weight: 600;
    text-shadow: 0 1px 1px rgba($c-shark-dark, 0.5);
  }
}

.loading {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;

  &__dot-pulse {
    position: relative;
    left: -9999px;
    width: 20px;
    height: 20px;
    border-radius: 10px;
    background-color: $c-green;
    color: $c-green;
    box-shadow: 9999px 0 0 -5px $c-green;
    animation: dotPulse 1.5s infinite linear;
    animation-delay: .25s;

    &::before, &::after {
      content: '';
      display: inline-block;
      position: absolute;
      top: 0;
      width: 20px;
      height: 20px;
      border-radius: 10px;
      background-color: $c-green;
      color: $c-green;
    }

    &::before {
      box-shadow: 9984px 0 0 -5px $c-green;
      animation: dotPulseBefore 1.5s infinite linear;
      animation-delay: 0s;
    }

    &::after {
      box-shadow: 10014px 0 0 -5px $c-green;
      animation: dotPulseAfter 1.5s infinite linear;
      animation-delay: .5s;
    }
  }

  @keyframes dotPulseBefore {
    0% {
      box-shadow: 9984px 0 0 -5px $c-green;
    }
    30% {
      box-shadow: 9984px 0 0 2px $c-green;
    }
    60%,
    100% {
      box-shadow: 9984px 0 0 -5px $c-green;
    }
  }

  @keyframes dotPulse {
    0% {
      box-shadow: 9999px 0 0 -5px $c-green;
    }
    30% {
      box-shadow: 9999px 0 0 2px $c-green;
    }
    60%,
    100% {
      box-shadow: 9999px 0 0 -5px $c-green;
    }
  }

  @keyframes dotPulseAfter {
    0% {
      box-shadow: 10014px 0 0 -5px $c-green;
    }
    30% {
      box-shadow: 10014px 0 0 2px $c-green;
    }
    60%,
    100% {
      box-shadow: 10014px 0 0 -5px $c-green;
    }
  }
}
</style>
