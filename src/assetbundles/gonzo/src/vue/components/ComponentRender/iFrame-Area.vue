<template>
  <div class="pl-content__section">
    <div class="pl__container pl-content__container pl-content__container--iFrameActions">
      <div class="pl-buttonGroup pl-buttonGroup--pill">
        <button v-for="width in mqButtons"
                :key="width"
                :class="{ 'pl-button--active': activeWidth === width }"
                class="pl-button pl-button--pill"
                @click="iFrameWidth(width)"
                v-text="width" />
  
        <a href="" class="pl-button pl-button--newWindow">Open in new tab</a>
      </div>
    </div>
    
    <div class="pl-content__container pl-content__container--iframe">
      <iframe :src="frameSrc"
              marginheight="0"
              marginwidth="0"
              vspace="0"
              hspace="0"
              scrolling="yes"
              name="patternlibRenderer"
              frameborder="0"/>
    </div>
    
  </div>
</template>

<script>
export default {
  name: 'IFrameArea',
  components: {},
  props: {
    frameSrc: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      activeWidth: '100%',
      iFrame: {
        loaded: false,
        height: 0,
        width: '100%',
      },
    };
  },
  computed: {
    mqButtons() {
      return this.$store.state.pluginSettings.mqButtons;
    },
  },
  methods: {
    iFrameWidth(width) {
      // let widthNumber = width.replace('px', '');
      // widthNumber = Number.parseInt(widthNumber, 10);
      this.activeWidth = width;
    },
  },
};
</script>
