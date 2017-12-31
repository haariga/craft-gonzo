
<template>
  <div>
    <ComponentInfos />
    <ComponentRender />
  </div>
</template>

<script>
import ComponentInfos from 'Modules/ComponentInfos/ComponentInfos';
import ComponentRender from 'Modules/ComponentRender/ComponentRender';

export default {
  name: 'PreviewArea',
  components: {
    ComponentInfos,
    ComponentRender,
  },
};
</script>
