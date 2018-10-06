import { shallowMount } from '@vue/test-utils';
import { Store } from 'vuex-mock-store';
// import moxios from 'moxios';
// import { HTTP } from '@Src/js/api';

const store = new Store({
    state: {},
    getters: {},
})

const mocks = {
    $store: store,
}

afterEach(() => store.reset());

describe('CHANGE THIS', () => {
    let wrapper;
    function mounter(overrides) {
        const defaultMountOptions = {
            mocks,
        };
        return shallowMount('COMPONENT HERE', { ...defaultMountOptions, ...overrides });
    }

    beforeEach(() => {
        // moxios.install(HTTP);
        wrapper = mounter();
    });
    //
    // afterEach(() => {
    //     moxios.uninstall();
    // });

    it('YOU TEST HERE', () => {
        const wrapper = mounter();
    });
});
