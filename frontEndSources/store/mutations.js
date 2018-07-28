export default {
  SET_FILELIST(state, filelist) {
    state.filelist = filelist;
  },
  SET_PLUGIN_SETTINGS(state, settings) {
    state.pluginSettings = settings;
  },
  SET_ACTIVE(state, component) {
    state.activeComponent = component;
    state.activeAssets = component.assets;
    // eslint-disable-next-line
    state.activeTemplate = component.templates[0];
    // eslint-disable-next-line
    state.activeTemplateRender = component.templateRender[0];
  },
  SET_OPEN(state, folderName) {
    state.openFolder = folderName;
  },
};
