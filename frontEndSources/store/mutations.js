export default {
  SET_FILELIST(state, filelist) {
    state.filelist = filelist;
  },
  SET_PLUGIN_SETTINGS(state, settings) {
    state.pluginSettings = settings;
  },
  SET_ACTIVE(state, component) {
    state.activeComponent = component;
    state.activeInfos = component.config.meta;
    state.activeVariants = component.config.variants;
    state.activeAssets = component.assets;
    // eslint-disable-next-line
    state.activeTemplate = component.templates[0];
    // eslint-disable-next-line
    state.activeTemplateRender = component.templateRender[0];
  },
  SET_TEMPLATERENDER(state, data) {
    state.activeTemplateRender = {
      code: data,
      extension: '',
    };
  },
  SET_OPEN(state, folderName) {
    state.openFolder = folderName;
  },
};
