<template>
  <div>
    <div class="navbar"
         role="navigation"
         aria-label="main navigation">
      <div class="navbar-menu">
        <div class="navbar-start"
             v-if="ttf">
          <div class="navbar-item">
            <strong class="title-margin">Índice: </strong>
            <progress-bar type="success"
                          size="small"
                          :value="progress"
                          :max="total"
                          :show-label="true"
                          class="width300" />
          </div>
          <div class="navbar-item"
               v-if="progress != total">
            Estimado: {{ttf}}
          </div>
          <div class="navbar-item"
               v-if="progress != total">
            Decorrido: {{elapsed}}
          </div>
          <div class="navbar-item"
               v-if="progress != total">
            {{progress}} / {{total}}
          </div>
        </div>
        <div class="navbar-start"
             v-else>
          <div class="navbar-item">
            <p>
              Aguarde o início da carga.
            </p>
          </div>
        </div>
      </div>
    </div>
    <router-view />
  </div>
</template>

<script>
import ProgressBar from 'vue-bulma-progress-bar'

export default {
  name: 'shell',
  components: {
    ProgressBar
  },
  computed: {
    total() {
      if (
        this.$store.getters.status == null ||
        !this.$store.getters.status.total
      )
        return -1
      return parseInt(this.$store.getters.status.total)
    },
    progress() {
      if (
        this.$store.getters.status == null ||
        !this.$store.getters.status.processed
      )
        return 0
      return parseInt(this.$store.getters.status.processed)
    },
    ttf() {
      if (this.$store.getters.status == null || this.progress == 0) return null

      let now = this.$moment().utc()
      let begin = this.$moment(this.$store.getters.status.begin)
      let elapsed = this.$moment.duration(now.diff(begin))
      let remaining = this.total - this.progress
      let left = parseInt(elapsed.asSeconds() * remaining / this.progress)
      let time_left = this.$moment.duration(left, 'seconds')

      return this.$moment.utc(time_left.asMilliseconds()).format('HH:mm:ss')
    },
    elapsed() {
      if (this.$store.getters.status == null || this.progress == 0) return null

      let now = this.$moment().utc()
      let begin = this.$moment(this.$store.getters.status.begin)
      let elapsed = this.$moment.duration(now.diff(begin))

      return this.$moment.utc(elapsed.asMilliseconds()).format('HH:mm:ss')
    }
  }
}
</script>

<style lang="scss" scoped>
.title-margin {
  margin-right: 10px;
}
.progress-container {
  margin-bottom: 0px;
}
.width300 {
  width: 300px;
}
</style>
