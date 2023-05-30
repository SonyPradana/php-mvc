// just short hand
const $id = el => document.getElementById(el);
const $ele = el => document.querySelector(el);
const $click = (el, callback) => $ele(el).addEventListener('click', callback);
