<template>
  <div class="list">
    <div
        class="list__item song"
        v-for="(song, i) in songs"
        :key="i"
        :class="{ 'list__item--active': active === i }"
        @click="select(i)"
    >
      <div class="song__cover">
        <img v-if="song.img" :src="song.img" alt="" class="song__img"/>
        <img
            v-else
            alt=""
            class="song__img song__img--no"
            src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxnPg0KCTxwb2x5Z29uIHN0eWxlPSJmaWxsOiM4QjdFN0Y7IiBwb2ludHM9IjM0LjI4OSwzNDEuOTg2IDQzLjM5MSw0MjQuOTUgNzEuMTczLDQyNC45NSA3MS4xNzMsMzQxLjk4NiAJIi8+DQoJPHBvbHlnb24gc3R5bGU9ImZpbGw6IzhCN0U3RjsiIHBvaW50cz0iNDc3LjcxMSwzNDEuOTg2IDQ2OC42MDksNDI0Ljk1IDQ0MC44MjcsNDI0Ljk1IDQ0MC44MjcsMzQxLjk4NiAJIi8+DQo8L2c+DQo8Zz4NCgk8cGF0aCBzdHlsZT0iZmlsbDojNDYzODM2OyIgZD0iTTQyMi42MzksMzEyLjQyMWwtMjIuNzU2LDcxLjA0N2wyMi43NTYsNzEuMDQ3YzE2LjMyOCwwLDI5LjU2NS0xMy4yMzcsMjkuNTY1LTI5LjU2NXYtODIuOTYzDQoJCUM0NTIuMjA1LDMyNS42NTksNDM4Ljk2OCwzMTIuNDIxLDQyMi42MzksMzEyLjQyMXoiLz4NCgk8cGF0aCBzdHlsZT0iZmlsbDojNDYzODM2OyIgZD0iTTU5Ljc5NSwzNDEuOTg2djgyLjk2M2MwLDE2LjMyOSwxMy4yMzcsMjkuNTY1LDI5LjU2NSwyOS41NjVsMjIuNzU2LTcxLjA0N0w4OS4zNiwzMTIuNDINCgkJQzczLjAzMiwzMTIuNDIxLDU5Ljc5NSwzMjUuNjU5LDU5Ljc5NSwzNDEuOTg2eiIvPg0KCTxwYXRoIHN0eWxlPSJmaWxsOiM0NjM4MzY7IiBkPSJNNDM3LjAyLDg3LjUzQzM4OC42NjUsMzkuMTg2LDMyNC4zOCwxMi41NTEsMjU2LDEyLjU1MVMxMjMuMzM1LDM5LjE4Niw3NC45OCw4Ny41Mw0KCQlDMjYuNjI0LDEzNS44ODYsMCwyMDAuMTcsMCwyNjguNTUxYzAsNy45MDgsNi40MTEsMTQuMzE5LDE0LjMxOSwxNC4zMTljNy45MDksMCwxNC4zMTktNi40MTEsMTQuMzE5LTE0LjMxOQ0KCQlDMjguNjM4LDE0Mi45ODYsMTMwLjQzNSw0MS4xODksMjU2LDQxLjE4OWMxMjUuNDY1LDAsMjI3LjE5NywxMDEuNjM3LDIyNy4zNTksMjI3LjA2M2MtMC4wMDIsMC4xMDEtMC4wMTUsMC4xOTgtMC4wMTUsMC4yOTkNCgkJYzAsNy45MTMsNi40MTUsMTQuMzI4LDE0LjMyOCwxNC4zMjhTNTEyLDI3Ni40NjUsNTEyLDI2OC41NTFDNTEyLDIwMC4xNyw0ODUuMzc2LDEzNS44ODYsNDM3LjAyLDg3LjUzeiIvPg0KPC9nPg0KPHBhdGggc3R5bGU9ImZpbGw6IzYwNTM1MzsiIGQ9Ik00NzcuMTQyLDQyNC45NWMtNC43MTQsMC04LjUzMywwLTguNTMzLDBWMzIxLjU1NWMwLTAuNjY4LDAuMDc5LTEuMzM1LDAuMjMzLTEuOTgzDQoJYzMuOTctMTYuNjEsNS45ODQtMzMuNzc1LDUuOTg0LTUxLjAxOWMwLTEyMC42NjEtOTguMTY0LTIxOC44MjctMjE4LjgyNS0yMTguODI3UzM3LjE3NSwxNDcuODkzLDM3LjE3NSwyNjguNTUzDQoJYzAsMTcuMjQ0LDIuMDE0LDM0LjQwOSw1Ljk4NCw1MS4wMTljMC4xNTUsMC42NDksMC4yMzMsMS4zMTUsMC4yMzMsMS45ODNWNDI0Ljk1YzAsMC0zLjgyLDAtOC41MzMsMHMtOC41MzMtMy44Mi04LjUzMy04LjUzMw0KCXYtOTMuODY0Yy00LjEyNi0xNy42LTYuMjE3LTM1Ljc2Mi02LjIxNy01My45OTlDMjAuMTA4LDEzOC40ODEsMTI1LjkyOSwzMi42NiwyNTYsMzIuNjZzMjM1Ljg5MiwxMDUuODIxLDIzNS44OTIsMjM1Ljg5Mw0KCWMwLDE4LjIzNy0yLjA5MSwzNi4zOTktNi4yMTcsNTMuOTk5djkzLjg2NEM0ODUuNjc1LDQyMS4xMyw0ODEuODU2LDQyNC45NSw0NzcuMTQyLDQyNC45NXoiLz4NCjxnPg0KCTxwYXRoIHN0eWxlPSJmaWxsOiNGMTQ3NDI7IiBkPSJNMzc3LjcwNiwyNjcuNDg4Yy0yNC44MTcsMC00NC45MzQsMjAuMTE4LTQ0LjkzNCw0NC45MzN2MTQyLjA5NQ0KCQljMCwyNC44MTcsMjAuMTE3LDQ0LjkzMyw0NC45MzQsNDQuOTMzYzI0LjgxNiwwLDQ0LjkzNC0yMC4xMTcsNDQuOTM0LTQ0LjkzM1YzMTIuNDIxDQoJCUM0MjIuNjM5LDI4Ny42MDYsNDAyLjUyMiwyNjcuNDg4LDM3Ny43MDYsMjY3LjQ4OHoiLz4NCgk8cGF0aCBzdHlsZT0iZmlsbDojRjE0NzQyOyIgZD0iTTEzNC4yOTQsMjY3LjQ4OGMtMjQuODE2LDAtNDQuOTM0LDIwLjExOC00NC45MzQsNDQuOTMzdjE0Mi4wOTUNCgkJYzAsMjQuODE3LDIwLjExNyw0NC45MzMsNDQuOTM0LDQ0LjkzM3M0NC45MzQtMjAuMTE3LDQ0LjkzNC00NC45MzNWMzEyLjQyMUMxNzkuMjI4LDI4Ny42MDYsMTU5LjExMSwyNjcuNDg4LDEzNC4yOTQsMjY3LjQ4OHoiLz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjwvc3ZnPg0K"
        />
      </div>
      <div class="song__info">
        <div class="song__name" :title="song.title">
          {{ song.title }}
        </div>
        <div v-if="song.artist" class="song__artist" :title="song.artist">
          {{ song.artist }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {useStore} from 'vuex'
import {computed} from "vue";

export default {
  name: 'song-list',
  emits: ['update:active'],
  props: {
    active: {
      type: Number,
      required: true,
      default: -1
    }
  },
  setup(_, {emit}) {
    const store = useStore()
    const songs = computed(() => store.state.playlist.songs)

    const select = (index) => emit('update:active', index)

    return {
      songs,
      select
    }
  }
}
</script>

<style scoped lang="scss">
.list {
  padding: 15px 0 0 15px;
  display: flex;
  flex-wrap: wrap;
  text-align: center;

  &__item {
    margin-bottom: 15px;
    margin-right: 15px;
    transition: all 0.3s ease-in;
    box-sizing: border-box;
    box-shadow: -10px 25px 50px rgba(0, 0, 0, 0.3);
    position: relative;

    &:hover {
      box-shadow: 20px 50px 100px rgba(0, 0, 0, 0.5);
    }

    &--active {
      box-shadow: 2px 0 2px rgba($c-shark-dark, 0.5);

      &::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 2px;
        background-color: $c-green;
      }
    }
  }
}

.song {
  cursor: pointer;
  color: $c-mine-shaft;
  display: flex;
  flex-direction: column;
  max-width: 200px;
  background: $c-white;

  &__cover {
    width: 200px;
    min-width: 200px;
    height: 200px;
    text-align: center;
    display: flex;
    justify-content: space-around;
  }

  &__img {
    width: 100%;

    &--no {
      width: calc(100% - 60px);
    }
  }

  &__info {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 10px;
    overflow: hidden;
    white-space: nowrap;
    position: relative;
  }

  &__name {
    font-size: 16px;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  &__artist {
    color: $c-tundra;
    font-size: 12px;
    overflow: hidden;
    text-overflow: ellipsis;
    padding-top: 5px;
    transition: all 0.3s ease-in;
  }

  &:hover {
    color: $c-white;
    background: $c-nobel;
    background: -moz-linear-gradient(-45deg, $c-nobel 15%, $c-sirocco 100%);
    background: -webkit-linear-gradient(-45deg, $c-nobel 15%, $c-sirocco 100%);
    background: linear-gradient(135deg, $c-nobel 15%, $c-sirocco 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=$c-nobel, endColorstr=$c-sirocco, GradientType=1);
  }

  &:hover &__artist {
    color: $c-white;
  }
}
</style>