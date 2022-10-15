import type { RouteLocation, RouteParams, Router } from 'vue-router';

export const useSetUrlParams = (
  params: RouteParams,
  router: Router,
  route: RouteLocation,
  method = 'push'
) => {
  if (params && router && route) {
    router[method]({
      path: route.path,
      query: {
        ...route.query,
        ...params,
      },
    });
  }
};
