<template>
    <div class="pl-wrapper">
        <!--<button @click="sidebar = !sidebar">Sidebar</button>-->
        <aside class="pl-aside">
            <Filelist v-show="sidebar" :nodes="filelist"/>
        </aside>

        <main class="pl-main">
            <div class="pl-main__inner">
                <PreviewArea/>
            </div>
        </main>
    </div>
</template>

<script>
    import Filelist from 'Modules/Filelist/Filelist'
    import PreviewArea from 'Modules/PreviewArea/PreviewArea'

    export default {
        name: 'Styleguide',
        data() {
            return {
                sidebar: true
            }
        },
        components: {
            Filelist,
            PreviewArea,
        },
        computed: {
            filelist() {
                return this.$store.getters.filelist
            },
        },
        mounted() {
            this.$store.dispatch('setFilelist', window.filelist)
        },
    }
</script>

<style lang="scss">
    .pl-wrapper {
        width: 100vw;
        max-width: 100%;
        height: 100vh;
        overflow: hidden;
        background-color: #f8f8f8;
        display: flex;
        flex-flow: row wrap;
    }

    .pl-aside {
        width: 320px;
        height: 100vh;
        overflow-y: scroll;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .pl-main {
        width: calc(100vw - 320px);
        padding: 32px 32px 64px 32px;
        overflow-y: scroll;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .pl-main__inner {
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        padding: 32px;
        background-color: #fff;
        box-shadow: 0 2px 0 rgba(#aaa, 0.1), 0 1px 2px rgba(#000, 0.1);
    }
</style>
