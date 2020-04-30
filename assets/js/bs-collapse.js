import $ from 'jquery';
import Collapse from 'bootstrap/js/src/collapse';

const DATA_KEY = 'bs.collapse';
const Default = { toggle: true, parent: '' };

Collapse._jQueryInterface = function (config) {
    return this.each(function () {
        const $this = $(this);
        let data = $this.data(DATA_KEY);
        const _config = {
            ...Default,
            ...$this.data(),
            ...typeof config === 'object' && config ? config : {}
        };

        if (!data) {
            data = new Collapse(this, _config);
            $this.data(DATA_KEY, data);
        }

        if (typeof config === 'string') {
            data[config]();
        }
    });
};
