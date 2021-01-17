<template>
  <div class="player">
    <div class="player__inner">
      <div class="player__left current-track">
        <div class="current-track__cover">
          <img v-if="song.img" :src="song.img" :alt="song.title" class="current-track__img"/>
          <img
              v-else
              alt=""
              class="current-track__img"
              src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxnPg0KCTxwb2x5Z29uIHN0eWxlPSJmaWxsOiM4QjdFN0Y7IiBwb2ludHM9IjM0LjI4OSwzNDEuOTg2IDQzLjM5MSw0MjQuOTUgNzEuMTczLDQyNC45NSA3MS4xNzMsMzQxLjk4NiAJIi8+DQoJPHBvbHlnb24gc3R5bGU9ImZpbGw6IzhCN0U3RjsiIHBvaW50cz0iNDc3LjcxMSwzNDEuOTg2IDQ2OC42MDksNDI0Ljk1IDQ0MC44MjcsNDI0Ljk1IDQ0MC44MjcsMzQxLjk4NiAJIi8+DQo8L2c+DQo8Zz4NCgk8cGF0aCBzdHlsZT0iZmlsbDojNDYzODM2OyIgZD0iTTQyMi42MzksMzEyLjQyMWwtMjIuNzU2LDcxLjA0N2wyMi43NTYsNzEuMDQ3YzE2LjMyOCwwLDI5LjU2NS0xMy4yMzcsMjkuNTY1LTI5LjU2NXYtODIuOTYzDQoJCUM0NTIuMjA1LDMyNS42NTksNDM4Ljk2OCwzMTIuNDIxLDQyMi42MzksMzEyLjQyMXoiLz4NCgk8cGF0aCBzdHlsZT0iZmlsbDojNDYzODM2OyIgZD0iTTU5Ljc5NSwzNDEuOTg2djgyLjk2M2MwLDE2LjMyOSwxMy4yMzcsMjkuNTY1LDI5LjU2NSwyOS41NjVsMjIuNzU2LTcxLjA0N0w4OS4zNiwzMTIuNDINCgkJQzczLjAzMiwzMTIuNDIxLDU5Ljc5NSwzMjUuNjU5LDU5Ljc5NSwzNDEuOTg2eiIvPg0KCTxwYXRoIHN0eWxlPSJmaWxsOiM0NjM4MzY7IiBkPSJNNDM3LjAyLDg3LjUzQzM4OC42NjUsMzkuMTg2LDMyNC4zOCwxMi41NTEsMjU2LDEyLjU1MVMxMjMuMzM1LDM5LjE4Niw3NC45OCw4Ny41Mw0KCQlDMjYuNjI0LDEzNS44ODYsMCwyMDAuMTcsMCwyNjguNTUxYzAsNy45MDgsNi40MTEsMTQuMzE5LDE0LjMxOSwxNC4zMTljNy45MDksMCwxNC4zMTktNi40MTEsMTQuMzE5LTE0LjMxOQ0KCQlDMjguNjM4LDE0Mi45ODYsMTMwLjQzNSw0MS4xODksMjU2LDQxLjE4OWMxMjUuNDY1LDAsMjI3LjE5NywxMDEuNjM3LDIyNy4zNTksMjI3LjA2M2MtMC4wMDIsMC4xMDEtMC4wMTUsMC4xOTgtMC4wMTUsMC4yOTkNCgkJYzAsNy45MTMsNi40MTUsMTQuMzI4LDE0LjMyOCwxNC4zMjhTNTEyLDI3Ni40NjUsNTEyLDI2OC41NTFDNTEyLDIwMC4xNyw0ODUuMzc2LDEzNS44ODYsNDM3LjAyLDg3LjUzeiIvPg0KPC9nPg0KPHBhdGggc3R5bGU9ImZpbGw6IzYwNTM1MzsiIGQ9Ik00NzcuMTQyLDQyNC45NWMtNC43MTQsMC04LjUzMywwLTguNTMzLDBWMzIxLjU1NWMwLTAuNjY4LDAuMDc5LTEuMzM1LDAuMjMzLTEuOTgzDQoJYzMuOTctMTYuNjEsNS45ODQtMzMuNzc1LDUuOTg0LTUxLjAxOWMwLTEyMC42NjEtOTguMTY0LTIxOC44MjctMjE4LjgyNS0yMTguODI3UzM3LjE3NSwxNDcuODkzLDM3LjE3NSwyNjguNTUzDQoJYzAsMTcuMjQ0LDIuMDE0LDM0LjQwOSw1Ljk4NCw1MS4wMTljMC4xNTUsMC42NDksMC4yMzMsMS4zMTUsMC4yMzMsMS45ODNWNDI0Ljk1YzAsMC0zLjgyLDAtOC41MzMsMHMtOC41MzMtMy44Mi04LjUzMy04LjUzMw0KCXYtOTMuODY0Yy00LjEyNi0xNy42LTYuMjE3LTM1Ljc2Mi02LjIxNy01My45OTlDMjAuMTA4LDEzOC40ODEsMTI1LjkyOSwzMi42NiwyNTYsMzIuNjZzMjM1Ljg5MiwxMDUuODIxLDIzNS44OTIsMjM1Ljg5Mw0KCWMwLDE4LjIzNy0yLjA5MSwzNi4zOTktNi4yMTcsNTMuOTk5djkzLjg2NEM0ODUuNjc1LDQyMS4xMyw0ODEuODU2LDQyNC45NSw0NzcuMTQyLDQyNC45NXoiLz4NCjxnPg0KCTxwYXRoIHN0eWxlPSJmaWxsOiNGMTQ3NDI7IiBkPSJNMzc3LjcwNiwyNjcuNDg4Yy0yNC44MTcsMC00NC45MzQsMjAuMTE4LTQ0LjkzNCw0NC45MzN2MTQyLjA5NQ0KCQljMCwyNC44MTcsMjAuMTE3LDQ0LjkzMyw0NC45MzQsNDQuOTMzYzI0LjgxNiwwLDQ0LjkzNC0yMC4xMTcsNDQuOTM0LTQ0LjkzM1YzMTIuNDIxDQoJCUM0MjIuNjM5LDI4Ny42MDYsNDAyLjUyMiwyNjcuNDg4LDM3Ny43MDYsMjY3LjQ4OHoiLz4NCgk8cGF0aCBzdHlsZT0iZmlsbDojRjE0NzQyOyIgZD0iTTEzNC4yOTQsMjY3LjQ4OGMtMjQuODE2LDAtNDQuOTM0LDIwLjExOC00NC45MzQsNDQuOTMzdjE0Mi4wOTUNCgkJYzAsMjQuODE3LDIwLjExNyw0NC45MzMsNDQuOTM0LDQ0LjkzM3M0NC45MzQtMjAuMTE3LDQ0LjkzNC00NC45MzNWMzEyLjQyMUMxNzkuMjI4LDI4Ny42MDYsMTU5LjExMSwyNjcuNDg4LDEzNC4yOTQsMjY3LjQ4OHoiLz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjwvc3ZnPg0K"
          />
        </div>
        <div class="current-track__info">
          <div v-if="song.title" class="current-track__name" :title="song.title">
            {{ song.title }}
          </div>
          <div v-if="song.artist" class="current-track__artist" :title="song.artist">
            {{ song.artist }}
          </div>
        </div>
      </div>
      <div class="player__center">
        <div class="player-controls">
          <button
              class="player-controls__button typcn typcn-arrow-shuffle"
              :class="{ 'player-controls__button--active': shuffle }"
              title="Shuffle"
              @click="onShuffle"
          ></button>
          <button
              :disabled="disabled"
              class="player-controls__button player-controls__button--prev typcn typcn-media-rewind"
              title="Previous"
              @click="prev"
          ></button>
          <button
              class="player-controls__button typcn"
              :class="playPauseClasses"
              :disabled="disabled || !readyStart"
              @click="playPause"
          ></button>
          <button
              :disabled="disabled"
              class="player-controls__button player-controls__button--next typcn typcn-media-fast-forward"
              title="Next"
              @click="next"
          ></button>
          <button
              class="player-controls__button typcn"
              :class="repeatClasses"
              title="Repeat"
              @click="onRepeat"
          ></button>
        </div>
        <div class="player-playback">
          <div class="player-playback__time">
            {{ leftTime }}
          </div>
          <div class="player-playback__progress">
            <vue-slider
                tooltip="none"
                :disabled="disabled"
                v-model="currentTime"
                :max="songDuration"
                :dot-size="15"
                :process-style="{ background: '#1db954' }"
                :rail-style="{ background: '#737575' }"
                @change="progressChange"
            ></vue-slider>
          </div>
          <div class="player-playback__time">
            {{ remainingTime }}
          </div>
        </div>
      </div>
      <div class="player__right volume-bar">
        <button
            class="volume-bar__button typcn"
            :class="volumeClasses"
            @click="volumeToggle"
        ></button>
        <vue-slider
            class="volume-bar__slider"
            tooltip="none"
            width="100px"
            v-model="volume"
            :min="0"
            :max="1"
            :interval="0.01"
            :dot-size="15"
            :process-style="{ background: '#1db954' }"
            :rail-style="{ background: '#737575' }"
            @change="volumeChange"
        ></vue-slider>
      </div>
    </div>
    <audio
        autoplay
        v-if="src"
        ref="audio"
        :src="src"
        :volume="volume"
        :loop="loop"
        @timeupdate="timeupdate"
        @loadeddata="loadeddata"
        @play="paused = false"
        @pause="paused = true"
        @ended="ended"
        @canplay="canplay"
        @playing="canplay"
        @waiting="waiting"
    />
  </div>
</template>

<script>
import {ref, toRefs, toRef, computed, watch} from 'vue'
import VueSlider from 'vue-slider-component'
import RepeatState from '@/@types/repeat-state'
import {songURL} from '@/api/request'
import {secondsToMinutes} from '@/filters'

export default {
  name: 'player',
  components: {
    VueSlider
  },
  emits: ['ended', 'prev', 'next', 'update:shuffle', 'update:repeat'],
  props: {
    song: {
      type: Object,
      required: true
    },
    autoPlay: {
      type: Boolean,
      required: false,
      default: false
    },
    shuffle: {
      type: Boolean,
      required: true
    },
    repeat: {
      type: Number,
      required: true
    }
  },
  setup(props, {emit}) {
    const {song, shuffle, repeat} = toRefs(props)
    const autoPlay = toRef(props, 'autoPlay')

    const audio = ref(null)
    const loaded = ref(false)
    const readyStart = ref(false)
    const playing = ref(false)
    const paused = ref(false)
    const currentTime = ref(0)
    const songDuration = ref(0)
    const volume = ref(0.5)

    let tmpVolume = 0

    watch(song, () => {
      loaded.value = false
      readyStart.value = false
      playing.value = false
      paused.value = false
      currentTime.value = 0
      songDuration.value = 1
    })

    const src = computed(() => song.value.file ? songURL + song.value.file : '')

    const disabled = computed(() => !song.value.file || !loaded.value)

    const loop = computed(() => RepeatState.Track === repeat.value)

    const remainingTime = computed(() => playing.value ? secondsToMinutes(songDuration.value - currentTime.value) : '')

    const leftTime = computed(() => secondsToMinutes(currentTime.value))

    const volumeClasses = computed(() => [
      {
        'typcn-volume-up': volume.value >= 0.4,
        'typcn-volume-down': volume.value >= 0.2 && volume.value < 0.4,
        'typcn-volume': volume.value > 0 && volume.value < 0.2,
        'typcn-volume-mute': volume.value <= 0
      }
    ])

    const playPauseClasses = computed(() => {
      const isPlaying = playing.value && !paused.value

      return [
        {
          'player-controls__button--pause': isPlaying,
          'typcn-media-pause': isPlaying,
          'player-controls__button--play': !isPlaying,
          'typcn-media-play': !isPlaying,
        }
      ]
    })

    const repeatClasses = computed(() => [
      {
        'typcn-arrow-repeat': RepeatState.Track !== repeat.value,
        'typcn-arrow-loop': RepeatState.Track === repeat.value,
        'player-controls__button--active': repeat.value > 0
      }
    ])

    const timeupdate = () => {
      if (!audio.value) {
        return
      }
      currentTime.value = Math.floor(audio.value.currentTime)
      playing.value = true
    }

    const loadeddata = () => {
      if (audio.value.readyState >= 2) {
        songDuration.value = Math.floor(audio.value.duration)
        loaded.value = true

        if (autoPlay.value) {
          audio.value.play()
        }
      } else {
        throw new Error('Failed to load sound file')
      }
    }

    const canplay = () => readyStart.value = true

    const waiting = () => readyStart.value = false

    const progressChange = (value) => audio.value.currentTime = value

    const volumeToggle = () => {
      if (volume.value > 0) {
        tmpVolume = volume.value
        volume.value = 0
      } else {
        volume.value = tmpVolume
      }
    }

    const volumeChange = (value) => volume.value = value

    const pause = () => {
      paused.value = !paused.value
      paused.value ? audio.value.pause() : audio.value.play()
    }

    const play = () => {
      if (playing.value) {
        return
      }

      audio.value.play().then(() => playing.value = true)
      paused.value = false
    }

    const playPause = () => playing.value ? pause() : play()

    const ended = () => {
      if (RepeatState.Off === repeat.value) {
        pause()
      }

      emit('ended')
    }

    const prev = () => loop.value ? progressChange(0) : emit('prev')

    const next = () => loop.value ? progressChange(0) : emit('next')

    const onShuffle = () => emit('update:shuffle', !shuffle.value)

    const onRepeat = () => emit('update:repeat', RepeatState.Track === repeat.value ? RepeatState.Off : repeat.value + 1)

    const toTimer = (secs) => {
      const hours = Math.floor(secs / 3600)
      const minutes = Math.floor(secs / 60) % 60
      const seconds = secs % 60

      return [hours, minutes, seconds]
          .map(v => v < 10 ? '0' + v : v)
          .filter((v, i) => v !== '00' || i > 0)
          .join(':')
    }

    return {
      src,
      disabled,
      loop,
      readyStart,
      audio,
      volume,
      currentTime,
      songDuration,
      remainingTime,
      leftTime,
      volumeClasses,
      playPauseClasses,
      repeatClasses,

      timeupdate,
      loadeddata,
      canplay,
      waiting,
      ended,
      progressChange,
      volumeToggle,
      volumeChange,
      playPause,
      prev,
      next,
      onShuffle,
      onRepeat,
      toTimer
    }
  }
}
</script>

<style scoped lang="scss">
.player {
  padding: 0 15px;
  background-color: $c-shark;

  &__inner {
    display: flex;
    align-items: center;
    height: 100%;
  }

  &__center {
    width: calc(100% - 500px);
  }

  &__left {
    width: 250px;
  }

  &__right {
    width: 250px;
  }
}

.current-track {
  display: flex;
  align-items: center;

  &__cover {
    width: 60px;
    min-width: 60px;
    height: 60px;
  }

  &__img {
    width: 100%;
  }

  &__info {
    position: relative;
    overflow: hidden;
    white-space: nowrap;
    padding: 0 15px;
  }

  &__name {
    font-size: 14px;
    color: $c-white;
    overflow: hidden;
    text-overflow: ellipsis;

    &:hover {
      text-decoration: underline;
    }
  }

  &__artist {
    font-size: 11px;
    color: $c-gray;
    overflow: hidden;
    text-overflow: ellipsis;
    padding-top: 5px;

    &:hover {
      color: $c-white;
      text-decoration: underline;
    }
  }
}

.player-controls {
  display: flex;
  justify-content: center;

  &__button {
    cursor: pointer;
    color: $c-gray;
    font-size: 20px;
    margin: 0 5px;

    &:hover {
      color: $c-white;
    }

    &:disabled {
      cursor: not-allowed;
      color: $c-gray;
    }

    &--active {
      color: $c-green;
    }

    &--prev,
    &--next {
      font-size: 25px;
    }

    &--play,
    &--pause {
      font-size: 35px;

      &:hover {
        transform: scale(1.1);
      }
    }
  }
}

.player-playback {
  display: flex;
  padding-top: 5px;

  &__time {
    min-width: 40px;
  }

  &__progress {
    width: calc(100% - 80px);
    padding: 0 15px;
  }
}

.volume-bar {
  display: flex;
  justify-content: flex-end;
  align-items: center;

  &__button {
    cursor: pointer;
    margin-right: 15px;
    font-size: 25px;
    margin-top: -2px;
    color: $c-gray;

    &:hover {
      color: $c-white;
    }
  }
}
</style>