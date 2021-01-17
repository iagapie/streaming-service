<template>
  <div v-if="error" class="error">
    <div class="error__message">
      {{ error }}
    </div>
  </div>
  <Suspense v-else>
    <template #default>
      <Home/>
    </template>
    <template #fallback>
      <div class="loading">
        <div class="loading__dot-pulse"></div>
      </div>
    </template>
  </Suspense>
</template>

<script>
import {ref, onErrorCaptured} from 'vue'
import Home from '@/views/Home'

export default {
  components: {
    Home
  },
  setup() {
    const error = ref(null)

    onErrorCaptured(e => error.value = e.message)

    return {
      error
    }
  }
}
</script>

<style lang="scss">
#app {
  min-height: 100vh;
}

.error,
.loading {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.error {
  &__message {
    color: $c-error;
    font-family: Tahoma, Helvetica, Arial, sans-serif;
    font-size: 40px;
    font-weight: 900;
    text-shadow: 0 1px 1px rgba($c-shark, 0.3);
  }
}

.loading {
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

    &::before,
    &::after {
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