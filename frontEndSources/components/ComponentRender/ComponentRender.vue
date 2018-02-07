<template>
    <div class="pl-renderer">
        <!--<button @click="sidebar = !sidebar">Sidebar</button>-->

        <div class="pl-renderer__frame">
            <h2 class="pl-renderer__h2">Rendered Template</h2>

            <!-- TODO: Active Class for Button -->
            <div class="pl-renderer__actions">
                <button class="pl-renderer__button" :class="buttonActive" @click="toggleClass(); maxWidth = '384px';">
                    320px
                </button>
                <button class="pl-renderer__button" @click="maxWidth = '832px'">768px</button>
                <button class="pl-renderer__button" @click="maxWidth = '1344px'">1280px</button>
                <button class="pl-renderer__button" @click="maxWidth = '100%'">100%</button>
            </div>

            <iframe :style="{ 'max-width': maxWidth }"
                    :src="frame.src"
                    marginheight="0"
                    marginwidth="0"
                    vspace="0"
                    hspace="0"
                    scrolling="yes"
                    name="patternlibRenderer"
                    frameborder="0"
                    v-if="activeComponent.relativePath"/>
            <div v-else>
                Please choose a component
            </div>
        </div>

        <hr class="pl-hr" />

        <div class="pl-renderer__code">
            <h2 class="pl-renderer__h2">Code: SCSS</h2>
            <pre>
<code>
.pl-renderer {
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
}</code></pre>


            <h2 class="pl-renderer__h2">Code: HTML</h2>
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
}</code></pre>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ComponentRender',
        data() {
            return {
                maxWidth: '100%',
                buttonActive: false,
                sidebar: false
            }
        },
        computed: {
            activeComponent() {
                return this.$store.getters.activeTemplate
            },
            frame() {
                const previewUrl = './patternlib'
                return {
                    src: previewUrl + this.activeComponent.relativePath,
                }
            },
        },
        methods: {
            toggleClass: function() {
                this.buttonActive = !this.buttonActive
            }
        }
    }
</script>

<style lang="scss" scoped>
    .pl-renderer {
        position: relative;

        &__actions {
            margin-top: 8px;
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

        &__h2 {
            margin: 0;
            margin-top: 32px;
            font-weight: 500;
            font-size: 24px;
            color: #333;
        }

        &__frame {
            width: 100%;
            max-width: 100%;
            padding: 32px;
            padding-top: 16px;
            position: relative;

            iframe {
                margin-top: 16px;
                width: 100%;
                max-width: 100%;
                background-color: #f8f8f8;
                border-radius: 5px;
                padding: 32px;
            }
        }

        &__code {
            width: 100%;
            max-width: 100%;
            padding: 32px;
            padding-top: 16px;
            position: relative;

            pre {
                width: 100%;
                max-width: 100%;
                background-color: #222;
                color: #555;
                border-radius: 5px;
                padding: 32px;
                max-height: 200px;
                overflow: hidden;
                transition: all 0.25s;

                &.is-open {
                    overflow: scroll;
                    max-height: none;
                    background-color: #222;
                    color: #ddd;
                }
            }
        }
    }
</style>

