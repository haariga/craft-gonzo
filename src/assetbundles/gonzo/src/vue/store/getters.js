export default {
  compStatus(state) {
    return currentStatus => {
      const { pluginSettings } = state;
      if (!pluginSettings) {
        return {};
      }
      // eslint-disable-next-line
      const matchedStatus =
        pluginSettings.compStatus.find(
          status => status.name.toLowerCase() === currentStatus.toLowerCase(),
        ) || 'wip';
      return matchedStatus;
    };
  },
};
