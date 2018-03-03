export default {
  SET_FILELIST(state, filelist) {
    state.filelist = filelist;
  },
  SET_PLUGIN_SETTINGS(state, settings) {
    state.pluginSettings = settings;
  },
  SET_ACTIVE(state, component) {
    state.activeComponent = component;
  },
  SET_OPEN(state, folderName) {
    state.openFolder = folderName;
  },
};
