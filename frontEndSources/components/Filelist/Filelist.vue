<template>
    <nav class="pl-files">
        <h3 class="pl-files__headline  ms-res--1">{{ label }}</h3>
        <ul class="pl-files__list">
            <filelist
                    v-for="(node, name) in nodes"
                    :nodes="node.children"
                    :label="name"
                    :key="name"
                    :depth="depth + 1"
                    v-if="!node.templates && typeof node === 'object'"
            />
            <Templatelist
                    :node="node"
                    :depth="depth + 1"
                    v-else-if="typeof node === 'object'"/>
        </ul>
    </nav>
</template>

<script>
    import Templatelist from 'Modules/Templatelist/Templatelist'
    /* eslint-disable */
    export default {
        name: 'Filelist',
        props: {
            label: {
                type: String,
                default: 'Label',
            },
            nodes: {
                default: () => {
                },
            },
            depth: {
                type: Number,
                default: 0,
            },
        },
        components: {
            Templatelist,
        }
    }
</script>

