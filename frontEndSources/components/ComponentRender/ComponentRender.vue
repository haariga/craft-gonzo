<template>
  <div class="pl-content">
    <div class="pl-content__section">
      <!--<h2 class="pl-headline&#45;&#45;h5">Code: SCSS</h2>-->
      <div class="pl-content__container  pl-content__container--iframeActions">
        <button class="pl-button pl-button--pill"
                :class="{'pl-button--active': activeWidth === width}"
                v-for="width in mqButtons"
                @click="iFrameWidth(width)"
                :key="width"
                v-text="`${width}`" />
      </div>
      <div class="pl-content__container  pl-content__container--iframe" v-show="iFrame.loaded">
        <iframe :style="{ 'max-width': iFrame.width }"
                :src="frame.src"
                :height="iFrame.height"
                marginheight="0"
                marginwidth="0"
                vspace="0"
                hspace="0"
                scrolling="yes"
                name="patternlibRenderer"
                frameborder="0"
                ref="iframe"
                @load="iFrameSize"
                v-if="activeComponent.relativePath"
        />
        <div v-else>
          Please choose a component
        </div>
      </div>
    </div>
    <hr class="pl-hr">

    <div class="pl-content__section">
      <h2 class="pl-headline--h5">Code: SCSS</h2>
      <div class="pl-content__container  pl-content__container--code">
        <pre>
                    <code>
                    .pl-content {
                        position: relative;

                        &__actions {
                            padding: 16px 32px;
                            background-color: #fff;
                        }

                        &__button {
                            display: inline-block;
                            margin-right: 4px;
                            border-radius: 100px;
                            padding: 8px 12px;
                            font-size: 12px;
                            font-weight: 500;
                            color: #999;
                            line-height: 1;
                            border: 1px solid #eee;
                            outline: none;
                            background: linear-gradient(to bottom, white, #eee);
                            transition: all 0.25s;

                            &:hover {
                                color: #333;
                                border: 1px solid #aaa;
                            }
                        }

                        &__frame {
                            width: 100%;
                            max-width: 100%;
                            padding: 32px;
                            position: relative;

                            &::before {
                                content: 'Rendered Template';
                                position: absolute;
                                left: 50%;
                                top: 32px;
                                transform: translate(-50%, -50%);
                                border-radius: 100px;
                                padding: 8px 12px;
                                font-size: 12px;
                                color: #999;
                                line-height: 1;
                                border: 1px solid #f8f8f8;
                                background-color: #fff;
                            }

                            iframe {
                                width: 100%;
                                max-width: 100%;
                                background-color: #f8f8f8;
                                border-radius: 5px;
                                padding: 32px;
                            }
                        }
                    }
                </code>
        </pre>
      </div>

      <h2 class="pl-headline--h5">Code: HTML</h2>
      <div class="pl-content__container  pl-content__container--code">
        <pre class="is-open">
                    <code>
                    &__frame {
                        width: 100%;
                        max-width: 100%;
                        padding: 32px;
                        position: relative;

                        &::before {
                            content: 'Rendered Template';
                            position: absolute;
                            left: 50%;
                            top: 32px;
                            transform: translate(-50%, -50%);
                            border-radius: 100px;
                            padding: 8px 12px;
                            font-size: 12px;
                            color: #999;
                            line-height: 1;
                            border: 1px solid #f8f8f8;
                            background-color: #fff;
                        }

                        iframe {
                            width: 100%;
                            max-width: 100%;
                            background-color: #f8f8f8;
                            border-radius: 5px;
                            padding: 32px;
                        }
                    }
                    </code>
        </pre>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ComponentRender',
  data() {
    return {
      buttonActive: false,
      sidebar: false,
      activeWidth: 'none',
      iFrame: {
        loaded: false,
        height: 0,
        width: '100%',
      },
    };
  },
  computed: {
    activeComponent() {
      return this.$store.getters.activeTemplate;
    },
    mqButtons() {
      return this.$store.getters.mqButtons;
    },
    frame() {
      const previewUrl = './patternlib';
      return {
        src: previewUrl + this.activeComponent.relativePath,
      };
    },
  },
  mounted() {
    this.iFrameSize();
  },
  methods: {
    toggleClass() {
      this.buttonActive = !this.buttonActive;
    },
    iFrameWidth(width) {
      let widthNumber = width.replace('px', '');
      widthNumber = Number.parseInt(widthNumber, 10);
      this.activeWidth = width;
      if (width.includes('px')) {
        this.$set(this.iFrame, 'width', `${widthNumber + 64}px`);
      } else {
        this.$set(this.iFrame, 'width', 'none');
      }
    },
    iFrameSize() {
      const iFrame = this.$refs.iframe;
      if (iFrame) {
        this.iFrame.loaded = true;
        this.iFrame.height = `${iFrame.contentWindow.document.body.scrollHeight + 120}px`;
      }
    },
  },
};
</script>

<style lang="scss">

</style>
