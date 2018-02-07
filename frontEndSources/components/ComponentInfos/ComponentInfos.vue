<template>
    <div>
        <div class="pl-infos" v-if="infos.title">
            <h1 class="pl-infos__h1">{{ infos.title }}</h1>
            <span class="pl-infos__status wip">{{ infos.status }}</span>
            <div class="pl-infos__description">
                {{ infos.description }}
            </div>
        </div>

        <hr class="pl-hr" />
    </div>
</template>

<script>
    export default {
        name: 'ComponentInfos',
        computed: {
            infos() {
                return this.$store.getters.activeComponent
            },
        },
    }
</script>

<style lang="scss" scoped>
    .pl-infos {
        padding: 32px;
        padding-top: 0;
        position: relative;

        &__status {
            position: absolute;
            right: 32px;
            top: 32px;
            border-radius: 100px;
            padding: 8px 12px;
            font-size: 12px;
            text-transform: uppercase;
            background-color: #eee;
            font-weight: 700;

            &.wip {
                background-color: orange;
                color: white;
            }

            &::before {
                content: 'Component Status';
                display: inline-block;
                word-break: keep-all;
                white-space: nowrap;
                text-transform: none;
                position: absolute;
                left: -8px;
                transform: translateX(-100%);
                color: #aaa;
                font-weight: 400;
            }
        }

        &__h1 {
            margin: 0;
            margin-top: 32px;
            font-size: 64px;
            text-transform: capitalize;
        }

        &__status {
            position: absolute;
        }

        &__description {
            margin-top: 16px;
            font-size: 24px;
            font-weight: 300;
            max-width: 80ch;
            color: #666;
        }
    }
</style>

